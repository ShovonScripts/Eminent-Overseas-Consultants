<?php
/**
 * Contact Form Email Handler
 * Eminent Overseas & Consultants
 */

// Security Headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Error Reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set to 0 in production
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

// Check if it's an AJAX request
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: contact.php');
    exit;
}

// Anti-spam honeypot check
if (!empty($_POST['honeypot'])) {
    error_log("Spam detected from IP: " . $_SERVER['REMOTE_ADDR']);
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Spam detected']);
    } else {
        http_response_code(403);
        die('Invalid submission');
    }
    exit;
}

// Rate limiting check (simple implementation)
session_start();
$rateLimitKey = 'form_submit_time';
$rateLimitWindow = 60; // seconds

if (isset($_SESSION[$rateLimitKey])) {
    $timeSinceLastSubmit = time() - $_SESSION[$rateLimitKey];
    if ($timeSinceLastSubmit < $rateLimitWindow) {
        $waitTime = $rateLimitWindow - $timeSinceLastSubmit;
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => "Please wait {$waitTime} seconds before submitting again."
            ]);
        } else {
            http_response_code(429);
            echo "Please wait before submitting again.";
        }
        exit;
    }
}

// Update rate limit timestamp
$_SESSION[$rateLimitKey] = time();

// Initialize PHPMailer flag
$usePHPMailer = false;

// Try to load PHPMailer
try {
    $phpmailerPaths = [
        __DIR__ . '/vendor/autoload.php',
        __DIR__ . '/../vendor/autoload.php',
        __DIR__ . '/../../vendor/autoload.php',
    ];
    
    foreach ($phpmailerPaths as $path) {
        if (file_exists($path)) {
            require_once $path;
            if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
                $usePHPMailer = true;
                break;
            }
        }
    }
} catch (Exception $e) {
    error_log("PHPMailer load error: " . $e->getMessage());
}

/**
 * Clean and sanitize input data
 */
function clean_input($data) {
    if (empty($data)) return '';
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email address
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) && 
           preg_match('/@.+\./', $email);
}

/**
 * Validate phone number
 */
function validate_phone($phone) {
    // Remove all non-numeric characters
    $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
    // Must be between 10-15 digits
    return strlen($cleanPhone) >= 10 && strlen($cleanPhone) <= 15;
}

// Get and sanitize form data
$firstName = clean_input($_POST['firstName'] ?? '');
$lastName = clean_input($_POST['lastName'] ?? '');
$email = clean_input($_POST['email'] ?? '');
$phone = clean_input($_POST['phone'] ?? '');
$country = clean_input($_POST['country'] ?? '');
$educationLevel = clean_input($_POST['educationLevel'] ?? '');
$message = clean_input($_POST['message'] ?? '');
$consent = isset($_POST['consent']) ? 'Yes' : 'No';

// Validation
$errors = [];

if (empty($firstName) || strlen($firstName) < 2 || strlen($firstName) > 50) {
    $errors[] = "First name must be between 2 and 50 characters";
}

if (empty($lastName) || strlen($lastName) < 2 || strlen($lastName) > 50) {
    $errors[] = "Last name must be between 2 and 50 characters";
}

if (!validate_email($email)) {
    $errors[] = "Please provide a valid email address";
}

if (!validate_phone($phone)) {
    $errors[] = "Please provide a valid phone number";
}

$validCountries = ['japan', 'uk', 'both', 'not-sure'];
if (empty($country) || !in_array($country, $validCountries)) {
    $errors[] = "Please select a valid country of interest";
}

if (empty($message) || strlen($message) < 10 || strlen($message) > 5000) {
    $errors[] = "Message must be between 10 and 5000 characters";
}

if ($consent !== 'Yes') {
    $errors[] = "You must agree to receive information";
}

// If validation fails, show errors
if (!empty($errors)) {
    if ($isAjax) {
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'errors' => $errors
        ]);
    } else {
        http_response_code(400);
        displayErrorPage($errors);
    }
    exit;
}

// Country and education level mappings
$countryNames = [
    'japan' => 'Japan',
    'uk' => 'United Kingdom',
    'both' => 'Both Japan & UK',
    'not-sure' => 'Not Sure Yet'
];

$educationNames = [
    'hsc' => 'HSC / A-Level Completed',
    'diploma' => 'Diploma Completed',
    'bachelor' => "Bachelor's Degree",
    'master' => "Master's Degree",
    'other' => 'Other'
];

