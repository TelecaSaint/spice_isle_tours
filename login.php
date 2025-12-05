<?php
session_start();
include __DIR__ . '/includes/db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hash);
        $stmt->fetch();

        if (password_verify($password, $hash)) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id;

            session_write_close();
            header("Location: tours.php");
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Username not found!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login | Spice Isle Tours</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center">Login</h2>
        <?php if($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            <p class="mt-3 text-center">
                Don’t have an account? <a href="register.php">Register here</a>
            </p>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
