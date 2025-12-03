<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include '../includes/db_connect.php';

$guide_id = intval($_GET['id'] ?? 0);
if (!$guide_id) header("Location: manage_guides.php");

$stmt = $conn->prepare("SELECT * FROM guide WHERE id=?");
$stmt->bind_param("i", $guide_id);
$stmt->execute();
$result = $stmt->get_result();
$guide = $result->fetch_assoc();
$stmt->close();

if (isset($_POST['update_guide'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    if ($name && $email) {
        $stmt = $conn->prepare("UPDATE guide SET name=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $email, $guide_id);
        $stmt->execute();
        $stmt->close();
        header("Location: manage_guides.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Guide</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'admin_navbar.php'; ?>

<div class="container mt-4">
    <h2>Edit Guide</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Guide Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($guide['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($guide['email']) ?>" required>
        </div>
        <button type="submit" name="update_guide" class="btn btn-warning">Update Guide</button>
        <a href="manage_guides.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
