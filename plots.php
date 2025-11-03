<?php
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/helpers.php';

$pageTitle = 'Available Plots';

// Get filters
$status = get('status', 'all');
$minPrice = get('min_price', '');
$maxPrice = get('max_price', '');

// Build query
$sql = "SELECT * FROM plots WHERE 1=1";
$params = [];

if ($status !== 'all') {
    $sql .= " AND status = ?";
    $params[] = $status;
}

if ($minPrice !== '') {
    $sql .= " AND price >= ?";
    $params[] = $minPrice;
}

if ($maxPrice !== '') {
    $sql .= " AND price <= ?";
    $params[] = $maxPrice;
}

$sql .= " ORDER BY created_at DESC";

$plots = query($sql, $params);

include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">Available Plots</h1>
        <p class="lead">Find Your Perfect Plot for Construction</p>
    </div>
</section>

<!-- Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="all" <?php echo $status === 'all' ? 'selected' : ''; ?>>All Status</option>
                    <option value="available" <?php echo $status === 'available' ? 'selected' : ''; ?>>Available</option>
                    <option value="booked" <?php echo $status === 'booked' ? 'selected' : ''; ?>>Booked</option>
                    <option value="sold" <?php echo $status === 'sold' ? 'selected' : ''; ?>>Sold</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <label class="form-label">Min Price</label>
                <input type="number" name="min_price" class="form-control" placeholder="0" value="<?php echo htmlspecialchars($minPrice); ?>">
            </div>
            
            <div class="col-md-3">
                <label class="form-label">Max Price</label>
                <input type="number" name="max_price" class="form-control" placeholder="1000000" value="<?php echo htmlspecialchars($maxPrice); ?>">
            </div>
            
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="plots.php" class="btn btn-secondary">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Plots Grid -->
<section class="py-5">
    <div class="container">
        <?php if (empty($plots)): ?>
            <div class="text-center py-5">
                <i class="fas fa-map-marked-alt fa-5x text-muted mb-3"></i>
                <h3>No Plots Found</h3>
                <p class="text-muted">No plots match your search criteria.</p>
                <a href="plots.php" class="btn btn-primary">Clear Filters</a>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($plots as $plot): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title fw-bold mb-0">Plot <?php echo htmlspecialchars($plot['plot_no']); ?></h5>
                                <?php echo getStatusBadge($plot['status']); ?>
                            </div>
                            
                            <p class="text-muted mb-3">
                                <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($plot['location']); ?>
                            </p>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Size</small>
                                    <p class="fw-bold mb-0"><?php echo htmlspecialchars($plot['size']); ?></p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Price</small>
                                    <p class="fw-bold mb-0 text-primary"><?php echo formatCurrency($plot['price']); ?></p>
                                </div>
                            </div>
                            
                            <p class="card-text small text-muted"><?php echo truncate($plot['description'], 100); ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary flex-fill" data-bs-toggle="modal" data-bs-target="#plotModal<?php echo $plot['id']; ?>">
                                <i class="fas fa-info-circle"></i> Details
                            </button>
                            <?php if ($plot['status'] === 'available'): ?>
                                <?php if (isLoggedIn()): ?>
                                    <a href="<?php echo baseUrl('book-plot.php?plot_id=' . $plot['id']); ?>" class="btn btn-sm btn-warning flex-fill">
                                        <i class="fas fa-bookmark"></i> Book Now
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo baseUrl('user/login.php?redirect=book-plot.php?plot_id=' . $plot['id']); ?>" class="btn btn-sm btn-warning flex-fill">
                                        <i class="fas fa-bookmark"></i> Book Now
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Plot Modal -->
                <div class="modal fade" id="plotModal<?php echo $plot['id']; ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Plot <?php echo htmlspecialchars($plot['plot_no']); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Plot Number:</strong>
                                        <p><?php echo htmlspecialchars($plot['plot_no']); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Status:</strong>
                                        <p><?php echo getStatusBadge($plot['status']); ?></p>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Size:</strong>
                                        <p><?php echo htmlspecialchars($plot['size']); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Price:</strong>
                                        <p class="text-primary fw-bold"><?php echo formatCurrency($plot['price']); ?></p>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <strong>Location:</strong>
                                    <p><?php echo htmlspecialchars($plot['location']); ?></p>
                                </div>
                                
                                <div class="mb-3">
                                    <strong>Description:</strong>
                                    <p><?php echo nl2br(htmlspecialchars($plot['description'])); ?></p>
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> <strong>Note:</strong> Prices are subject to change. Contact us for the latest pricing and availability.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <?php if ($plot['status'] === 'available'): ?>
                                    <?php if (isLoggedIn()): ?>
                                        <a href="<?php echo baseUrl('book-plot.php?plot_id=' . $plot['id']); ?>" class="btn btn-warning">
                                            <i class="fas fa-bookmark"></i> Book This Plot
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo baseUrl('user/login.php'); ?>" class="btn btn-warning">
                                            Login to Book
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Info Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <i class="fas fa-file-contract fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Legal Documentation</h5>
                    <p class="text-muted small">All plots come with clear titles and proper legal documentation.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <i class="fas fa-road fa-3x text-warning mb-3"></i>
                    <h5 class="fw-bold">Prime Locations</h5>
                    <p class="text-muted small">Strategically located plots with excellent connectivity and infrastructure.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <i class="fas fa-handshake fa-3x text-success mb-3"></i>
                    <h5 class="fw-bold">Flexible Payment</h5>
                    <p class="text-muted small">Easy payment plans and financing options available.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
