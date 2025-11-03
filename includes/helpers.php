<?php
/**
 * Helper Functions
 */

/**
 * Sanitize input
 */
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone
 */
function isValidPhone($phone) {
    return preg_match('/^[+]?[0-9]{10,15}$/', $phone);
}

/**
 * Format currency
 */
function formatCurrency($amount) {
    return '$' . number_format($amount, 2);
}

/**
 * Format date
 */
function formatDate($date, $format = 'M d, Y') {
    return date($format, strtotime($date));
}

/**
 * Time ago function
 */
function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $difference = time() - $timestamp;
    
    $periods = [
        'year' => 31536000,
        'month' => 2592000,
        'week' => 604800,
        'day' => 86400,
        'hour' => 3600,
        'minute' => 60,
        'second' => 1
    ];
    
    foreach ($periods as $key => $value) {
        if ($difference >= $value) {
            $time = floor($difference / $value);
            return $time . ' ' . $key . ($time > 1 ? 's' : '') . ' ago';
        }
    }
    
    return 'Just now';
}

/**
 * Upload file
 */
function uploadFile($file, $uploadDir = 'uploads/', $allowedTypes = ['jpg', 'jpeg', 'png', 'gif']) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'No file uploaded or upload error'];
    }
    
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    if (!in_array($fileExt, $allowedTypes)) {
        return ['success' => false, 'message' => 'Invalid file type'];
    }
    
    if ($fileSize > 5242880) { // 5MB
        return ['success' => false, 'message' => 'File size exceeds 5MB'];
    }
    
    $newFileName = uniqid('', true) . '.' . $fileExt;
    $uploadPath = $uploadDir . $newFileName;
    
    // Create directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    if (move_uploaded_file($fileTmpName, $uploadPath)) {
        return ['success' => true, 'filename' => $newFileName, 'path' => $uploadPath];
    }
    
    return ['success' => false, 'message' => 'Failed to upload file'];
}

/**
 * Delete file
 */
function deleteFile($filePath) {
    if (file_exists($filePath)) {
        return unlink($filePath);
    }
    return false;
}

/**
 * Redirect
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Get base URL
 */
function baseUrl($path = '') {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    return $protocol . '://' . $host . '/const/' . ltrim($path, '/');
}

/**
 * Get asset URL
 */
function asset($path) {
    return baseUrl('assets/' . ltrim($path, '/'));
}

/**
 * Truncate text
 */
function truncate($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $suffix;
}

/**
 * Generate random string
 */
