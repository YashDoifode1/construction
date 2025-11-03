# SmartBuild Developers - Construction Company Web System

A complete full-stack construction company website system built with PHP 8+, MySQL, and Bootstrap 5.

## 🌟 Features

### Public Website
- **Home Page**: Hero section, featured services, projects showcase, available plots, testimonials
- **About Us**: Company mission, vision, values, team profiles, company history
- **Services**: Residential construction, commercial projects, interior design, renovation, consulting
- **Projects**: Portfolio gallery with category filters and detailed project views
- **Plots**: Browse available plots with advanced filtering (price, status, size)
- **Contact**: Contact form with company information
- **Quote Request**: Detailed quote request form for project inquiries

### User Features
- **Registration & Login**: Secure user authentication with password hashing
- **User Profile**: View and edit profile information
- **Plot Booking**: Book available plots with booking management
- **Booking History**: Track all plot bookings and their status
- **Password Management**: Change password securely

### Admin Dashboard
- **Dashboard Overview**: Statistics, charts, recent activity
- **Plots Management**: Full CRUD operations for plots
- **Bookings Management**: Approve/reject/manage plot bookings
- **Projects Management**: Add, edit, delete portfolio projects
- **User Management**: View, activate/deactivate users
- **Enquiries**: Manage contact form submissions
- **Quote Requests**: Review and manage quote requests

## 🛠️ Technology Stack

- **Backend**: PHP 8+ (PDO, MVC-style structure)
- **Database**: MySQL (InnoDB, utf8mb4)
- **Frontend**: Bootstrap 5, HTML5, CSS3, JavaScript
- **Icons**: Font Awesome 6
- **Charts**: Chart.js
- **Authentication**: Session-based with password hashing
- **Security**: CSRF protection, prepared statements, input sanitization

## 📁 Project Structure

```
const/
├── admin/                      # Admin panel
│   ├── includes/
│   │   ├── header.php
│   │   └── footer.php
│   ├── login.php
│   ├── dashboard.php
│   ├── plots.php
│   ├── bookings.php
│   ├── projects.php
│   ├── users.php
│   ├── enquiries.php
│   └── quotes.php
├── assets/                     # Static assets
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── main.js
│   └── images/
├── database/                   # Database files
│   ├── create_tables.sql
│   └── seed_data.sql
├── includes/                   # Core includes
│   ├── db.php                 # Database connection
│   ├── session.php            # Session management
│   ├── auth.php               # Authentication functions
│   ├── helpers.php            # Helper functions
│   ├── header.php             # Public header
│   └── footer.php             # Public footer
├── user/                       # User area
│   ├── login.php
│   ├── register.php
│   └── profile.php
├── uploads/                    # File uploads directory
├── index.php                   # Home page
├── about.php
├── services.php
├── projects.php
├── plots.php
├── contact.php
├── quote.php
├── book-plot.php
├── logout.php
└── README.md
```

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.0 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- XAMPP/WAMP/LAMP (recommended for local development)

### Step 1: Clone/Download Project
```bash
# Place the project in your web server directory
# For XAMPP: C:/xampp/htdocs/const/
# For WAMP: C:/wamp64/www/const/
```

### Step 2: Database Setup

1. Open phpMyAdmin or MySQL command line
2. Create the database:
   ```sql
   CREATE DATABASE smartbuild_construction CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. Import the database schema:
   ```bash
   # Using phpMyAdmin: Import database/create_tables.sql
   # OR using command line:
   mysql -u root -p smartbuild_construction < database/create_tables.sql
   ```

4. Import seed data (optional but recommended):
   ```bash
   mysql -u root -p smartbuild_construction < database/seed_data.sql
   ```

### Step 3: Configure Database Connection

Edit `includes/db.php` and update the database credentials:

```php
private $host = 'localhost';
private $dbname = 'smartbuild_construction';
private $username = 'root';        // Your MySQL username
private $password = '';            // Your MySQL password
```

### Step 4: Set Permissions

Ensure the `uploads/` directory is writable:

```bash
# Linux/Mac
chmod 755 uploads/

# Windows: Right-click > Properties > Security > Edit permissions
```

### Step 5: Access the Application

1. **Public Website**: `http://localhost/const/`
2. **Admin Panel**: `http://localhost/const/admin/login.php`

## 🔐 Default Credentials

### Admin Account
- **Email**: admin@smartbuild.com
- **Password**: admin123

