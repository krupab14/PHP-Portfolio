
<?php include 'header.php'; ?>
<?php include 'db-connect.php'; ?>
<div class="container mt-5">
    <!-- Validation Messages -->
    <div id="validationMessages"></div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['addInternshipRole'])) {
            // Add Internship
            $role = mysqli_real_escape_string($conn, $_POST['addInternshipRole']);
            $duration = mysqli_real_escape_string($conn, $_POST['addInternshipDuration']);
            $details = mysqli_real_escape_string($conn, $_POST['addInternshipDetails']);

            $query = "INSERT INTO internships (internship_role, internship_duration, internship_details) 
                      VALUES ('$role', '$duration', '$details')";

            if (mysqli_query($conn, $query)) {
                echo "<script>document.getElementById('validationMessages').innerHTML += '<div class=\"alert alert-success\">Internship added successfully!</div>';</script>";
            } else {
                echo "<script>document.getElementById('validationMessages').innerHTML += '<div class=\"alert alert-danger\">Error adding internship: " . mysqli_error($conn) . "</div>';</script>";
            }
        } elseif (isset($_POST['updateInternshipId'])) {
            // Update Internship
            $id = mysqli_real_escape_string($conn, $_POST['updateInternshipId']);
            $role = mysqli_real_escape_string($conn, $_POST['updateInternshipRole']);
            $duration = mysqli_real_escape_string($conn, $_POST['updateInternshipDuration']);
            $details = mysqli_real_escape_string($conn, $_POST['updateInternshipDetails']);

            $query = "UPDATE internships SET 
                      internship_role='$role', internship_duration='$duration', internship_details='$details' 
                      WHERE id='$id'";

            if (mysqli_query($conn, $query)) {
                echo "<script>document.getElementById('validationMessages').innerHTML += '<div class=\"alert alert-success\">Internship updated successfully!</div>';</script>";
            } else {
                echo "<script>document.getElementById('validationMessages').innerHTML += '<div class=\"alert alert-danger\">Error updating internship: " . mysqli_error($conn) . "</div>';</script>";
            }
        } elseif (isset($_POST['deleteInternshipId'])) {
            // Delete Internship
            $id = mysqli_real_escape_string($conn, $_POST['deleteInternshipId']);

            $query = "DELETE FROM internships WHERE id='$id'";

            if (mysqli_query($conn, $query)) {
                echo "<script>document.getElementById('validationMessages').innerHTML += '<div class=\"alert alert-success\">Internship deleted successfully!</div>';</script>";
            } else {
                echo "<script>document.getElementById('validationMessages').innerHTML += '<div class=\"alert alert-danger\">Error deleting internship: " . mysqli_error($conn) . "</div>';</script>";
            }
        }
    }
    ?>
    
    <form id="internshipForm" method="POST">
        <div id="internshipContainer">
            <!-- PHP Code to Fetch and Display Data -->
            <?php
            $query = "SELECT * FROM internships";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                    <div class="internship-section" id="internship' . $row['id'] . '">
                        <div class="mb-3">
                            <label for="internshipRole' . $row['id'] . '" class="form-label">Internship Role</label>
                            <input type="text" class="form-control" id="internshipRole' . $row['id'] . '" name="updateInternshipRole" value="' . htmlspecialchars($row['internship_role']) . '" required>
                        </div>
                        <div class="mb-3">
                            <label for="internshipDuration' . $row['id'] . '" class="form-label">Duration</label>
                            <input type="text" class="form-control" id="internshipDuration' . $row['id'] . '" name="updateInternshipDuration" value="' . htmlspecialchars($row['internship_duration']) . '" required>
                        </div>
                        <div class="mb-3">
                            <label for="internshipDetails' . $row['id'] . '" class="form-label">Details</label>
                            <textarea class="form-control" id="internshipDetails' . $row['id'] . '" name="updateInternshipDetails" rows="3" required>' . htmlspecialchars($row['internship_details']) . '</textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="updateInternshipId" value="' . $row['id'] . '">
                                <button type="submit" class="btn btn-warning">Update</button>
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="deleteInternshipId" value="' . $row['id'] . '">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>No internships found. Please add new internships using the "Add" button.</p>';
            }
            ?>
        </div>

        <!-- Add Another Internship Button -->
        <div class="mt-3 d-flex justify-content-start">
            <button type="button" class="mb-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add New Internship</button>
        </div>
    </form>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Internship</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addInternshipForm" method="POST">
                    <div class="mb-3">
                        <label for="addInternshipRole" class="form-label">Internship Role</label>
                        <input type="text" class="form-control" id="addInternshipRole" name="addInternshipRole">
                    </div>
                    <div class="mb-3">
                        <label for="addInternshipDuration" class="form-label">Duration</label>
                        <input type="text" class="form-control" id="addInternshipDuration" name="addInternshipDuration">
                    </div>
                    <div class="mb-3">
                        <label for="addInternshipDetails" class="form-label">Details</label>
                        <textarea class="form-control" id="addInternshipDetails" name="addInternshipDetails" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?>