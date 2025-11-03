# SmartBuild Developers - Installation Guide

## Quick Start Guide

Follow these steps to get SmartBuild Developers up and running on your local machine.

## Prerequisites Checklist

Before you begin, ensure you have:

- [ ] PHP 8.0 or higher installed
- [ ] MySQL 5.7 or higher installed
- [ ] Web server (Apache/Nginx) installed
- [ ] XAMPP/WAMP/LAMP (recommended) OR separate installations
- [ ] Text editor or IDE (VS Code, PHPStorm, etc.)
- [ ] Web browser (Chrome, Firefox, Edge)

## Installation Steps

### 1. Download and Extract

1. Download the project files
2. Extract to your web server directory:
   - **XAMPP**: `C:/xampp/htdocs/const/`
   - **WAMP**: `C:/wamp64/www/const/`
   - **LAMP**: `/var/www/html/const/`
   - **MAMP**: `/Applications/MAMP/htdocs/const/`

### 2. Start Your Web Server

#### For XAMPP Users:
1. Open XAMPP Control Panel
2. Start Apache
3. Start MySQL
4. Verify both services are running (green indicators)

#### For WAMP Users:
1. Start WAMP Server
2. Wait for icon to turn green
3. Ensure all services are online

#### For LAMP Users:
```bash
sudo service apache2 start
sudo service mysql start
```

### 3. Create Database

#### Option A: Using phpMyAdmin (Recommended for Beginners)

1. Open browser and go to: `http://localhost/phpmyadmin`
2. Click on "New" in the left sidebar
3. Database name: `smartbuild_construction`
4. Collation: `utf8mb4_unicode_ci`
5. Click "Create"

#### Option B: Using MySQL Command Line

```bash
# Open MySQL command line
mysql -u root -p

# Create database
CREATE DATABASE smartbuild_construction CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Exit
exit;
```

### 4. Import Database Tables

#### Option A: Using phpMyAdmin

1. In phpMyAdmin, select `smartbuild_construction` database
2. Click "Import" tab
3. Click "Choose File"
4. Navigate to `const/database/create_tables.sql`
5. Click "Go" at the bottom
6. Wait for success message
7. Repeat steps 3-5 for `const/database/seed_data.sql`

#### Option B: Using Command Line

```bash
# Navigate to project directory
cd C:/xampp/htdocs/const/database

# Import schema
mysql -u root -p smartbuild_construction < create_tables.sql

# Import sample data
mysql -u root -p smartbuild_construction < seed_data.sql
```

### 5. Configure Database Connection

1. Open `includes/db.php` in your text editor
2. Locate these lines (around line 11-14):

```php
private $host = 'localhost';
private $dbname = 'smartbuild_construction';
private $username = 'root';
private $password = '';
```

3. Update if your MySQL credentials are different:
   - `$username`: Your MySQL username (default: 'root')
   - `$password`: Your MySQL password (default: empty for XAMPP)

4. Save the file

### 6. Set Directory Permissions

#### Windows:
1. Right-click on `uploads` folder
2. Properties → Security → Edit
3. Add "Full Control" for Users
4. Apply and OK

#### Linux/Mac:
```bash
chmod 755 uploads/
chmod 755 assets/images/
```

### 7. Access the Application

Open your web browser and navigate to:

**Public Website:**
```
http://localhost/const/
```

**Admin Panel:**
```
http://localhost/const/admin/login.php
```

### 8. Login with Default Credentials

#### Admin Login:
- Email: `admin@smartbuild.com`
- Password: `admin123`

#### Test User Login:
- Email: `john@example.com`
- Password: `admin123`

## Verification Checklist

After installation, verify the following:

- [ ] Home page loads without errors
- [ ] Navigation menu works
- [ ] Can view plots page
- [ ] Can view projects page
- [ ] Contact form is accessible
- [ ] User registration works
- [ ] User login works
- [ ] Admin login works
- [ ] Admin dashboard displays statistics
- [ ] Can add/edit/delete plots in admin panel

## Common Installation Issues

### Issue 1: "Database connection failed"

