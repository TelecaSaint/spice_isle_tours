<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = "Invalid booking ID.";
    header("Location: my_bookings.php");
    exit();
}

$booking_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Verify booking belongs to this user
$stmt = $conn->prepare("SELECT c.id 
                        FROM bookings b 
                        JOIN clients c ON b.client_id = c.id
                        WHERE b.id = ? AND c.user_id = ?");
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $_SESSION['message'] = "This booking doesn’t belong to your account.";
    header("Location: my_bookings.php");
    exit();
}
$stmt->close();

// Delete booking
$delete = $conn->prepare("DELETE FROM bookings WHERE id = ?");
$delete->bind_param("i", $booking_id);
$delete->execute();
$delete->close();

$_SESSION['message'] = "Booking canceled successfully!";
header("Location: my_bookings.php");
exit();
