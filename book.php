<?php
session_start();
include 'includes/db_connect.php';

// Redirect if user not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Make sure a tour_id was passed
if (!isset($_POST['tour_id'])) {
    header("Location: tours.php");
    exit();
}

$username = $_SESSION['username'];
$tour_id = intval($_POST['tour_id']);

// Get the client ID based on the logged-in user
$stmt = $conn->prepare("SELECT id, email FROM clients WHERE name = ? OR email = ?");
$stmt->bind_param("ss", $username, $username);
$stmt->execute();
$stmt->bind_result($client_id, $client_email);
$stmt->fetch();
$stmt->close();

// If client doesn’t exist in clients table, create one
if (empty($client_id)) {
    $insert = $conn->prepare("INSERT INTO clients (name, email) VALUES (?, ?)");
    $insert->bind_param("ss", $username, $username);
    $insert->execute();
    $client_id = $insert->insert_id;
    $insert->close();
}

// Insert booking
$stmt = $conn->prepare("INSERT INTO bookings (client_id, tour_id) VALUES (?, ?)");
$stmt->bind_param("ii", $client_id, $tour_id);
$stmt->execute();
$stmt->close();

header("Location: my_bookings.php");
exit();
?>
