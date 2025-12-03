<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include '../includes/db_connect.php';
$message = '';

if (isset($_POST['add_tour'])) {
    $title = trim($_POST['title']);
    $duration = intval($_POST['duration']);
    $fee = floatval($_POST['fee']);

    if ($title && $duration > 0 && $fee >= 0) {
        $stmt = $conn->prepare("INSERT INTO tours (title, duration, fee) VALUES (?, ?, ?)");
        $stmt->bind_param("sid", $title, $duration, $fee);
        if ($stmt->execute()) {
            $message = "Tour added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
        $stmt->close();
    } else {
        $message = "Please fill in all fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Tour</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'admin_navbar.php'; ?>

<div class="container mt-4">
    <h2>Add New Tour</h2>

    <?php if($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="title" class="form-label">Tour Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="col-md-3">
            <label for="duration" class="form-label">Duration (hrs)</label>
            <input type="number" class="form-control" id="duration" name="duration" min="1" required>
        </div>
        <div class="col-md-3">
            <label for="fee" class="form-label">Fee ($)</label>
            <input type="number" class="form-control" id="fee" name="fee" step="0.01" min="0" required>
        </div>
        <div class="col-12">
            <button type="submit" name="add_tour" class="btn btn-success">Add Tour</button>
            <a href="manage_tours.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
