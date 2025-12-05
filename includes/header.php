<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define base URL (adjust folder name if different)
$base_url = '/spice_isle_tours/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spice Isle Tours</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Main CSS (absolute path) -->
    <link rel="stylesheet" href="<?= $base_url ?>css/style.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-warning" href="<?= $base_url ?>index.php">
            🌴 Spice Isle Tours
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>index.php">🏠 Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>tours.php">🗺️ Tours</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>book.php">📅 Book</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>blog.php">📰 Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>contact.php">📬 Contact</a></li>

                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                    <li class="nav-item">
                        <span class="nav-link text-info fw-bold">
                            Welcome, <?= htmlspecialchars($_SESSION['username']) ?>
                        </span>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>my_bookings.php">👤 My Bookings</a></li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fw-semibold" href="<?= $base_url ?>logout.php">🚪 Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>login.php">🔑 Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>register.php">📝 Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
