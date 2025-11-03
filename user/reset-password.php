<?php
require_once '../includes/db.php';
require_once '../includes/session.php';
require_once '../includes/auth.php';
require_once '../includes/helpers.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect(baseUrl('user/profile.php'));
}

$pageTitle = 'Reset Password';
$token = get('token', '');
$tokenValid = false;
$resetData = null;

// Verify token
if (!empty($token)) {
    $resetData = verifyResetToken($token);
    $tokenValid = $resetData !== false;
}

// Handle form submission
if (isPost() && $tokenValid) {
    $newPassword = post('new_password');
    $confirmPassword = post('confirm_password');
    $csrfToken = post('csrf_token');
    $tokenPost = post('token');
    
    if (!verifyCsrfToken($csrfToken)) {
        setFlash('error', 'Invalid request. Please try again.');
    } elseif (empty($newPassword) || empty($confirmPassword)) {
        setFlash('error', 'All fields are required');
    } elseif (strlen($newPassword) < 6) {
        setFlash('error', 'Password must be at least 6 characters');
    } elseif ($newPassword !== $confirmPassword) {
        setFlash('error', 'Passwords do not match');
    } else {
        // Verify token again
        $resetData = verifyResetToken($tokenPost);
        
        if ($resetData) {
            // Get user
            $user = queryOne("SELECT * FROM users WHERE email = ?", [$resetData['email']]);
            
            if ($user) {
                // Update password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updated = execute("UPDATE users SET password = ? WHERE id = ?", [$hashedPassword, $user['id']]);
                
                if ($updated) {
                    // Delete used token
                    deleteResetToken($tokenPost);
                    
                    setFlash('success', 'Password reset successfully! You can now login with your new password.');
                    redirect(baseUrl('user/login.php'));
                } else {
                    setFlash('error', 'Failed to update password. Please try again.');
                }
            } else {
                setFlash('error', 'User not found');
            }
        } else {
            setFlash('error', 'Invalid or expired token');
        }
    }
}

include '../includes/header.php';
?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-lock fa-4x text-primary mb-3"></i>
                            <h2 class="fw-bold">Reset Password</h2>
                            <p class="text-muted">Enter your new password</p>
                        </div>
                        
                        <?php if (!$tokenValid): ?>
                            <div class="alert alert-danger">
                                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Invalid or Expired Link</h5>
                                <p class="mb-0">This password reset link is invalid or has expired. Reset links are valid for 30 minutes.</p>
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="<?php echo baseUrl('user/forgot-password.php'); ?>" class="btn btn-primary">
                                    <i class="fas fa-redo"></i> Request New Reset Link
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-info-circle"></i> Resetting password for: <strong><?php echo htmlspecialchars($resetData['email']); ?></strong>
                            </div>
                            
                            <form method="POST" action="">
                                <?php echo csrfField(); ?>
                                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                                
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="new_password" name="new_password" required autofocus>
                                    </div>
                                    <small class="text-muted">Minimum 6 characters</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="showPassword" onclick="togglePasswordVisibility()">
                                        <label class="form-check-label" for="showPassword">
                                            Show passwords
                                        </label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                    <i class="fas fa-check"></i> Reset Password
                                </button>
                                
                                <div class="text-center">
                                    <p class="mb-0">
                                        <a href="<?php echo baseUrl('user/login.php'); ?>" class="text-decoration-none">
                                            <i class="fas fa-arrow-left"></i> Back to Login
                                        </a>
                                    </p>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <a href="<?php echo baseUrl('index.php'); ?>" class="text-muted text-decoration-none">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function togglePasswordVisibility() {
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');
    const checkbox = document.getElementById('showPassword');
    
    const type = checkbox.checked ? 'text' : 'password';
    newPassword.type = type;
    confirmPassword.type = type;
}
</script>

<?php include '../includes/footer.php'; ?>
