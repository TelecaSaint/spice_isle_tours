<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Get the client ID
$stmt = $conn->prepare("SELECT id FROM clients WHERE email = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($client_id);
$stmt->fetch();
$stmt->close();

// Fetch user's bookings
$stmt = $conn->prepare("
    SELECT t.title, t.duration, t.fee, o.outing_datetime, g.name AS guide_name
    FROM bookings b
    JOIN tours t ON b.tour_id = t.id
    LEFT JOIN outing o ON t.id = o.tour_id
    LEFT JOIN guide g ON o.guide_id = g.id
    WHERE b.client_id = ?
    ORDER BY o.outing_datetime ASC
");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Bookings</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <h2>My Bookings</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="row">
            <?php while($booking = $result->fetch_assoc()): ?>
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($booking['title']) ?></h5>
                            <p class="card-text">Duration: <?= $booking['duration'] ?> hrs</p>
                            <p class="card-text">Fee: $<?= $booking['fee'] ?></p>
                            <?php if ($booking['outing_datetime']): ?>
                                <p class="card-text">Scheduled: <?= date("M d, Y H:i", strtotime($booking['outing_datetime'])) ?></p>
                                <p class="card-text">Guide: <?= htmlspecialchars($booking['guide_name']) ?></p>
                            <?php else: ?>
                                <p class="card-text text-warning">Not scheduled yet</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>You have not booked any tours yet.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