**Solution:**
1. Verify MySQL is running
2. Check database name is exactly `smartbuild_construction`
3. Verify username and password in `includes/db.php`
4. Ensure database was created successfully

### Issue 2: "Table doesn't exist" errors

**Solution:**
1. Re-import `create_tables.sql`
2. Check that all tables were created in phpMyAdmin
3. Verify you're using the correct database

### Issue 3: Blank white page

**Solution:**
1. Enable error reporting:
   - Edit `php.ini`
   - Set `display_errors = On`
   - Restart Apache
2. Check Apache error logs
3. Verify PHP version is 8.0+

### Issue 4: 404 Not Found errors

**Solution:**
1. Check file paths are correct
2. Verify project is in correct directory
3. Check Apache configuration
4. Ensure mod_rewrite is enabled (if using .htaccess)

### Issue 5: Upload functionality not working

**Solution:**
1. Create `uploads` directory if missing
2. Set proper permissions (755 or 777)
3. Check PHP upload settings in `php.ini`:
   ```ini
   upload_max_filesize = 10M
   post_max_size = 10M
   ```

### Issue 6: Session errors

**Solution:**
1. Check PHP session configuration
2. Ensure session save path is writable
3. Clear browser cookies
4. Restart Apache

## Post-Installation Steps

### 1. Change Default Passwords (CRITICAL!)

1. Login to admin panel
2. Go to your profile
3. Change password immediately
4. Update all test user passwords

### 2. Configure Company Information

1. Edit `includes/footer.php` - Update contact details
2. Edit `includes/header.php` - Update company name
3. Update settings in database if needed

### 3. Add Your Content

1. **Upload Images**: Add your project and plot images to `assets/images/`
2. **Add Projects**: Use admin panel to add real projects
3. **Add Plots**: Use admin panel to add actual plots
4. **Customize Pages**: Edit PHP files to match your content

### 4. Security Hardening

1. Change database password
2. Update CSRF token generation
3. Configure HTTPS (for production)
4. Set up regular backups
5. Review file permissions

### 5. Testing

1. Test user registration flow
2. Test plot booking process
3. Test contact form submission
4. Test quote request submission
5. Test admin CRUD operations
6. Test on different browsers
7. Test on mobile devices

## Development vs Production

### Development Setup (Current)
- Error display: ON
- Debug mode: ON
- Sample data: Included
- Security: Basic

### Production Setup (When Going Live)

1. **Disable Error Display**
```php
// In php.ini or at top of files
display_errors = Off
log_errors = On
```

2. **Enable HTTPS**
- Get SSL certificate
- Configure Apache/Nginx for HTTPS
- Force HTTPS redirects

3. **Secure Database**
- Use strong passwords
- Limit database user privileges
- Enable MySQL security features

4. **Environment Variables**
- Move sensitive config to .env file
- Use environment variables for credentials

5. **Optimize Performance**
- Enable caching
- Minify CSS/JS
- Optimize images
- Enable gzip compression

6. **Backup Strategy**
- Automated daily database backups
- File system backups
- Off-site backup storage

## Getting Help

If you encounter issues:

1. **Check Documentation**: Review README.md
2. **Check Error Logs**: 
   - Apache: `xampp/apache/logs/error.log`
   - PHP: Check php error log location
3. **Verify Requirements**: Ensure all prerequisites are met
4. **Test Database**: Verify database connection manually
5. **Browser Console**: Check for JavaScript errors

## Next Steps

After successful installation:

1. Explore the admin dashboard
2. Add your first plot
3. Create a test booking
4. Customize the design
5. Add your company information
6. Test all features thoroughly

## Backup Your Work

Before making changes:

```bash
# Backup database
mysqldump -u root -p smartbuild_construction > backup.sql

# Backup files
# Copy entire const/ folder to safe location
```

## Updating the System

To update in the future:

1. Backup current database and files
2. Download new version
3. Replace files (keep your config)
4. Run any new migration scripts
5. Test thoroughly

---

**Installation Complete! 🎉**

You're now ready to use SmartBuild Developers. Visit `http://localhost/const/` to get started!

For questions or issues, refer to the main README.md file.
