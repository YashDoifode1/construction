# SmartBuild Developers - API Documentation

## Overview

This document provides information about the internal functions and structure of the SmartBuild Developers system. This is not a REST API documentation but rather a guide to the PHP functions and database structure.

## Database Functions (includes/db.php)

### Database Connection

#### `getDB()`
Returns the PDO database connection instance.

```php
$db = getDB();
```

#### `query($sql, $params = [])`
Execute a query and return all results.

```php
$plots = query("SELECT * FROM plots WHERE status = ?", ['available']);
```

**Parameters:**
- `$sql` (string): SQL query with placeholders
- `$params` (array): Parameters for prepared statement

**Returns:** Array of results

#### `queryOne($sql, $params = [])`
Execute a query and return single result.

```php
$user = queryOne("SELECT * FROM users WHERE id = ?", [1]);
```

**Returns:** Single row as associative array or false

#### `execute($sql, $params = [])`
Execute an insert/update/delete query.

```php
execute("UPDATE plots SET status = ? WHERE id = ?", ['sold', 5]);
```

**Returns:** Boolean success status

#### `lastInsertId()`
Get the ID of the last inserted row.

```php
$newId = lastInsertId();
```

**Returns:** Integer ID

## Authentication Functions (includes/auth.php)

### User Management

#### `registerUser($fullName, $email, $phone, $password, $role = 'user')`
Register a new user account.

```php
$result = registerUser('John Doe', 'john@example.com', '+1234567890', 'password123');
```

**Returns:** Array with 'success' and 'message' keys

#### `loginUser($email, $password)`
Authenticate user and create session.

```php
$result = loginUser('john@example.com', 'password123');
```

**Returns:** Array with 'success', 'message', and 'user' keys

#### `updateUserProfile($userId, $fullName, $phone)`
Update user profile information.

```php
updateUserProfile(1, 'John Smith', '+1234567891');
```

#### `changePassword($userId, $currentPassword, $newPassword)`
Change user password.

```php
$result = changePassword(1, 'oldpass', 'newpass');
```

#### `getUserById($userId)`
Get user information by ID.

```php
$user = getUserById(1);
```

#### `getAllUsers($role = null)`
Get all users, optionally filtered by role.

```php
$users = getAllUsers('user');
```

## Session Functions (includes/session.php)

### Session Management

#### `setFlash($type, $message)`
Set a flash message for next page load.

```php
setFlash('success', 'Operation completed successfully');
```

**Parameters:**
- `$type`: 'success', 'error', 'warning', 'info'
- `$message`: Message text

#### `getFlash()`
Retrieve and clear flash message.

```php
$flash = getFlash();
if ($flash) {
    echo $flash['message'];
}
```

#### `isLoggedIn()`
Check if user is logged in.

```php
if (isLoggedIn()) {
    // User is authenticated
}
```

#### `isAdmin()`
Check if current user is admin.

```php
if (isAdmin()) {
    // User has admin privileges
}
```

#### `getCurrentUserId()`
Get current user's ID.

```php
$userId = getCurrentUserId();
```

#### `getCurrentUser()`
Get current user's information.

```php
$user = getCurrentUser();
echo $user['name'];
```

#### `requireLogin($redirectUrl)`
Require user to be logged in, redirect if not.

```php
requireLogin('/const/user/login.php');
```

#### `requireAdmin($redirectUrl)`
Require admin access, redirect if not.

```php
requireAdmin('/const/admin/login.php');
```

### CSRF Protection

#### `generateCsrfToken()`
Generate CSRF token for forms.

```php
$token = generateCsrfToken();
```

#### `verifyCsrfToken($token)`
Verify CSRF token from form submission.

```php
if (verifyCsrfToken($_POST['csrf_token'])) {
    // Token is valid
}
```

#### `csrfField()`
Generate hidden input field with CSRF token.

```php
<form method="POST">
    <?php echo csrfField(); ?>
    <!-- form fields -->
</form>
```

## Helper Functions (includes/helpers.php)

### Input Validation

#### `sanitize($data)`
Sanitize user input.

```php
$clean = sanitize($_POST['input']);
```

#### `isValidEmail($email)`
Validate email address.

```php
if (isValidEmail($email)) {
    // Email is valid
}
```

#### `isValidPhone($phone)`
Validate phone number.

```php
if (isValidPhone($phone)) {
    // Phone is valid
}
```

### Formatting

#### `formatCurrency($amount)`
Format number as currency.

```php
echo formatCurrency(125000); // $125,000.00
```

#### `formatDate($date, $format = 'M d, Y')`
Format date string.

```php
echo formatDate('2024-11-03'); // Nov 03, 2024
```

#### `timeAgo($datetime)`
Get relative time string.

```php
echo timeAgo('2024-11-03 10:00:00'); // 2 hours ago
```

