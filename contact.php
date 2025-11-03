<?php
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/helpers.php';

$pageTitle = 'Contact Us';

// Handle form submission
if (isPost()) {
    $name = sanitize(post('name'));
    $email = sanitize(post('email'));
    $phone = sanitize(post('phone'));
    $message = sanitize(post('message'));
    $csrfToken = post('csrf_token');
    
    if (!verifyCsrfToken($csrfToken)) {
        setFlash('error', 'Invalid request. Please try again.');
    } elseif (empty($name) || empty($email) || empty($phone) || empty($message)) {
        setFlash('error', 'All fields are required');
    } elseif (!isValidEmail($email)) {
        setFlash('error', 'Invalid email address');
    } else {
        $sql = "INSERT INTO contacts (name, email, phone, message) VALUES (?, ?, ?, ?)";
        $result = execute($sql, [$name, $email, $phone, $message]);
        
        if ($result) {
            setFlash('success', 'Thank you for contacting us! We will get back to you soon.');
            redirect(baseUrl('contact.php'));
        } else {
            setFlash('error', 'Failed to send message. Please try again.');
        }
    }
}

include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">Contact Us</h1>
        <p class="lead">Get in Touch with SmartBuild Developers</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4">Send Us a Message</h3>
                        
                        <form method="POST" action="">
                            <?php echo csrfField(); ?>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="col-lg-5">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4">Contact Information</h4>
                        
                        <div class="mb-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-box bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; flex-shrink: 0;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Address</h6>
                                    <p class="text-muted mb-0">123 Construction Avenue<br>Builder City, BC 12345</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-box bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; flex-shrink: 0;">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Phone</h6>
                                    <p class="text-muted mb-0">+1-800-SMARTBUILD</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-box bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; flex-shrink: 0;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Email</h6>
                                    <p class="text-muted mb-0">info@smartbuild.com</p>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <h6 class="fw-bold mb-3">Business Hours</h6>
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Monday - Friday:</span>
                                <span class="fw-bold">9:00 AM - 6:00 PM</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Saturday:</span>
                                <span class="fw-bold">10:00 AM - 4:00 PM</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Sunday:</span>
                                <span class="fw-bold">Closed</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Follow Us</h5>
                        <div class="d-flex gap-3">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook fa-lg"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger btn-sm">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-linkedin fa-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section (Placeholder) -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="card border-0 shadow">
            <div class="card-body p-0">
                <div class="bg-secondary text-white text-center py-5" style="min-height: 400px;">
                    <i class="fas fa-map-marked-alt fa-5x mb-3" style="opacity: 0.3;"></i>
                    <h4>Map Location</h4>
                    <p class="text-muted">Google Maps integration can be added here</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
