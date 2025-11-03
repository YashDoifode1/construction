<?php
require_once '../includes/db.php';
require_once '../includes/session.php';
require_once '../includes/auth.php';
require_once '../includes/helpers.php';

requireLogin();

$pageTitle = 'My Profile';
$userId = getCurrentUserId();

// Get user data
$user = getUserById($userId);

// Get user bookings
$bookings = query("
    SELECT b.*, p.plot_no, p.size, p.price, p.location 
    FROM bookings b 
    JOIN plots p ON b.plot_id = p.id 
    WHERE b.user_id = ? 
    ORDER BY b.created_at DESC
", [$userId]);

// Handle profile update
if (isPost() && post('action') === 'update_profile') {
    $fullName = sanitize(post('full_name'));
    $phone = sanitize(post('phone'));
    $csrfToken = post('csrf_token');
    
    if (!verifyCsrfToken($csrfToken)) {
        setFlash('error', 'Invalid request. Please try again.');
    } elseif (empty($fullName) || empty($phone)) {
        setFlash('error', 'All fields are required');
    } else {
        $result = updateUserProfile($userId, $fullName, $phone);
        
        if ($result['success']) {
            setFlash('success', $result['message']);
            redirect(baseUrl('user/profile.php'));
        } else {
            setFlash('error', $result['message']);
        }
    }
}

// Handle password change
if (isPost() && post('action') === 'change_password') {
    $currentPassword = post('current_password');
    $newPassword = post('new_password');
    $confirmPassword = post('confirm_password');
    $csrfToken = post('csrf_token');
    
    if (!verifyCsrfToken($csrfToken)) {
        setFlash('error', 'Invalid request. Please try again.');
    } elseif (empty($currentPassword) || empty($newPassword)) {
        setFlash('error', 'All fields are required');
    } elseif (strlen($newPassword) < 6) {
        setFlash('error', 'New password must be at least 6 characters');
    } elseif ($newPassword !== $confirmPassword) {
        setFlash('error', 'Passwords do not match');
    } else {
        $result = changePassword($userId, $currentPassword, $newPassword);
        
        if ($result['success']) {
            setFlash('success', $result['message']);
            redirect(baseUrl('user/profile.php'));
        } else {
            setFlash('error', $result['message']);
        }
    }
}

include '../includes/header.php';
?>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                            <i class="fas fa-user fa-3x"></i>
                        </div>
                        <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($user['full_name']); ?></h5>
                        <p class="text-muted small mb-3"><?php echo htmlspecialchars($user['email']); ?></p>
                        <span class="badge bg-success">Active Member</span>
                    </div>
                </div>
                
                <div class="card border-0 shadow mt-3">
                    <div class="list-group list-group-flush">
                        <a href="#profile" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                            <i class="fas fa-user me-2"></i> Profile Info
                        </a>
                        <a href="#bookings" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-bookmark me-2"></i> My Bookings
                        </a>
                        <a href="#security" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-lock me-2"></i> Security
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="tab-content">
                    <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="profile">
                        <div class="card border-0 shadow">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">Profile Information</h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="">
                                    <?php echo csrfField(); ?>
                                    <input type="hidden" name="action" value="update_profile">
                                    
                                    <div class="mb-3">
                                        <label for="full_name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                                        <small class="text-muted">Email cannot be changed</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Member Since</label>
                                        <input type="text" class="form-control" value="<?php echo formatDate($user['created_at'], 'F d, Y'); ?>" disabled>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Profile
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bookings Tab -->
                    <div class="tab-pane fade" id="bookings">
                        <div class="card border-0 shadow">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">My Bookings</h5>
                            </div>
                            <div class="card-body p-4">
                                <?php if (empty($bookings)): ?>
                                    <div class="text-center py-5">
                                        <i class="fas fa-bookmark fa-4x text-muted mb-3"></i>
                                        <h5>No Bookings Yet</h5>
                                        <p class="text-muted">You haven't made any plot bookings.</p>
                                        <a href="<?php echo baseUrl('plots.php'); ?>" class="btn btn-primary">Browse Plots</a>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Plot No</th>
                                                    <th>Location</th>
                                                    <th>Size</th>
                                                    <th>Price</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($bookings as $booking): ?>
                                                <tr>
                                                    <td><strong><?php echo htmlspecialchars($booking['plot_no']); ?></strong></td>
                                                    <td><?php echo htmlspecialchars($booking['location']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['size']); ?></td>
                                                    <td><?php echo formatCurrency($booking['price']); ?></td>
                                                    <td><?php echo formatDate($booking['booking_date']); ?></td>
                                                    <td><?php echo getStatusBadge($booking['status']); ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Security Tab -->
                    <div class="tab-pane fade" id="security">
                        <div class="card border-0 shadow">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">Change Password</h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="">
                                    <?php echo csrfField(); ?>
                                    <input type="hidden" name="action" value="change_password">
                                    
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                                        <small class="text-muted">Minimum 6 characters</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-key"></i> Change Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
