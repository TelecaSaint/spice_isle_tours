<?php
// Detect if running locally or on InfinityFree
if ($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "127.0.0.1") {
    // Local XAMPP settings
    $host = "localhost";
    $user = "root";
    $pass = "";              // default XAMPP password is empty
    $db   = "spice_isle_tours"; // your local database name
} else {
    // InfinityFree online settings
    $host = "sql204.infinityfree.com";
    $user = "if0_40571768";
    $pass = "BbGLmRnW8Ux";
    $db   = "if0_40571768_XXX"; // replace XXX with your actual DB name
}

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // optional for testing
?>
