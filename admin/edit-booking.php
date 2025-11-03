<?php
require_once '../includes/db.php';
require_once '../includes/helpers.php';

$pageTitle = 'Edit Booking';

$bookingId = get('id', 0);

// Get booking details
$booking = queryOne("
    SELECT b.*, u.full_name, u.email, u.phone, p.plot_no, p.size, p.price, p.location 
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN plots p ON b.plot_id = p.id 
    WHERE b.id = ?
", [$bookingId]);

if (!$booking) {
    setFlash('error', 'Booking not found');
    redirect(baseUrl('admin/bookings.php'));
}

// Get all available plots (including current plot)
$availablePlots = query("SELECT * FROM plots WHERE status = 'available' OR id = ? ORDER BY plot_no", [$booking['plot_id']]);

// Handle form submission
if (isPost()) {
    $plotId = post('plot_id');
    $bookingDate = sanitize(post('booking_date'));
    $status = sanitize(post('status'));
    $notes = sanitize(post('notes'));
    $csrfToken = post('csrf_token');
    
    if (!verifyCsrfToken($csrfToken)) {
        setFlash('error', 'Invalid request');
    } elseif (empty($plotId) || empty($bookingDate) || empty($status)) {
        setFlash('error', 'Please fill all required fields');
    } else {
        // Check if plot is available (if changing plot)
        if ($plotId != $booking['plot_id']) {
            $newPlot = queryOne("SELECT status FROM plots WHERE id = ?", [$plotId]);
            if (!$newPlot || $newPlot['status'] !== 'available') {
                setFlash('error', 'Selected plot is not available');
                redirect(baseUrl('admin/edit-booking.php?id=' . $bookingId));
                exit;
            }
            
            // Update old plot status back to available
            execute("UPDATE plots SET status = 'available' WHERE id = ?", [$booking['plot_id']]);
            
            // Update new plot status to booked
            execute("UPDATE plots SET status = 'booked' WHERE id = ?", [$plotId]);
        }
        
        // Update booking
        $sql = "UPDATE bookings SET plot_id = ?, booking_date = ?, status = ?, notes = ? WHERE id = ?";
        $result = execute($sql, [$plotId, $bookingDate, $status, $notes, $bookingId]);
        
        if ($result) {
            // If status changed to cancelled or rejected, make plot available again
            if (in_array($status, ['cancelled', 'rejected'])) {
                execute("UPDATE plots SET status = 'available' WHERE id = ?", [$plotId]);
            }
            
            setFlash('success', 'Booking updated successfully');
            redirect(baseUrl('admin/bookings.php'));
        } else {
            setFlash('error', 'Failed to update booking');
        }
    }
}

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Edit Booking #<?php echo $bookingId; ?></h2>
        <a href="<?php echo baseUrl('admin/bookings.php'); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Bookings
        </a>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Booking Details</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="">
                        <?php echo csrfField(); ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Select Plot *</label>
                            <select class="form-select" name="plot_id" required>
                                <?php foreach ($availablePlots as $plot): ?>
                                <option value="<?php echo $plot['id']; ?>" <?php echo $plot['id'] == $booking['plot_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($plot['plot_no']); ?> - 
                                    <?php echo htmlspecialchars($plot['location']); ?> - 
                                    <?php echo formatCurrency($plot['price']); ?> - 
                                    <?php echo htmlspecialchars($plot['size']); ?>
                                    <?php echo $plot['id'] == $booking['plot_id'] ? '(Current)' : ''; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Only available plots are shown (plus current plot)</small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Booking Date *</label>
                                <input type="date" class="form-control" name="booking_date" value="<?php echo $booking['booking_date']; ?>" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select class="form-select" name="status" required>
                                    <option value="pending" <?php echo $booking['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="approved" <?php echo $booking['status'] === 'approved' ? 'selected' : ''; ?>>Approved</option>
                                    <option value="rejected" <?php echo $booking['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                    <option value="cancelled" <?php echo $booking['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Notes / Remarks</label>
                            <textarea class="form-control" name="notes" rows="4" placeholder="Add any notes or remarks about this booking..."><?php echo htmlspecialchars($booking['notes']); ?></textarea>
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> <strong>Important:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Changing the plot will update plot availability status</li>
                                <li>Setting status to "Rejected" or "Cancelled" will make the plot available again</li>
                                <li>Ensure all changes are intentional before saving</li>
                            </ul>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Update Booking
                            </button>
                            <a href="<?php echo baseUrl('admin/bookings.php'); ?>" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Customer Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Name:</strong><br><?php echo htmlspecialchars($booking['full_name']); ?></p>
                    <p class="mb-2"><strong>Email:</strong><br><?php echo htmlspecialchars($booking['email']); ?></p>
                    <p class="mb-2"><strong>Phone:</strong><br><?php echo htmlspecialchars($booking['phone']); ?></p>
                    <p class="mb-0"><strong>User ID:</strong> #<?php echo $booking['user_id']; ?></p>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Current Plot Info</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Plot No:</strong><br><?php echo htmlspecialchars($booking['plot_no']); ?></p>
                    <p class="mb-2"><strong>Size:</strong><br><?php echo htmlspecialchars($booking['size']); ?></p>
                    <p class="mb-2"><strong>Price:</strong><br><?php echo formatCurrency($booking['price']); ?></p>
                    <p class="mb-2"><strong>Location:</strong><br><?php echo htmlspecialchars($booking['location']); ?></p>
                    <p class="mb-0"><strong>Created:</strong><br><?php echo formatDate($booking['created_at'], 'M d, Y h:i A'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
