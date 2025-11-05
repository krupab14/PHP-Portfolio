
<?php
include 'header.php';
include 'db-connect.php';

// Handle Add, Update, and Delete Operations for Projects
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add Project
    if (isset($_POST['addProjectTitle'])) {
        $title = $_POST['addProjectTitle'];
        $link = $_POST['addProjectGitHubLink'];
        $description = $_POST['addProjectDescription'];

        $sql = "INSERT INTO projects (project_title, project_github_link, project_description) VALUES ('$title', '$link', '$description')";
        if ($conn->query($sql) === TRUE) {
            $successMessage = "New project added successfully!";
        } else {
            $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Update Project
    if (isset($_POST['updateProjectTitle'])) {
        $titles = $_POST['updateProjectTitle'];
        $links = $_POST['updateProjectGitHubLink'];
        $descriptions = $_POST['updateProjectDescription'];
        $ids = $_POST['projectId'];

        foreach ($ids as $index => $id) {
            $title = $titles[$index];
            $link = $links[$index];
            $description = $descriptions[$index];

            $sql = "UPDATE projects SET project_title='$title', project_github_link='$link', project_description='$description' WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                $successMessage = "Project updated successfully!";
            } else {
                $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    // Delete Project
    if (isset($_POST['deleteProjectId'])) {
        $id = $_POST['deleteProjectId'];
        $sql = "DELETE FROM projects WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $successMessage = "Project deleted successfully!";
        } else {
            $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetch Projects
$sql = "SELECT * FROM projects";
$projectResult = $conn->query($sql);
$projects = [];
if ($projectResult->num_rows > 0) {
    while($row = $projectResult->fetch_assoc()) {
        $projects[] = $row;
    }
}
?>

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

    <!-- Projects Section -->
    
    <form action="#" method="POST">
        <div id="projectContainer">
            <?php foreach ($projects as $project): ?>
                <div class="project-section" id="project<?= $project['id'] ?>">
                    <input type="hidden" name="projectId[]" value="<?= $project['id'] ?>">

                    <!-- Project Title Input -->
                    <div class="mb-3">
                        <label class="form-label">Project Title</label>
                        <input type="text" class="form-control" name="updateProjectTitle[]" value="<?= $project['project_title'] ?>">
                    </div>

                    <!-- GitHub Link Input -->
                    <div class="mb-3">
                        <label class="form-label">GitHub Link</label>
                        <input type="url" class="form-control" name="updateProjectGitHubLink[]" value="<?= $project['project_github_link'] ?>">
                    </div>

                    <!-- Project Description Input -->
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="updateProjectDescription[]" rows="3"><?= $project['project_description'] ?></textarea>
                    </div>

                    <!-- Update and Delete Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                    <button type="submit" name="updateProjectTitle[]" class="btn btn-warning">Update</button>
                        <button type="submit" name="deleteProjectId" value="<?= $project['id'] ?>" class="btn btn-danger">Delete</button>
                        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </form>

    <!-- Add Project Button -->
    <div class="mt-3 mb-3 d-flex justify-content-start">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">Add New Project</button>
    </div>
</div>

<!-- Add Project Modal -->
<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectModalLabel">Add Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="addProjectTitle" class="form-label">Project Title</label>
                        <input type="text" class="form-control" id="addProjectTitle" name="addProjectTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="addProjectGitHubLink" class="form-label">GitHub Link</label>
                        <input type="url" class="form-control" id="addProjectGitHubLink" name="addProjectGitHubLink" required>
                    </div>
                    <div class="mb-3">
                        <label for="addProjectDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="addProjectDescription" name="addProjectDescription" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?>