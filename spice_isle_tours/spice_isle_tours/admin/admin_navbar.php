<?php
// admin_navbar.php
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard.php">Spice Isle Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">🏠 Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_tours.php">🗺️ Tours</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_posts.php">📰 Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_message.php">📬 Messages</a></li>
                <li class="nav-item"><a class="nav-link" href="admin.php">👥 Users</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_bookings.php">📋 Bookings</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">🚪 Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