function generateRandomString($length = 10) {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Check if request is POST
 */
function isPost() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
 * Check if request is GET
 */
function isGet() {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

/**
 * Get POST data
 */
function post($key, $default = null) {
    return $_POST[$key] ?? $default;
}

/**
 * Get GET data
 */
function get($key, $default = null) {
    return $_GET[$key] ?? $default;
}

/**
 * JSON response
 */
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

/**
 * Get status badge HTML
 */
function getStatusBadge($status) {
    $badges = [
        'available' => '<span class="badge bg-success">Available</span>',
        'booked' => '<span class="badge bg-warning">Booked</span>',
        'sold' => '<span class="badge bg-danger">Sold</span>',
        'pending' => '<span class="badge bg-warning">Pending</span>',
        'approved' => '<span class="badge bg-success">Approved</span>',
        'rejected' => '<span class="badge bg-danger">Rejected</span>',
        'cancelled' => '<span class="badge bg-secondary">Cancelled</span>',
        'active' => '<span class="badge bg-success">Active</span>',
        'inactive' => '<span class="badge bg-secondary">Inactive</span>',
        'unread' => '<span class="badge bg-primary">Unread</span>',
        'read' => '<span class="badge bg-secondary">Read</span>',
        'ongoing' => '<span class="badge bg-info">Ongoing</span>',
        'completed' => '<span class="badge bg-success">Completed</span>',
        'reviewed' => '<span class="badge bg-info">Reviewed</span>',
        'quoted' => '<span class="badge bg-primary">Quoted</span>',
        'closed' => '<span class="badge bg-secondary">Closed</span>',
    ];
    
    return $badges[$status] ?? '<span class="badge bg-secondary">' . ucfirst($status) . '</span>';
}

/**
 * Generate password reset token
 */
function generateResetToken() {
    return bin2hex(random_bytes(32));
}

/**
 * Create password reset request and send email
 */
function createPasswordReset($email, $sendEmail = true) {
    $token = generateResetToken();
    $sql = "INSERT INTO password_resets (email, token) VALUES (?, ?)";
    $result = execute($sql, [$email, $token]);
    
    if ($result && $sendEmail) {
        // Load mail helper if not already loaded
        if (!function_exists('sendPasswordResetEmail')) {
            require_once __DIR__ . '/mail.php';
        }
        
        // Send password reset email
        $emailSent = sendPasswordResetEmail($email, $token);
        
        // Return token even if email fails (for debugging)
        return $token;
    }
    
    return $result ? $token : false;
}

/**
 * Verify password reset token
 */
function verifyResetToken($token) {
    // Token expires after 30 minutes
    $sql = "SELECT * FROM password_resets WHERE token = ? AND created_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)";
    return queryOne($sql, [$token]);
}

/**
 * Delete password reset token
 */
function deleteResetToken($token) {
    execute("DELETE FROM password_resets WHERE token = ?", [$token]);
}

/**
 * Clean expired reset tokens
 */
function cleanExpiredTokens() {
    execute("DELETE FROM password_resets WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 MINUTE)");
}

/**
 * Upload image file with validation
 */
function uploadImage($file, $uploadDir = 'uploads/', $allowedTypes = ['jpg', 'jpeg', 'png', 'webp', 'gif']) {
    // Check if file was uploaded
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return ['success' => false, 'message' => 'No file uploaded'];
    }
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Upload error occurred'];
    }
    
    // Validate file size (max 2MB)
    $maxSize = 2 * 1024 * 1024; // 2MB
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'message' => 'File size exceeds 2MB limit'];
    }
    
    // Get file extension
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    // Validate file type
    if (!in_array($extension, $allowedTypes)) {
        return ['success' => false, 'message' => 'Invalid file type. Allowed: ' . implode(', ', $allowedTypes)];
    }
    
    // Validate MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    $allowedMimes = [
        'image/jpeg' => ['jpg', 'jpeg'],
        'image/png' => ['png'],
        'image/webp' => ['webp'],
        'image/gif' => ['gif']
    ];
    
    $validMime = false;
    foreach ($allowedMimes as $mime => $exts) {
        if ($mimeType === $mime && in_array($extension, $exts)) {
            $validMime = true;
            break;
        }
    }
    
    if (!$validMime) {
        return ['success' => false, 'message' => 'Invalid file format'];
    }
    
    // Create upload directory if it doesn't exist
    $fullUploadDir = __DIR__ . '/../' . $uploadDir;
    if (!is_dir($fullUploadDir)) {
        mkdir($fullUploadDir, 0755, true);
    }
    
    // Generate unique filename
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $destination = $fullUploadDir . $filename;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return [
            'success' => true,
            'filename' => $filename,
            'path' => $uploadDir . $filename,
            'message' => 'File uploaded successfully'
        ];
    }
    
    return ['success' => false, 'message' => 'Failed to move uploaded file'];
}

/**
 * Delete uploaded file
 */
function deleteUploadedFile($filepath) {
    $fullPath = __DIR__ . '/../' . $filepath;
    if (file_exists($fullPath) && is_file($fullPath)) {
        return unlink($fullPath);
    }
    return false;
}

/**
 * Get site settings from database
 */
function getSiteSettings() {
    static $settings = null;
    
    if ($settings === null) {
        $settings = queryOne("SELECT * FROM settings LIMIT 1");
        if (!$settings) {
            // Return default settings if none exist
            $settings = [
                'site_name' => 'SmartBuild Developers',
                'tagline' => 'Building Dreams, Shaping Skylines',
                'logo' => null,
                'favicon' => null,
                'footer_text' => '© 2024 SmartBuild Developers. All rights reserved.',
                'contact_email' => 'info@smartbuild.com',
                'contact_phone' => '+1-800-SMARTBUILD'
            ];
        }
    }
    
    return $settings;
}

/**
 * Update site settings
 */
function updateSiteSettings($data) {
    $sql = "UPDATE settings SET 
            site_name = ?, 
            tagline = ?, 
            footer_text = ?, 
            contact_email = ?, 
            contact_phone = ?,
            facebook_url = ?,
            twitter_url = ?,
            instagram_url = ?,
            linkedin_url = ?
            WHERE id = 1";
    
    return execute($sql, [
        $data['site_name'],
        $data['tagline'],
        $data['footer_text'],
        $data['contact_email'],
        $data['contact_phone'],
        $data['facebook_url'] ?? null,
        $data['twitter_url'] ?? null,
        $data['instagram_url'] ?? null,
        $data['linkedin_url'] ?? null
    ]);
}

/**
 * Update site logo
 */
function updateSiteLogo($filename) {
    return execute("UPDATE settings SET logo = ? WHERE id = 1", [$filename]);
}

/**
 * Update site favicon
 */
function updateSiteFavicon($filename) {
    return execute("UPDATE settings SET favicon = ? WHERE id = 1", [$filename]);
}
