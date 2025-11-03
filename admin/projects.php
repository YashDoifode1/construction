<?php
require_once '../includes/db.php';
require_once '../includes/helpers.php';

$pageTitle = 'Manage Projects';

// Handle delete
if (get('action') === 'delete' && get('id')) {
    execute("DELETE FROM projects WHERE id = ?", [get('id')]);
    setFlash('success', 'Project deleted successfully');
    redirect(baseUrl('admin/projects.php'));
}

// Handle add/edit
if (isPost()) {
    $id = post('id');
    $title = sanitize(post('title'));
    $category = sanitize(post('category'));
    $description = sanitize(post('description'));
    $location = sanitize(post('location'));
    $completionDate = sanitize(post('completion_date'));
    $status = sanitize(post('status'));
    $csrfToken = post('csrf_token');
    
    if (!verifyCsrfToken($csrfToken)) {
        setFlash('error', 'Invalid request');
    } elseif (empty($title) || empty($category) || empty($description)) {
        setFlash('error', 'Please fill all required fields');
    } else {
        if ($id) {
            $sql = "UPDATE projects SET title = ?, category = ?, description = ?, location = ?, completion_date = ?, status = ? WHERE id = ?";
            execute($sql, [$title, $category, $description, $location, $completionDate, $status, $id]);
            setFlash('success', 'Project updated successfully');
        } else {
            $sql = "INSERT INTO projects (title, category, description, location, completion_date, status) VALUES (?, ?, ?, ?, ?, ?)";
            execute($sql, [$title, $category, $description, $location, $completionDate, $status]);
            setFlash('success', 'Project added successfully');
        }
        redirect(baseUrl('admin/projects.php'));
    }
}

$projects = query("SELECT * FROM projects ORDER BY created_at DESC");
$editProject = null;
if (get('action') === 'edit' && get('id')) {
    $editProject = queryOne("SELECT * FROM projects WHERE id = ?", [get('id')]);
}

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manage Projects</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#projectModal">
            <i class="fas fa-plus"></i> Add New Project
        </button>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Completion Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($project['title']); ?></strong></td>
                            <td><span class="badge bg-secondary"><?php echo ucfirst($project['category']); ?></span></td>
                            <td><?php echo htmlspecialchars($project['location']); ?></td>
                            <td><?php echo $project['completion_date'] ? formatDate($project['completion_date']) : 'N/A'; ?></td>
                            <td><?php echo getStatusBadge($project['status']); ?></td>
                            <td>
                                <a href="?action=edit&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="?action=delete&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="projectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST">
                <?php echo csrfField(); ?>
                <input type="hidden" name="id" value="<?php echo $editProject['id'] ?? ''; ?>">
                
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $editProject ? 'Edit Project' : 'Add New Project'; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($editProject['title'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category *</label>
                            <select class="form-select" name="category" required>
                                <option value="residential" <?php echo ($editProject['category'] ?? '') === 'residential' ? 'selected' : ''; ?>>Residential</option>
                                <option value="commercial" <?php echo ($editProject['category'] ?? '') === 'commercial' ? 'selected' : ''; ?>>Commercial</option>
                                <option value="interior" <?php echo ($editProject['category'] ?? '') === 'interior' ? 'selected' : ''; ?>>Interior</option>
                                <option value="renovation" <?php echo ($editProject['category'] ?? '') === 'renovation' ? 'selected' : ''; ?>>Renovation</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status *</label>
                            <select class="form-select" name="status" required>
                                <option value="ongoing" <?php echo ($editProject['status'] ?? '') === 'ongoing' ? 'selected' : ''; ?>>Ongoing</option>
                                <option value="completed" <?php echo ($editProject['status'] ?? '') === 'completed' ? 'selected' : ''; ?>>Completed</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control" name="location" value="<?php echo htmlspecialchars($editProject['location'] ?? ''); ?>">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Completion Date</label>
                            <input type="date" class="form-control" name="completion_date" value="<?php echo $editProject['completion_date'] ?? ''; ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description *</label>
                        <textarea class="form-control" name="description" rows="4" required><?php echo htmlspecialchars($editProject['description'] ?? ''); ?></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?php echo $editProject ? 'Update' : 'Add'; ?> Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if ($editProject): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new bootstrap.Modal(document.getElementById('projectModal')).show();
});
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
