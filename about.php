<?php
require_once 'includes/session.php';
require_once 'includes/helpers.php';

$pageTitle = 'About Us';
$metaDescription = 'SmartBuild Developers - Nagpur\'s trusted construction company since 2015. Serving Civil Lines, Dharampeth, Sadar, and all areas of Nagpur with 150+ completed projects. Expert builders in Maharashtra.';
$metaKeywords = 'about SmartBuild Nagpur, construction company Nagpur history, builders Nagpur team, Nagpur construction services, best construction company Nagpur, building contractors Nagpur Maharashtra';
include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">About SmartBuild Developers</h1>
        <p class="lead">Nagpur's Premier Construction Company - Building Excellence Since 2015</p>
        <div class="mt-3">
            <span class="badge bg-warning text-dark me-2"><i class="fas fa-map-marker-alt"></i> Based in Nagpur, Maharashtra</span>
            <span class="badge bg-light text-dark"><i class="fas fa-building"></i> 150+ Projects in Nagpur</span>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-4">Our Mission</h2>
                <p class="lead text-muted">To be Nagpur's most trusted construction partner, delivering exceptional construction solutions that exceed client expectations through innovation, quality craftsmanship, and unwavering commitment to excellence.</p>
                <p>We believe in building not just structures, but lasting relationships with our clients across Nagpur and Vidarbha region. Every project is an opportunity to showcase our dedication to quality, safety, and sustainability while contributing to Nagpur's growth.</p>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-bullseye fa-10x text-primary" style="opacity: 0.1;"></i>
            </div>
        </div>
        
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-4">Our Vision</h2>
                <p class="lead text-muted">To be the most trusted and innovative construction company in Nagpur and Central India, shaping skylines and transforming communities across Maharashtra.</p>
                <p>We envision a future where every building we construct in Nagpur stands as a testament to quality, sustainability, and architectural excellence, contributing to better living and working environments for Nagpur residents and making our city proud.</p>
            </div>
            <div class="col-lg-6 order-lg-1 text-center">
                <i class="fas fa-eye fa-10x text-warning" style="opacity: 0.1;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Our Core Values</h2>
            <p class="lead text-muted">The principles that guide everything we do</p>
        </div>
        
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Integrity</h5>
                    <p class="text-muted small">Honest, transparent, and ethical in all our dealings</p>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <i class="fas fa-star fa-3x text-warning mb-3"></i>
                    <h5 class="fw-bold">Excellence</h5>
                    <p class="text-muted small">Committed to the highest standards of quality</p>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <i class="fas fa-lightbulb fa-3x text-success mb-3"></i>
                    <h5 class="fw-bold">Innovation</h5>
                    <p class="text-muted small">Embracing new technologies and creative solutions</p>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <i class="fas fa-leaf fa-3x text-info mb-3"></i>
                    <h5 class="fw-bold">Sustainability</h5>
                    <p class="text-muted small">Building with environmental responsibility</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company History -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Our Journey</h2>
            <p class="lead text-muted">Milestones in our growth story</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="timeline">
                    <div class="timeline-item mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-primary me-3">2015</span>
                                    <h5 class="mb-0 fw-bold">Company Founded in Nagpur</h5>
                                </div>
                                <p class="text-muted mb-0">SmartBuild Developers was established in Nagpur with a vision to revolutionize the construction industry in Central India.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-primary me-3">2017</span>
                                    <h5 class="mb-0 fw-bold">First Major Project in Nagpur</h5>
                                </div>
                                <p class="text-muted mb-0">Completed our first commercial tower in Civil Lines, Nagpur, establishing our reputation for quality and reliability across the city.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-primary me-3">2020</span>
                                    <h5 class="mb-0 fw-bold">100+ Projects in Nagpur</h5>
                                </div>
                                <p class="text-muted mb-0">Celebrated the completion of over 100 successful projects across Nagpur's residential and commercial sectors, from Dharampeth to Pratap Nagar.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-primary me-3">2023</span>
                                    <h5 class="mb-0 fw-bold">Sustainability Initiative</h5>
                                </div>
                                <p class="text-muted mb-0">Launched green building program, committed to eco-friendly construction practices.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="card border-0 shadow-sm bg-warning">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-dark me-3">2024</span>
                                    <h5 class="mb-0 fw-bold">Expanding Across Vidarbha</h5>
                                </div>
                                <p class="mb-0">Continuing to grow across Nagpur and Vidarbha region, serving more clients and building better communities in Maharashtra.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Nagpur Section -->
