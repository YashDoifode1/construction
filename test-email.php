<?php
/**
 * Email Testing Script
 * 
 * This script helps you test your email configuration
 * Access it at: http://localhost/const/test-email.php
 */

require_once 'includes/db.php';
require_once 'includes/helpers.php';
require_once 'includes/mail.php';

// Only allow in development mode
if (!defined('DEBUG_MODE') || !DEBUG_MODE) {
    die('This script is only available in development mode.');
}

$pageTitle = 'Email Test';
$testResult = null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $testEmail = filter_var($_POST['test_email'] ?? '', FILTER_SANITIZE_EMAIL);
    $testType = $_POST['test_type'] ?? 'reset';
    
    if (!filter_var($testEmail, FILTER_VALIDATE_EMAIL)) {
        $testResult = ['success' => false, 'message' => 'Invalid email address'];
    } else {
        switch ($testType) {
            case 'reset':
                $token = bin2hex(random_bytes(32));
                $success = sendPasswordResetEmail($testEmail, $token);
                $testResult = [
                    'success' => $success,
                    'message' => $success 
                        ? 'Password reset email sent successfully!' 
                        : 'Failed to send password reset email. Check your SMTP settings.'
                ];
                break;
                
            case 'welcome':
                $success = sendWelcomeEmail($testEmail, 'Test User');
                $testResult = [
                    'success' => $success,
                    'message' => $success 
                        ? 'Welcome email sent successfully!' 
                        : 'Failed to send welcome email. Check your SMTP settings.'
                ];
                break;
                
            case 'custom':
                $success = sendEmail(
                    $testEmail,
                    'Test Email from SmartBuild',
                    '<h1>Test Email</h1><p>This is a test email from your SmartBuild application.</p>',
                    'This is a test email from your SmartBuild application.'
                );
                $testResult = [
                    'success' => $success,
                    'message' => $success 
                        ? 'Custom email sent successfully!' 
                        : 'Failed to send custom email. Check your SMTP settings.'
                ];
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - SmartBuild</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 50px 0;
        }
        .test-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .config-info {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="test-card p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-envelope-open-text fa-4x text-primary mb-3"></i>
                        <h1 class="fw-bold">Email Configuration Test</h1>
                        <p class="text-muted">Test your PHPMailer setup</p>
                    </div>

                    <?php if ($testResult): ?>
                        <div class="alert alert-<?php echo $testResult['success'] ? 'success' : 'danger'; ?> alert-dismissible fade show">
                            <i class="fas fa-<?php echo $testResult['success'] ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                            <?php echo htmlspecialchars($testResult['message']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="config-info">
                        <h5><i class="fas fa-cog"></i> Current Configuration</h5>
                        <table class="table table-sm mb-0">
                            <tr>
                                <td><strong>SMTP Host:</strong></td>
                                <td><?php echo defined('SMTP_HOST') ? htmlspecialchars(SMTP_HOST) : 'Not configured'; ?></td>
                            </tr>
                            <tr>
                                <td><strong>SMTP Port:</strong></td>
                                <td><?php echo defined('SMTP_PORT') ? SMTP_PORT : 'Not configured'; ?></td>
                            </tr>
                            <tr>
                                <td><strong>SMTP User:</strong></td>
                                <td><?php echo defined('SMTP_USER') ? htmlspecialchars(SMTP_USER) : 'Not configured'; ?></td>
                            </tr>
                            <tr>
                                <td><strong>From Email:</strong></td>
                                <td><?php echo defined('SMTP_FROM_EMAIL') ? htmlspecialchars(SMTP_FROM_EMAIL) : 'Not configured'; ?></td>
                            </tr>
                        </table>
                    </div>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="test_email" class="form-label">Test Email Address</label>
                            <input type="email" class="form-control" id="test_email" name="test_email" 
                                   placeholder="your@email.com" required>
                            <small class="text-muted">Enter the email address where you want to receive the test email</small>
                        </div>

                        <div class="mb-3">
                            <label for="test_type" class="form-label">Email Type</label>
                            <select class="form-select" id="test_type" name="test_type" required>
                                <option value="reset">Password Reset Email</option>
                                <option value="welcome">Welcome Email</option>
                                <option value="custom">Custom Test Email</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-paper-plane"></i> Send Test Email
                        </button>
                    </form>

                    <hr class="my-4">

                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Setup Instructions</h6>
                        <ol class="mb-0">
                            <li>Install PHPMailer: Run <code>composer install</code></li>
                            <li>Configure SMTP settings in <code>config.php</code></li>
                            <li>Use this page to test your email configuration</li>
                            <li>Check your email inbox (and spam folder)</li>
                        </ol>
                        <p class="mb-0 mt-2">
                            <a href="EMAIL_SETUP.md" target="_blank">📖 Read Full Setup Guide</a>
                        </p>
                    </div>

                    <div class="text-center mt-4">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
