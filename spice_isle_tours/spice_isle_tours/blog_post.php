<?php
session_start();
include 'includes/db_connect.php';
include 'includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger text-center my-5'>Invalid post ID.</div>";
    include 'includes/footer.php';
    exit();
}

$post_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM blog_posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
$stmt->close();

if (!$post) {
    echo "<div class='alert alert-danger text-center my-5'>Post not found.</div>";
    include 'includes/footer.php';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post['title']) ?> - Spice Isle Tours Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <div class="text-center mb-4">
        <h2><?= htmlspecialchars($post['title']) ?></h2>
        <p class="text-muted"><?= date("F j, Y", strtotime($post['created_at'])) ?></p>
    </div>

    <?php if (!empty($post['image'])): ?>
        <div class="text-center mb-4">
            <img src="images/<?= htmlspecialchars($post['image']) ?>" class="img-fluid rounded shadow-sm" alt="Post Image">
        </div>
    <?php endif; ?>

    <div class="card shadow-sm p-4">
        <p style="white-space: pre-line;"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
    </div>

    <div class="text-center mt-4">
        <a href="blog.php" class="btn btn-outline-secondary">← Back to Blog</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
