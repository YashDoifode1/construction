<?php
http_response_code(404);
$pageTitle = '404 - Page Not Found';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - SmartBuild Developers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            text-align: center;
            color: white;
        }
        .error-code {
            font-size: 150px;
            font-weight: 700;
            line-height: 1;
            text-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .error-icon {
            font-size: 100px;
            margin-bottom: 20px;
            opacity: 0.8;
        }
        .btn-home {
            margin-top: 30px;
            padding: 15px 40px;
            font-size: 18px;
            border-radius: 50px;
            background: white;
            color: #1e3c72;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            color: #1e3c72;
        }
        .logo {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-container">
            <div class="logo">
                <i class="fas fa-building"></i> SmartBuild Developers
            </div>
            
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            
            <div class="error-code">404</div>
            
            <h1 class="display-4 mb-3">Page Not Found</h1>
            <p class="lead mb-4">
                Oops! The page you're looking for doesn't exist or has been moved.
            </p>
            
            <div class="mt-4">
                <a href="/const/" class="btn btn-home">
                    <i class="fas fa-home me-2"></i> Go Back Home
                </a>
                <a href="javascript:history.back()" class="btn btn-home ms-3">
                    <i class="fas fa-arrow-left me-2"></i> Go Back
                </a>
            </div>
            
            <div class="mt-5">
                <p class="small">
                    <a href="/const/contact.php" class="text-white text-decoration-none">
                        <i class="fas fa-envelope me-2"></i> Contact Support
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
