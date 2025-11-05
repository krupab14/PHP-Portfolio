
<?php include 'header.php'; ?>
<?php include 'db-connect.php'; ?>

<?php
// Fetch the existing data from the 'about' table
$query = "SELECT * FROM about WHERE id = 1"; // Assuming there's only one record in the 'about' table
$result = $conn->query($query);
$aboutData = null;

if ($result->num_rows > 0) {
    $aboutData = $result->fetch_assoc();
}
?>

<div class="container mt-5">
    <!-- Form Container -->
    <form action="#" method="POST" id="aboutForm" enctype="multipart/form-data" onsubmit="return validateForm()">
        <!-- Profile Image Input -->
        <div class="mb-3">
            <label for="aboutImage" class="form-label">Upload Your About Image</label>
            <input type="file" class="form-control" id="aboutImage" name="aboutImage" accept="image/*">
            
            <!-- Display existing image if available -->
            <?php if ($aboutData && $aboutData['about_image']): ?>
                <div class="mt-2">
                    <img src="<?php echo $aboutData['about_image']; ?>" alt="About Image" class="img-fluid" style="width: 200px; height: 200px; object-fit: cover; border-radius: 10px;">
                </div>
            <?php endif; ?>

            <div id="imageError" class="text-danger" style="display: none;">Please upload an image.</div>
        </div>

        <!-- About Text Input -->
        <div class="mb-3">
            <label for="aboutText" class="form-label">About Me</label>
            <textarea class="form-control" id="aboutText" name="aboutText" rows="6" placeholder="Write about yourself..."><?php echo $aboutData ? htmlspecialchars($aboutData['about_text']) : ''; ?></textarea>
            <div id="textError" class="text-danger" style="display: none;">Please fill this field.</div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn mb-3 btn-primary">Submit</button>
    </form>

    <!-- Success Message (Initially hidden) -->
    <div id="successMessage" class="alert alert-success mt-3" style="display: none;">
        Data submitted successfully!
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
// JavaScript function to validate the form
function validateForm() {
    let isValid = true;

    // Reset error messages
    document.getElementById('imageError').style.display = 'none';
    document.getElementById('textError').style.display = 'none';
    document.getElementById('successMessage').style.display = 'none'; // Hide success message initially

    // Validate About Image
    let aboutImage = document.getElementById('aboutImage').files[0];
    if (!aboutImage && !<?php echo $aboutData && $aboutData['about_image'] ? 'true' : 'false'; ?>) {
        document.getElementById('imageError').style.display = 'block';
        isValid = false;
    }

    // Validate About Text
    let aboutText = document.getElementById('aboutText').value.trim();
    if (aboutText === '') {
        document.getElementById('textError').style.display = 'block';
        isValid = false;
    }

    // If all validations pass, show success message
    if (isValid) {
        // Store success flag in sessionStorage
        sessionStorage.setItem('formSubmitted', 'true');
        document.getElementById('successMessage').style.display = 'block';
    }

    return isValid;
}

// Check if the form was submitted on page load
window.onload = function() {
    if (sessionStorage.getItem('formSubmitted') === 'true') {
        document.getElementById('successMessage').style.display = 'block';
        // Clear the sessionStorage so that the message is not shown after a page refresh
        sessionStorage.removeItem('formSubmitted');
    }
}
</script>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $about_text = $_POST['aboutText'];

    // Handle file upload if a new image is provided
    $about_image = null;
    if (isset($_FILES['aboutImage']) && $_FILES['aboutImage']['error'] == 0) {
        $image_name = $_FILES['aboutImage']['name'];
        $image_tmp_name = $_FILES['aboutImage']['tmp_name'];
        
        // Define the destination path for the image in the same directory as this script
        $image_destination = $image_name; // Just save in the same directory with its original name
        if (move_uploaded_file($image_tmp_name, $image_destination)) {
            $about_image = $image_destination;
        } else {
            echo "Failed to upload the image.";
        }
    } elseif ($aboutData && $aboutData['about_image']) {
        // If no new image is uploaded, keep the old image path
        $about_image = $aboutData['about_image'];
    }

    // Update the data in the 'about' table
    $sql = "UPDATE about SET about_text = ?, about_image = ? WHERE id = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $about_text, $about_image);

    // Execute the update query
    if ($stmt->execute()) {
        // Set success flag in sessionStorage
        echo "<script>setItem('formSubmitted', 'true');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<?php include "footer.php" ?>