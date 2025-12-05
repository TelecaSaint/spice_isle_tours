<?php
session_start();
include '../includes/db_connect.php';
include '../includes/header.php';

// --- Admin flag ---
$isAdmin = true; // set false for public page

// --- Handle booking submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book'])) {
    $tour_id = intval($_POST['tour_id']);
    $outing_datetime = $_POST['outing_datetime'];
    $booking_id = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : NULL;

    // Validate tour exists
    $check = $conn->prepare("SELECT id FROM tours WHERE id=?");
    $check->bind_param("i", $tour_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $stmt = $conn->prepare("INSERT INTO outing (tour_id, outing_datetime, booking_id) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $tour_id, $outing_datetime, $booking_id);
        if ($stmt->execute()) {
            $success = "Booking scheduled successfully!";
        } else {
            $error = "Error scheduling booking: " . $stmt->error;
        }
    } else {
        $error = "Invalid tour selected.";
    }
}

// --- Handle booking cancellation (admin only) ---
if ($isAdmin && isset($_GET['cancel_id'])) {
    $cancel_id = intval($_GET['cancel_id']);
    $stmt = $conn->prepare("DELETE FROM outing WHERE id=?");
    $stmt->bind_param("i", $cancel_id);
    if ($stmt->execute()) {
        $success = "Booking canceled successfully!";
    } else {
        $error = "Error canceling booking: " . $stmt->error;
    }
}

// --- Fetch tours for dropdown ---
$tours = $conn->query("SELECT id, title FROM tours ORDER BY title");

// --- Fetch existing bookings (admin only) ---
if ($isAdmin) {
    $bookings = $conn->query("
        SELECT o.id, t.title AS tour_title, o.outing_datetime, o.booking_id
        FROM outing o
        JOIN tours t ON o.tour_id = t.id
        ORDER BY o.outing_datetime ASC
    ");
}
?>

<div class="container my-5">
    <h2 class="text-center mb-4"><?= $isAdmin ? "Manage Tour Bookings" : "Book a Tour" ?></h2>

    <?php if (!empty($success)) echo '<div class="alert alert-success">'.$success.'</div>'; ?>
    <?php if (!empty($error)) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>

    <!-- Booking Form -->
    <form method="POST" class="mb-5">
        <div class="mb-3">
            <label for="tour_id" class="form-label">Select Tour</label>
            <select name="tour_id" id="tour_id" class="form-control" required>
                <option value="">-- Choose a Tour --</option>
                <?php while ($row = $tours->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="outing_datetime" class="form-label">Tour Date & Time</label>
            <input type="datetime-local" name="outing_datetime" id="outing_datetime" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="booking_id" class="form-label">Booking ID (Optional)</label>
            <input type="number" name="booking_id" id="booking_id" class="form-control">
        </div>

        <button type="submit" name="book" class="btn btn-primary"><?= $isAdmin ? "Add Booking" : "Book Tour" ?></button>
    </form>

    <?php if ($isAdmin): ?>
        <h3 class="mb-3">Existing Bookings</h3>
        <?php if ($bookings->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tour</th>
                        <th>Date & Time</th>
                        <th>Booking ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($b = $bookings->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($b['tour_title']) ?></td>
                            <td><?= htmlspecialchars($b['outing_datetime']) ?></td>
                            <td><?= htmlspecialchars($b['booking_id'] ?? '-') ?></td>
                            <td>
                                <a href="?cancel_id=<?= $b['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this booking?');">Cancel</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-secondary">No bookings yet.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
