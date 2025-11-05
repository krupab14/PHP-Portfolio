<?php
/**
 * Session Management Handler
 * Provides secure session handling for admin authentication
 */

// Start session with secure configuration
if (session_status() === PHP_SESSION_NONE) {
    // Configure session security settings
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 1);
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_samesite', 'Strict');
    
    // Set session lifetime (24 hours)
    ini_set('session.gc_maxlifetime', 86400);
    ini_set('session.cookie_lifetime', 86400);
    
    session_start();
}

/**
 * Check if user is authenticated
 * @return bool Authentication status
 */
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && 
           $_SESSION['admin_logged_in'] === true &&
           isset($_SESSION['admin_user_id']) &&
           isset($_SESSION['login_time']);
}

/**
 * Check if session has expired
 * @return bool Session expiry status
 */
function isSessionExpired() {
    if (!isset($_SESSION['login_time'])) {
        return true;
    }
    
    // Session expires after 24 hours
    $sessionLifetime = 86400; // 24 hours in seconds
    return (time() - $_SESSION['login_time']) > $sessionLifetime;
}

/**
 * Require authentication for admin pages
 * Redirects to login if not authenticated
 */
function requireAuth() {
    if (!isLoggedIn() || isSessionExpired()) {
        // Clear expired session
        destroySession();
        
        // Redirect to login page
        header("Location: login.php?error=session_expired");
        exit();
    }
    
    // Update last activity time
    $_SESSION['last_activity'] = time();
}

/**
 * Create authenticated session for user
 * @param int $userId User ID from database
 * @param string $username Username
 * @return bool Success status
 */
function createSession($userId, $username) {
    // Regenerate session ID for security
    session_regenerate_id(true);
    
    // Set session variables
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_user_id'] = $userId;
    $_SESSION['admin_username'] = $username;
    $_SESSION['login_time'] = time();
    $_SESSION['last_activity'] = time();
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'] ?? '';
    
    return true;
}

/**
 * Destroy user session and clean up
 */
function destroySession() {
    // Clear all session variables
    $_SESSION = array();
    
    // Delete session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy session
    session_destroy();
}

/**
 * Get current admin user info
 * @return array|null User information or null if not logged in
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['admin_user_id'],
        'username' => $_SESSION['admin_username'],
        'login_time' => $_SESSION['login_time'],
        'last_activity' => $_SESSION['last_activity'] ?? $_SESSION['login_time']
    ];
}

/**
 * Validate session security
 * Checks for session hijacking attempts
 * @return bool Security validation status
 */
function validateSessionSecurity() {
    if (!isLoggedIn()) {
        return false;
    }
    
    // Check user agent consistency
    $currentUserAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $sessionUserAgent = $_SESSION['user_agent'] ?? '';
    
    if ($currentUserAgent !== $sessionUserAgent) {
        error_log("Session security warning: User agent mismatch for user " . $_SESSION['admin_username']);
        return false;
    }
    
    // Check IP address consistency (optional - can be disabled if using dynamic IPs)
    $currentIP = $_SERVER['REMOTE_ADDR'] ?? '';
    $sessionIP = $_SESSION['ip_address'] ?? '';
    
    // Note: IP checking is commented out as it can cause issues with dynamic IPs
    // Uncomment if you need strict IP validation
    /*
    if ($currentIP !== $sessionIP) {
        error_log("Session security warning: IP address mismatch for user " . $_SESSION['admin_username']);
        return false;
    }
    */
    
    return true;
}

/**
 * Display session status for debugging (development only)
 */
function displaySessionStatus() {
    if (defined('DEBUG_MODE') && DEBUG_MODE === true) {
        echo "<!-- Session Status: ";
        echo "Logged In: " . (isLoggedIn() ? 'Yes' : 'No') . ", ";
        echo "Expired: " . (isSessionExpired() ? 'Yes' : 'No') . ", ";
        echo "Secure: " . (validateSessionSecurity() ? 'Yes' : 'No');
        echo " -->";
    }
}

/**
 * CSRF Token Management
 */

/**
 * Generate CSRF token for forms
 * @return string CSRF token
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 * @param string $token Token to validate
 * @return bool Validation status
 */
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && 
           hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Generate CSRF hidden input field
 * @return string HTML input field
 */
function getCSRFField() {
    $token = generateCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

// Auto-validate session security on each request (if session exists)
if (isLoggedIn() && !validateSessionSecurity()) {
    error_log("Session security validation failed. Destroying session.");
    destroySession();
    header("Location: login.php?error=security_violation");
    exit();
}
?>