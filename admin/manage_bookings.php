<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include '../includes/db_connect.php';

// Include the admin navbar
include 'admin_navbar.php';

// Delete outing if requested
if (isset($_GET['delete_outing'])) {
    $outing_id = intval($_GET['delete_outing']);
    $stmt = $conn->prepare("DELETE FROM outing WHERE id = ?");
    $stmt->bind_param("i", $outing_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_bookings.php");
    exit();
}

// Get bookings with optional outing info
$sql = "
SELECT b.id AS booking_id, c.name AS client_name, c.email AS client_email,
       t.title AS tour_title, t.duration AS tour_duration, t.fee AS tour_fee,
       o.id AS outing_id, g.name AS guide_name, o.outing_datetime
FROM bookings b
JOIN tours t ON b.tour_id = t.id
JOIN clients c ON b.client_id = c.id
LEFT JOIN outing o ON o.booking_id = b.id
LEFT JOIN guide g ON g.id = o.guide_id
ORDER BY b.id DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Bookings</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Manage Bookings</h2>
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Email</th>
                <th>Tour</th>
                <th>Duration</th>
                <th>Fee</th>
                <th>Scheduled</th>
                <th>Guide</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($booking = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $booking['booking_id'] ?></td>
                <td><?= htmlspecialchars($booking['client_name']) ?></td>
                <td><?= htmlspecialchars($booking['client_email']) ?></td>
                <td><?= htmlspecialchars($booking['tour_title']) ?></td>
                <td><?= htmlspecialchars($booking['tour_duration']) ?> hrs</td>
                <td>$<?= number_format($booking['tour_fee'], 2) ?></td>
                <td><?= $booking['outing_datetime'] ? date("Y-m-d H:i", strtotime($booking['outing_datetime'])) : "Not scheduled" ?></td>
                <td><?= $booking['guide_name'] ?? "N/A" ?></td>
                <td>
                    <?php if ($booking['outing_id']): ?>
                        <a href="schedule_booking.php?booking_id=<?= $booking['booking_id'] ?>" class="btn btn-sm btn-warning mb-1">Reschedule</a>
                        <a href="manage_bookings.php?delete_outing=<?= $booking['outing_id'] ?>" 
                           class="btn btn-sm btn-danger mb-1"
                           onclick="return confirm('Are you sure you want to delete this outing?');">
                           Delete
                        </a>
                    <?php else: ?>
                        <a href="schedule_booking.php?booking_id=<?= $booking['booking_id'] ?>" class="btn btn-sm btn-primary mb-1">Schedule</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
