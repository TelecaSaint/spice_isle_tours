<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_GET['id'])) {
    header("Location: tours.php");
    exit();
}

$tour_id = intval($_GET['id']);

// Fetch tour details
$stmt = $conn->prepare("SELECT * FROM tours WHERE id = ?");
$stmt->bind_param("i", $tour_id);
$stmt->execute();
$result = $stmt->get_result();
$tour = $result->fetch_assoc();

if (!$tour) {
    echo "<p class='text-center mt-5'>Tour not found.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($tour['title']) ?> - Spice Isle Tours</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <?php if (!empty($tour['image'])): ?>
                <img src="images/<?= htmlspecialchars($tour['image']) ?>" alt="<?= htmlspecialchars($tour['title']) ?>" class="img-fluid rounded shadow">
            <?php else: ?>
                <img src="images/default.jpg" alt="No Image Available" class="img-fluid rounded shadow">
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h2><?= htmlspecialchars($tour['title']) ?></h2>
            <p><strong>Duration:</strong> <?= htmlspecialchars($tour['duration']) ?> hours</p>
            <p><strong>Fee:</strong> $<?= number_format($tour['fee'], 2) ?></p>
            
            <p class="mt-3">
                <?= !empty($tour['description']) 
                    ? htmlspecialchars($tour['description']) 
                    : "Experience an unforgettable adventure with our expert guides through Grenada’s most scenic destinations." ?>
            </p>

            <?php if (isset($_SESSION['username'])): ?>
                <form method="POST" action="book.php">
                    <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">
                    <button type="submit" name="book_now" class="btn btn-primary btn-lg mt-3">Book Now</button>
                </form>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline-primary btn-lg mt-3">Login to Book</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
