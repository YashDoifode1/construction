<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/helpers.php';

$currentUser = getCurrentUser();
$isUserLoggedIn = isLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'SmartBuild Developers'; ?> - Best Construction Company in Nagpur | Building Dreams, Shaping Skylines</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo $metaDescription ?? 'SmartBuild Developers - Leading construction company in Nagpur, Maharashtra. Expert builders offering residential, commercial construction, plot development, and interior design services. Trusted by 500+ clients in Nagpur.'; ?>">
    <meta name="keywords" content="<?php echo $metaKeywords ?? 'construction company Nagpur, builders in Nagpur, residential construction Nagpur, commercial construction Nagpur, plot booking Nagpur, interior design Nagpur, best builders Nagpur Maharashtra, construction services Nagpur, real estate Nagpur, property developers Nagpur'; ?>">
    <meta name="author" content="SmartBuild Developers">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    
    <!-- Geo Tags for Local SEO -->
    <meta name="geo.region" content="IN-MH">
    <meta name="geo.placename" content="Nagpur">
    <meta name="geo.position" content="21.1458;79.0882">
    <meta name="ICBM" content="21.1458, 79.0882">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo baseUrl($_SERVER['REQUEST_URI'] ?? ''); ?>">
    <meta property="og:title" content="<?php echo $pageTitle ?? 'SmartBuild Developers'; ?> - Best Construction Company in Nagpur">
    <meta property="og:description" content="<?php echo $metaDescription ?? 'Leading construction company in Nagpur offering residential, commercial construction, and plot development services.'; ?>">
    <meta property="og:image" content="<?php echo asset('images/og-image.jpg'); ?>">
    <meta property="og:locale" content="en_IN">
    <meta property="og:site_name" content="SmartBuild Developers">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo baseUrl($_SERVER['REQUEST_URI'] ?? ''); ?>">
    <meta name="twitter:title" content="<?php echo $pageTitle ?? 'SmartBuild Developers'; ?> - Best Construction Company in Nagpur">
    <meta name="twitter:description" content="<?php echo $metaDescription ?? 'Leading construction company in Nagpur offering residential, commercial construction, and plot development services.'; ?>">
    <meta name="twitter:image" content="<?php echo asset('images/og-image.jpg'); ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo baseUrl($_SERVER['REQUEST_URI'] ?? ''); ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo asset('images/favicon.ico'); ?>">
    <link rel="apple-touch-icon" href="<?php echo asset('images/apple-touch-icon.png'); ?>">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">
    
    <?php if (isset($additionalCSS)): ?>
        <?php echo $additionalCSS; ?>
    <?php endif; ?>
    
    <!-- Structured Data / Schema.org for Local Business -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "GeneralContractor",
      "name": "SmartBuild Developers",
      "image": "<?php echo asset('images/logo.png'); ?>",
      "@id": "<?php echo baseUrl(); ?>",
      "url": "<?php echo baseUrl(); ?>",
      "telephone": "+91-712-XXXXXXX",
      "priceRange": "₹₹₹",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Construction Avenue, Civil Lines",
        "addressLocality": "Nagpur",
        "addressRegion": "Maharashtra",
        "postalCode": "440001",
        "addressCountry": "IN"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 21.1458,
        "longitude": 79.0882
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday"
        ],
        "opens": "09:00",
        "closes": "18:00"
      },
      "sameAs": [
        "https://facebook.com/smartbuild",
        "https://twitter.com/smartbuild",
        "https://instagram.com/smartbuild",
        "https://linkedin.com/company/smartbuild"
      ],
      "areaServed": {
        "@type": "City",
        "name": "Nagpur",
        "@id": "https://en.wikipedia.org/wiki/Nagpur"
      },
      "serviceArea": {
        "@type": "GeoCircle",
        "geoMidpoint": {
          "@type": "GeoCoordinates",
          "latitude": 21.1458,
          "longitude": 79.0882
        },
        "geoRadius": "50000"
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.8",
        "reviewCount": "500"
      }
    }
    </script>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo baseUrl(); ?>">
                <i class="fas fa-building"></i> SmartBuild Developers
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('index.php'); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('about.php'); ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('services.php'); ?>">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('projects.php'); ?>">Projects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('plots.php'); ?>">Plots</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('contact.php'); ?>">Contact</a>
                    </li>
                    
                    <?php if ($isUserLoggedIn): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($currentUser['name']); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo baseUrl('user/profile.php'); ?>"><i class="fas fa-user"></i> Profile</a></li>
                                <?php if (isAdmin()): ?>
                                    <li><a class="dropdown-item" href="<?php echo baseUrl('admin/dashboard.php'); ?>"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo baseUrl('logout.php'); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo baseUrl('user/login.php'); ?>"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-warning text-dark ms-2" href="<?php echo baseUrl('user/register.php'); ?>">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php
    $flash = getFlash();
    if ($flash):
    ?>
    <div class="container mt-3">
        <div class="alert alert-<?php echo $flash['type'] === 'error' ? 'danger' : $flash['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($flash['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php endif; ?>
