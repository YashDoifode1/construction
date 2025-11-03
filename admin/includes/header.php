<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/helpers.php';

requireAdmin();

$currentUser = getCurrentUser();
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Admin Dashboard'; ?> - SmartBuild Developers</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 4px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        .main-content {
            padding: 20px;
        }
        .stat-card {
            border-radius: 10px;
            border: none;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .navbar-admin {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
    
    <?php if (isset($additionalCSS)): ?>
        <?php echo $additionalCSS; ?>
    <?php endif; ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3 text-white">
                    <h4 class="fw-bold mb-0"><i class="fas fa-building"></i> SmartBuild</h4>
                    <small>Admin Panel</small>
                </div>
                
                <nav class="nav flex-column mt-3">
                    <a href="<?php echo baseUrl('admin/dashboard.php'); ?>" class="nav-link <?php echo $currentPage === 'dashboard' ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="<?php echo baseUrl('admin/plots.php'); ?>" class="nav-link <?php echo $currentPage === 'plots' ? 'active' : ''; ?>">
                        <i class="fas fa-map-marked-alt"></i> Plots
                    </a>
                    <a href="<?php echo baseUrl('admin/bookings.php'); ?>" class="nav-link <?php echo $currentPage === 'bookings' ? 'active' : ''; ?>">
                        <i class="fas fa-bookmark"></i> Bookings
                    </a>
                    <a href="<?php echo baseUrl('admin/projects.php'); ?>" class="nav-link <?php echo $currentPage === 'projects' ? 'active' : ''; ?>">
                        <i class="fas fa-project-diagram"></i> Projects
                    </a>
                    <a href="<?php echo baseUrl('admin/users.php'); ?>" class="nav-link <?php echo $currentPage === 'users' ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i> Users
                    </a>
                    <a href="<?php echo baseUrl('admin/enquiries.php'); ?>" class="nav-link <?php echo $currentPage === 'enquiries' ? 'active' : ''; ?>">
                        <i class="fas fa-envelope"></i> Enquiries
                    </a>
                    <a href="<?php echo baseUrl('admin/quotes.php'); ?>" class="nav-link <?php echo $currentPage === 'quotes' ? 'active' : ''; ?>">
                        <i class="fas fa-file-invoice"></i> Quotes
                    </a>
                    
                    <hr class="text-white-50 my-3">
                    
                    <a href="<?php echo baseUrl('index.php'); ?>" class="nav-link" target="_blank">
                        <i class="fas fa-globe"></i> View Website
                    </a>
                    <a href="<?php echo baseUrl('logout.php'); ?>" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-0">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg navbar-admin sticky-top">
                    <div class="container-fluid">
                        <span class="navbar-brand mb-0 h1"><?php echo $pageTitle ?? 'Dashboard'; ?></span>
                        
                        <div class="d-flex align-items-center">
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <span><?php echo htmlspecialchars($currentUser['name']); ?></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="<?php echo baseUrl('user/profile.php'); ?>"><i class="fas fa-user me-2"></i> Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?php echo baseUrl('logout.php'); ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                
                <!-- Flash Messages -->
                <?php
                $flash = getFlash();
                if ($flash):
                ?>
                <div class="container-fluid mt-3">
                    <div class="alert alert-<?php echo $flash['type'] === 'error' ? 'danger' : $flash['type']; ?> alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($flash['message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Page Content -->
                <div class="main-content">