// Email configuration
$to_email = "info@eminentoverseas.uk";
$subject = "New Contact Form Enquiry - " . $firstName . " " . $lastName;
$countryDisplay = $countryNames[$country] ?? $country;
$educationDisplay = $educationLevel ? ($educationNames[$educationLevel] ?? $educationLevel) : 'Not specified';

// HTML Email Body
$htmlBody = generateHtmlEmail($firstName, $lastName, $email, $phone, $countryDisplay, $educationDisplay, $message, $consent);

// Plain Text Email Body
$plainBody = generatePlainEmail($firstName, $lastName, $email, $phone, $countryDisplay, $educationDisplay, $message, $consent);

// Send email
$emailSent = false;
$errorMessage = '';

if ($usePHPMailer) {
    $emailSent = sendWithPHPMailer($to_email, $subject, $htmlBody, $plainBody, $email, $firstName, $lastName, $countryDisplay, $errorMessage);
} else {
    $emailSent = sendWithMailFunction($to_email, $subject, $htmlBody, $email, $errorMessage);
}

// Handle response
if ($emailSent) {
    // Log successful submission
    error_log("Form submitted successfully by: {$firstName} {$lastName} ({$email})");
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => "Thank you! Your enquiry has been submitted. We'll contact you within 24 hours.",
            'redirect' => 'thank-you.html?ref=' . urlencode($email) . '&name=' . urlencode($firstName)
        ]);
    } else {
        header('Location: thank-you.html?ref=' . urlencode($email) . '&name=' . urlencode($firstName));
    }
} else {
    // Log error
    error_log("Email send failed: {$errorMessage}");
    
    if ($isAjax) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to send your enquiry. Please try again or contact us directly at info@eminentoverseas.uk'
        ]);
    } else {
        displayEmailErrorPage();
    }
}

exit;

// ============================================================================
// HELPER FUNCTIONS
// ============================================================================

/**
 * Send email using PHPMailer
 */
function sendWithPHPMailer($to, $subject, $htmlBody, $plainBody, $replyEmail, $firstName, $lastName, $country, &$errorMessage) {
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'mail.eminentoverseas.uk';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@eminentoverseas.uk';
        $mail->Password = 'Pele@2468';
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';
        
        // Disable SSL verification if needed (not recommended for production)
        // $mail->SMTPOptions = array(
        //     'ssl' => array(
        //         'verify_peer' => false,
        //         'verify_peer_name' => false,
        //         'allow_self_signed' => true
        //     )
        // );
        
        // Recipients
        $mail->setFrom('info@eminentoverseas.uk', 'Eminent Overseas Contact Form');
        $mail->addAddress($to, 'Eminent Overseas Team');
        $mail->addReplyTo($replyEmail, $firstName . ' ' . $lastName);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;
        $mail->AltBody = $plainBody;
        
        $mail->send();
        
        // Send confirmation email to customer
        sendConfirmationEmail($replyEmail, $firstName, $country);
        
        return true;
    } catch (Exception $e) {
        $errorMessage = "PHPMailer Error: " . $e->getMessage();
        error_log($errorMessage);
        return false;
    }
}

/**
 * Send confirmation email to customer
 */
function sendConfirmationEmail($email, $firstName, $country) {
    try {
        $confirmMail = new PHPMailer\PHPMailer\PHPMailer(true);
        
        $confirmMail->isSMTP();
        $confirmMail->Host = 'mail.eminentoverseas.uk';
        $confirmMail->SMTPAuth = true;
        $confirmMail->Username = 'info@eminentoverseas.uk';
        $confirmMail->Password = 'Pele@2468';
        $confirmMail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        $confirmMail->Port = 465;
        $confirmMail->CharSet = 'UTF-8';
        
        $confirmMail->setFrom('info@eminentoverseas.uk', 'Eminent Overseas & Consultants');
        $confirmMail->addAddress($email, $firstName);
        
        $confirmMail->isHTML(true);
        $confirmMail->Subject = 'Thank You for Contacting Eminent Overseas & Consultants';
        $confirmMail->Body = generateConfirmationEmail($firstName, $country);
        $confirmMail->AltBody = "Thank you for contacting Eminent Overseas & Consultants!\n\nWe have received your enquiry. Our counselor will contact you within 24 hours.\n\nContact: +880 XXXX-XXXXXX\nAddress: 16/9, Indira Road, Dhaka 1212";
        
        $confirmMail->send();
    } catch (Exception $e) {
        error_log("Confirmation email failed: " . $e->getMessage());
    }
}

