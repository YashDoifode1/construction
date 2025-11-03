<?php
/**
 * SmartBuild Developers - Configuration Example
 * 
 * Copy this file to config.php and update with your settings
 * DO NOT commit config.php to version control
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'smartbuild_construction');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Application Configuration
define('APP_NAME', 'SmartBuild Developers');
define('APP_URL', 'http://localhost/const');
define('APP_ENV', 'development'); // development, staging, production

// Security Configuration
define('CSRF_TOKEN_NAME', 'csrf_token');
define('SESSION_LIFETIME', 7200); // 2 hours in seconds
define('PASSWORD_MIN_LENGTH', 6);

// File Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);
define('ALLOWED_DOCUMENT_TYPES', ['pdf', 'doc', 'docx']);

// Email Configuration (for future use)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'yashdoifode1439@gmail.com');
define('SMTP_PASS', 'mvub juzg shso fhpa');
define('SMTP_FROM_EMAIL', 'noreply@smartbuild.com');
define('SMTP_FROM_NAME', 'SmartBuild Developers');

// Company Information
define('COMPANY_NAME', 'SmartBuild Developers');
define('COMPANY_EMAIL', 'info@smartbuild.com');
define('COMPANY_PHONE', '+1-800-SMARTBUILD');
define('COMPANY_ADDRESS', '123 Construction Avenue, Builder City, BC 12345');
define('COMPANY_TAGLINE', 'Building Dreams, Shaping Skylines');

// Pagination
define('ITEMS_PER_PAGE', 10);
define('PLOTS_PER_PAGE', 12);
define('PROJECTS_PER_PAGE', 9);

// Date & Time
define('TIMEZONE', 'America/New_York');
define('DATE_FORMAT', 'M d, Y');
define('DATETIME_FORMAT', 'M d, Y h:i A');

// Currency
define('CURRENCY_SYMBOL', '$');
define('CURRENCY_CODE', 'USD');

// Social Media Links (for future use)
define('SOCIAL_FACEBOOK', 'https://facebook.com/smartbuild');
define('SOCIAL_TWITTER', 'https://twitter.com/smartbuild');
define('SOCIAL_INSTAGRAM', 'https://instagram.com/smartbuild');
define('SOCIAL_LINKEDIN', 'https://linkedin.com/company/smartbuild');

// Google Services (for future use)
define('GOOGLE_MAPS_API_KEY', 'your-api-key-here');
define('GOOGLE_ANALYTICS_ID', 'UA-XXXXXXXXX-X');

// Payment Gateway (for future use)
define('STRIPE_PUBLIC_KEY', 'pk_test_xxxxxxxxxxxxx');
define('STRIPE_SECRET_KEY', 'sk_test_xxxxxxxxxxxxx');
define('PAYPAL_CLIENT_ID', 'your-paypal-client-id');
define('PAYPAL_SECRET', 'your-paypal-secret');

// Debug & Logging
define('DEBUG_MODE', true); // Set to false in production
define('LOG_ERRORS', true);
define('LOG_FILE', __DIR__ . '/logs/error.log');

// Cache Configuration
define('CACHE_ENABLED', false);
define('CACHE_LIFETIME', 3600); // 1 hour

// API Configuration (for future use)
define('API_ENABLED', false);
define('API_KEY', 'your-api-key-here');
define('API_VERSION', 'v1');

// Maintenance Mode
define('MAINTENANCE_MODE', false);
define('MAINTENANCE_MESSAGE', 'We are currently performing scheduled maintenance. Please check back soon.');

// Feature Flags
define('FEATURE_REGISTRATION', true);
define('FEATURE_BOOKING', true);
define('FEATURE_CONTACT_FORM', true);
define('FEATURE_QUOTE_REQUEST', true);
define('FEATURE_NEWSLETTER', false);
define('FEATURE_BLOG', false);

// Set timezone
date_default_timezone_set(TIMEZONE);

// Error reporting based on environment
if (APP_ENV === 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
