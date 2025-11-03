<?php
require_once '../includes/db.php';
require_once '../includes/helpers.php';

$pageTitle = 'Contact Enquiries';

// Handle mark as read
if (get('action') === 'mark_read' && get('id')) {
    execute("UPDATE contacts SET status = 'read' WHERE id = ?", [get('id')]);
    setFlash('success', 'Marked as read');
    redirect(baseUrl('admin/enquiries.php'));
}

// Handle delete
if (get('action') === 'delete' && get('id')) {
    execute("DELETE FROM contacts WHERE id = ?", [get('id')]);
    setFlash('success', 'Enquiry deleted successfully');
    redirect(baseUrl('admin/enquiries.php'));
}

$enquiries = query("SELECT * FROM contacts ORDER BY created_at DESC");

include 'includes/header.php';
?>

<div class="container-fluid">
    <h2 class="fw-bold mb-4">Contact Enquiries</h2>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($enquiries)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No enquiries found</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($enquiries as $enquiry): ?>
                            <tr class="<?php echo $enquiry['status'] === 'unread' ? 'table-primary' : ''; ?>">
                                <td><?php echo $enquiry['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($enquiry['name']); ?></strong></td>
                                <td>
                                    <small><?php echo htmlspecialchars($enquiry['email']); ?></small><br>
                                    <small><?php echo htmlspecialchars($enquiry['phone']); ?></small>
                                </td>
                                <td><?php echo truncate($enquiry['message'], 60); ?></td>
                                <td><?php echo formatDate($enquiry['created_at']); ?></td>
                                <td><?php echo getStatusBadge($enquiry['status']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $enquiry['id']; ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <?php if ($enquiry['status'] === 'unread'): ?>
                                    <a href="?action=mark_read&id=<?php echo $enquiry['id']; ?>" class="btn btn-sm btn-success">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <?php endif; ?>
                                    <a href="?action=delete&id=<?php echo $enquiry['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            
                            <!-- View Modal -->
                            <div class="modal fade" id="viewModal<?php echo $enquiry['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Enquiry Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Name:</strong> <?php echo htmlspecialchars($enquiry['name']); ?></p>
                                            <p><strong>Email:</strong> <?php echo htmlspecialchars($enquiry['email']); ?></p>
                                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($enquiry['phone']); ?></p>
                                            <p><strong>Date:</strong> <?php echo formatDate($enquiry['created_at'], 'F d, Y h:i A'); ?></p>
                                            <p><strong>Status:</strong> <?php echo getStatusBadge($enquiry['status']); ?></p>
                                            <hr>
                                            <p><strong>Message:</strong></p>
                                            <p><?php echo nl2br(htmlspecialchars($enquiry['message'])); ?></p>
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
