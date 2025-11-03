<?php
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/helpers.php';

requireLogin();

$pageTitle = 'Book Plot';
$userId = getCurrentUserId();
$plotId = get('plot_id', 0);

// Get plot details
$plot = queryOne("SELECT * FROM plots WHERE id = ? AND status = 'available'", [$plotId]);

if (!$plot) {
    setFlash('error', 'Plot not found or not available for booking');
    redirect(baseUrl('plots.php'));
}

// Get user details
$user = queryOne("SELECT * FROM users WHERE id = ?", [$userId]);

// Handle booking submission
if (isPost()) {
    $bookingDate = sanitize(post('booking_date'));
    $notes = sanitize(post('notes'));
    $csrfToken = post('csrf_token');
    
    if (!verifyCsrfToken($csrfToken)) {
        setFlash('error', 'Invalid request. Please try again.');
    } elseif (empty($bookingDate)) {
        setFlash('error', 'Booking date is required');
    } else {
        // Check if plot is still available
        $checkPlot = queryOne("SELECT status FROM plots WHERE id = ?", [$plotId]);
        
        if ($checkPlot['status'] !== 'available') {
            setFlash('error', 'This plot is no longer available');
            redirect(baseUrl('plots.php'));
        }
        
        // Start transaction
        beginTransaction();
        
        try {
            // Insert booking
            $sql = "INSERT INTO bookings (user_id, plot_id, booking_date, notes) VALUES (?, ?, ?, ?)";
            execute($sql, [$userId, $plotId, $bookingDate, $notes]);
            
            // Update plot status
            execute("UPDATE plots SET status = 'booked' WHERE id = ?", [$plotId]);
            
            commit();
            
            setFlash('success', 'Plot booked successfully! Our team will contact you soon.');
            redirect(baseUrl('user/profile.php'));
        } catch (Exception $e) {
            rollback();
            setFlash('error', 'Booking failed. Please try again.');
        }
    }
}

include 'includes/header.php';
?>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-bookmark"></i> Book Plot</h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Plot Details -->
                        <div class="alert alert-info">
                            <h5 class="alert-heading fw-bold">Plot Details</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <strong>Plot Number:</strong> <?php echo htmlspecialchars($plot['plot_no']); ?>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Size:</strong> <?php echo htmlspecialchars($plot['size']); ?>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Price:</strong> <span class="text-primary fw-bold"><?php echo formatCurrency($plot['price']); ?></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Status:</strong> <?php echo getStatusBadge($plot['status']); ?>
                                </div>
                                <div class="col-12 mb-2">
                                    <strong>Location:</strong> <?php echo htmlspecialchars($plot['location']); ?>
                                </div>
                                <div class="col-12">
                                    <strong>Description:</strong><br>
                                    <?php echo nl2br(htmlspecialchars($plot['description'])); ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Booking Form -->
                        <h5 class="fw-bold mb-3">Your Information</h5>
                        
                        <form method="POST" action="">
                            <?php echo csrfField(); ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" disabled>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" disabled>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="booking_date" class="form-label">Preferred Booking Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="booking_date" name="booking_date" min="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="notes" class="form-label">Additional Notes (Optional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any special requirements or questions..."></textarea>
                            </div>
                            
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle"></i> <strong>Important:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>This is a booking request and not a confirmed purchase</li>
                                    <li>Our team will contact you within 24-48 hours to confirm</li>
                                    <li>You may be required to pay a booking amount</li>
                                    <li>All bookings are subject to verification and approval</li>
                                </ul>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="agree" required>
                                <label class="form-check-label" for="agree">
                                    I agree to the terms and conditions and understand that this is a booking request
                                </label>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                    <i class="fas fa-check"></i> Confirm Booking
                                </button>
                                <a href="<?php echo baseUrl('plots.php'); ?>" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
