<?php
/**
 * Email Helper Functions using PHPMailer
 */

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Send email using PHPMailer
 */
function sendEmail($to, $subject, $body, $altBody = '') {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        if (defined('SMTP_HOST') && SMTP_HOST !== 'smtp.example.com') {
            // Use SMTP
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;
        } else {
            // Use PHP mail() function
            $mail->isMail();
        }
        
        // Recipients
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress($to);
        $mail->addReplyTo(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $altBody ?: strip_tags($body);
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email Error: {$mail->ErrorInfo}");
        return false;
    }
}

/**
 * Send password reset email
 */
function sendPasswordResetEmail($email, $token) {
    $resetLink = baseUrl('user/reset-password.php?token=' . $token);
    $siteName = defined('APP_NAME') ? APP_NAME : 'SmartBuild Developers';
    
    $subject = "Password Reset Request - {$siteName}";
    
    $body = getPasswordResetEmailTemplate($email, $resetLink, $siteName);
    
    $altBody = "Hello,\n\n"
             . "You have requested to reset your password for {$siteName}.\n\n"
             . "Click the link below to reset your password:\n"
             . "{$resetLink}\n\n"
             . "This link will expire in 30 minutes.\n\n"
             . "If you did not request this password reset, please ignore this email.\n\n"
             . "Best regards,\n"
             . "{$siteName} Team";
    
    return sendEmail($email, $subject, $body, $altBody);
}

/**
 * Get password reset email HTML template
 */
function getPasswordResetEmailTemplate($email, $resetLink, $siteName) {
    return '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 40px 30px;
        }
        .content h2 {
            color: #667eea;
            margin-top: 0;
        }
        .button {
            display: inline-block;
            padding: 14px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            opacity: 0.9;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .link-text {
            word-break: break-all;
            color: #667eea;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Password Reset Request</h1>
        </div>
        <div class="content">
            <h2>Hello!</h2>
            <p>You have requested to reset your password for your <strong>' . htmlspecialchars($siteName) . '</strong> account.</p>
            
            <p>Click the button below to reset your password:</p>
            
            <div style="text-align: center;">
                <a href="' . htmlspecialchars($resetLink) . '" class="button">Reset Password</a>
            </div>
            
            <div class="info-box">
                <strong>⏰ Important:</strong> This link will expire in <strong>30 minutes</strong> for security reasons.
            </div>
            
            <p>If the button doesn\'t work, copy and paste this link into your browser:</p>
            <p class="link-text">' . htmlspecialchars($resetLink) . '</p>
            
            <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
            
            <p style="color: #666; font-size: 14px;">
                <strong>Didn\'t request this?</strong><br>
                If you did not request a password reset, please ignore this email. Your password will remain unchanged.
            </p>
        </div>
        <div class="footer">
            <p>© ' . date('Y') . ' ' . htmlspecialchars($siteName) . '. All rights reserved.</p>
            <p>This is an automated email. Please do not reply to this message.</p>
        </div>
    </div>
</body>
</html>';
}

/**
 * Send welcome email to new users
 */
function sendWelcomeEmail($email, $name) {
    $siteName = defined('APP_NAME') ? APP_NAME : 'SmartBuild Developers';
    $subject = "Welcome to {$siteName}!";
    
    $body = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 40px 30px;
        }
        .button {
            display: inline-block;
            padding: 14px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Welcome to ' . htmlspecialchars($siteName) . '!</h1>
        </div>
        <div class="content">
            <h2>Hello ' . htmlspecialchars($name) . '!</h2>
            <p>Thank you for registering with <strong>' . htmlspecialchars($siteName) . '</strong>.</p>
            <p>Your account has been successfully created and you can now access all our services.</p>
            
            <div style="text-align: center;">
                <a href="' . baseUrl('user/login.php') . '" class="button">Login to Your Account</a>
            </div>
            
            <p>If you have any questions or need assistance, please don\'t hesitate to contact us.</p>
        </div>
        <div class="footer">
            <p>© ' . date('Y') . ' ' . htmlspecialchars($siteName) . '. All rights reserved.</p>
        </div>
    </div>
</body>
</html>';
    
    $altBody = "Hello {$name},\n\nThank you for registering with {$siteName}.\n\nYour account has been successfully created.\n\nBest regards,\n{$siteName} Team";
    
    return sendEmail($email, $subject, $body, $altBody);
}

/**
 * Send contact form notification email
 */
function sendContactNotification($data) {
    $siteName = defined('APP_NAME') ? APP_NAME : 'SmartBuild Developers';
    $adminEmail = defined('COMPANY_EMAIL') ? COMPANY_EMAIL : SMTP_FROM_EMAIL;
    
    $subject = "New Contact Form Submission - {$siteName}";
    
    $body = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: #667eea;
            color: #ffffff;
            padding: 20px 30px;
        }
        .content {
            padding: 30px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field label {
            font-weight: bold;
            color: #667eea;
        }
        .field p {
            margin: 5px 0 0 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>📧 New Contact Form Submission</h2>
        </div>
        <div class="content">
            <div class="field">
                <label>Name:</label>
                <p>' . htmlspecialchars($data['name']) . '</p>
            </div>
            <div class="field">
                <label>Email:</label>
                <p>' . htmlspecialchars($data['email']) . '</p>
            </div>
            <div class="field">
                <label>Phone:</label>
                <p>' . htmlspecialchars($data['phone'] ?? 'Not provided') . '</p>
            </div>
            <div class="field">
                <label>Subject:</label>
                <p>' . htmlspecialchars($data['subject']) . '</p>
            </div>
            <div class="field">
                <label>Message:</label>
                <p>' . nl2br(htmlspecialchars($data['message'])) . '</p>
            </div>
            <div class="field">
                <label>Submitted:</label>
                <p>' . date('M d, Y h:i A') . '</p>
            </div>
        </div>
    </div>
</body>
</html>';
    
    return sendEmail($adminEmail, $subject, $body);
}
