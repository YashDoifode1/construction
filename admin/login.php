<?php
require_once '../includes/db.php';
require_once '../includes/session.php';
require_once '../includes/auth.php';
require_once '../includes/helpers.php';

// Redirect if already logged in as admin
if (isAdmin()) {
    redirect(baseUrl('admin/dashboard.php'));
}

$pageTitle = 'Admin Login';

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
            if ($result['user']['role'] === 'admin') {
                setFlash('success', 'Welcome back, Admin!');
                redirect(baseUrl('admin/dashboard.php'));
            } else {
                destroyUserSession();
                setFlash('error', 'Access denied. Admin privileges required.');
            }
        } else {
            setFlash('error', $result['message']);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SmartBuild Developers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <?php
                $flash = getFlash();
                if ($flash):
                ?>
                <div class="alert alert-<?php echo $flash['type'] === 'error' ? 'danger' : $flash['type']; ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($flash['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-user-shield fa-2x"></i>
                            </div>
                            <h2 class="fw-bold">Admin Login</h2>
                            <p class="text-muted">SmartBuild Developers</p>
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
                            
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="fas fa-sign-in-alt"></i> Login to Dashboard
                            </button>
                            
                            <div class="text-center">
                                <a href="<?php echo baseUrl('index.php'); ?>" class="text-muted text-decoration-none small">
                                    <i class="fas fa-arrow-left"></i> Back to Website
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-3 text-white small">
                    <p>Default credentials: admin@smartbuild.com / admin123</p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
