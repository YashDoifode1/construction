<?php
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/helpers.php';

$pageTitle = 'Projects';

// Get filter
$category = get('category', 'all');

// Fetch projects
if ($category === 'all') {
    $projects = query("SELECT * FROM projects ORDER BY created_at DESC");
} else {
    $projects = query("SELECT * FROM projects WHERE category = ? ORDER BY created_at DESC", [$category]);
}

include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">Our Projects</h1>
        <p class="lead">Showcasing Our Portfolio of Excellence</p>
    </div>
</section>

<!-- Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a href="?category=all" class="btn <?php echo $category === 'all' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                All Projects
            </a>
            <a href="?category=residential" class="btn <?php echo $category === 'residential' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                Residential
            </a>
            <a href="?category=commercial" class="btn <?php echo $category === 'commercial' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                Commercial
            </a>
            <a href="?category=interior" class="btn <?php echo $category === 'interior' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                Interior Design
            </a>
            <a href="?category=renovation" class="btn <?php echo $category === 'renovation' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                Renovation
            </a>
        </div>
    </div>
</section>

<!-- Projects Grid -->
<section class="py-5">
    <div class="container">
        <?php if (empty($projects)): ?>
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-5x text-muted mb-3"></i>
                <h3>No Projects Found</h3>
                <p class="text-muted">No projects available in this category.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($projects as $project): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow project-card">
                        <div class="position-relative overflow-hidden">
                            <img src="<?php echo asset('images/' . ($project['image'] ?? 'placeholder.jpg')); ?>" 
                                 class="card-img-top" alt="<?php echo htmlspecialchars($project['title']); ?>" 
                                 style="height: 250px; object-fit: cover; transition: transform 0.3s;">
                            <div class="position-absolute top-0 end-0 m-3">
                                <?php echo getStatusBadge($project['status']); ?>
                            </div>
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-dark"><?php echo ucfirst($project['category']); ?></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($project['title']); ?></h5>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($project['location']); ?>
                            </p>
                            <?php if ($project['completion_date']): ?>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-calendar"></i> Completed: <?php echo formatDate($project['completion_date']); ?>
                            </p>
                            <?php endif; ?>
                            <p class="card-text"><?php echo truncate($project['description'], 120); ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#projectModal<?php echo $project['id']; ?>">
                                <i class="fas fa-eye"></i> View Details
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Project Modal -->
                <div class="modal fade" id="projectModal<?php echo $project['id']; ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold"><?php echo htmlspecialchars($project['title']); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <img src="<?php echo asset('images/' . ($project['image'] ?? 'placeholder.jpg')); ?>" 
                                     class="img-fluid rounded mb-3" alt="<?php echo htmlspecialchars($project['title']); ?>">
                                
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Category:</strong>
                                        <p><?php echo ucfirst($project['category']); ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Location:</strong>
                                        <p><?php echo htmlspecialchars($project['location']); ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Status:</strong>
                                        <p><?php echo getStatusBadge($project['status']); ?></p>
                                    </div>
                                </div>
                                
                                <?php if ($project['completion_date']): ?>
                                <div class="mb-3">
                                    <strong>Completion Date:</strong>
                                    <p><?php echo formatDate($project['completion_date'], 'F d, Y'); ?></p>
                                </div>
                                <?php endif; ?>
                                
                                <div class="mb-3">
                                    <strong>Description:</strong>
                                    <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="<?php echo baseUrl('quote.php'); ?>" class="btn btn-primary">Request Similar Project</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Inspired by Our Work?</h2>
        <p class="lead text-muted mb-4">Let's create something amazing together</p>
        <a href="<?php echo baseUrl('quote.php'); ?>" class="btn btn-primary btn-lg">Start Your Project</a>
    </div>
</section>

<style>
.project-card:hover img {
    transform: scale(1.1);
}
</style>

<?php include 'includes/footer.php'; ?>
