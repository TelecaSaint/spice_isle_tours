<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include '../includes/db_connect.php';

// Fetch some quick stats
$total_messages = $conn->query("SELECT COUNT(*) AS cnt FROM messages")->fetch_assoc()['cnt'] ?? 0;
$unread_messages = $conn->query("SELECT COUNT(*) AS cnt FROM messages WHERE status='Unread'")->fetch_assoc()['cnt'] ?? 0;

// Optional: fetch total bookings or tours if you have those tables
$total_tours = $conn->query("SELECT COUNT(*) AS cnt FROM tours")->fetch_assoc()['cnt'] ?? 0;
$total_bookings = $conn->query("SELECT COUNT(*) AS cnt FROM bookings")->fetch_assoc()['cnt'] ?? 0;
?>

<?php include 'admin_navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dashboard-card {
            border-radius: 15px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Welcome, Admin 👋</h2>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card dashboard-card text-bg-primary text-center p-3">
                <h5>Total Messages</h5>
                <h2><?= $total_messages ?></h2>
                <a href="admin_messages.php" class="btn btn-light btn-sm mt-2">View Messages</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card text-bg-warning text-center p-3">
                <h5>Unread Messages</h5>
                <h2><?= $unread_messages ?></h2>
                <a href="admin_messages.php" class="btn btn-light btn-sm mt-2">Check Inbox</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card text-bg-success text-center p-3">
                <h5>Total Tours</h5>
                <h2><?= $total_tours ?></h2>
                <a href="manage_tours.php" class="btn btn-light btn-sm mt-2">Manage Tours</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card text-bg-info text-center p-3">
                <h5>Total Bookings</h5>
                <h2><?= $total_bookings ?></h2>
                <a href="manage_bookings.php" class="btn btn-light btn-sm mt-2">View Bookings</a>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <h4>Recent Messages</h4>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $recent = $conn->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5");
                while ($msg = $recent->fetch_assoc()):
                ?>
                <tr <?= $msg['status'] == 'Unread' ? 'class="table-warning fw-bold"' : '' ?>>
                    <td><?= $msg['id'] ?></td>
                    <td><?= htmlspecialchars($msg['name']) ?></td>
                    <td><?= htmlspecialchars($msg['subject']) ?></td>
                    <td><?= $msg['status'] ?></td>
                    <td><?= date("Y-m-d H:i", strtotime($msg['created_at'])) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
