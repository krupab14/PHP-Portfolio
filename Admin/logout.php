<?php
/**
 * Admin Logout Handler
 * Securely logs out admin users and destroys sessions
 */

// Include session handler
require_once 'session-handler.php';

// Log the logout action
if (isLoggedIn()) {
    $user = getCurrentUser();
    error_log("Admin logout: User '{$user['username']}' logged out at " . date('Y-m-d H:i:s'));
}

// Destroy the session
destroySession();

// Redirect to login page with logout message
header("Location: login.php?message=logged_out");
exit();
?>