<?php
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/helpers.php';

$pageTitle = 'Request a Quote';

// Handle form submission
if (isPost()) {
    $name = sanitize(post('name'));
    $email = sanitize(post('email'));
    $phone = sanitize(post('phone'));
    $projectType = sanitize(post('project_type'));
    $budget = sanitize(post('budget'));
    $location = sanitize(post('location'));
    $description = sanitize(post('description'));
    $csrfToken = post('csrf_token');
    
    if (!verifyCsrfToken($csrfToken)) {
        setFlash('error', 'Invalid request. Please try again.');
    } elseif (empty($name) || empty($email) || empty($phone) || empty($projectType) || empty($description)) {
        setFlash('error', 'Please fill all required fields');
    } elseif (!isValidEmail($email)) {
        setFlash('error', 'Invalid email address');
    } else {
        $sql = "INSERT INTO quotes (name, email, phone, project_type, budget, location, description) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $result = execute($sql, [$name, $email, $phone, $projectType, $budget, $location, $description]);
        
        if ($result) {
            setFlash('success', 'Quote request submitted successfully! We will contact you soon.');
            redirect(baseUrl('quote.php'));
        } else {
            setFlash('error', 'Failed to submit request. Please try again.');
        }
    }
}

include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">Request a Quote</h1>
        <p class="lead">Tell us about your project and get a free estimate</p>
    </div>
</section>

<!-- Quote Form Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Project Details</h3>
                        
                        <form method="POST" action="">
                            <?php echo csrfField(); ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="project_type" class="form-label">Project Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="project_type" name="project_type" required>
                                        <option value="">Select Project Type</option>
                                        <option value="Residential Construction">Residential Construction</option>
                                        <option value="Commercial Construction">Commercial Construction</option>
                                        <option value="Interior Design">Interior Design</option>
                                        <option value="Renovation">Renovation</option>
                                        <option value="Consulting">Consulting</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="budget" class="form-label">Estimated Budget</label>
                                    <select class="form-select" id="budget" name="budget">
                                        <option value="">Select Budget Range</option>
                                        <option value="Under $50,000">Under $50,000</option>
                                        <option value="$50,000 - $100,000">$50,000 - $100,000</option>
                                        <option value="$100,000 - $250,000">$100,000 - $250,000</option>
                                        <option value="$250,000 - $500,000">$250,000 - $500,000</option>
                                        <option value="$500,000+">$500,000+</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="location" class="form-label">Project Location</label>
                                    <input type="text" class="form-control" id="location" name="location" placeholder="City, State">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="description" class="form-label">Project Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="6" placeholder="Please provide details about your project requirements, timeline, and any specific needs..." required></textarea>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> <strong>Note:</strong> All quote requests are reviewed within 24-48 hours. Our team will contact you to discuss your project in detail.
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-paper-plane"></i> Submit Quote Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">What Happens Next?</h2>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <span class="h2 mb-0">1</span>
                    </div>
                    <h5 class="fw-bold">Review</h5>
                    <p class="text-muted">Our team reviews your project requirements and budget</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <span class="h2 mb-0">2</span>
                    </div>
                    <h5 class="fw-bold">Consultation</h5>
                    <p class="text-muted">We schedule a call to discuss your project in detail</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <span class="h2 mb-0">3</span>
                    </div>
                    <h5 class="fw-bold">Proposal</h5>
                    <p class="text-muted">Receive a detailed quote and project timeline</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
