<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include '../includes/db_connect.php';

$tour_id = $_GET['id'] ?? null;
if (!$tour_id) {
    header("Location: manage_tours.php");
    exit();
}

// Fetch tour info
$stmt = $conn->prepare("SELECT * FROM tours WHERE id = ?");
$stmt->bind_param("i", $tour_id);
$stmt->execute();
$result = $stmt->get_result();
$tour = $result->fetch_assoc();
$stmt->close();

// Fetch all guides
$guides = $conn->query("SELECT id, name FROM guide");

// Fetch existing outings for this tour
$existing_outings = [];
$res = $conn->query("SELECT * FROM outing WHERE tour_id = $tour_id");
while($row = $res->fetch_assoc()) {
    $existing_outings[$row['guide_id']] = $row['outing_datetime'];
}

// Handle tour update
if (isset($_POST['update_tour'])) {
    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $fee = $_POST['fee'];
    $assigned_guides = $_POST['guides'] ?? [];
    $outing_datetimes = $_POST['outing_datetime'] ?? [];

    // Update tour info
    $stmt = $conn->prepare("UPDATE tours SET title = ?, duration = ?, fee = ? WHERE id = ?");
    $stmt->bind_param("sidi", $title, $duration, $fee, $tour_id);
    $stmt->execute();
    $stmt->close();

    // Clear existing outings for this tour
    $conn->query("DELETE FROM outing WHERE tour_id = $tour_id");

    // Insert new outings
    foreach ($assigned_guides as $guide_id) {
        $datetime = $outing_datetimes[$guide_id] ?? null;
        if ($datetime) {
            $stmt = $conn->prepare("INSERT INTO outing (tour_id, guide_id, outing_datetime) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $tour_id, $guide_id, $datetime);
            $stmt->execute();
            $stmt->close();
        }
    }

    header("Location: manage_tours.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Tour</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Edit Tour: <?= htmlspecialchars($tour['title']) ?></h2>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($tour['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Duration (hours)</label>
            <input type="number" name="duration" class="form-control" value="<?= $tour['duration'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Fee ($)</label>
            <input type="number" step="0.01" name="fee" class="form-control" value="<?= $tour['fee'] ?>" required>
        </div>

        <h5>Assign Guides & Schedule</h5>
        <?php while($guide = $guides->fetch_assoc()): ?>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="guides[]" value="<?= $guide['id'] ?>" id="guide<?= $guide['id'] ?>"
                    <?= isset($existing_outings[$guide['id']]) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="guide<?= $guide['id'] ?>"><?= htmlspecialchars($guide['name']) ?></label>
                </div>
                <input type="datetime-local" name="outing_datetime[<?= $guide['id'] ?>]" class="form-control mt-1"
                    value="<?= isset($existing_outings[$guide['id']]) ? date('Y-m-d\TH:i', strtotime($existing_outings[$guide['id']])) : '' ?>">
            </div>
        <?php endwhile; ?>

        <button type="submit" name="update_tour" class="btn btn-primary btn-lg"
            style="transition: transform 0.2s, box-shadow 0.2s;">Update Tour</button>
        <a href="manage_tours.php" class="btn btn-secondary btn-lg"
           style="transition: transform 0.2s, box-shadow 0.2s;">Cancel</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<style>
.btn-primary:hover, .btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
</style>
</body>
</html>
