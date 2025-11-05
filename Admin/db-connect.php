<?php
/**
 * Database Connection Configuration
 * Establishes secure connection to MySQL database for portfolio management
 * Configured for phpMyAdmin local development environment
 */

// Database configuration constants for phpMyAdmin
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'cv_db');

// Enable error reporting for development
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    /**
     * Create MySQL connection with error handling
     */
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Set charset to UTF-8 for proper character handling
    $conn->set_charset("utf8");
    
    // Set timezone
    $conn->query("SET time_zone = '+00:00'");
    
} catch (mysqli_sql_exception $e) {
    /**
     * Handle connection errors gracefully
     */
    error_log("Database Connection Error: " . $e->getMessage());
    
    // Display user-friendly error message
    if (php_sapi_name() === 'cli') {
        // Command line interface
        die("Database connection failed. Please check configuration.\n");
    } else {
        // Web interface - show detailed error for development
        die("
            <div style='
                font-family: Arial, sans-serif; 
                max-width: 600px; 
                margin: 50px auto; 
                padding: 20px; 
                border: 1px solid #dc3545; 
                border-radius: 5px; 
                background-color: #f8d7da; 
                color: #721c24;
            '>
                <h3>Database Connection Error</h3>
                <p>Unable to connect to the database: {$e->getMessage()}</p>
                <p><strong>Make sure:</strong></p>
                <ul>
                    <li>XAMPP/WAMP is running</li>
                    <li>MySQL service is started</li>
                    <li>Database 'cv_db' exists in phpMyAdmin</li>
                    <li>Database credentials are correct</li>
                </ul>
                <small>Check phpMyAdmin at <a href='http://localhost/phpmyadmin'>http://localhost/phpmyadmin</a></small>
            </div>
        ");
    }
}

/**
 * Function to safely close database connection
 */
function closeDbConnection() {
    global $conn;
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}

/**
 * Function to execute prepared statements safely
 * @param string $sql SQL query with placeholders
 * @param string $types Parameter types (s, i, d, b)
 * @param array $params Parameters array
 * @return mysqli_result|bool Query result or boolean
 */
function executeQuery($sql, $types = '', $params = []) {
    global $conn;
    
    try {
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        
        return $result;
        
    } catch (Exception $e) {
        error_log("Query Execution Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Function to get single row from database
 * @param string $sql SQL query
 * @param string $types Parameter types
 * @param array $params Parameters
 * @return array|null Single row or null
 */
function getSingleRow($sql, $types = '', $params = []) {
    $result = executeQuery($sql, $types, $params);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

/**
 * Function to get multiple rows from database
 * @param string $sql SQL query
 * @param string $types Parameter types
 * @param array $params Parameters
 * @return array Array of rows
 */
function getMultipleRows($sql, $types = '', $params = []) {
    $result = executeQuery($sql, $types, $params);
    $rows = [];
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    
    return $rows;
}

/**
 * Function to insert data and return inserted ID
 * @param string $sql SQL insert query
 * @param string $types Parameter types
 * @param array $params Parameters
 * @return int|false Inserted ID or false on failure
 */
function insertData($sql, $types = '', $params = []) {
    global $conn;
    
    try {
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $result = $stmt->execute();
        $insertId = $conn->insert_id;
        $stmt->close();
        
        return $result ? $insertId : false;
        
    } catch (Exception $e) {
        error_log("Insert Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Function to update/delete data
 * @param string $sql SQL update/delete query
 * @param string $types Parameter types
 * @param array $params Parameters
 * @return bool Success status
 */
function modifyData($sql, $types = '', $params = []) {
    global $conn;
    
    try {
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
        
    } catch (Exception $e) {
        error_log("Modify Error: " . $e->getMessage());
        return false;
    }
}

// Register shutdown function to close connection
register_shutdown_function('closeDbConnection');
?>