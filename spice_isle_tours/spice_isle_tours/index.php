<?php include 'includes/header.php'; ?>
<section class="hero text-center py-5 bg-primary text-white">
    <h1>Welcome to Spice Isle Tours</h1>
    <p>Explore the best of Grenada with our guided tours</p>
    <a href="tours.php" class="btn btn-light btn-lg">View Tours</a>
</section>

<section class="featured-tours py-5 container">
    <h2 class="mb-4">Featured Tours</h2>
    <div class="row">
        <?php
        include 'includes/db_connect.php';
        $result = $conn->query("SELECT * FROM tours ORDER BY created_at DESC LIMIT 3");
        while($tour = $result->fetch_assoc()):
        ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($tour['title']) ?></h5>
                    <p class="card-text"><?= $tour['duration'] ?> hours - $<?= number_format($tour['fee'],2) ?></p>
                    <a href="tour_details.php?id=<?= $tour['id'] ?>" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
