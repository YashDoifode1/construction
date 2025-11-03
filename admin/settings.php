<?php
require_once '../includes/db.php';
require_once '../includes/helpers.php';

$pageTitle = 'Website Settings';

// Get current settings
$settings = getSiteSettings();

// Handle form submission
if (isPost()) {
    $action = post('action');
    $csrfToken = post('csrf_token');
    
    if (!verifyCsrfToken($csrfToken)) {
        setFlash('error', 'Invalid request');
        redirect(baseUrl('admin/settings.php'));
        exit;
    }
    
    if ($action === 'update_settings') {
        $data = [
            'site_name' => sanitize(post('site_name')),
            'tagline' => sanitize(post('tagline')),
            'footer_text' => sanitize(post('footer_text')),
            'contact_email' => sanitize(post('contact_email')),
            'contact_phone' => sanitize(post('contact_phone')),
            'facebook_url' => sanitize(post('facebook_url')),
            'twitter_url' => sanitize(post('twitter_url')),
            'instagram_url' => sanitize(post('instagram_url')),
            'linkedin_url' => sanitize(post('linkedin_url'))
        ];
        
        if (empty($data['site_name']) || empty($data['contact_email'])) {
            setFlash('error', 'Site name and contact email are required');
        } elseif (!isValidEmail($data['contact_email'])) {
            setFlash('error', 'Invalid email address');
        } else {
            if (updateSiteSettings($data)) {
                setFlash('success', 'Settings updated successfully');
            } else {
                setFlash('error', 'Failed to update settings');
            }
        }
        redirect(baseUrl('admin/settings.php'));
    }
    
    elseif ($action === 'upload_logo') {
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = uploadImage($_FILES['logo'], 'uploads/settings/');
            
            if ($uploadResult['success']) {
                // Delete old logo
                if ($settings['logo']) {
                    deleteUploadedFile($settings['logo']);
                }
                
                if (updateSiteLogo($uploadResult['path'])) {
                    setFlash('success', 'Logo uploaded successfully');
                } else {
                    setFlash('error', 'Failed to save logo');
                }
            } else {
                setFlash('error', $uploadResult['message']);
            }
        } else {
            setFlash('error', 'No file uploaded');
        }
        redirect(baseUrl('admin/settings.php'));
    }
    
    elseif ($action === 'upload_favicon') {
        if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = uploadImage($_FILES['favicon'], 'uploads/settings/', ['ico', 'png']);
            
            if ($uploadResult['success']) {
                // Delete old favicon
                if ($settings['favicon']) {
                    deleteUploadedFile($settings['favicon']);
                }
                
                if (updateSiteFavicon($uploadResult['path'])) {
                    setFlash('success', 'Favicon uploaded successfully');
                } else {
                    setFlash('error', 'Failed to save favicon');
                }
            } else {
                setFlash('error', $uploadResult['message']);
            }
        } else {
            setFlash('error', 'No file uploaded');
        }
        redirect(baseUrl('admin/settings.php'));
    }
}

// Refresh settings after update
$settings = getSiteSettings();

include 'includes/header.php';
?>

<div class="container-fluid">
    <h2 class="fw-bold mb-4">Website Settings</h2>
    
    <div class="row">
        <!-- General Settings -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-cog me-2"></i> General Settings</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="action" value="update_settings">
                        
                        <div class="mb-3">
                            <label class="form-label">Site Name *</label>
                            <input type="text" class="form-control" name="site_name" value="<?php echo htmlspecialchars($settings['site_name']); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Tagline / Slogan</label>
                            <input type="text" class="form-control" name="tagline" value="<?php echo htmlspecialchars($settings['tagline']); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Footer Text</label>
                            <input type="text" class="form-control" name="footer_text" value="<?php echo htmlspecialchars($settings['footer_text']); ?>">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Email *</label>
                                <input type="email" class="form-control" name="contact_email" value="<?php echo htmlspecialchars($settings['contact_email']); ?>" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Phone</label>
                                <input type="text" class="form-control" name="contact_phone" value="<?php echo htmlspecialchars($settings['contact_phone']); ?>">
                            </div>
                        </div>
                        
                        <h6 class="fw-bold mt-4 mb-3">Social Media Links</h6>
                        
                        <div class="mb-3">
                            <label class="form-label"><i class="fab fa-facebook text-primary me-2"></i> Facebook URL</label>
                            <input type="url" class="form-control" name="facebook_url" value="<?php echo htmlspecialchars($settings['facebook_url'] ?? ''); ?>" placeholder="https://facebook.com/yourpage">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><i class="fab fa-twitter text-info me-2"></i> Twitter URL</label>
                            <input type="url" class="form-control" name="twitter_url" value="<?php echo htmlspecialchars($settings['twitter_url'] ?? ''); ?>" placeholder="https://twitter.com/yourhandle">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><i class="fab fa-instagram text-danger me-2"></i> Instagram URL</label>
                            <input type="url" class="form-control" name="instagram_url" value="<?php echo htmlspecialchars($settings['instagram_url'] ?? ''); ?>" placeholder="https://instagram.com/yourprofile">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><i class="fab fa-linkedin text-primary me-2"></i> LinkedIn URL</label>
                            <input type="url" class="form-control" name="linkedin_url" value="<?php echo htmlspecialchars($settings['linkedin_url'] ?? ''); ?>" placeholder="https://linkedin.com/company/yourcompany">
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Logo & Favicon -->
        <div class="col-lg-4">
            <!-- Logo Upload -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-image me-2"></i> Site Logo</h5>
                </div>
                <div class="card-body p-4">
                    <?php if ($settings['logo']): ?>
                    <div class="text-center mb-3">
                        <img src="<?php echo baseUrl($settings['logo']); ?>" alt="Logo" class="img-fluid" style="max-height: 100px;">
                    </div>
                    <?php else: ?>
                    <div class="text-center mb-3 text-muted">
                        <i class="fas fa-image fa-3x"></i>
                        <p class="mt-2">No logo uploaded</p>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="" enctype="multipart/form-data">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="action" value="upload_logo">
                        
                        <div class="mb-3">
                            <input type="file" class="form-control" name="logo" accept="image/*" required>
                            <small class="text-muted">PNG, JPG, WEBP. Max 2MB</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-upload"></i> Upload Logo
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Favicon Upload -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-star me-2"></i> Favicon</h5>
                </div>
                <div class="card-body p-4">
                    <?php if ($settings['favicon']): ?>
                    <div class="text-center mb-3">
                        <img src="<?php echo baseUrl($settings['favicon']); ?>" alt="Favicon" style="width: 64px; height: 64px;">
                    </div>
                    <?php else: ?>
                    <div class="text-center mb-3 text-muted">
                        <i class="fas fa-star fa-3x"></i>
                        <p class="mt-2">No favicon uploaded</p>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="" enctype="multipart/form-data">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="action" value="upload_favicon">
                        
                        <div class="mb-3">
                            <input type="file" class="form-control" name="favicon" accept=".ico,.png" required>
                            <small class="text-muted">ICO or PNG. 16x16 or 32x32px</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-upload"></i> Upload Favicon
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
