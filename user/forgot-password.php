<?php
require_once '../includes/db.php';
require_once '../includes/session.php';
require_once '../includes/helpers.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect(baseUrl('user/profile.php'));
}

$pageTitle = 'Forgot Password';

// Handle form submission
if (isPost()) {
    $email = sanitize(post('email'));
    $csrfToken = post('csrf_token');
    
    if (!verifyCsrfToken($csrfToken)) {
        setFlash('error', 'Invalid request. Please try again.');
    } elseif (empty($email)) {
        setFlash('error', 'Email address is required');
    } elseif (!isValidEmail($email)) {
        setFlash('error', 'Invalid email address');
    } else {
        // Check if user exists
        $user = queryOne("SELECT * FROM users WHERE email = ?", [$email]);
        
        if ($user) {
            // Clean old tokens for this email
            execute("DELETE FROM password_resets WHERE email = ?", [$email]);
            
            // Create reset token and send email
            $token = createPasswordReset($email, true);
            
            if ($token) {
                setFlash('success', 'Password reset instructions have been sent to your email!');
                redirect(baseUrl('user/forgot-password.php?sent=1'));
            } else {
                setFlash('error', 'Failed to generate reset token. Please try again.');
            }
        } else {
            // Don't reveal if email exists or not (security)
            setFlash('success', 'If that email exists, reset instructions have been sent.');
            redirect(baseUrl('user/forgot-password.php?sent=1'));
        }
    }
}

// Clean expired tokens
cleanExpiredTokens();

include '../includes/header.php';
?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-key fa-4x text-primary mb-3"></i>
                            <h2 class="fw-bold">Forgot Password?</h2>
                            <p class="text-muted">Enter your email to reset your password</p>
                        </div>
                        
                        <?php if (get('sent')): ?>
                            <div class="alert alert-success">
                                <h5 class="alert-heading"><i class="fas fa-check-circle"></i> Email Sent!</h5>
                                <p class="mb-2">If an account exists with that email address, you will receive password reset instructions shortly.</p>
                                <hr>
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-info-circle text-info me-2 mt-1"></i>
                                    <div>
                                        <p class="mb-1"><strong>What to do next:</strong></p>
                                        <ol class="mb-0 ps-3">
                                            <li>Check your email inbox</li>
                                            <li>Click the reset link in the email</li>
                                            <li>Create your new password</li>
                                        </ol>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-3">
                                    <i class="fas fa-clock"></i> The reset link will expire in 30 minutes for security reasons.
                                </small>
                            </div>
                            
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> <strong>Didn't receive the email?</strong>
                                <ul class="mb-0 mt-2 ps-3">
                                    <li>Check your spam/junk folder</li>
                                    <li>Make sure you entered the correct email</li>
                                    <li>Wait a few minutes and try again</li>
                                </ul>
                            </div>
                            
                            <div class="text-center">
                                <a href="<?php echo baseUrl('user/forgot-password.php'); ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-redo"></i> Try Again
                                </a>
                            </div>
                        <?php else: ?>
                            <form method="POST" action="">
                                <?php echo csrfField(); ?>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="your@email.com" required autofocus>
                                    </div>
                                    <small class="text-muted">Enter the email address associated with your account</small>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                    <i class="fas fa-paper-plane"></i> Send Reset Link
                                </button>
                                
                                <div class="text-center">
                                    <p class="mb-0">
                                        Remember your password? 
                                        <a href="<?php echo baseUrl('user/login.php'); ?>" class="text-decoration-none">Login here</a>
                                    </p>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <a href="<?php echo baseUrl('index.php'); ?>" class="text-muted text-decoration-none">
                        <i class="fas fa-arrow-left"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
