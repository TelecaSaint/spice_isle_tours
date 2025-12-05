<?php
session_start();
include 'includes/db_connect.php';
include 'includes/header.php';

// Fetch all posts
$result = $conn->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spice Isle Tours Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h2 class="text-center mb-4">📰 Spice Isle Tours Blog</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($row['image'])): ?>
                            <img src="images/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="Post Image">
                        <?php else: ?>
                            <img src="images/diving.jpg" class="card-img-top" alt="Default Image">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                            <p class="card-text text-muted small">
                                <?= date("F j, Y", strtotime($row['created_at'])) ?>
                            </p>
                            <p class="card-text"><?= nl2br(substr(htmlspecialchars($row['content']), 0, 120)) ?>...</p>
                            <a href="blog_post.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-secondary text-center">No blog posts yet. Check back soon!</div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
