<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include '../includes/db_connect.php';

$booking_id = $_GET['booking_id'] ?? null;
if (!$booking_id) {
    header("Location: manage_bookings.php");
    exit();
}

// Get booking info
$stmt = $conn->prepare("
    SELECT b.id AS booking_id, t.id AS tour_id, t.title, c.name AS client_name
    FROM bookings b
    JOIN tours t ON b.tour_id = t.id
    JOIN clients c ON b.client_id = c.id
    WHERE b.id = ?
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();
$stmt->close();

// Get all guides
$guides = $conn->query("SELECT id, name FROM guide");

// Handle scheduling
if (isset($_POST['schedule'])) {
    $guide_id = $_POST['guide_id'];
    $outing_datetime = $_POST['outing_datetime'];

    // Check if outing already exists for this booking
    $check = $conn->prepare("SELECT id FROM outing WHERE booking_id = ?");
    $check->bind_param("i", $booking_id);
    $check->execute();
    $checkResult = $check->get_result();
    
    if ($checkResult->num_rows > 0) {
        // Update existing outing
        $update = $conn->prepare("UPDATE outing SET guide_id = ?, outing_datetime = ? WHERE booking_id = ?");
        $update->bind_param("isi", $guide_id, $outing_datetime, $booking_id);
        $update->execute();
        $update->close();
    } else {
        // Insert new outing
        $insert = $conn->prepare("INSERT INTO outing (booking_id, guide_id, outing_datetime) VALUES (?, ?, ?)");
        $insert->bind_param("iis", $booking_id, $guide_id, $outing_datetime);
        $insert->execute();
        $insert->close();
    }

    header("Location: manage_bookings.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Schedule Booking</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Schedule Booking for <?= htmlspecialchars($booking['title']) ?> (<?= htmlspecialchars($booking['client_name']) ?>)</h2>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Select Guide</label>
            <select name="guide_id" class="form-control" required>
                <option value="">-- Choose Guide --</option>
                <?php while($guide = $guides->fetch_assoc()): ?>
                    <option value="<?= $guide['id'] ?>"><?= htmlspecialchars($guide['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Outing Date & Time</label>
            <input type="datetime-local" name="outing_datetime" class="form-control" required>
        </div>

        <button type="submit" name="schedule" class="btn btn-primary btn-lg" 
                style="transition: transform 0.2s, box-shadow 0.2s;">
            Schedule
        </button>
        <a href="manage_bookings.php" class="btn btn-secondary btn-lg"
           style="transition: transform 0.2s, box-shadow 0.2s;">Cancel</a>
    </form>
</div>

<style>
.btn-primary:hover, .btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
