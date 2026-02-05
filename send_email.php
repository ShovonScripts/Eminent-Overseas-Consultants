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
                    <a href="contact.php" class="btn btn-outline-danger">Go Back to Contact Form</a>
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
    $to_email = "info@eminentoverseas.com"; // CHANGE THIS TO YOUR EMAIL
    $subject = "New Contact Form Enquiry - " . $firstName . " " . $lastName;
    
    $body = "<!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #0ea5e9, #3b82f6); color: white; padding: 20px; border-radius: 8px 8px 0 0; }
            .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 8px 8px; border: 1px solid #dee2e6; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #0ea5e9; }
            .footer { margin-top: 30px; padding-top: 20px; border-top: 2px solid #0ea5e9; color: #666; font-size: 12px; }
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
                    <div>{$firstName} {$lastName}</div>
                </div>
                <div class='field'>
                    <div class='label'>Email:</div>
                    <div>{$email}</div>
                </div>
                <div class='field'>
                    <div class='label'>Phone:</div>
                    <div>{$phone}</div>
                </div>
                <div class='field'>
                    <div class='label'>Country of Interest:</div>
                    <div>" . ($countryNames[$country] ?? $country) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>Education Level:</div>
                    <div>" . ($educationLevel ? ($educationNames[$educationLevel] ?? $educationLevel) : 'Not specified') . "</div>
                </div>
                <div class='field'>
                    <div class='label'>Consent Given:</div>
                    <div>{$consent}</div>
                </div>
                <div class='field'>
                    <div class='label'>Message:</div>
                    <div style='white-space: pre-wrap; background: white; padding: 15px; border-radius: 5px; border: 1px solid #ddd;'>{$message}</div>
                </div>
                <div class='footer'>
                    <p>This enquiry was submitted from the Eminent Overseas contact form on " . date('Y-m-d H:i:s') . "</p>
                    <p>Please respond within 24 hours.</p>
                </div>
            </div>
        </div>
    </body>
    </html>";
    
    // Plain text version for non-HTML email clients
    $plainBody = "New Contact Form Enquiry\n";
    $plainBody .= "=======================\n\n";
    $plainBody .= "Name: {$firstName} {$lastName}\n";
    $plainBody .= "Email: {$email}\n";
    $plainBody .= "Phone: {$phone}\n";
    $plainBody .= "Country of Interest: " . ($countryNames[$country] ?? $country) . "\n";
    $plainBody .= "Education Level: " . ($educationLevel ? ($educationNames[$educationLevel] ?? $educationLevel) : 'Not specified') . "\n";
    $plainBody .= "Consent Given: {$consent}\n\n";
    $plainBody .= "Message:\n{$message}\n\n";
    $plainBody .= "Submitted on: " . date('Y-m-d H:i:s') . "\n";
    
    try {
        // Create PHPMailer instance
        $mail = new PHPMailer(true);
        
        // Server settings - USING YOUR EXCELEDUCATIONCENTER.COM SERVER
        $mail->isSMTP();
        $mail->Host = 'mail.exceleducationcenter.com'; // Your mail server
        $mail->SMTPAuth = true;
        $mail->Username = 'info@exceleducationcenter.com'; // Your email username
        $mail->Password = 'Pele@246'; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Using SSL/TLS
        $mail->Port = 465; // SMTP port from your settings
        
        // Enable debugging if needed
        // $mail->SMTPDebug = 2;
        // $mail->Debugoutput = function($str, $level) {
        //     error_log("SMTP level $level: $str");
        // };
        
        // Recipients
        $mail->setFrom('info@exceleducationcenter.com', 'Eminent Overseas Contact Form');
        $mail->addAddress($to_email);
        $mail->addReplyTo($email, $firstName . ' ' . $lastName);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = $plainBody;
        
        // Send email
        $mail->send();
        
        // Also send a confirmation email to the user
        try {
            $confirmMail = new PHPMailer(true);
            $confirmMail->isSMTP();
            $confirmMail->Host = 'mail.exceleducationcenter.com';
            $confirmMail->SMTPAuth = true;
            $confirmMail->Username = 'info@exceleducationcenter.com'; // Same as above
            $confirmMail->Password = 'Pele@246'; // Same as above
            $confirmMail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $confirmMail->Port = 465;
            
            $confirmMail->setFrom('info@exceleducationcenter.com', 'Eminent Overseas & Consultants');
            $confirmMail->addAddress($email, $firstName . ' ' . $lastName);
            
            $confirmMail->isHTML(true);
            $confirmMail->Subject = 'Thank You for Contacting Eminent Overseas';
            $confirmMail->Body = '
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: linear-gradient(135deg, #0ea5e9, #3b82f6); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
                    .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 8px 8px; border: 1px solid #dee2e6; }
                    .footer { margin-top: 30px; padding-top: 20px; border-top: 2px solid #0ea5e9; color: #666; font-size: 12px; text-align: center; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h2>Thank You for Contacting Us!</h2>
                    </div>
                    <div class="content">
                        <p>Dear ' . $firstName . ',</p>
                        <p>Thank you for reaching out to <strong>Eminent Overseas & Consultants</strong>. We have received your enquiry and our team will review it shortly.</p>
                        <p><strong>What happens next:</strong></p>
                        <ul>
                            <li>Our expert counselor will contact you within <strong>24 hours</strong> (during office hours: Sat-Thu, 10AM-6PM)</li>
                            <li>We\'ll discuss your study abroad goals and provide personalized guidance</li>
                            <li>You\'ll receive information about our services and next steps</li>
                        </ul>
                        <p><strong>Our Office Details:</strong><br>
                        📍 16/9, Indira Road (Behind Tejgaon College), Dhaka 1212<br>
                        📞 +880 XXXX-XXXXXX<br>
                        🕐 Saturday - Thursday: 10:00 AM - 6:00 PM</p>
                        <p>If you need immediate assistance, please call us directly.</p>
                        <p>Best regards,<br>
                        <strong>The Eminent Overseas Team</strong></p>
                    </div>
                    <div class="footer">
                        <p>© ' . date('Y') . ' Eminent Overseas & Consultants. All rights reserved.</p>
                        <p>This is an automated email. Please do not reply to this address.</p>
                    </div>
                </div>
            </body>
            </html>';
            
            $confirmMail->AltBody = "Thank you for contacting Eminent Overseas & Consultants. We have received your enquiry and will contact you within 24 hours during office hours (Sat-Thu, 10AM-6PM).";
            
            $confirmMail->send();
        } catch (Exception $e) {
            // Confirmation email failed, but main email was sent
            // Log error or continue anyway
            error_log("Confirmation email failed: " . $e->getMessage());
        }
        
        // Success response
        header('Location: contact.php?success=1');
        exit;
        
    } catch (Exception $e) {
        // Error response
        error_log("PHPMailer Error: " . $e->getMessage());
        header('Location: contact.php?error=1');
        exit;
    }
} else {
    // If not POST request, redirect to contact page
    header('Location: contact.php');
    exit;
}
?>