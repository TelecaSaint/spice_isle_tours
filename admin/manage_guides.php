<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include '../includes/db_connect.php';

// Handle add guide
if (isset($_POST['add_guide'])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);

    if (!empty($name) && !empty($phone)) {
        $stmt = $conn->prepare("INSERT INTO guide (name, phone) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $phone);
        $stmt->execute();
        $stmt->close();
        header("Location: manage_guides.php");
        exit();
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM guide WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_guides.php");
    exit();
}

// Fetch all guides
$result = $conn->query("SELECT * FROM guide ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Guides</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'admin_navbar.php'; ?>

<div class="container mt-4">
    <h2>Manage Guides</h2>

    <!-- Add Guide Form -->
    <div class="card mb-4">
        <div class="card-header">Add New Guide</div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Guide Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" name="add_guide" class="btn btn-primary w-100">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Guides Table -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($guide = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $guide['id'] ?></td>
                        <td><?= htmlspecialchars($guide['name']) ?></td>
                        <td><?= htmlspecialchars($guide['phone']) ?></td>
                        <td>
                            <a href="manage_guides.php?delete=<?= $guide['id'] ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this guide?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center">No guides found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
