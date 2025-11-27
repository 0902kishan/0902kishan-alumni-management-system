<?php
session_start();
include '../includes/connection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$sql = "SELECT p.id, p.title, p.body, p.created_at, a.name
        FROM posts p
        LEFT JOIN alumni a ON p.alumni_id = a.id
        WHERE p.approved = 0
        ORDER BY p.created_at DESC";
$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Pending Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <h3>Pending Posts</h3>
            <div class="top-controls">
                <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">Back</a>
                <button id="themeToggle" class="btn btn-sm btn-outline-primary">Dark</button>
            </div>
        </div>

        <?php if(mysqli_num_rows($res) == 0): ?>
        <div class="alert alert-info mt-3">No pending posts.</div>
        <?php else: ?>
        <?php while($p = mysqli_fetch_assoc($res)): ?>
        <div class="card mt-3">
            <div class="card-body">
                <h5><?= htmlspecialchars($p['title']) ?></h5>
                <small class="muted">By <?= htmlspecialchars($p['name']) ?> — <?= $p['created_at'] ?></small>
                <p class="mt-2"><?= nl2br(htmlspecialchars($p['body'])) ?></p>

                <a href="approve_post.php?id=<?= $p['id'] ?>&act=approve" class="btn btn-success btn-sm">Approve</a>

                <a href="approve_post.php?id=<?= $p['id'] ?>&act=delete" class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this post?')">Delete</a>
            </div>
        </div>
        <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <script src="../js/app.js"></script>
</body>

</html>