<?php
session_start();
include '../includes/connection.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}
$res = mysqli_query($conn, "SELECT p.id, p.title, p.body, p.approved, p.created_at, a.name, a.email
                           FROM posts p LEFT JOIN alumni a ON p.alumni_id = a.id
                           ORDER BY p.created_at DESC");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Manage Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <h3>All Posts (Manage)</h3>
            <div class="top-controls">
                <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">Back</a>
                <button id="themeToggle" class="btn btn-sm btn-outline-primary">Dark</button>
            </div>
        </div>

        <?php if(!$res || mysqli_num_rows($res) == 0): ?>
        <div class="alert alert-info mt-3">No posts found.</div>
        <?php else: ?>
        <?php while($p = mysqli_fetch_assoc($res)): ?>
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5><?= htmlspecialchars($p['title']) ?></h5>
                        <small class="muted">By <?= htmlspecialchars($p['name'] ?? 'Unknown') ?>
                            (<?= htmlspecialchars($p['email'] ?? '') ?>) —
                            <?= htmlspecialchars($p['created_at']) ?></small>
                    </div>
                    <div class="text-end">
                        <?php if($p['approved']==1): ?>
                        <span class="badge bg-success">Approved</span>
                        <?php else: ?>
                        <span class="badge bg-warning text-dark">Pending</span>
                        <?php endif; ?>
                    </div>
                </div>

                <p class="mt-2"><?= nl2br(htmlspecialchars($p['body'])) ?></p>

                <div class="mt-2">
                    <?php if($p['approved']==0): ?>
                    <a href="approve_post.php?id=<?= intval($p['id']) ?>&act=approve"
                        class="btn btn-sm btn-success">Approve</a>
                    <?php endif; ?>
                    <a href="approve_post.php?id=<?= intval($p['id']) ?>&act=delete" class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this post?')">Delete</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php endif; ?>

    </div>

    <script src="../js/app.js"></script>
</body>

</html>