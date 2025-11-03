<?php
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/helpers.php';

$pageTitle = 'Home';

// Fetch featured data
$featuredPlots = query("SELECT * FROM plots WHERE status = 'available' ORDER BY created_at DESC LIMIT 3");
$featuredProjects = query("SELECT * FROM projects WHERE status = 'completed' ORDER BY created_at DESC LIMIT 3");

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-6">
                <h1 class="display-3 fw-bold mb-4">Building Dreams, Shaping Skylines</h1>
                <p class="lead mb-4">Your trusted partner in construction excellence. We transform visions into reality with quality, innovation, and dedication.</p>
                <div class="d-flex gap-3">
                    <a href="<?php echo baseUrl('plots.php'); ?>" class="btn btn-warning btn-lg">
                        <i class="fas fa-map-marked-alt"></i> Explore Plots
                    </a>
                    <a href="<?php echo baseUrl('quote.php'); ?>" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-file-invoice"></i> Get Quote
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-city" style="font-size: 15rem; opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="feature-box p-4">
                    <div class="icon-box mb-3">
                        <i class="fas fa-award fa-3x text-warning"></i>
                    </div>
                    <h5 class="fw-bold">Quality Construction</h5>
                    <p class="text-muted">Premium materials and expert craftsmanship</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-box p-4">
                    <div class="icon-box mb-3">
                        <i class="fas fa-users fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Expert Team</h5>
                    <p class="text-muted">Experienced professionals at your service</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-box p-4">
                    <div class="icon-box mb-3">
                        <i class="fas fa-clock fa-3x text-success"></i>
                    </div>
                    <h5 class="fw-bold">Timely Delivery</h5>
                    <p class="text-muted">Projects completed on schedule</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-box p-4">
                    <div class="icon-box mb-3">
                        <i class="fas fa-handshake fa-3x text-info"></i>
                    </div>
                    <h5 class="fw-bold">Customer Satisfaction</h5>
                    <p class="text-muted">Your happiness is our priority</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Our Services</h2>
            <p class="lead text-muted">Comprehensive construction solutions for all your needs</p>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-home fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-bold">Residential Construction</h5>
                        <p class="card-text text-muted">Build your dream home with our expert residential construction services.</p>
                        <a href="<?php echo baseUrl('services.php'); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-building fa-3x text-warning mb-3"></i>
                        <h5 class="card-title fw-bold">Commercial Projects</h5>
                        <p class="card-text text-muted">Professional commercial construction for offices, malls, and more.</p>
                        <a href="<?php echo baseUrl('services.php'); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-paint-roller fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Interior Design</h5>
                        <p class="card-text text-muted">Transform spaces with our creative interior design solutions.</p>
                        <a href="<?php echo baseUrl('services.php'); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Projects -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Featured Projects</h2>
            <p class="lead text-muted">Showcasing our finest work</p>
        </div>
        
        <div class="row">
            <?php foreach ($featuredProjects as $project): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow">
                    <div class="position-relative">
                        <img src="<?php echo asset('images/' . ($project['image'] ?? 'placeholder.jpg')); ?>" 
                             class="card-img-top" alt="<?php echo htmlspecialchars($project['title']); ?>" 
                             style="height: 250px; object-fit: cover;">
                        <span class="position-absolute top-0 end-0 m-3">
                            <?php echo getStatusBadge($project['status']); ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?php echo htmlspecialchars($project['title']); ?></h5>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($project['location']); ?>
                        </p>
                        <p class="card-text"><?php echo truncate($project['description'], 100); ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="<?php echo baseUrl('projects.php'); ?>" class="btn btn-sm btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?php echo baseUrl('projects.php'); ?>" class="btn btn-primary btn-lg">View All Projects</a>
        </div>
    </div>
</section>

<!-- Available Plots -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Available Plots</h2>
            <p class="lead text-muted">Find your perfect plot for construction</p>
        </div>
        
        <div class="row">
            <?php foreach ($featuredPlots as $plot): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title fw-bold mb-0">Plot <?php echo htmlspecialchars($plot['plot_no']); ?></h5>
                            <?php echo getStatusBadge($plot['status']); ?>
                        </div>
                        <p class="text-muted mb-2">
                            <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($plot['location']); ?>
                        </p>
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted">Size</small>
                                <p class="fw-bold mb-0"><?php echo htmlspecialchars($plot['size']); ?></p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Price</small>
                                <p class="fw-bold mb-0 text-primary"><?php echo formatCurrency($plot['price']); ?></p>
                            </div>
                        </div>
                        <p class="card-text small"><?php echo truncate($plot['description'], 80); ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="<?php echo baseUrl('plots.php'); ?>" class="btn btn-sm btn-warning w-100">
                            <i class="fas fa-info-circle"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?php echo baseUrl('plots.php'); ?>" class="btn btn-warning btn-lg">Browse All Plots</a>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">What Our Clients Say</h2>
            <p class="lead text-muted">Trusted by hundreds of satisfied customers</p>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text">"SmartBuild delivered our dream home exactly as we envisioned. Professional, timely, and excellent quality!"</p>
                        <div class="d-flex align-items-center mt-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fw-bold">JD</span>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold">John Doe</h6>
                                <small class="text-muted">Homeowner</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text">"Outstanding commercial project execution. Their team's expertise and attention to detail is remarkable."</p>
                        <div class="d-flex align-items-center mt-3">
                            <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fw-bold">SM</span>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold">Sarah Miller</h6>
                                <small class="text-muted">Business Owner</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text">"Best investment decision! The plot I purchased has excellent potential and the booking process was seamless."</p>
                        <div class="d-flex align-items-center mt-3">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fw-bold">RJ</span>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold">Robert Johnson</h6>
                                <small class="text-muted">Investor</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-4">Ready to Start Your Project?</h2>
        <p class="lead mb-4">Let's build something amazing together</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="<?php echo baseUrl('contact.php'); ?>" class="btn btn-light btn-lg">
                <i class="fas fa-envelope"></i> Contact Us
            </a>
            <a href="<?php echo baseUrl('quote.php'); ?>" class="btn btn-warning btn-lg">
                <i class="fas fa-file-invoice"></i> Request Quote
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
