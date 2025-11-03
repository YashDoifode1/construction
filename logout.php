<?php
require_once 'includes/session.php';
require_once 'includes/helpers.php';

destroyUserSession();
setFlash('success', 'You have been logged out successfully');
redirect(baseUrl('index.php'));
