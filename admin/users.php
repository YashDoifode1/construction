<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/helpers.php';

$pageTitle = 'Manage Users';

// Handle status update
if (get('action') === 'toggle_status' && get('id')) {
    $user = getUserById(get('id'));
    $newStatus = $user['status'] === 'active' ? 'inactive' : 'active';
    updateUserStatus(get('id'), $newStatus);
    setFlash('success', 'User status updated successfully');
    redirect(baseUrl('admin/users.php'));
}

// Handle delete
if (get('action') === 'delete' && get('id')) {
    deleteUser(get('id'));
    setFlash('success', 'User deleted successfully');
    redirect(baseUrl('admin/users.php'));
}

$users = getAllUsers();

include 'includes/header.php';
?>

<div class="container-fluid">
    <h2 class="fw-bold mb-4">Manage Users</h2>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($user['full_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td><span class="badge bg-info"><?php echo ucfirst($user['role']); ?></span></td>
                            <td><?php echo getStatusBadge($user['status']); ?></td>
                            <td><?php echo formatDate($user['created_at']); ?></td>
                            <td>
                                <a href="?action=toggle_status&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning" title="Toggle Status">
                                    <i class="fas fa-toggle-on"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $user['id']; ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <?php if ($user['id'] != getCurrentUserId()): ?>
                                <a href="?action=delete&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        
                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal<?php echo $user['id']; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">User Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
                                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                                        <p><strong>Role:</strong> <?php echo ucfirst($user['role']); ?></p>
                                        <p><strong>Status:</strong> <?php echo getStatusBadge($user['status']); ?></p>
                                        <p><strong>Registered:</strong> <?php echo formatDate($user['created_at'], 'F d, Y h:i A'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
