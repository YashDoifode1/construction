<?php
require_once '../includes/db.php';
require_once '../includes/helpers.php';

$pageTitle = 'Manage Bookings';

// Handle status update
if (get('action') === 'update_status' && get('id') && get('status')) {
    $id = get('id');
    $status = get('status');
    execute("UPDATE bookings SET status = ? WHERE id = ?", [$status, $id]);
    setFlash('success', 'Booking status updated successfully');
    redirect(baseUrl('admin/bookings.php'));
}

// Handle delete
if (get('action') === 'delete' && get('id')) {
    $id = get('id');
    execute("DELETE FROM bookings WHERE id = ?", [$id]);
    setFlash('success', 'Booking deleted successfully');
    redirect(baseUrl('admin/bookings.php'));
}

// Get all bookings with user and plot details
$bookings = query("
    SELECT b.*, u.full_name, u.email, u.phone, p.plot_no, p.size, p.price, p.location 
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN plots p ON b.plot_id = p.id 
    ORDER BY b.created_at DESC
");

include 'includes/header.php';
?>

<div class="container-fluid">
    <h2 class="fw-bold mb-4">Manage Bookings</h2>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Plot</th>
                            <th>Price</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($bookings)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No bookings found</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><strong>#<?php echo $booking['id']; ?></strong></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($booking['full_name']); ?></strong><br>
                                    <small class="text-muted"><?php echo htmlspecialchars($booking['email']); ?></small><br>
                                    <small class="text-muted"><?php echo htmlspecialchars($booking['phone']); ?></small>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($booking['plot_no']); ?></strong><br>
                                    <small class="text-muted"><?php echo htmlspecialchars($booking['location']); ?></small>
                                </td>
                                <td><?php echo formatCurrency($booking['price']); ?></td>
                                <td><?php echo formatDate($booking['booking_date']); ?></td>
                                <td><?php echo getStatusBadge($booking['status']); ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $booking['id']; ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <?php if ($booking['status'] === 'pending'): ?>
                                        <a href="?action=update_status&id=<?php echo $booking['id']; ?>&status=approved" class="btn btn-success" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="?action=update_status&id=<?php echo $booking['id']; ?>&status=rejected" class="btn btn-warning" title="Reject">
                                            <i class="fas fa-times"></i>
                                        </a>
                                        <?php endif; ?>
                                        <a href="?action=delete&id=<?php echo $booking['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- View Modal -->
                            <div class="modal fade" id="viewModal<?php echo $booking['id']; ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Booking Details #<?php echo $booking['id']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h6 class="fw-bold">Customer Information</h6>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>Name:</strong> <?php echo htmlspecialchars($booking['full_name']); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Email:</strong> <?php echo htmlspecialchars($booking['email']); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Phone:</strong> <?php echo htmlspecialchars($booking['phone']); ?>
                                                </div>
                                            </div>
                                            
                                            <hr>
                                            
                                            <h6 class="fw-bold">Plot Information</h6>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>Plot No:</strong> <?php echo htmlspecialchars($booking['plot_no']); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Size:</strong> <?php echo htmlspecialchars($booking['size']); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Price:</strong> <?php echo formatCurrency($booking['price']); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Location:</strong> <?php echo htmlspecialchars($booking['location']); ?>
                                                </div>
                                            </div>
                                            
                                            <hr>
                                            
                                            <h6 class="fw-bold">Booking Information</h6>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>Booking Date:</strong> <?php echo formatDate($booking['booking_date']); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Status:</strong> <?php echo getStatusBadge($booking['status']); ?>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <strong>Notes:</strong><br>
                                                    <?php echo nl2br(htmlspecialchars($booking['notes'] ?: 'No notes')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
