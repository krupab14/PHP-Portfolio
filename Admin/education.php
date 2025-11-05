<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize message variable
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the session message after showing it
} else {
    $message = "";
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        // Update logic
        $id = $_POST['id'];
        $degree = $conn->real_escape_string($_POST['degree']);
        $duration = $conn->real_escape_string($_POST['duration']);
        $college = $conn->real_escape_string($_POST['college']);
        $cgpa = $_POST['cgpa'];

        $sql = "UPDATE qualifications SET degree='$degree', duration='$duration', college='$college', cgpa='$cgpa' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Qualification updated successfully!";
        } else {
            $_SESSION['message'] = "Error updating qualification: " . $conn->error;
        }
    }

    if (isset($_POST['delete'])) {
        // Delete logic
        $id = $_POST['id'];

        $sql = "DELETE FROM qualifications WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Qualification deleted successfully!";
        } else {
            $_SESSION['message'] = "Error deleting qualification: " . $conn->error;
        }
    }

    if (isset($_POST['add'])) {
        // Add new record logic
        $degree = $conn->real_escape_string($_POST['degree']);
        $duration = $conn->real_escape_string($_POST['duration']);
        $college = $conn->real_escape_string($_POST['college']);
        $cgpa = $_POST['cgpa'];

        $sql = "INSERT INTO qualifications (degree, duration, college, cgpa) VALUES ('$degree', '$duration', '$college', '$cgpa')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "New qualification added successfully!";
        } else {
            $_SESSION['message'] = "Error adding qualification: " . $conn->error;
        }
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch qualifications
$sql = "SELECT * FROM qualifications";
$result = $conn->query($sql);
$qualifications = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $qualifications[] = $row;
    }
}

include 'header.php';
?>

<div class="container mt-5">
    <!-- Show message if available -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-info">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($qualifications as $qual): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <input type="hidden" name="id" value="<?php echo $qual['id']; ?>">

                            <div class="mb-3">
                                <label for="degree" class="form-label">Degree</label>
                                <input type="text" class="form-control" name="degree" value="<?php echo htmlspecialchars($qual['degree']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration</label>
                                <input type="text" class="form-control" name="duration" value="<?php echo htmlspecialchars($qual['duration']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="college" class="form-label">College</label>
                                <input type="text" class="form-control" name="college" value="<?php echo htmlspecialchars($qual['college']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="cgpa" class="form-label">CGPA</label>
                                <input type="number" step="0.01" class="form-control" name="cgpa" value="<?php echo htmlspecialchars($qual['cgpa']); ?>" required>
                            </div>

                            <button type="submit" name="update" class="btn btn-warning">Update</button>
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Add Button -->
    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addModal">Add New Qualification</button>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Qualification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="degree" class="form-label">Degree</label>
                            <input type="text" class="form-control" name="degree" required>
                        </div>
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="text" class="form-control" name="duration" required>
                        </div>
                        <div class="mb-3">
                            <label for="college" class="form-label">College</label>
                            <input type="text" class="form-control" name="college" required>
                        </div>
                        <div class="mb-3">
                            <label for="cgpa" class="form-label">CGPA</label>
                            <input type="number" step="0.01" class="form-control" name="cgpa" required>
                        </div>

                        <button type="submit" name="add" class="mb-3 btn btn-primary">Add Qualification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?>