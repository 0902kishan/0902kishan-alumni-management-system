<?php
session_start();
include 'includes/connection.php';
if (!isset($_SESSION['alumni_id'])) {
    header("Location: login.php");
    exit;
}
$alumni_id = intval($_SESSION['alumni_id']);
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
    $body  = mysqli_real_escape_string($conn, $_POST['body'] ?? '');
    if (trim($title) === '' || trim($body) === '') {
        $msg = "Please enter both title and content.";
    } else {
        $sql = "INSERT INTO posts (alumni_id, title, body, approved)
                VALUES ($alumni_id, '$title', '$body', 0)";
        if (mysqli_query($conn, $sql)) {
            $msg = "Post submitted. Waiting for admin approval.";
        } else {
            $msg = "Database error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <h3>Create Post</h3>
            <div class="top-controls">
                <a href="posts.php" class="btn btn-sm btn-outline-primary">View Posts</a>
                <a href="profile.php" class="btn btn-sm btn-outline-secondary">My Profile</a>
                <button id="themeToggle" class="btn btn-sm btn-outline-primary">Dark</button>
            </div>
        </div>

        <?php if ($msg): ?>
        <div class="alert alert-info mt-3"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <form method="POST" class="mt-3">
            <input class="form-control mb-2" name="title" placeholder="Post Title" required>
            <textarea class="form-control mb-2" rows="6" name="body" placeholder="Write your post..."
                required></textarea>
            <button class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="js/app.js"></script>
</body>

</html>