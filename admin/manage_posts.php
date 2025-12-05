<?php
session_start();
include '../includes/db_connect.php';
include 'admin_navbar.php';

// Optional admin access check
// if (!isset($_SESSION['admin_logged_in'])) {
//     header("Location: admin_login.php");
//     exit();
// }

// Create table if not exists (failsafe)
$conn->query("CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Handle add new post
if (isset($_POST['add_post'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image = '';

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../images/";
        $image_name = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $image_name;
        }
    }

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO blog_posts (title, image, content) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $image, $content);
        $stmt->execute();
        $stmt->close();
        $message = "✅ Blog post added successfully!";
    } else {
        $message = "⚠️ Please fill out all required fields.";
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM blog_posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $message = "🗑️ Post deleted successfully!";
}

// Handle update (edit post)
if (isset($_POST['update_post'])) {
    $id = intval($_POST['post_id']);
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image = $_POST['existing_image'];

    // Handle image replacement
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../images/";
        $image_name = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $image_name;
        }
    }

    $stmt = $conn->prepare("UPDATE blog_posts SET title=?, image=?, content=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $image, $content, $id);
    $stmt->execute();
    $stmt->close();
    $message = "✏️ Post updated successfully!";
}

// Fetch all posts
$posts = $conn->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h2 class="text-center mb-4">📰 Manage Blog Posts</h2>

    <?php if (isset($message)): ?>
        <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- Add Post Form -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">Add New Post</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="5" required></textarea>
                </div>

                <button type="submit" name="add_post" class="btn btn-success w-100">Add Post</button>
            </form>
        </div>
    </div>

    <!-- Blog Posts Table -->
    <?php if ($posts->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $posts->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?= $row['id'] ?></td>
                            <td class="text-center">
                                <?php if (!empty($row['image'])): ?>
                                    <img src="../images/<?= htmlspecialchars($row['image']) ?>" width="100" class="rounded">
                                <?php else: ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= nl2br(substr(htmlspecialchars($row['content']), 0, 80)) ?>...</td>
                            <td class="text-center"><?= $row['created_at'] ?></td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                                <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this post?');">Delete</a>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title">Edit Post</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="post_id" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="existing_image" value="<?= $row['image'] ?>">
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($row['title']) ?>" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Image</label>
                                                <input type="file" name="image" class="form-control">
                                                <?php if ($row['image']): ?>
                                                    <small>Current: <?= htmlspecialchars($row['image']) ?></small>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Content</label>
                                                <textarea name="content" class="form-control" rows="5" required><?= htmlspecialchars($row['content']) ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="update_post" class="btn btn-warning">Save Changes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-secondary text-center">No blog posts yet. Add one above!</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
