<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// If you installed via Composer
require 'vendor/autoload.php';

// Or if you downloaded PHPMailer manually
// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';

// Anti-spam honeypot check
if (!empty($_POST['honeypot'])) {
    die('Spam detected');
}

// Validate and sanitize input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = clean_input($_POST['firstName'] ?? '');
    $lastName = clean_input($_POST['lastName'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $phone = clean_input($_POST['phone'] ?? '');
    $country = clean_input($_POST['country'] ?? '');
    $educationLevel = clean_input($_POST['educationLevel'] ?? '');
    $message = clean_input($_POST['message'] ?? '');
    $consent = isset($_POST['consent']) ? 'Yes' : 'No';
    
    // Basic validation
    $errors = [];
    
    if (empty($firstName) || strlen($firstName) < 2) {
        $errors[] = "First name is required and must be at least 2 characters";
    }
    
    if (empty($lastName) || strlen($lastName) < 2) {
        $errors[] = "Last name is required and must be at least 2 characters";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if (empty($phone) || strlen($phone) < 10) {
        $errors[] = "Valid phone number is required";
    }
    
    if (empty($country)) {
        $errors[] = "Please select a country of interest";
    }
    
    if (empty($message) || strlen($message) < 10) {
        $errors[] = "Message is required and must be at least 10 characters";
    }
    
    if ($consent === 'No') {
        $errors[] = "You must agree to receive information";
    }
    
    // If there are errors, show them
    if (!empty($errors)) {
        http_response_code(400);
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error - Eminent Overseas</title>
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
                    <h4 class="alert-heading">Form Submission Error</h4>';
        foreach ($errors as $error) {
            echo "<p class='mb-1'>• {$error}</p>";
        }
        echo '      <hr>
                    <p class="mb-0">Please correct the errors and try again.</p>
                    <a href="contact.php" class="btn btn-outline-danger mt-3">Go Back to Contact Form</a>
                </div>
            </div>
        </body>
        </html>';
        exit;
    }
    
    // Country mapping for display
    $countryNames = [
        'japan' => 'Japan',
        'uk' => 'United Kingdom',
        'both' => 'Both Japan & UK',
        'not-sure' => 'Not Sure Yet'
    ];
    
    // Education level mapping
    $educationNames = [
        'hsc' => 'HSC / A-Level Completed',
        'diploma' => 'Diploma Completed',
        'bachelor' => 'Bachelor\'s Degree',
        'master' => 'Master\'s Degree',
        'other' => 'Other'
    ];
    
    // Prepare email content
    $to_email = "info@eminentoverseas.uk"; // Using the email from manual settings
    $subject = "New Contact Form Enquiry - " . $firstName . " " . $lastName;
    
    $body = "<!DOCTYPE html>
    <html>
    <head>
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
            .value { color: #4a5568; font-size: 16px; }
            .message-box { background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #4299e1; margin-top: 10px; }
            .footer { background: #f8f9fa; padding: 25px; text-align: center; color: #718096; font-size: 14px; border-top: 1px solid #eaeaea; }
            .footer p { margin: 5px 0; }
            .highlight { color: #4299e1; font-weight: 600; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>New Contact Form Enquiry</h2>
                <p>Eminent Overseas & Consultants</p>
            </div>
            <div class='content'>
                <div class='field'>
                    <div class='label'>Full Name:</div>
                    <div class='value'>{$firstName} {$lastName}</div>
                </div>
                <div class='field'>
                    <div class='label'>Email Address:</div>
                    <div class='value'>{$email}</div>
                </div>
                <div class='field'>
                    <div class='label'>Phone Number:</div>
                    <div class='value'>{$phone}</div>
                </div>
                <div class='field'>
                    <div class='label'>Country of Interest:</div>
                    <div class='value highlight'>" . ($countryNames[$country] ?? $country) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>Education Level:</div>
                    <div class='value'>" . ($educationLevel ? ($educationNames[$educationLevel] ?? $educationLevel) : 'Not specified') . "</div>
                </div>
                <div class='field'>
                    <div class='label'>Marketing Consent:</div>
                    <div class='value'>" . ($consent === 'Yes' ? '✅ Granted' : '❌ Not Granted') . "</div>
                </div>
                <div class='field'>
                    <div class='label'>Enquiry Message:</div>
                    <div class='message-box'>{$message}</div>
                </div>
            </div>
            <div class='footer'>
                <p><strong>Submission Details:</strong></p>
                <p>Submitted on: " . date('F j, Y \a\t g:i A') . "</p>
                <p>IP Address: " . $_SERVER['REMOTE_ADDR'] . " | Browser: " . $_SERVER['HTTP_USER_AGENT'] . "</p>
                <p>Please respond to this enquiry within <span class='highlight'>24 hours</span>.</p>
            </div>
        </div>
    </body>
    </html>";
    
    // Plain text version for non-HTML email clients
    $plainBody = "═══════════════════════════════════════════════════
            NEW CONTACT FORM ENQUIRY - EMINENT OVERSEAS
═══════════════════════════════════════════════════

» CLIENT INFORMATION
• Full Name: {$firstName} {$lastName}
• Email: {$email}
• Phone: {$phone}

» STUDY INTERESTS
• Country of Interest: " . ($countryNames[$country] ?? $country) . "
• Education Level: " . ($educationLevel ? ($educationNames[$educationLevel] ?? $educationLevel) : 'Not specified') . "
• Marketing Consent: {$consent}

» ENQUIRY MESSAGE
───────────────────────────────────────────────────
{$message}
───────────────────────────────────────────────────

» TECHNICAL DETAILS
• Submitted: " . date('Y-m-d H:i:s') . "
• IP Address: " . $_SERVER['REMOTE_ADDR'] . "

═══════════════════════════════════════════════════
Please respond to this enquiry within 24 hours.
═══════════════════════════════════════════════════";
    
    try {
        // Create PHPMailer instance
        $mail = new PHPMailer(true);
        
        // Server settings - USING EMINENTOVERSEAS.UK SERVER FROM MANUAL SETTINGS
        $mail->isSMTP();
        $mail->Host = 'mail.eminentoverseas.uk'; // From manual settings
        $mail->SMTPAuth = true;
        $mail->Username = 'info@eminentoverseas.uk'; // From manual settings
        $mail->Password = 'Pele@2468'; // Using the password from your comment
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL/TLS encryption
        $mail->Port = 465; // SMTP port from manual settings
        
        // Optional: Enable debugging
        // $mail->SMTPDebug = 2;
        // $mail->Debugoutput = function($str, $level) {
        //     error_log("SMTP level $level: $str");
        // };
        
        // Set character encoding
        $mail->CharSet = 'UTF-8';
        
        // Recipients
        $mail->setFrom('info@eminentoverseas.uk', 'Eminent Overseas Contact Form');
        $mail->addAddress($to_email, 'Eminent Overseas Team');
        $mail->addReplyTo($email, $firstName . ' ' . $lastName);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = $plainBody;
        
        // Set priority
        $mail->Priority = 1; // High priority
        
        // Send email
        $mail->send();
        
        // Send confirmation email to the user
        try {
            $confirmMail = new PHPMailer(true);
            $confirmMail->isSMTP();
            $confirmMail->Host = 'mail.eminentoverseas.uk';
            $confirmMail->SMTPAuth = true;
            $confirmMail->Username = 'info@eminentoverseas.uk';
            $confirmMail->Password = 'Pele@2468';
            $confirmMail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $confirmMail->Port = 465;
            $confirmMail->CharSet = 'UTF-8';
            
            $confirmMail->setFrom('info@eminentoverseas.uk', 'Eminent Overseas & Consultants');
            $confirmMail->addAddress($email, $firstName . ' ' . $lastName);
            
            $confirmMail->isHTML(true);
            $confirmMail->Subject = 'Thank You for Contacting Eminent Overseas & Consultants';
            
            // Confirmation email HTML
            $confirmBody = '
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f5f5f5; margin: 0; padding: 20px; }
                    .container { max-width: 650px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
                    .header { background: linear-gradient(135deg, #1a365d, #2d3748); color: white; padding: 40px; text-align: center; }
                    .header h1 { margin: 0; font-size: 32px; font-weight: 600; }
                    .header p { margin: 10px 0 0; opacity: 0.9; font-size: 18px; }
                    .content { padding: 50px 40px; }
                    .greeting { font-size: 20px; color: #2d3748; margin-bottom: 25px; }
                    .message { color: #4a5568; font-size: 16px; margin-bottom: 30px; }
                    .next-steps { background: #f0f9ff; padding: 25px; border-radius: 10px; border-left: 5px solid #4299e1; margin: 30px 0; }
                    .next-steps h3 { color: #2d3748; margin-top: 0; }
                    .next-steps ul { padding-left: 20px; }
                    .next-steps li { margin-bottom: 12px; }
                    .contact-info { background: #f8f9fa; padding: 25px; border-radius: 10px; margin: 30px 0; border: 1px solid #eaeaea; }
                    .contact-info h3 { color: #2d3748; margin-top: 0; }
                    .icon { color: #4299e1; margin-right: 10px; }
                    .footer { background: #f8f9fa; padding: 30px; text-align: center; color: #718096; font-size: 14px; border-top: 1px solid #eaeaea; }
                    .highlight { color: #4299e1; font-weight: 600; }
                    .cta-button { display: inline-block; background: linear-gradient(135deg, #4299e1, #3182ce); color: white; padding: 14px 32px; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; margin: 20px 0; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>Thank You for Contacting Us!</h1>
                        <p>Eminent Overseas & Consultants</p>
                    </div>
                    <div class="content">
                        <div class="greeting">Dear ' . $firstName . ',</div>
                        
                        <div class="message">
                            <p>Thank you for reaching out to <strong>Eminent Overseas & Consultants</strong>. We have successfully received your enquiry regarding studying abroad.</p>
                            <p>Your interest in <strong>' . ($countryNames[$country] ?? $country) . '</strong> has been noted, and one of our expert education counselors will review your profile.</p>
                        </div>
                        
                        <div class="next-steps">
                            <h3>📋 What Happens Next:</h3>
                            <ul>
                                <li><strong>Within 24 Hours:</strong> Our education counselor will contact you via phone or email</li>
                                <li><strong>Personal Consultation:</strong> We\'ll discuss your academic goals and preferences</li>
                                <li><strong>University Shortlisting:</strong> Personalized recommendation of suitable institutions</li>
                                <li><strong>Application Guidance:</strong> Step-by-step assistance with the entire process</li>
                                <li><strong>Visa Support:</strong> Comprehensive help with visa documentation and interview preparation</li>
                            </ul>
                        </div>
                        
                        <div class="contact-info">
                            <h3>📍 Our Office Details</h3>
                            <p>🏢 <strong>Address:</strong> 16/9, Indira Road (Behind Tejgaon College), Dhaka 1212</p>
                            <p>📞 <strong>Phone:</strong> +880 XXXX-XXXXXX</p>
                            <p>🕐 <strong>Office Hours:</strong> Saturday - Thursday: 10:00 AM - 6:00 PM</p>
                            <p>📧 <strong>Email:</strong> info@eminentoverseas.uk</p>
                        </div>
                        
                        <p style="text-align: center;">
                            <a href="https://eminentoverseas.uk" class="cta-button">Visit Our Website</a>
                        </p>
                        
                        <p>If you have any urgent questions, feel free to call us directly during office hours.</p>
                        
                        <p>Best regards,<br>
                        <strong>Md. Shahriar Islam</strong><br>
                        <em>Senior Education Counselor</em><br>
                        Eminent Overseas & Consultants</p>
                    </div>
                    
                    <div class="footer">
                        <p>© ' . date('Y') . ' Eminent Overseas & Consultants. All rights reserved.</p>
                        <p>This is an automated confirmation email. Please do not reply to this address.</p>
                        <p>Reference ID: EOC-' . date('Ymd') . '-' . strtoupper(substr(md5($email . time()), 0, 8)) . '</p>
                    </div>
                </div>
            </body>
            </html>';
            
            $confirmMail->Body = $confirmBody;
            
            $confirmPlain = "Thank you for contacting Eminent Overseas & Consultants!

We have received your enquiry about studying in " . ($countryNames[$country] ?? $country) . ". Our education counselor will contact you within 24 hours (Sat-Thu, 10AM-6PM).

WHAT TO EXPECT:
1. Phone/email contact from our counselor
2. Free consultation about your study options
3. University recommendations
4. Application guidance
5. Visa support

CONTACT US:
Address: 16/9, Indira Road (Behind Tejgaon College), Dhaka 1212
Phone: +880 XXXX-XXXXXX
Hours: Sat-Thu, 10AM-6PM
Email: info@eminentoverseas.uk

Reference ID: EOC-" . date('Ymd') . '-' . strtoupper(substr(md5($email . time()), 0, 8));

            $confirmMail->AltBody = $confirmPlain;
            
            $confirmMail->send();
            
        } catch (Exception $e) {
            // Confirmation email failed - log but don't stop the process
            error_log("Confirmation email failed for {$email}: " . $e->getMessage());
        }
        
        // Success - redirect to thank you page
        header('Location: thank-you.html?ref=' . urlencode($email) . '&name=' . urlencode($firstName));
        exit;
        
    } catch (Exception $e) {
        // Log the error
        error_log("PHPMailer Error: " . $e->getMessage() . " | Form Data: " . json_encode($_POST));
        
        // User-friendly error page
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Submission Error - Eminent Overseas</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { padding: 3rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
                .error-card { max-width: 600px; margin: 0 auto; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
                .error-header { background: #dc3545; color: white; padding: 25px; text-align: center; }
                .error-content { padding: 40px; }
                .contact-alternative { background: #f8f9fa; padding: 25px; border-radius: 10px; margin-top: 25px; border-left: 4px solid #0ea5e9; }
            </style>
        </head>
        <body>
            <div class="error-card">
                <div class="error-header">
                    <h3>⚠️ Submission Error</h3>
                </div>
                <div class="error-content">
                    <h4 class="text-danger mb-4">We\'re sorry, but there was an error sending your enquiry.</h4>
                    <p>Your form was submitted successfully, but we encountered a technical issue while sending the confirmation.</p>
                    
                    <div class="contact-alternative">
                        <h5 class="mb-3">📞 Please contact us directly:</h5>
                        <p><strong>Email:</strong> info@eminentoverseas.uk</p>
                        <p><strong>Phone:</strong> +880 XXXX-XXXXXX</p>
                        <p><strong>Address:</strong> 16/9, Indira Road, Dhaka 1212</p>
                    </div>
                    
                    <div class="mt-4">
                        <a href="contact.php" class="btn btn-primary me-2">Try Again</a>
                        <a href="index.html" class="btn btn-outline-secondary">Return to Homepage</a>
                    </div>
                    
                    <p class="text-muted mt-4 small">Error Reference: ' . time() . '</p>
                </div>
            </div>
        </body>
        </html>';
        exit;
    }
} else {
    // If not POST request, redirect to contact page
    header('Location: contact.php');
    exit;
}
?>