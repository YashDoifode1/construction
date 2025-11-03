<?php
require_once 'includes/session.php';
require_once 'includes/helpers.php';

$pageTitle = 'Services';
include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">Our Services</h1>
        <p class="lead">Comprehensive Construction Solutions for Every Need</p>
    </div>
</section>

<!-- Services Grid -->
<section class="py-5">
    <div class="container">
        <!-- Residential Construction -->
        <div class="row mb-5 align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="service-image">
                    <i class="fas fa-home fa-10x text-primary" style="opacity: 0.2;"></i>
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3"><i class="fas fa-home text-primary me-2"></i> Residential Construction</h2>
                <p class="lead text-muted">Build your dream home with our expert residential construction services.</p>
                <p>We specialize in creating beautiful, functional homes tailored to your lifestyle and preferences. From single-family homes to luxury villas, our team brings your vision to life with precision and care.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Custom Home Design & Construction</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Luxury Villa Development</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Apartment Complexes</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Sustainable Green Homes</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Smart Home Integration</li>
                </ul>
                <a href="<?php echo baseUrl('quote.php'); ?>" class="btn btn-primary mt-3">Request Quote</a>
            </div>
        </div>

        <hr class="my-5">

        <!-- Commercial Projects -->
        <div class="row mb-5 align-items-center">
            <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                <div class="service-image">
                    <i class="fas fa-building fa-10x text-warning" style="opacity: 0.2;"></i>
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <h2 class="fw-bold mb-3"><i class="fas fa-building text-warning me-2"></i> Commercial Projects</h2>
                <p class="lead text-muted">Professional commercial construction for offices, retail, and more.</p>
                <p>Our commercial construction expertise spans office buildings, shopping centers, hotels, and industrial facilities. We deliver projects that meet business needs while maintaining the highest quality standards.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Office Buildings & Corporate Towers</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Shopping Malls & Retail Spaces</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Hotels & Hospitality</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Industrial Facilities</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Mixed-Use Developments</li>
                </ul>
                <a href="<?php echo baseUrl('quote.php'); ?>" class="btn btn-warning mt-3">Request Quote</a>
            </div>
        </div>

        <hr class="my-5">

        <!-- Interior Design -->
        <div class="row mb-5 align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="service-image">
                    <i class="fas fa-paint-roller fa-10x text-success" style="opacity: 0.2;"></i>
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3"><i class="fas fa-paint-roller text-success me-2"></i> Interior Design</h2>
                <p class="lead text-muted">Transform spaces with our creative interior design solutions.</p>
                <p>Our interior design team creates stunning, functional spaces that reflect your personality and meet your needs. We handle everything from concept to completion.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Residential Interior Design</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Commercial Interior Design</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Space Planning & Layout</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Custom Furniture & Fixtures</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Lighting Design</li>
                </ul>
                <a href="<?php echo baseUrl('quote.php'); ?>" class="btn btn-success mt-3">Request Quote</a>
            </div>
        </div>

        <hr class="my-5">

        <!-- Renovation -->
        <div class="row mb-5 align-items-center">
            <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                <div class="service-image">
                    <i class="fas fa-tools fa-10x text-info" style="opacity: 0.2;"></i>
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <h2 class="fw-bold mb-3"><i class="fas fa-tools text-info me-2"></i> Renovation & Remodeling</h2>
                <p class="lead text-muted">Breathe new life into existing spaces with expert renovation.</p>
                <p>Whether you're updating a single room or undertaking a complete property transformation, our renovation services ensure quality results that enhance value and functionality.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Complete Home Renovations</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Kitchen & Bathroom Remodeling</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Heritage Building Restoration</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Office Refurbishment</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Structural Modifications</li>
                </ul>
                <a href="<?php echo baseUrl('quote.php'); ?>" class="btn btn-info mt-3">Request Quote</a>
            </div>
        </div>

        <hr class="my-5">

        <!-- Consulting -->
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="service-image">
                    <i class="fas fa-user-tie fa-10x text-danger" style="opacity: 0.2;"></i>
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3"><i class="fas fa-user-tie text-danger me-2"></i> Construction Consulting</h2>
                <p class="lead text-muted">Expert guidance for your construction projects.</p>
                <p>Our consulting services provide valuable insights and expertise to help you make informed decisions throughout your construction journey.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Project Feasibility Studies</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Cost Estimation & Budgeting</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Quality Assurance</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Regulatory Compliance</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Project Management</li>
                </ul>
                <a href="<?php echo baseUrl('quote.php'); ?>" class="btn btn-danger mt-3">Request Quote</a>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Why Choose SmartBuild?</h2>
            <p class="lead text-muted">What sets us apart from the competition</p>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-certificate fa-3x text-primary mb-3"></i>
                        <h5 class="fw-bold">Licensed & Certified</h5>
                        <p class="text-muted">Fully licensed contractors with industry certifications and insurance coverage.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-award fa-3x text-warning mb-3"></i>
                        <h5 class="fw-bold">Quality Guarantee</h5>
                        <p class="text-muted">We stand behind our work with comprehensive warranties and quality assurance.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-headset fa-3x text-success mb-3"></i>
                        <h5 class="fw-bold">24/7 Support</h5>
                        <p class="text-muted">Dedicated customer support team available to assist you at any time.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-4">Ready to Get Started?</h2>
        <p class="lead mb-4">Let's discuss your project and bring your vision to life</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="<?php echo baseUrl('contact.php'); ?>" class="btn btn-light btn-lg">Contact Us</a>
            <a href="<?php echo baseUrl('quote.php'); ?>" class="btn btn-warning btn-lg">Get a Free Quote</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