/**
 * Send email using PHP's mail() function
 */
function sendWithMailFunction($to, $subject, $htmlBody, $replyEmail, &$errorMessage) {
    $headers = "From: info@eminentoverseas.uk\r\n";
    $headers .= "Reply-To: {$replyEmail}\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    
    if (@mail($to, $subject, $htmlBody, $headers)) {
        return true;
    } else {
        $errorMessage = "PHP mail() function failed";
        return false;
    }
}

/**
 * Generate HTML email for admin
 */
function generateHtmlEmail($firstName, $lastName, $email, $phone, $country, $education, $message, $consent) {
    $currentDate = date('F j, Y \a\t g:i A');
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $consentIcon = $consent === 'Yes' ? '✅ Granted' : '❌ Not Granted';
    
    return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 700px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #1a365d, #2d3748); color: white; padding: 30px; text-align: center; }
        .header h2 { margin: 0; font-size: 28px; }
        .header p { margin: 5px 0 0; opacity: 0.9; }
        .content { padding: 40px; }
        .field { margin-bottom: 25px; padding-bottom: 25px; border-bottom: 1px solid #eaeaea; }
        .field:last-child { border-bottom: none; }
        .label { font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 16px; }
        .value { color: #4a5568; font-size: 16px; word-wrap: break-word; }
        .message-box { background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #4299e1; margin-top: 10px; white-space: pre-wrap; }
        .footer { background: #f8f9fa; padding: 25px; text-align: center; color: #718096; font-size: 14px; border-top: 1px solid #eaeaea; }
        .footer p { margin: 5px 0; }
        .highlight { color: #4299e1; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Form Enquiry</h2>
            <p>Eminent Overseas & Consultants</p>
        </div>
        <div class="content">
            <div class="field">
                <div class="label">Full Name:</div>
                <div class="value">{$firstName} {$lastName}</div>
            </div>
            <div class="field">
                <div class="label">Email Address:</div>
                <div class="value"><a href="mailto:{$email}">{$email}</a></div>
            </div>
            <div class="field">
                <div class="label">Phone Number:</div>
                <div class="value"><a href="tel:{$phone}">{$phone}</a></div>
            </div>
            <div class="field">
                <div class="label">Country of Interest:</div>
                <div class="value highlight">{$country}</div>
            </div>
            <div class="field">
                <div class="label">Education Level:</div>
                <div class="value">{$education}</div>
            </div>
            <div class="field">
                <div class="label">Marketing Consent:</div>
                <div class="value">{$consentIcon}</div>
            </div>
            <div class="field">
                <div class="label">Enquiry Message:</div>
                <div class="message-box">{$message}</div>
            </div>
        </div>
        <div class="footer">
            <p><strong>Submission Details:</strong></p>
            <p>Submitted on: {$currentDate}</p>
            <p>IP Address: {$ipAddress}</p>
            <p>Please respond to this enquiry within <span class="highlight">24 hours</span>.</p>
        </div>
    </div>
</body>
</html>
HTML;
}

/**
 * Generate plain text email for admin
 */
function generatePlainEmail($firstName, $lastName, $email, $phone, $country, $education, $message, $consent) {
    $currentDate = date('Y-m-d H:i:s');
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    
    return <<<PLAIN
NEW CONTACT FORM ENQUIRY - EMINENT OVERSEAS
=========================================

CLIENT INFORMATION
- Full Name: {$firstName} {$lastName}
- Email: {$email}
- Phone: {$phone}

STUDY INTERESTS
- Country of Interest: {$country}
- Education Level: {$education}
- Marketing Consent: {$consent}

ENQUIRY MESSAGE
-----------------------------------------
{$message}
-----------------------------------------

TECHNICAL DETAILS
- Submitted: {$currentDate}
- IP Address: {$ipAddress}

=========================================
Please respond to this enquiry within 24 hours.
=========================================
PLAIN;
}

/**
 * Generate confirmation email for customer
 */
function generateConfirmationEmail($firstName, $country) {
    $year = date('Y');
    
    return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 650px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #1a365d, #2d3748); color: white; padding: 40px; text-align: center; }
        .header h1 { margin: 0; font-size: 32px; font-weight: 600; }
        .header p { margin: 10px 0 0; opacity: 0.9; font-size: 18px; }
        .content { padding: 50px 40px; }
        .greeting { font-size: 20px; color: #2d3748; margin-bottom: 25px; }
        .message { color: #4a5568; font-size: 16px; margin-bottom: 30px; }
        .message p { margin: 10px 0; }
        .next-steps { background: #f0f9ff; padding: 25px; border-radius: 10px; border-left: 5px solid #4299e1; margin: 30px 0; }
        .next-steps h3 { color: #2d3748; margin-top: 0; }
        .next-steps ul { padding-left: 20px; margin: 15px 0; }
        .next-steps li { margin-bottom: 12px; }
        .contact-info { background: #f8f9fa; padding: 25px; border-radius: 10px; margin: 30px 0; border: 1px solid #eaeaea; }
        .contact-info h3 { color: #2d3748; margin-top: 0; }
        .contact-info p { margin: 10px 0; }
        .footer { background: #f8f9fa; padding: 30px; text-align: center; color: #718096; font-size: 14px; border-top: 1px solid #eaeaea; }
        .highlight { color: #4299e1; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Contacting Us!</h1>
            <p>Eminent Overseas & Consultants</p>
        </div>
        <div class="content">
            <div class="greeting">Dear {$firstName},</div>
            <div class="message">
                <p>Thank you for reaching out to <strong>Eminent Overseas & Consultants</strong>.</p>
                <p>We have received your enquiry about studying in <strong>{$country}</strong>.</p>
            </div>
            <div class="next-steps">
                <h3>📋 What Happens Next:</h3>
                <ul>
                    <li><strong>Within 24 Hours:</strong> Our education counselor will contact you</li>
                    <li><strong>Personal Consultation:</strong> We'll discuss your academic goals</li>
                    <li><strong>University Shortlisting:</strong> Personalized recommendations</li>
                </ul>
            </div>
            <div class="contact-info">
                <h3>📍 Our Office Details</h3>
                <p>🏢 <strong>Address:</strong> 16/9, Indira Road (Behind Tejgaon College), Dhaka 1212</p>
                <p>📞 <strong>Phone:</strong> +880 XXXX-XXXXXX</p>
                <p>🕐 <strong>Office Hours:</strong> Saturday - Thursday: 10:00 AM - 6:00 PM</p>
            </div>
            <p>Best regards,<br>
            <strong>Eminent Overseas & Consultants Team</strong></p>
        </div>
        <div class="footer">
            <p>© {$year} Eminent Overseas & Consultants. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
HTML;
}

/**
 * Display error page
 */
function displayErrorPage($errors) {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Error - Eminent Overseas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 2rem; background: #f8f9fa; }
        .error-container { max-width: 600px; margin: 0 auto; }
        .alert { border-radius: 10px; }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="alert alert-danger">
            <h4 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Form Submission Error</h4>
            <ul class="mb-3">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
            <hr>
            <p class="mb-0">Please correct the errors and try again.</p>
            <a href="contact.php" class="btn btn-outline-danger mt-3">Go Back to Contact Form</a>
        </div>
    </div>
</body>
</html>
    <?php
}

/**
 * Display email error page
 */
function displayEmailErrorPage() {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Error - Eminent Overseas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 3rem; background: #f8f9fa; }
        .error-card { max-width: 600px; margin: 0 auto; background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="error-card">
        <h3 class="text-danger mb-4">⚠️ Email Sending Failed</h3>
        <p>We encountered an issue sending your enquiry. This could be a temporary problem.</p>
        <p>Please try one of the following:</p>
        <div class="alert alert-info mt-3">
            <p class="mb-2"><strong>Email:</strong> <a href="mailto:info@eminentoverseas.uk">info@eminentoverseas.uk</a></p>
            <p class="mb-0"><strong>Phone:</strong> <a href="tel:+880XXXXXXXXXX">+880 XXXX-XXXXXX</a></p>
        </div>
        <div class="mt-4">
            <a href="contact.php" class="btn btn-primary">Try Again</a>
            <a href="index.html" class="btn btn-outline-secondary">Return to Homepage</a>
        </div>
    </div>
</body>
</html>
    <?php
}
?>