#### `truncate($text, $length = 100, $suffix = '...')`
Truncate text to specified length.

```php
echo truncate($longText, 50);
```

### File Operations

#### `uploadFile($file, $uploadDir, $allowedTypes)`
Handle file upload.

```php
$result = uploadFile($_FILES['image'], 'uploads/', ['jpg', 'png']);
if ($result['success']) {
    echo $result['filename'];
}
```

#### `deleteFile($filePath)`
Delete a file.

```php
deleteFile('uploads/image.jpg');
```

### URL & Navigation

#### `redirect($url)`
Redirect to URL.

```php
redirect(baseUrl('admin/dashboard.php'));
```

#### `baseUrl($path = '')`
Get base URL with optional path.

```php
$url = baseUrl('plots.php'); // http://localhost/const/plots.php
```

#### `asset($path)`
Get asset URL.

```php
$cssUrl = asset('css/style.css');
```

### Request Helpers

#### `isPost()`
Check if request is POST.

```php
if (isPost()) {
    // Handle form submission
}
```

#### `post($key, $default = null)`
Get POST data safely.

```php
$name = post('name', 'Guest');
```

#### `get($key, $default = null)`
Get GET data safely.

```php
$id = get('id', 0);
```

### UI Helpers

#### `getStatusBadge($status)`
Get HTML badge for status.

```php
echo getStatusBadge('available'); // <span class="badge bg-success">Available</span>
```

## Database Schema

### Users Table
```sql
- id (INT, PRIMARY KEY)
- full_name (VARCHAR)
- email (VARCHAR, UNIQUE)
- phone (VARCHAR)
- password (VARCHAR, hashed)
- role (ENUM: 'user', 'admin')
- status (ENUM: 'active', 'inactive')
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

### Plots Table
```sql
- id (INT, PRIMARY KEY)
- plot_no (VARCHAR, UNIQUE)
- size (VARCHAR)
- price (DECIMAL)
- location (VARCHAR)
- description (TEXT)
- image (VARCHAR)
- status (ENUM: 'available', 'booked', 'sold')
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

### Bookings Table
```sql
- id (INT, PRIMARY KEY)
- user_id (INT, FOREIGN KEY)
- plot_id (INT, FOREIGN KEY)
- booking_date (DATE)
- status (ENUM: 'pending', 'approved', 'rejected', 'cancelled')
- notes (TEXT)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

### Projects Table
```sql
- id (INT, PRIMARY KEY)
- title (VARCHAR)
- category (ENUM: 'residential', 'commercial', 'interior', 'renovation')
- description (TEXT)
- location (VARCHAR)
- image (VARCHAR)
- gallery (TEXT, JSON)
- completion_date (DATE)
- status (ENUM: 'ongoing', 'completed')
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

### Contacts Table
```sql
- id (INT, PRIMARY KEY)
- name (VARCHAR)
- email (VARCHAR)
- phone (VARCHAR)
- message (TEXT)
- status (ENUM: 'unread', 'read')
- created_at (TIMESTAMP)
```

### Quotes Table
```sql
- id (INT, PRIMARY KEY)
- name (VARCHAR)
- email (VARCHAR)
- phone (VARCHAR)
- project_type (VARCHAR)
- budget (VARCHAR)
- location (VARCHAR)
- description (TEXT)
- status (ENUM: 'pending', 'reviewed', 'quoted', 'closed')
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

## Security Best Practices

### Password Handling
```php
// Hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Verify password
if (password_verify($inputPassword, $hashedPassword)) {
    // Password is correct
}
```

### SQL Queries
Always use prepared statements:
```php
// GOOD
$user = queryOne("SELECT * FROM users WHERE email = ?", [$email]);

// BAD - Never do this!
$user = query("SELECT * FROM users WHERE email = '$email'");
```

### Input Sanitization
```php
$name = sanitize($_POST['name']);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
```

### Output Escaping
```php
echo htmlspecialchars($userInput, ENT_QUOTES, 'UTF-8');
```

## Common Workflows

### User Registration Flow
1. User submits registration form
2. Validate input data
3. Check if email already exists
4. Hash password
5. Insert into database
6. Redirect to login

### Plot Booking Flow
1. User selects plot
2. Check if user is logged in
3. Verify plot is available
4. Create booking record
5. Update plot status to 'booked'
6. Send confirmation

### Admin Approval Flow
1. Admin views pending bookings
2. Reviews booking details
3. Approves or rejects
4. Updates booking status
5. Notification sent to user

## Error Handling

```php
try {
    beginTransaction();
    
    // Multiple database operations
    execute("INSERT INTO ...", []);
    execute("UPDATE ...", []);
    
    commit();
} catch (Exception $e) {
    rollback();
    error_log($e->getMessage());
    setFlash('error', 'Operation failed');
}
```

---

**Last Updated:** November 3, 2024
**Version:** 1.0.0
