<?php
require_once '../includes/db.php';

$pageTitle = 'Dashboard';

// Get statistics
$totalPlots = queryOne("SELECT COUNT(*) as count FROM plots")['count'];
$availablePlots = queryOne("SELECT COUNT(*) as count FROM plots WHERE status = 'available'")['count'];
$bookedPlots = queryOne("SELECT COUNT(*) as count FROM plots WHERE status = 'booked'")['count'];
$soldPlots = queryOne("SELECT COUNT(*) as count FROM plots WHERE status = 'sold'")['count'];

$totalBookings = queryOne("SELECT COUNT(*) as count FROM bookings")['count'];
$pendingBookings = queryOne("SELECT COUNT(*) as count FROM bookings WHERE status = 'pending'")['count'];
$approvedBookings = queryOne("SELECT COUNT(*) as count FROM bookings WHERE status = 'approved'")['count'];

$totalUsers = queryOne("SELECT COUNT(*) as count FROM users WHERE role = 'user'")['count'];
$totalProjects = queryOne("SELECT COUNT(*) as count FROM projects")['count'];

$unreadContacts = queryOne("SELECT COUNT(*) as count FROM contacts WHERE status = 'unread'")['count'];
$pendingQuotes = queryOne("SELECT COUNT(*) as count FROM quotes WHERE status = 'pending'")['count'];

// Calculate total revenue (from sold and booked plots)
$revenue = queryOne("SELECT SUM(price) as total FROM plots WHERE status IN ('sold', 'booked')")['total'] ?? 0;

// Get recent bookings
$recentBookings = query("
    SELECT b.*, u.full_name, u.email, p.plot_no, p.price 
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN plots p ON b.plot_id = p.id 
    ORDER BY b.created_at DESC 
    LIMIT 5
");

// Get recent enquiries
$recentEnquiries = query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5");

// Get bookings by month for chart (last 6 months)
$bookingsByMonth = query("
    SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count 
    FROM bookings 
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY month 
    ORDER BY month ASC
");

include 'includes/header.php';
?>

<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total Plots</h6>
                            <h2 class="mb-0 fw-bold"><?php echo $totalPlots; ?></h2>
                        </div>
                        <div>
                            <i class="fas fa-map-marked-alt fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    </div>
                    <small><?php echo $availablePlots; ?> Available</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total Bookings</h6>
                            <h2 class="mb-0 fw-bold"><?php echo $totalBookings; ?></h2>
                        </div>
                        <div>
                            <i class="fas fa-bookmark fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    </div>
                    <small><?php echo $pendingBookings; ?> Pending</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total Users</h6>
                            <h2 class="mb-0 fw-bold"><?php echo $totalUsers; ?></h2>
                        </div>
                        <div>
                            <i class="fas fa-users fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    </div>
                    <small>Registered Clients</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Revenue</h6>
                            <h2 class="mb-0 fw-bold"><?php echo formatCurrency($revenue); ?></h2>
                        </div>
                        <div>
                            <i class="fas fa-dollar-sign fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    </div>
                    <small>From Bookings & Sales</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-project-diagram fa-2x text-primary mb-2"></i>
                    <h4 class="fw-bold mb-0"><?php echo $totalProjects; ?></h4>
                    <small class="text-muted">Projects</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-envelope fa-2x text-success mb-2"></i>
                    <h4 class="fw-bold mb-0"><?php echo $unreadContacts; ?></h4>
                    <small class="text-muted">Unread Messages</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-file-invoice fa-2x text-warning mb-2"></i>
                    <h4 class="fw-bold mb-0"><?php echo $pendingQuotes; ?></h4>
                    <small class="text-muted">Pending Quotes</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-info mb-2"></i>
                    <h4 class="fw-bold mb-0"><?php echo $approvedBookings; ?></h4>
                    <small class="text-muted">Approved Bookings</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Bookings Overview (Last 6 Months)</h5>
                </div>
                <div class="card-body">
                    <canvas id="bookingsChart" height="80"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Plot Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="plotsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Recent Bookings</h5>
                    <a href="<?php echo baseUrl('admin/bookings.php'); ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Customer</th>
                                    <th>Plot</th>
                                    <th>Price</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($recentBookings)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No bookings yet</td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($recentBookings as $booking): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($booking['full_name']); ?></strong><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($booking['email']); ?></small>
                                        </td>
                                        <td><?php echo htmlspecialchars($booking['plot_no']); ?></td>
                                        <td><?php echo formatCurrency($booking['price']); ?></td>
                                        <td><?php echo formatDate($booking['booking_date']); ?></td>
                                        <td><?php echo getStatusBadge($booking['status']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Recent Enquiries</h5>
                    <a href="<?php echo baseUrl('admin/enquiries.php'); ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <?php if (empty($recentEnquiries)): ?>
                        <p class="text-center text-muted py-4">No enquiries yet</p>
                    <?php else: ?>
                        <?php foreach ($recentEnquiries as $enquiry): ?>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <strong class="small"><?php echo htmlspecialchars($enquiry['name']); ?></strong>
                                <?php echo getStatusBadge($enquiry['status']); ?>
                            </div>
                            <p class="small text-muted mb-1"><?php echo truncate($enquiry['message'], 60); ?></p>
                            <small class="text-muted"><?php echo timeAgo($enquiry['created_at']); ?></small>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Bookings Chart
const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
const bookingsChart = new Chart(bookingsCtx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_column($bookingsByMonth, 'month')); ?>,
        datasets: [{
            label: 'Bookings',
            data: <?php echo json_encode(array_column($bookingsByMonth, 'count')); ?>,
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Plots Chart
const plotsCtx = document.getElementById('plotsChart').getContext('2d');
const plotsChart = new Chart(plotsCtx, {
    type: 'doughnut',
    data: {
        labels: ['Available', 'Booked', 'Sold'],
        datasets: [{
            data: [<?php echo $availablePlots; ?>, <?php echo $bookedPlots; ?>, <?php echo $soldPlots; ?>],
            backgroundColor: ['#28a745', '#ffc107', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

<?php include 'includes/footer.php'; ?>
