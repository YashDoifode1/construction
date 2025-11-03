<?php
require_once '../includes/db.php';
require_once '../includes/session.php';
require_once '../includes/auth.php';
require_once '../includes/helpers.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect(baseUrl('user/profile.php'));
}

$pageTitle = 'Register';

// Handle registration
if (isPost()) {
    $fullName = sanitize(post('full_name'));
    $email = sanitize(post('email'));
    $phone = sanitize(post('phone'));
    $password = post('password');
    $confirmPassword = post('confirm_password');
    $csrfToken = post('csrf_token');
    
    if (!verifyCsrfToken($csrfToken)) {
        setFlash('error', 'Invalid request. Please try again.');
    } elseif (empty($fullName) || empty($email) || empty($phone) || empty($password)) {
        setFlash('error', 'All fields are required');
    } elseif (!isValidEmail($email)) {
        setFlash('error', 'Invalid email address');
    } elseif (strlen($password) < 6) {
        setFlash('error', 'Password must be at least 6 characters');
    } elseif ($password !== $confirmPassword) {
        setFlash('error', 'Passwords do not match');
    } else {
        $result = registerUser($fullName, $email, $phone, $password);
        
        if ($result['success']) {
            setFlash('success', 'Registration successful! Please login.');
            redirect(baseUrl('user/login.php'));
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
                            <i class="fas fa-user-plus fa-4x text-primary mb-3"></i>
                            <h2 class="fw-bold">Create Account</h2>
                            <p class="text-muted">Join SmartBuild Developers today!</p>
                        </div>
                        
                        <form method="POST" action="">
                            <?php echo csrfField(); ?>
                            
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="full_name" name="full_name" required autofocus>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <small class="text-muted">Minimum 6 characters</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" class="text-decoration-none">Terms & Conditions</a>
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="fas fa-user-plus"></i> Register
                            </button>
                            
                            <div class="text-center">
                                <p class="mb-0">Already have an account? <a href="<?php echo baseUrl('user/login.php'); ?>" class="text-decoration-none">Login here</a></p>
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
