<?php
session_start();
include '../includes/db_connect.php'; // adjust path

// Only allow admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle Add Tour
if (isset($_POST['add_tour'])) {
    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $fee = $_POST['fee'];

    $stmt = $conn->prepare("INSERT INTO tours (title, duration, fee) VALUES (?, ?, ?)");
    $stmt->bind_param("sid", $title, $duration, $fee);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_tours.php");
    exit();
}

// Handle Delete Tour
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM tours WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_tours.php");
    exit();
}

// Fetch all tours
$tours = $conn->query("SELECT * FROM tours ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Tours</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Admin Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard.php">Spice Isle Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">🏠 Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="manage_tours.php">🗺️ Tours</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_posts.php">📰 Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_messages.php">📬 Messages</a></li>
                <li class="nav-item"><a class="nav-link" href="admin.php">👥 Users</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">🚪 Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2>Manage Tours</h2>

    <!-- Add Tour Form -->
    <div class="card mb-4">
        <div class="card-header">Add New Tour</div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Duration (hours)</label>
                    <input type="number" name="duration" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fee ($)</label>
                    <input type="number" step="0.01" name="fee" class="form-control" required>
                </div>
                <button type="submit" name="add_tour" class="btn btn-primary">Add Tour</button>
            </form>
        </div>
    </div>

    <!-- Tours Table -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Duration</th>
                <th>Fee</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($tour = $tours->fetch_assoc()): ?>
            <tr>
                <td><?= $tour['id'] ?></td>
                <td><?= htmlspecialchars($tour['title']) ?></td>
                <td><?= $tour['duration'] ?> hrs</td>
                <td>$<?= number_format($tour['fee'], 2) ?></td>
                <td>
                    <a href="edit_tour.php?id=<?= $tour['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="manage_tours.php?delete=<?= $tour['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this tour?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
