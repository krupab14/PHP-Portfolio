
<?php
include 'header.php';
include 'db-connect.php';

// Handle Add Skill
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addSkill'])) {
    $skillName = $_POST['addSkillName'];
    $skillPercentage = $_POST['addSkillPercentage'];

    $sql = "INSERT INTO skills (skill_name, skill_percentage) VALUES ('$skillName', $skillPercentage)";
    if ($conn->query($sql) === TRUE) {
        $successMessage = "New skill added successfully!";
    } else {
        $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Update Skill
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateSkill'])) {
    $id = $_POST['skillId'];
    $skillName = $_POST['updateSkillName'];
    $skillPercentage = $_POST['updateSkillPercentage'];

    $sql = "UPDATE skills SET skill_name = '$skillName', skill_percentage = $skillPercentage WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $successMessage = "Skill updated successfully!";
    } else {
        $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Delete Skill
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM skills WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $successMessage = "Skill deleted successfully!";
    } else {
        $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch Skills for Display
$sql = "SELECT * FROM skills";
$result = $conn->query($sql);
$skills = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $skills[] = $row;
    }
}
?>

<!-- Skills List Section -->
<div class="container mt-5">
    <!-- Display Success/Failure Messages -->
    <div id="messageContainer">
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Display Existing Skills -->
    <div id="skillsContainer">
        <?php foreach ($skills as $skill): ?>
        <div class="skill-card" id="skill<?= $skill['id'] ?>">
            <form action="#" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="skillId" value="<?= $skill['id'] ?>">

                <!-- Skill Name Input -->
                <div class="mb-3">
                    <label for="skillName<?= $skill['id'] ?>" class="form-label">Skill Name</label>
                    <input type="text" class="form-control" id="skillName<?= $skill['id'] ?>" name="updateSkillName" value="<?= $skill['skill_name'] ?>" required>
                    <div class="invalid-feedback">Please provide a valid skill name.</div>
                </div>

                <!-- Skill Percentage Input -->
                <div class="mb-3">
                    <label for="skillPercentage<?= $skill['id'] ?>" class="form-label">Skill Percentage</label>
                    <input type="number" class="form-control" id="skillPercentage<?= $skill['id'] ?>" name="updateSkillPercentage" value="<?= $skill['skill_percentage'] ?>" min="0" max="100" required>
                    <div class="invalid-feedback">Please provide a valid skill percentage.</div>
                </div>

                <!-- Button Container -->
                <div class="button-container d-flex justify-content-end gap-2">
                    <!-- Update Button -->
                    <button type="submit" class="btn btn-warning " name="updateSkill">Update</button>

                    <!-- Delete Button -->
                    <a href="?delete=<?= $skill['id'] ?>" class="btn btn-danger " onclick="deleteSkill(event, <?= $skill['id'] ?>)">Delete</a>
                </div>
            </form>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Add New Skill Modal Button -->
    <button type="button" class="btn btn-primary mt-3 mb-3"  data-bs-toggle="modal" data-bs-target="#addModal">Add New Skill </button>
  
    <!-- Add New Skill Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Skill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" id="addSkillForm" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="addSkillName" class="form-label">Skill Name</label>
                            <input type="text" class="form-control" id="addSkillName" name="addSkillName" required>
                            <div class="invalid-feedback">Please provide a valid skill name.</div>
                        </div>

                        <div class="mb-3">
                            <label for="addSkillPercentage" class="form-label">Skill Percentage</label>
                            <input type="number" class="form-control" id="addSkillPercentage" name="addSkillPercentage" min="0" max="100" required>
                            <div class="invalid-feedback">Please provide a valid skill percentage.</div>
                        </div>

                        <input type="hidden" name="addSkill" value="true">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="validateForm(event, 'add')">Add Skill</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Validation function for Add and Update
    function validateForm(event, actionType) {
        event.preventDefault(); // Prevent form submission
        
        let isValid = true;
        let form;
        
        // Determine which form to validate (Add or Update)
        if (actionType === 'add') {
            form = document.getElementById('addSkillForm');
        } else {
            const skillId = document.querySelector('input[name="skillId"]').value;
            form = document.querySelector(`#skill${skillId} form`);
        }

        const nameField = form.querySelector('input[name="updateSkillName"], input[name="addSkillName"]');
        const percentageField = form.querySelector('input[name="updateSkillPercentage"], input[name="addSkillPercentage"]');
        
        // Validate Skill Name
        if (!nameField.value.trim()) {
            nameField.classList.add('is-invalid');
            isValid = false;
        } else {
            nameField.classList.remove('is-invalid');
        }
        
        // Validate Skill Percentage
        if (percentageField.value < 0 || percentageField.value > 100) {
            percentageField.classList.add('is-invalid');
            isValid = false;
        } else {
            percentageField.classList.remove('is-invalid');
        }
        
        // If valid, submit the form
        if (isValid) {
            form.submit();  // Submit the form
        } else {
            showMessage('Please fill in valid values for all fields.', 'error');
        }
    }

    // Function to handle skill deletion
    function deleteSkill(event, id) {
        event.preventDefault(); // Prevent link from navigating
        
        if (confirm('Are you sure you want to delete this skill?')) {
            window.location.href = `?delete=${id}`;
            showMessage('Skill deleted successfully!', 'success');
        }
    }

    // Show success/error messages and store them in sessionStorage
    function showMessage(message, type) {
        const messageContainer = document.getElementById('messageContainer');
        messageContainer.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;

        // Store the message and its type in sessionStorage
        sessionStorage.setItem('message', message);
        sessionStorage.setItem('messageType', type);
    }

    // Display the message stored in sessionStorage on page load
    window.onload = function() {
        const messageContainer = document.getElementById('messageContainer');
        const storedMessage = sessionStorage.getItem('message');
        const storedMessageType = sessionStorage.getItem('messageType');

        if (storedMessage && storedMessageType) {
            messageContainer.innerHTML = `<div class="alert alert-${storedMessageType}" role="alert">${storedMessage}</div>`;
        }

        // Clear the sessionStorage after displaying the message
        sessionStorage.removeItem('message');
        sessionStorage.removeItem('messageType');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></
<?php include "footer.php" ?>