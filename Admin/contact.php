
<?php
include "header.php"; 
include "db-connect.php";

// Handle form submissions
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    // Delete logic
    $id = $_POST['id'];

    $sql = "DELETE FROM contact WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "Contact entry deleted successfully!";
    } else {
        $message = "Error deleting entry: " . $conn->error;
    }
}

// Fetch contacts
$sql = "SELECT * FROM contact";
$result = $conn->query($sql);
$contacts = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contacts[] = $row;
    }
}
?>

<div class="container mt-5">
    <!-- Show message if available -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-info">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($contacts as $contact): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" 
                                    value="<?php echo htmlspecialchars($contact['name']); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" name="contact" 
                                    value="<?php echo htmlspecialchars($contact['contact_number']); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" 
                                    value="<?php echo htmlspecialchars($contact['email']); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Message Title</label>
                                <input type="text" class="form-control" name="title" 
                                    value="<?php echo htmlspecialchars($contact['message_title']); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" rows="5" readonly><?php echo htmlspecialchars($contact['message']); ?></textarea>
                            </div>

                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include "footer.php" ?>
