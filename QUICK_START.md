# SmartBuild Developers - Quick Start Guide

Get up and running in 5 minutes!

## ⚡ Quick Setup (5 Steps)

### Step 1: Start XAMPP (1 minute)
1. Open XAMPP Control Panel
2. Click "Start" for Apache
3. Click "Start" for MySQL
4. Wait for green indicators

### Step 2: Create Database (1 minute)
1. Open browser: `http://localhost/phpmyadmin`
2. Click "New" on left sidebar
3. Database name: `smartbuild_construction`
4. Collation: `utf8mb4_unicode_ci`
5. Click "Create"

### Step 3: Import Database (1 minute)
1. Select `smartbuild_construction` database
2. Click "Import" tab
3. Choose file: `database/create_tables.sql`
4. Click "Go"
5. Repeat for: `database/seed_data.sql`

### Step 4: Configure (30 seconds)
1. Open `includes/db.php`
2. Verify these settings:
   ```php
   private $host = 'localhost';
   private $dbname = 'smartbuild_construction';
   private $username = 'root';
   private $password = '';  // Leave empty for XAMPP
   ```

### Step 5: Launch (30 seconds)
Open browser and visit:
- **Website**: `http://localhost/const/`
- **Admin**: `http://localhost/const/admin/login.php`

## 🔑 Login Credentials

**Admin:**
- Email: `admin@smartbuild.com`
- Password: `admin123`

**Test User:**
- Email: `john@example.com`
- Password: `admin123`

## ✅ Quick Test Checklist

After setup, test these features:

- [ ] Home page loads
- [ ] View plots page
- [ ] View projects page
- [ ] Submit contact form
- [ ] Register new user
- [ ] Login as user
- [ ] Book a plot
- [ ] Login as admin
- [ ] View dashboard
- [ ] Add new plot

## 🎯 First Tasks

### As Admin:
1. Login to admin panel
2. Change default password
3. Add your first plot
4. Add your first project
5. Customize company info

### As User:
1. Register new account
2. Browse available plots
3. Book a plot
4. Check booking status
5. Update profile

## 📂 Important Files

| File | Purpose |
|------|---------|
| `index.php` | Home page |
| `includes/db.php` | Database config |
| `admin/dashboard.php` | Admin dashboard |
| `user/profile.php` | User profile |
| `assets/css/style.css` | Custom styles |

## 🔧 Common Issues & Quick Fixes

### Issue: "Database connection failed"
**Fix:** Check MySQL is running in XAMPP

### Issue: "Table doesn't exist"
**Fix:** Re-import `create_tables.sql`

### Issue: Blank page
**Fix:** Check Apache error log in XAMPP

### Issue: Can't login
**Fix:** Verify database has seed data

## 🚀 Next Steps

1. **Customize Design**
   - Edit `assets/css/style.css`
   - Change colors in CSS variables

2. **Add Content**
   - Upload project images to `assets/images/`
   - Add plots via admin panel
   - Add projects via admin panel

3. **Update Info**
   - Edit `includes/footer.php` for contact details
   - Update company name in `includes/header.php`

4. **Security**
   - Change all default passwords
   - Review security settings
   - Configure HTTPS for production

## 📖 Full Documentation

For detailed information, see:
- `README.md` - Complete documentation
- `INSTALLATION.md` - Detailed installation guide
- `API_DOCUMENTATION.md` - Function reference

## 💡 Tips

- **Backup regularly**: Export database from phpMyAdmin
- **Test thoroughly**: Try all features before going live
- **Keep it updated**: Check for updates regularly
- **Secure it**: Change passwords, enable HTTPS
- **Monitor it**: Check error logs periodically

## 🆘 Need Help?

1. Check `README.md` for detailed docs
2. Review `INSTALLATION.md` for setup issues
3. Check XAMPP error logs
4. Verify all prerequisites are met

## 🎉 You're Ready!

Your SmartBuild Developers system is now running!

Visit: `http://localhost/const/`

---

**Happy Building! 🏗️**
