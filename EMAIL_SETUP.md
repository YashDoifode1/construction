# Email Setup Guide - PHPMailer Integration

This guide will help you set up email functionality for password reset and other notifications.

## Installation

### Step 1: Install PHPMailer via Composer

Open your terminal/command prompt in the project root directory and run:

```bash
composer install
```

This will install PHPMailer and its dependencies.

### Step 2: Configure Email Settings

1. Copy `config.example.php` to `config.php` if you haven't already:
   ```bash
   copy config.example.php config.php
   ```

2. Open `config.php` and update the email configuration section:

```php
// Email Configuration
define('SMTP_HOST', 'smtp.gmail.com');           // Your SMTP server
define('SMTP_PORT', 587);                        // SMTP port (587 for TLS, 465 for SSL)
define('SMTP_USER', 'your-email@gmail.com');     // Your email address
define('SMTP_PASS', 'your-app-password');        // Your email password or app password
define('SMTP_FROM_EMAIL', 'noreply@yourdomain.com');
define('SMTP_FROM_NAME', 'SmartBuild Developers');
```

## Email Provider Setup

### Gmail Setup

1. **Enable 2-Step Verification** on your Google account
2. **Generate App Password**:
   - Go to Google Account Settings
   - Security → 2-Step Verification → App passwords
   - Generate a new app password for "Mail"
   - Use this password in `SMTP_PASS`

3. **Configuration**:
   ```php
   define('SMTP_HOST', 'smtp.gmail.com');
   define('SMTP_PORT', 587);
   define('SMTP_USER', 'your-email@gmail.com');
   define('SMTP_PASS', 'your-16-char-app-password');
   ```

### Other Email Providers

#### Outlook/Hotmail
```php
define('SMTP_HOST', 'smtp-mail.outlook.com');
define('SMTP_PORT', 587);
```

#### Yahoo Mail
```php
define('SMTP_HOST', 'smtp.mail.yahoo.com');
define('SMTP_PORT', 587);
```

#### SendGrid
```php
define('SMTP_HOST', 'smtp.sendgrid.net');
define('SMTP_PORT', 587);
define('SMTP_USER', 'apikey');
define('SMTP_PASS', 'your-sendgrid-api-key');
```

#### Mailgun
```php
define('SMTP_HOST', 'smtp.mailgun.org');
define('SMTP_PORT', 587);
define('SMTP_USER', 'postmaster@your-domain.mailgun.org');
define('SMTP_PASS', 'your-mailgun-password');
```

## Testing Email Functionality

### Test Password Reset Email

1. Go to the forgot password page: `http://localhost/const/user/forgot-password.php`
2. Enter a registered email address
3. Submit the form
4. Check your email inbox (and spam folder)

### Development/Testing Without SMTP

If you want to test without configuring SMTP, you can use PHP's built-in `mail()` function:

In `config.php`, set:
```php
define('SMTP_HOST', 'smtp.example.com'); // Keep as example
```

The system will automatically fall back to PHP's `mail()` function. Note: This requires your server to have mail configured.

### Alternative: Use Mailtrap for Testing

Mailtrap is a fake SMTP server for development:

1. Sign up at https://mailtrap.io (free)
2. Get your credentials from the inbox settings
3. Configure:
   ```php
   define('SMTP_HOST', 'smtp.mailtrap.io');
   define('SMTP_PORT', 2525);
   define('SMTP_USER', 'your-mailtrap-username');
   define('SMTP_PASS', 'your-mailtrap-password');
   ```

## Email Functions Available

### 1. Password Reset Email
```php
sendPasswordResetEmail($email, $token);
```
Automatically called when a user requests a password reset.

### 2. Welcome Email
```php
sendWelcomeEmail($email, $name);
```
Send a welcome email to new users after registration.

### 3. Contact Form Notification
```php
sendContactNotification($data);
```
Send notification when someone submits the contact form.

### 4. Custom Email
```php
sendEmail($to, $subject, $htmlBody, $plainTextBody);
```
Send any custom email with HTML and plain text versions.

## Troubleshooting

### Email Not Sending

1. **Check SMTP credentials** - Make sure they're correct
2. **Check firewall** - Ensure port 587 or 465 is not blocked
3. **Check error logs** - Look in your PHP error log for details
4. **Enable debugging** - Add this to `mail.php` temporarily:
   ```php
   $mail->SMTPDebug = SMTP::DEBUG_SERVER;
   ```

### Gmail "Less Secure Apps" Error

- Use App Passwords instead of your regular password
- Enable 2-Step Verification first

### Emails Going to Spam

1. Use a proper "From" email address (not @gmail.com for production)
2. Set up SPF, DKIM, and DMARC records for your domain
3. Use a reputable email service provider

## Production Recommendations

1. **Use a dedicated email service**:
   - SendGrid (12,000 free emails/month)
   - Mailgun (5,000 free emails/month)
   - Amazon SES (62,000 free emails/month)

2. **Set up proper DNS records**:
   - SPF record
   - DKIM signature
   - DMARC policy

3. **Monitor email delivery**:
   - Track bounce rates
   - Monitor spam complaints
   - Keep email lists clean

4. **Security**:
   - Never commit `config.php` to version control
   - Use environment variables for sensitive data
   - Rotate SMTP passwords regularly

## File Structure

```
includes/
├── mail.php          # Email helper functions
└── helpers.php       # Updated with email integration

user/
└── forgot-password.php  # Password reset form

composer.json         # PHPMailer dependency
```

## Support

For issues or questions:
- Check PHPMailer documentation: https://github.com/PHPMailer/PHPMailer
- Review error logs in your server
- Test with Mailtrap.io for development
