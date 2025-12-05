<?php
include 'includes/header.php';
include 'includes/db_connect.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO messages (name,email,subject,message,status,created_at) VALUES (?,?,?,?, 'Unread', NOW())");
    $stmt->bind_param("ssss", $name,$email,$subject,$message);
    $stmt->execute();
    $stmt->close();
    $success = "Message sent successfully!";
}
?>

<div class="container py-5">
    <h2>Contact Us</h2>
    <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <form method="POST">
        <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" required></div>
        <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-3"><label>Subject</label><input type="text" name="subject" class="form-control" required></div>
        <div class="mb-3"><label>Message</label><textarea name="message" class="form-control" required></textarea></div>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
