    <!-- Footer -->
    <footer class="bg-dark text-white mt-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3"><i class="fas fa-building"></i> SmartBuild Developers</h5>
                    <p class="text-muted">Building Dreams, Shaping Skylines</p>
                    <p class="small">We are committed to delivering excellence in construction, creating spaces that inspire and endure.</p>
                </div>
                
                <div class="col-md-2 mb-4">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo baseUrl('index.php'); ?>" class="text-muted text-decoration-none">Home</a></li>
                        <li><a href="<?php echo baseUrl('about.php'); ?>" class="text-muted text-decoration-none">About Us</a></li>
                        <li><a href="<?php echo baseUrl('services.php'); ?>" class="text-muted text-decoration-none">Services</a></li>
                        <li><a href="<?php echo baseUrl('projects.php'); ?>" class="text-muted text-decoration-none">Projects</a></li>
                        <li><a href="<?php echo baseUrl('plots.php'); ?>" class="text-muted text-decoration-none">Plots</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold mb-3">Services</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo baseUrl('services.php'); ?>" class="text-muted text-decoration-none">Residential Construction</a></li>
                        <li><a href="<?php echo baseUrl('services.php'); ?>" class="text-muted text-decoration-none">Commercial Projects</a></li>
                        <li><a href="<?php echo baseUrl('services.php'); ?>" class="text-muted text-decoration-none">Interior Design</a></li>
                        <li><a href="<?php echo baseUrl('services.php'); ?>" class="text-muted text-decoration-none">Renovation</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold mb-3">Contact Info</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Construction Avenue<br><span class="ms-4">Builder City, BC 12345</span></li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +1-800-SMARTBUILD</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@smartbuild.com</li>
                    </ul>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin fa-lg"></i></a>
                    </div>
                </div>
            </div>
            
            <hr class="border-secondary">
            
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 small">&copy; <?php echo date('Y'); ?> SmartBuild Developers. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-muted text-decoration-none small me-3">Privacy Policy</a>
                    <a href="#" class="text-muted text-decoration-none small">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?php echo asset('js/main.js'); ?>"></script>
    
    <?php if (isset($additionalJS)): ?>
        <?php echo $additionalJS; ?>
    <?php endif; ?>
</body>
</html>
