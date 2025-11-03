@echo off
echo ========================================
echo PHPMailer Installation Script
echo ========================================
echo.

REM Check if composer is installed
where composer >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Composer is not installed or not in PATH
    echo.
    echo Please install Composer first:
    echo https://getcomposer.org/download/
    echo.
    pause
    exit /b 1
)

echo Composer found! Installing PHPMailer...
echo.

REM Install PHPMailer
composer install

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ========================================
    echo SUCCESS! PHPMailer installed successfully
    echo ========================================
    echo.
    echo Next steps:
    echo 1. Copy config.example.php to config.php
    echo 2. Update SMTP settings in config.php
    echo 3. Read EMAIL_SETUP.md for detailed instructions
    echo.
) else (
    echo.
    echo ========================================
    echo ERROR: Installation failed
    echo ========================================
    echo.
    echo Please check the error messages above
    echo.
)

pause
