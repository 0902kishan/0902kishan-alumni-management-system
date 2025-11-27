<?php
session_start();
include 'includes/connection.php';

$sql = "SELECT p.title, p.body, p.created_at, a.name
        FROM posts p
        LEFT JOIN alumni a ON p.alumni_id = a.id
        WHERE p.approved = 1
        ORDER BY p.created_at DESC";
$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-4">

        <div class="d-flex justify-content-between mb-3">
            <h3>Alumni Posts</h3>
            <div class="top-controls">
                <a href="index.php" class="btn btn-sm btn-outline-secondary">Home</a>

                <?php if (isset($_SESSION['alumni_id'])): ?>
                <a href="create_post.php" class="btn btn-sm btn-outline-primary">Create Post</a>
                <?php else: ?>
                <a href="login.php" class="btn btn-sm btn-outline-primary">Login to Post</a>
                <?php endif; ?>

                <button id="themeToggle" class="btn btn-sm btn-outline-primary">Dark</button>
            </div>
        </div>

        <?php if (!$res || mysqli_num_rows($res) == 0): ?>
        <div class="alert alert-info">No posts available.</div>
        <?php else: ?>
        <?php while ($p = mysqli_fetch_assoc($res)): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5><?= htmlspecialchars($p['title']) ?></h5>
                <small class="muted">By <?= htmlspecialchars($p['name'] ?? 'Unknown') ?> —
                    <?= $p['created_at'] ?></small>
                <p class="mt-2"><?= nl2br(htmlspecialchars($p['body'])) ?></p>
            </div>
        </div>
        <?php endwhile; ?>
        <?php endif; ?>

    </div>

    <script src="js/app.js"></script>
</body>

</html>