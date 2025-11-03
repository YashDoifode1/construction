<?php
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/helpers.php';

$pageTitle = 'Home';
$metaDescription = 'SmartBuild Developers - #1 Construction Company in Nagpur, Maharashtra. Expert builders for residential & commercial projects, plot development in Nagpur. 500+ satisfied clients. Call now for free consultation!';
$metaKeywords = 'construction company in Nagpur, best builders Nagpur, residential construction Nagpur, commercial builders Nagpur, plot booking Nagpur, construction services Nagpur city, builders in Nagpur Maharashtra, real estate developers Nagpur, house construction Nagpur, building contractors Nagpur';

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
                <h1 class="display-3 fw-bold mb-4">Nagpur's Premier Construction Company</h1>
                <p class="lead mb-4">Building Dreams Across Nagpur Since 2015. Your trusted local partner in construction excellence. We transform visions into reality with quality, innovation, and dedication.</p>
                <div class="mb-4">
                    <span class="badge bg-warning text-dark me-2"><i class="fas fa-map-marker-alt"></i> Serving Nagpur & Surrounding Areas</span>
                    <span class="badge bg-light text-dark me-2"><i class="fas fa-star"></i> 4.8/5 Rating</span>
                    <span class="badge bg-light text-dark"><i class="fas fa-users"></i> 500+ Happy Clients</span>
                </div>
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

<!-- Location Badge -->
<section class="py-3 bg-warning">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-md-12">
                <p class="mb-0 fw-bold">
                    <i class="fas fa-map-marker-alt"></i> Proudly Serving: Nagpur | Wardha | Bhandara | Gondia | Chandrapur | Amravati | Yavatmal
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Why Choose SmartBuild in Nagpur?</h2>
            <p class="text-muted">Nagpur's Most Trusted Construction Partner</p>
        </div>
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="feature-box p-4">
                    <div class="icon-box mb-3">
                        <i class="fas fa-award fa-3x text-warning"></i>
                    </div>
                    <h5 class="fw-bold">Quality Construction</h5>
                    <p class="text-muted">Premium materials and expert craftsmanship for Nagpur's climate</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-box p-4">
                    <div class="icon-box mb-3">
                        <i class="fas fa-users fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Local Expert Team</h5>
                    <p class="text-muted">50+ experienced professionals based in Nagpur</p>
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
            <h2 class="display-5 fw-bold">Construction Services in Nagpur</h2>
            <p class="lead text-muted">Comprehensive construction solutions tailored for Nagpur residents</p>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-home fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-bold">Residential Construction in Nagpur</h5>
                        <p class="card-text text-muted">Build your dream home in Nagpur with our expert residential construction services. Perfect for Nagpur's climate and lifestyle.</p>
                        <a href="<?php echo baseUrl('services.php'); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-building fa-3x text-warning mb-3"></i>
                        <h5 class="card-title fw-bold">Commercial Projects in Nagpur</h5>
                        <p class="card-text text-muted">Professional commercial construction for offices, malls, and businesses across Nagpur and Vidarbha region.</p>
                        <a href="<?php echo baseUrl('services.php'); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-paint-roller fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Interior Design Nagpur</h5>
                        <p class="card-text text-muted">Transform your Nagpur home or office with our creative interior design solutions tailored to local preferences.</p>
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

<!-- Nagpur Areas We Serve -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Areas We Serve in Nagpur</h2>
            <p class="lead text-muted">Bringing quality construction to every corner of Nagpur</p>
        </div>
        
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 text-center p-3">
                    <i class="fas fa-map-marker-alt text-primary fa-2x mb-2"></i>
                    <h6 class="fw-bold mb-0">Civil Lines</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 text-center p-3">
                    <i class="fas fa-map-marker-alt text-primary fa-2x mb-2"></i>
                    <h6 class="fw-bold mb-0">Dharampeth</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 text-center p-3">
                    <i class="fas fa-map-marker-alt text-primary fa-2x mb-2"></i>
                    <h6 class="fw-bold mb-0">Sadar</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 text-center p-3">
                    <i class="fas fa-map-marker-alt text-primary fa-2x mb-2"></i>
                    <h6 class="fw-bold mb-0">Sitabuldi</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 text-center p-3">
                    <i class="fas fa-map-marker-alt text-primary fa-2x mb-2"></i>
                    <h6 class="fw-bold mb-0">Ramdaspeth</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 text-center p-3">
                    <i class="fas fa-map-marker-alt text-primary fa-2x mb-2"></i>
                    <h6 class="fw-bold mb-0">Pratap Nagar</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 text-center p-3">
                    <i class="fas fa-map-marker-alt text-primary fa-2x mb-2"></i>
                    <h6 class="fw-bold mb-0">Manish Nagar</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 text-center p-3">
                    <i class="fas fa-map-marker-alt text-primary fa-2x mb-2"></i>
                    <h6 class="fw-bold mb-0">Hingna</h6>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <p class="text-muted">And many more areas across Nagpur, Wardha, Bhandara, and Vidarbha region</p>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">What Nagpur Residents Say</h2>
            <p class="lead text-muted">Trusted by hundreds of satisfied customers across Nagpur</p>
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
                        <p class="card-text">"SmartBuild delivered our dream home in Civil Lines exactly as we envisioned. Professional, timely, and excellent quality! Best builders in Nagpur."</p>
                        <div class="d-flex align-items-center mt-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fw-bold">RP</span>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold">Rajesh Patil</h6>
                                <small class="text-muted">Civil Lines, Nagpur</small>
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
                        <p class="card-text">"Outstanding commercial project execution in Dharampeth. Their team's expertise and attention to detail is remarkable. Highly recommend for any construction work in Nagpur."</p>
                        <div class="d-flex align-items-center mt-3">
                            <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fw-bold">SD</span>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold">Sneha Deshmukh</h6>
                                <small class="text-muted">Dharampeth, Nagpur</small>
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
                        <p class="card-text">"Best investment decision! The plot I purchased in Pratap Nagar has excellent potential and the booking process was seamless. Great service!"</p>
                        <div class="d-flex align-items-center mt-3">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fw-bold">AK</span>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold">Amit Khandelwal</h6>
                                <small class="text-muted">Pratap Nagar, Nagpur</small>
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
