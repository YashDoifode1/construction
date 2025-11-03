<?php
require_once '../includes/db.php';
require_once '../includes/session.php';
require_once '../includes/auth.php';
require_once '../includes/helpers.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect(baseUrl('user/profile.php'));
}

$pageTitle = 'Login';

// Handle login
if (isPost()) {
    $email = sanitize(post('email'));
    $password = post('password');
    $csrfToken = post('csrf_token');
    
    if (!verifyCsrfToken($csrfToken)) {
        setFlash('error', 'Invalid request. Please try again.');
    } elseif (empty($email) || empty($password)) {
        setFlash('error', 'Email and password are required');
    } else {
        $result = loginUser($email, $password);
        
        if ($result['success']) {
            setFlash('success', 'Welcome back, ' . $result['user']['full_name'] . '!');
            
            // Check for redirect
            $redirect = get('redirect', '');
            if ($redirect) {
                redirect(baseUrl($redirect));
            } else {
                redirect(baseUrl('user/profile.php'));
            }
        } else {
            setFlash('error', $result['message']);
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
                            <i class="fas fa-user-circle fa-4x text-primary mb-3"></i>
                            <h2 class="fw-bold">Login</h2>
                            <p class="text-muted">Welcome back! Please login to your account.</p>
                        </div>
                        
                        <form method="POST" action="">
                            <?php echo csrfField(); ?>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <a href="<?php echo baseUrl('user/forgot-password.php'); ?>" class="text-decoration-none small">
                                    Forgot Password?
                                </a>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                            
                            <div class="text-center">
                                <p class="mb-0">Don't have an account? <a href="<?php echo baseUrl('user/register.php'); ?>" class="text-decoration-none">Register here</a></p>
                            </div>
                        </form>
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
