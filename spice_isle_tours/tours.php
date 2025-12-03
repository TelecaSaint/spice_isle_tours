<?php include 'includes/header.php'; ?>
<div class="container py-5">
    <h2>Our Tours</h2>
    <div class="row">
        <?php
        include 'includes/db_connect.php';
        $tours = $conn->query("SELECT * FROM tours ORDER BY created_at DESC");
        while($tour = $tours->fetch_assoc()):
        ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($tour['title']) ?></h5>
                    <p class="card-text"><?= $tour['duration'] ?> hours - $<?= number_format($tour['fee'],2) ?></p>
                    <a href="tour_details.php?id=<?= $tour['id'] ?>" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
