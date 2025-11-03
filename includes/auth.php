<?php
/**
 * Authentication Functions
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/session.php';

/**
 * Register a new user
 */
function registerUser($fullName, $email, $phone, $password, $role = 'user') {
    // Check if email already exists
    $existing = queryOne("SELECT id FROM users WHERE email = ?", [$email]);
    if ($existing) {
        return ['success' => false, 'message' => 'Email already registered'];
    }
    
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user
    $sql = "INSERT INTO users (full_name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)";
    $result = execute($sql, [$fullName, $email, $phone, $hashedPassword, $role]);
    
    if ($result) {
        return ['success' => true, 'message' => 'Registration successful'];
    }
    
    return ['success' => false, 'message' => 'Registration failed'];
}

/**
 * Login user
 */
function loginUser($email, $password) {
    $user = queryOne("SELECT * FROM users WHERE email = ? AND status = 'active'", [$email]);
    
    if (!$user) {
        return ['success' => false, 'message' => 'Invalid credentials'];
    }
    
    if (!password_verify($password, $user['password'])) {
        return ['success' => false, 'message' => 'Invalid credentials'];
    }
    
    // Set session
    setUserSession($user);
    
    return ['success' => true, 'message' => 'Login successful', 'user' => $user];
}

/**
 * Update user profile
 */
function updateUserProfile($userId, $fullName, $phone) {
    $sql = "UPDATE users SET full_name = ?, phone = ? WHERE id = ?";
    $result = execute($sql, [$fullName, $phone, $userId]);
    
    if ($result) {
        // Update session
        $_SESSION['user_name'] = $fullName;
        return ['success' => true, 'message' => 'Profile updated successfully'];
    }
    
    return ['success' => false, 'message' => 'Update failed'];
}

/**
 * Change user password
 */
function changePassword($userId, $currentPassword, $newPassword) {
    $user = queryOne("SELECT password FROM users WHERE id = ?", [$userId]);
    
    if (!$user) {
        return ['success' => false, 'message' => 'User not found'];
    }
    
    if (!password_verify($currentPassword, $user['password'])) {
        return ['success' => false, 'message' => 'Current password is incorrect'];
    }
    
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = ? WHERE id = ?";
    $result = execute($sql, [$hashedPassword, $userId]);
    
    if ($result) {
        return ['success' => true, 'message' => 'Password changed successfully'];
    }
    
    return ['success' => false, 'message' => 'Password change failed'];
}

/**
 * Get user by ID
 */
function getUserById($userId) {
    return queryOne("SELECT id, full_name, email, phone, role, status, created_at FROM users WHERE id = ?", [$userId]);
}

/**
 * Get all users
 */
function getAllUsers($role = null) {
    if ($role) {
        return query("SELECT id, full_name, email, phone, role, status, created_at FROM users WHERE role = ? ORDER BY created_at DESC", [$role]);
    }
    return query("SELECT id, full_name, email, phone, role, status, created_at FROM users ORDER BY created_at DESC");
}

/**
 * Update user status
 */
function updateUserStatus($userId, $status) {
    $sql = "UPDATE users SET status = ? WHERE id = ?";
    return execute($sql, [$status, $userId]);
}

/**
 * Delete user
 */
function deleteUser($userId) {
    $sql = "DELETE FROM users WHERE id = ?";
    return execute($sql, [$userId]);
}
