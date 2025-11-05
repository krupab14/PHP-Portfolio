<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Krupa Bhalsod Portfolio</title>
    <meta name="description" content="Admin panel login for Krupa Bhalsod's portfolio website">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #522258;
            --secondary-color: #dc5f00;
            --background-gradient: linear-gradient(135deg, #c3b1e1 0%, #eeeeee 100%);
        }
        
        body {
            background: var(--background-gradient);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 500px;
            width: 100%;
            padding: 3rem;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: #6c757d;
            margin: 0;
        }
        
        .form-floating {
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(82, 34, 88, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            margin-top: 1rem;
        }
        
        .back-to-site {
            text-align: center;
            margin-top: 2rem;
        }
        
        .back-to-site a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-to-site a:hover {
            color: var(--secondary-color);
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2><i class="fas fa-user-shield"></i> Admin Login</h2>
                <p>Access the portfolio administration panel</p>
            </div>
            
            <!-- Success Message -->
            <?php if ($success_message): ?>
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>
            
            <!-- Error Message -->
            <?php if ($error_message): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <form id="loginForm" method="POST" class="needs-validation" novalidate>
                <?php echo getCSRFField(); ?>
                
                <div class="form-floating">
                    <input type="text" class="form-control" id="username" name="username" 
                           placeholder="Enter username" autocomplete="username" required
                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <div class="invalid-feedback">
                        Please enter your username.
                    </div>
                </div>
                
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="Enter password" autocomplete="current-password" required>
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <div class="invalid-feedback">
                        Please enter your password.
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-login">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>
            
            <div class="back-to-site">
                <a href="../index.php">
                    <i class="fas fa-arrow-left"></i> Back to Portfolio
                </a>
            </div>
        </div>
    </div>

<?php
/**
 * Admin Login Authentication System
 * Handles secure user authentication for portfolio admin panel
 */

// Include session handler
require_once 'session-handler.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

// Database configuration
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "cv_db";

// Initialize messages
$error_message = null;
$success_message = null;

// Handle logout message
if (isset($_GET['message']) && $_GET['message'] === 'logged_out') {
    $success_message = 'You have been successfully logged out.';
}

// Handle session expired message
if (isset($_GET['error']) && $_GET['error'] === 'session_expired') {
    $error_message = 'Your session has expired. Please log in again.';
}

// Handle security violation message
if (isset($_GET['error']) && $_GET['error'] === 'security_violation') {
    $error_message = 'Security violation detected. Please log in again.';
}

// Process login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $error_message = 'Security validation failed. Please try again.';
    } else {
        // Create database connection
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            $error_message = "Database connection failed. Please try again later.";
        } else {
            // Get and sanitize form input
            $username = trim($_POST["username"] ?? '');
            $password = trim($_POST["password"] ?? '');

            if (empty($username) || empty($password)) {
                $error_message = 'Both username and password are required.';
            } else {
                // Prepare secure SQL statement to prevent injection
                $sql = "SELECT id, username FROM users WHERE username = ? AND password = ?";
                $stmt = $conn->prepare($sql);
                
                if ($stmt) {
                    $stmt->bind_param("ss", $username, $password);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Verify credentials
                    if ($result->num_rows === 1) {
                        $user = $result->fetch_assoc();
                        
                        // Create secure session
                        if (createSession($user['id'], $user['username'])) {
                            // Log successful login
                            error_log("Admin login: User '{$user['username']}' logged in at " . date('Y-m-d H:i:s'));
                            
                            // Redirect to admin dashboard
                            header("Location: index.php");
                            exit();
                        } else {
                            $error_message = 'Login failed. Please try again.';
                        }
                    } else {
                        $error_message = 'Invalid username or password. Please try again.';
                        
                        // Log failed login attempt
                        error_log("Failed login attempt for username: {$username} from IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
                    }
                    
                    $stmt->close();
                } else {
                    $error_message = 'Authentication system error. Please try again later.';
                }
            }
            
            $conn->close();
        }
    }
}
?>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
/**
 * Client-side Form Validation
 * Provides immediate feedback and enhanced user experience
 */
(function() {
    'use strict';

    // Enable Bootstrap validation styling
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();

// Enhanced form validation
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();
    
    // Basic client-side validation
    if (username === '' || password === '') {
        e.preventDefault();
        
        // Show custom error message
        let errorDiv = document.querySelector('.alert-danger');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger';
            errorDiv.setAttribute('role', 'alert');
            this.appendChild(errorDiv);
        }
        errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Both username and password are required.';
        
        return false;
    }
});

// Auto-focus username field
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('username').focus();
});
</script>

</body>
</html>