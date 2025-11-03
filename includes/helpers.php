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
    ];
    
    return $badges[$status] ?? '<span class="badge bg-secondary">' . ucfirst($status) . '</span>';
}