<section class="py-5 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row align-items-center text-white">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="display-5 fw-bold mb-4">Why We Love Nagpur</h2>
                <p class="lead mb-3">Nagpur - The Heart of India, and the heart of our business!</p>
                <ul class="list-unstyled">
                    <li class="mb-3"><i class="fas fa-check-circle me-2"></i> <strong>Strategic Location:</strong> Centrally located in India, making it the perfect hub for growth</li>
                    <li class="mb-3"><i class="fas fa-check-circle me-2"></i> <strong>Orange City:</strong> Known for its rich culture, heritage, and warm people</li>
                    <li class="mb-3"><i class="fas fa-check-circle me-2"></i> <strong>Growing Economy:</strong> Rapid infrastructure development and business opportunities</li>
                    <li class="mb-3"><i class="fas fa-check-circle me-2"></i> <strong>Smart City:</strong> Part of India's Smart Cities Mission with modern amenities</li>
                    <li class="mb-3"><i class="fas fa-check-circle me-2"></i> <strong>Our Home:</strong> Proud to serve the community that has supported us since 2015</li>
                </ul>
            </div>
            <div class="col-lg-6 text-center">
                <div class="bg-white rounded p-4 shadow-lg">
                    <h4 class="text-dark mb-3">Our Nagpur Presence</h4>
                    <div class="row text-dark">
                        <div class="col-6 mb-3">
                            <i class="fas fa-building fa-3x text-primary mb-2"></i>
                            <h5 class="fw-bold">150+</h5>
                            <small>Projects Completed</small>
                        </div>
                        <div class="col-6 mb-3">
                            <i class="fas fa-users fa-3x text-warning mb-2"></i>
                            <h5 class="fw-bold">500+</h5>
                            <small>Nagpur Clients</small>
                        </div>
                        <div class="col-6">
                            <i class="fas fa-map-marked-alt fa-3x text-success mb-2"></i>
                            <h5 class="fw-bold">15+</h5>
                            <small>Areas Covered</small>
                        </div>
                        <div class="col-6">
                            <i class="fas fa-award fa-3x text-info mb-2"></i>
                            <h5 class="fw-bold">4.8/5</h5>
                            <small>Customer Rating</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Meet Our Nagpur Team</h2>
            <p class="lead text-muted">Local experts dedicated to building Nagpur's future</p>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                            <i class="fas fa-user fa-3x"></i>
                        </div>
                        <h5 class="fw-bold">Michael Anderson</h5>
                        <p class="text-muted mb-3">CEO & Founder</p>
                        <p class="small">Visionary leader with 20+ years in construction industry, driving innovation and excellence.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                            <i class="fas fa-user fa-3x"></i>
                        </div>
                        <h5 class="fw-bold">Sarah Williams</h5>
                        <p class="text-muted mb-3">Chief Architect</p>
                        <p class="small">Award-winning architect specializing in sustainable and innovative design solutions.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                            <i class="fas fa-user fa-3x"></i>
                        </div>
                        <h5 class="fw-bold">David Chen</h5>
                        <p class="text-muted mb-3">Project Manager</p>
                        <p class="small">Expert in project execution, ensuring timely delivery and quality standards.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4 mb-md-0">
                <h2 class="display-4 fw-bold">150+</h2>
                <p class="lead">Projects Completed</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <h2 class="display-4 fw-bold">500+</h2>
                <p class="lead">Happy Clients</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <h2 class="display-4 fw-bold">50+</h2>
                <p class="lead">Expert Team</p>
            </div>
            <div class="col-md-3">
                <h2 class="display-4 fw-bold">9+</h2>
                <p class="lead">Years Experience</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
