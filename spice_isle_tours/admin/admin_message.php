<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include '../includes/db_connect.php';

// Handle marking messages as read/unread
if (isset($_GET['toggle_status'])) {
    $msg_id = intval($_GET['toggle_status']);
    $current_status = $_GET['current'] == 'Unread' ? 'Read' : 'Unread';
    $stmt = $conn->prepare("UPDATE messages SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $current_status, $msg_id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_messages.php");
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $msg_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param("i", $msg_id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_messages.php");
    exit();
}

// Fetch messages
$result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");

// Count unread messages for navbar badge
$unread_count = $conn->query("SELECT COUNT(*) as cnt FROM messages WHERE status='Unread'")->fetch_assoc()['cnt'];
?>

<?php include 'admin_navbar.php'; ?>

<div class="container mt-4">
    <h2>Client Messages</h2>
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($msg = $result->fetch_assoc()): ?>
            <tr <?= $msg['status'] == 'Unread' ? 'class="table-warning fw-bold"' : '' ?>>
                <td><?= $msg['id'] ?></td>
                <td><?= htmlspecialchars($msg['name']) ?></td>
                <td><?= htmlspecialchars($msg['email']) ?></td>
                <td><?= htmlspecialchars($msg['subject']) ?></td>
                <td><?= htmlspecialchars($msg['message']) ?></td>
                <td><?= $msg['status'] ?></td>
                <td><?= date("Y-m-d H:i", strtotime($msg['created_at'])) ?></td>
                <td>
                    <a href="admin_messages.php?toggle_status=<?= $msg['id'] ?>&current=<?= $msg['status'] ?>" class="btn btn-sm btn-secondary mb-1">
                        <?= $msg['status'] == 'Unread' ? 'Mark as Read' : 'Mark as Unread' ?>
                    </a>
                    <a href="admin_messages.php?delete=<?= $msg['id'] ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Delete this message?');">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