### Test User Accounts
- **Email**: john@example.com / **Password**: admin123
- **Email**: jane@example.com / **Password**: admin123

**⚠️ IMPORTANT**: Change default passwords immediately in production!

## 📊 Database Schema

### Tables Overview

1. **users** - User accounts (clients and admins)
2. **plots** - Available construction plots
3. **bookings** - Plot booking records
4. **projects** - Portfolio projects
5. **contacts** - Contact form submissions
6. **quotes** - Quote request submissions
7. **settings** - Site-wide configuration

### Key Relationships
- `users` (1) → (many) `bookings`
- `plots` (1) → (many) `bookings`
- Foreign keys with CASCADE delete

## 🎨 Customization

### Change Color Scheme

Edit `assets/css/style.css`:

```css
:root {
    --primary-color: #1e3c72;      /* Navy Blue */
    --secondary-color: #2a5298;    /* Light Blue */
    --accent-color: #ffc107;       /* Gold */
}
```

### Update Company Information

1. Edit `includes/footer.php` for footer details
2. Update `database/seed_data.sql` settings table
3. Modify `includes/header.php` for navigation

### Add Custom Pages

1. Create new PHP file in root directory
2. Include header: `include 'includes/header.php';`
3. Add your content
4. Include footer: `include 'includes/footer.php';`

## 🔒 Security Features

- **Password Hashing**: Using PHP `password_hash()` with bcrypt
- **CSRF Protection**: Token-based CSRF prevention
- **SQL Injection Prevention**: PDO prepared statements
- **XSS Protection**: Input sanitization and output escaping
- **Session Security**: Secure session management
- **Access Control**: Role-based authentication (user/admin)

## 📱 Responsive Design

The system is fully responsive and works on:
- Desktop (1920px+)
- Laptop (1024px - 1919px)
- Tablet (768px - 1023px)
- Mobile (320px - 767px)

## 🧪 Testing

### Test User Registration
1. Go to `/user/register.php`
2. Fill in the registration form
3. Login with new credentials

### Test Plot Booking
1. Login as a user
2. Browse plots at `/plots.php`
3. Click "Book Now" on an available plot
4. Complete booking form

### Test Admin Functions
1. Login to admin panel
2. Test CRUD operations on plots
3. Approve/reject bookings
4. Manage users and content

## 🐛 Troubleshooting

### Database Connection Error
- Check MySQL service is running
- Verify database credentials in `includes/db.php`
- Ensure database exists

### 404 Errors
- Check Apache mod_rewrite is enabled
- Verify file paths are correct
- Check .htaccess if using URL rewriting

### Upload Errors
- Ensure `uploads/` directory exists
- Check directory permissions (755 or 777)
- Verify PHP upload settings in php.ini

### Session Issues
- Check PHP session configuration
- Ensure cookies are enabled in browser
- Clear browser cache and cookies

## 📈 Future Enhancements

Potential features for future development:

1. **Payment Integration**
   - Stripe/PayPal for plot booking deposits
   - Online payment tracking

2. **Email Notifications**
   - Booking confirmations
   - Status updates
   - Newsletter system

3. **Google Maps Integration**
   - Plot location mapping
   - Interactive map views

4. **REST API**
   - Mobile app support
   - Third-party integrations

5. **Advanced Features**
   - Multi-language support
   - Document management
   - Project timeline tracking
   - Customer portal with documents

6. **Analytics**
   - Google Analytics integration
   - Custom reporting dashboard
   - Sales analytics

## 📝 License

This project is provided as-is for educational and commercial use.

## 👥 Support

For issues, questions, or contributions:
- Review the documentation
- Check the troubleshooting section
- Examine the code comments

## 🎯 Best Practices

### For Developers
- Follow PSR coding standards
- Comment complex logic
- Use prepared statements for all queries
- Validate and sanitize all inputs
- Keep functions small and focused

### For Administrators
- Regular database backups
- Update passwords regularly
- Monitor user activity
- Keep PHP and MySQL updated
- Review security logs

### For Deployment
- Change default credentials
- Enable HTTPS
- Configure proper file permissions
- Set up automated backups
- Enable error logging (disable display_errors)
- Use environment variables for sensitive data

## 📞 Contact

SmartBuild Developers
- Website: http://localhost/const/
- Email: info@smartbuild.com
- Phone: +1-800-SMARTBUILD

---

**Built with ❤️ for SmartBuild Developers**

*Version 1.0.0 - November 2024*
