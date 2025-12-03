<?php
session_start();

// Only allow admin access
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include '../includes/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="manage_tours.php">Manage Tours</a></li>
        <li class="nav-item"><a class="nav-link" href="manage_bookings.php">Manage Bookings</a></li>
        <li class="nav-item"><a class="nav-link" href="manage_guides.php">Manage Guides</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <h1>Welcome, Admin!</h1>
    <p>Use the navigation bar above to manage tours, bookings, and guides.</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Tours</h5>
                    <p class="card-text">View, add, or edit tours.</p>
                    <a href="manage_tours.php" class="btn btn-light">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Bookings</h5>
                    <p class="card-text">View and manage all bookings.</p>
                    <a href="manage_bookings.php" class="btn btn-light">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Guides</h5>
                    <p class="card-text">Manage tour guides and certifications.</p>
                    <a href="manage_guides.php" class="btn btn-light">Go</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
