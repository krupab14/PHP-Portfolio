
<?php
/**
 * Admin Panel Homepage Management
 * Manages homepage content including title, description, and profile image
 * Configured for phpMyAdmin local development
 */

// Simple session check for development
session_start();

// Basic authentication check (uncomment when ready)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Include header and database connection
include 'header.php'; 
include 'db-connect.php';

/**
 * Fetch existing homepage data
 */
$query = "SELECT * FROM homepage LIMIT 1";
$result = $conn->query($query);

$homepageData = null;
if ($result && $result->num_rows > 0) {
    $homepageData = $result->fetch_assoc();
}

/**
 * Handle form submission for homepage updates
 */
$successMessage = false;
$errorMessage = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic validation
    // Sanitize and validate input
    $home_title = trim(htmlspecialchars($_POST['titleUpload'] ?? ''));
    $home_description = trim(htmlspecialchars($_POST['introText'] ?? ''));

    // Validate required fields
    if (empty($home_title) || empty($home_description)) {
        $errorMessage = "Title and description are required fields.";
    } else {
        // Handle file upload
        $home_image = $homepageData['home_image'] ?? 'me.jpeg'; // Default fallback
        
        if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $maxFileSize = 5 * 1024 * 1024; // 5MB
            
            $uploadedFile = $_FILES['imageUpload'];
            $fileType = $uploadedFile['type'];
            $fileSize = $uploadedFile['size'];
            $fileName = $uploadedFile['name'];
            $fileTmpName = $uploadedFile['tmp_name'];
            
            // Validate file type and size
            if (!in_array($fileType, $allowedTypes)) {
                $errorMessage = "Invalid file type. Please upload JPG, PNG, or GIF images only.";
            } elseif ($fileSize > $maxFileSize) {
                $errorMessage = "File too large. Maximum size is 5MB.";
            } else {
                // Generate unique filename to prevent conflicts
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = 'profile_' . time() . '.' . $fileExtension;
                $uploadPath = __DIR__ . '/' . $newFileName;
                
                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    // Delete old image if it exists and is not the default
                    if ($homepageData && $homepageData['home_image'] !== 'me.jpeg') {
                        $oldImagePath = __DIR__ . '/' . $homepageData['home_image'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    $home_image = $newFileName;
                } else {
                    $errorMessage = "Failed to upload image. Please try again.";
                }
            }
        }

        // Update database if no errors
        if (!$errorMessage) {
            if ($homepageData) {
                // Update existing record
                $sql = "UPDATE homepage SET home_title = ?, home_description = ?, home_image = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $home_title, $home_description, $home_image, $homepageData['id']);
            } else {
                // Insert new record
                $sql = "INSERT INTO homepage (home_title, home_description, home_image) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $home_title, $home_description, $home_image);
            }

            if ($stmt && $stmt->execute()) {
                $successMessage = "Homepage content updated successfully!";
                // Refresh data
                $result = $conn->query($query);
                if ($result && $result->num_rows > 0) {
                    $homepageData = $result->fetch_assoc();
                }
            } else {
                $errorMessage = "Database error. Please try again.";
            }
            
            if ($stmt) {
                $stmt->close();
            }
        }
    }
}
?>

<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-home"></i> Homepage Management
        </h1>
        <p class="page-subtitle">
            Manage your portfolio's main page content, including profile image, title, and introduction text.
        </p>
    </div>

    <!-- Success/Error Messages -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo $successMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <?php echo $errorMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Homepage Content Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit"></i> Edit Homepage Content
            </h3>
        </div>
        <div class="card-body">
            <form action="#" method="POST" enctype="multipart/form-data" id="homepageForm" class="needs-validation" novalidate>
                <!-- Simple CSRF protection -->
                <div class="row">
                    <!-- Profile Image Section -->
                    <div class="col-md-4">
                        <div class="mb-4">
                            <label for="imageUpload" class="form-label">
                                <i class="fas fa-image"></i> Profile Image
                            </label>
                            <input type="file" class="form-control" id="imageUpload" name="imageUpload" 
                                   accept="image/*" onchange="previewImage(event)">
                            <div class="form-text">Accepted formats: JPG, PNG, GIF. Max size: 5MB</div>
                            
                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-3" 
                                 style="<?php echo ($homepageData && $homepageData['home_image']) ? 'display: block;' : 'display: none;'; ?>">
                                <div class="border rounded p-3 text-center bg-light">
                                    <?php if ($homepageData && $homepageData['home_image']): ?>
                                        <img src="<?php echo htmlspecialchars($homepageData['home_image']); ?>" 
                                             alt="Profile Preview" class="img-fluid rounded" style="max-width: 200px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Fields -->
                    <div class="col-md-8">
                        <!-- Profile Title -->
                        <div class="mb-3">
                            <label for="titleUpload" class="form-label">
                                <i class="fas fa-heading"></i> Profile Title *
                            </label>
                            <input type="text" class="form-control" id="titleUpload" name="titleUpload" 
                                   placeholder="Enter your main title (e.g., I'm John Doe)" 
                                   value="<?php echo $homepageData ? htmlspecialchars($homepageData['home_title']) : ''; ?>" 
                                   required>
                            <div class="invalid-feedback">
                                Please provide a profile title.
                            </div>
                        </div>

                        <!-- Introduction Text -->
                        <div class="mb-3">
                            <label for="introText" class="form-label">
                                <i class="fas fa-align-left"></i> Introduction Text *
                            </label>
                            <textarea class="form-control" id="introText" name="introText" rows="6" 
                                      placeholder="Write a compelling introduction about yourself..." 
                                      required><?php echo $homepageData ? htmlspecialchars($homepageData['home_description']) : ''; ?></textarea>
                            <div class="invalid-feedback">
                                Please provide an introduction text.
                            </div>
                            <div class="form-text">This text will appear as your main introduction on the homepage.</div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Homepage
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
/**
 * Homepage Management JavaScript Functions
 */

// Image preview functionality
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="border rounded p-3 text-center bg-light">
                    <img src="${e.target.result}" alt="Profile Preview" 
                         class="img-fluid rounded" style="max-width: 200px;">
                    <div class="mt-2 text-muted small">New image selected</div>
                </div>
            `;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

// Form validation
(function() {
    'use strict';
    
    const form = document.getElementById('homepageForm');
    
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
    }, false);
})();

// Character counter for textarea
document.getElementById('introText').addEventListener('input', function() {
    const maxLength = 1000;
    const currentLength = this.value.length;
    const remaining = maxLength - currentLength;
    
    let counter = document.getElementById('charCounter');
    if (!counter) {
        counter = document.createElement('div');
        counter.id = 'charCounter';
        counter.className = 'form-text';
        this.parentNode.appendChild(counter);
    }
    
    counter.textContent = `${currentLength}/${maxLength} characters`;
    counter.style.color = remaining < 50 ? '#dc3545' : '#6c757d';
});
</script>

<?php include "footer.php" ?>