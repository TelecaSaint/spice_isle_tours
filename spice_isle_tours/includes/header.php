<?php
// Start session for client login if needed
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spice Isle Tours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"> <!-- Optional custom CSS -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">Spice Isle Tours</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">🏠 Home</a></li>
                <li class="nav-item"><a class="nav-link" href="tours.php">🗺️ Tours</a></li>
                <li class="nav-item"><a class="nav-link" href="book.php">📅 Book</a></li>
                <li class="nav-item"><a class="nav-link" href="blog.php">📰 Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">📬 Contact</a></li>
                <?php if(isset($_SESSION['client_logged_in']) && $_SESSION['client_logged_in'] === true): ?>
                    <li class="nav-item"><a class="nav-link" href="my_bookings.php">👤 My Bookings</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">🚪 Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">🔑 Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">📝 Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
