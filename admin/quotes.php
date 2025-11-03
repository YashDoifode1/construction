<?php
require_once '../includes/db.php';
require_once '../includes/helpers.php';

$pageTitle = 'Quote Requests';

// Handle status update
if (get('action') === 'update_status' && get('id') && get('status')) {
    execute("UPDATE quotes SET status = ? WHERE id = ?", [get('status'), get('id')]);
    setFlash('success', 'Quote status updated successfully');
    redirect(baseUrl('admin/quotes.php'));
}

// Handle delete
if (get('action') === 'delete' && get('id')) {
    execute("DELETE FROM quotes WHERE id = ?", [get('id')]);
    setFlash('success', 'Quote deleted successfully');
    redirect(baseUrl('admin/quotes.php'));
}

$quotes = query("SELECT * FROM quotes ORDER BY created_at DESC");

include 'includes/header.php';
?>

<div class="container-fluid">
    <h2 class="fw-bold mb-4">Quote Requests</h2>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Project Type</th>
                            <th>Budget</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($quotes)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No quote requests found</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($quotes as $quote): ?>
                            <tr>
                                <td><?php echo $quote['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($quote['name']); ?></strong></td>
                                <td>
                                    <small><?php echo htmlspecialchars($quote['email']); ?></small><br>
                                    <small><?php echo htmlspecialchars($quote['phone']); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($quote['project_type']); ?></td>
                                <td><?php echo htmlspecialchars($quote['budget'] ?: 'Not specified'); ?></td>
                                <td><?php echo formatDate($quote['created_at']); ?></td>
                                <td><?php echo getStatusBadge($quote['status']); ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $quote['id']; ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="?action=update_status&id=<?php echo $quote['id']; ?>&status=pending">Pending</a></li>
                                            <li><a class="dropdown-item" href="?action=update_status&id=<?php echo $quote['id']; ?>&status=reviewed">Reviewed</a></li>
                                            <li><a class="dropdown-item" href="?action=update_status&id=<?php echo $quote['id']; ?>&status=quoted">Quoted</a></li>
                                            <li><a class="dropdown-item" href="?action=update_status&id=<?php echo $quote['id']; ?>&status=closed">Closed</a></li>
                                        </ul>
                                        <a href="?action=delete&id=<?php echo $quote['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- View Modal -->
                            <div class="modal fade" id="viewModal<?php echo $quote['id']; ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Quote Request Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Name:</strong> <?php echo htmlspecialchars($quote['name']); ?></p>
                                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($quote['email']); ?></p>
                                                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($quote['phone']); ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Project Type:</strong> <?php echo htmlspecialchars($quote['project_type']); ?></p>
                                                    <p><strong>Budget:</strong> <?php echo htmlspecialchars($quote['budget'] ?: 'Not specified'); ?></p>
                                                    <p><strong>Location:</strong> <?php echo htmlspecialchars($quote['location'] ?: 'Not specified'); ?></p>
                                                </div>
                                            </div>
                                            <hr>
                                            <p><strong>Description:</strong></p>
                                            <p><?php echo nl2br(htmlspecialchars($quote['description'])); ?></p>
                                            <hr>
                                            <p><strong>Status:</strong> <?php echo getStatusBadge($quote['status']); ?></p>
                                            <p><strong>Submitted:</strong> <?php echo formatDate($quote['created_at'], 'F d, Y h:i A'); ?></p>
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
