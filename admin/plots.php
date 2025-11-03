<?php
require_once '../includes/db.php';
require_once '../includes/helpers.php';

$pageTitle = 'Manage Plots';

// Handle delete
if (get('action') === 'delete' && get('id')) {
    $id = get('id');
    execute("DELETE FROM plots WHERE id = ?", [$id]);
    setFlash('success', 'Plot deleted successfully');
    redirect(baseUrl('admin/plots.php'));
}

// Handle add/edit
if (isPost()) {
    $id = post('id');
    $plotNo = sanitize(post('plot_no'));
    $size = sanitize(post('size'));
    $price = sanitize(post('price'));
    $location = sanitize(post('location'));
    $description = sanitize(post('description'));
    $status = sanitize(post('status'));
    $csrfToken = post('csrf_token');
    
    if (!verifyCsrfToken($csrfToken)) {
        setFlash('error', 'Invalid request');
    } elseif (empty($plotNo) || empty($size) || empty($price) || empty($location)) {
        setFlash('error', 'Please fill all required fields');
    } else {
        if ($id) {
            // Update
            $sql = "UPDATE plots SET plot_no = ?, size = ?, price = ?, location = ?, description = ?, status = ? WHERE id = ?";
            execute($sql, [$plotNo, $size, $price, $location, $description, $status, $id]);
            setFlash('success', 'Plot updated successfully');
        } else {
            // Insert
            $sql = "INSERT INTO plots (plot_no, size, price, location, description, status) VALUES (?, ?, ?, ?, ?, ?)";
            execute($sql, [$plotNo, $size, $price, $location, $description, $status]);
            setFlash('success', 'Plot added successfully');
        }
        redirect(baseUrl('admin/plots.php'));
    }
}

// Get all plots
$plots = query("SELECT * FROM plots ORDER BY created_at DESC");

// Get plot for editing
$editPlot = null;
if (get('action') === 'edit' && get('id')) {
    $editPlot = queryOne("SELECT * FROM plots WHERE id = ?", [get('id')]);
}

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manage Plots</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#plotModal">
            <i class="fas fa-plus"></i> Add New Plot
        </button>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Plot No</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($plots)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No plots found</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($plots as $plot): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($plot['plot_no']); ?></strong></td>
                                <td><?php echo htmlspecialchars($plot['size']); ?></td>
                                <td><?php echo formatCurrency($plot['price']); ?></td>
                                <td><?php echo htmlspecialchars($plot['location']); ?></td>
                                <td><?php echo getStatusBadge($plot['status']); ?></td>
                                <td><?php echo formatDate($plot['created_at']); ?></td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $plot['id']; ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?action=delete&id=<?php echo $plot['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="plotModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="">
                <?php echo csrfField(); ?>
                <input type="hidden" name="id" value="<?php echo $editPlot['id'] ?? ''; ?>">
                
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $editPlot ? 'Edit Plot' : 'Add New Plot'; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Plot Number *</label>
                            <input type="text" class="form-control" name="plot_no" value="<?php echo htmlspecialchars($editPlot['plot_no'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Size *</label>
                            <input type="text" class="form-control" name="size" value="<?php echo htmlspecialchars($editPlot['size'] ?? ''); ?>" placeholder="e.g., 2400 sq ft" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price *</label>
                            <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $editPlot['price'] ?? ''; ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status *</label>
                            <select class="form-select" name="status" required>
                                <option value="available" <?php echo ($editPlot['status'] ?? '') === 'available' ? 'selected' : ''; ?>>Available</option>
                                <option value="booked" <?php echo ($editPlot['status'] ?? '') === 'booked' ? 'selected' : ''; ?>>Booked</option>
                                <option value="sold" <?php echo ($editPlot['status'] ?? '') === 'sold' ? 'selected' : ''; ?>>Sold</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Location *</label>
                        <input type="text" class="form-control" name="location" value="<?php echo htmlspecialchars($editPlot['location'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"><?php echo htmlspecialchars($editPlot['description'] ?? ''); ?></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?php echo $editPlot ? 'Update' : 'Add'; ?> Plot
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if ($editPlot): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = new bootstrap.Modal(document.getElementById('plotModal'));
    modal.show();
});
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
