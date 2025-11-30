<?php
session_start();
include '../includes/connection.php';
if(!isset($_SESSION['admin_id'])){ header("Location: admin_login.php"); exit; }
$res = mysqli_query($conn,"SELECT n.*, a.name AS reporter_name FROM notifications n LEFT JOIN alumni a ON n.reporter_id=a.id ORDER BY n.created_at DESC");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Reports</h3>
            <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">Back</a>
        </div>
        <?php if(!$res || mysqli_num_rows($res)==0): ?>
        <div class="alert alert-info mt-3">No reports.</div>
        <?php else: ?>
        <?php while($n=mysqli_fetch_assoc($res)): ?>
        <div class="card mt-3 p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <strong><?= htmlspecialchars($n['reporter_name'] ?? 'User') ?></strong>
                    <small class="text-muted"> — <?= htmlspecialchars($n['created_at']) ?></small>
                    <p class="mb-1">Type: <?= htmlspecialchars($n['type']) ?> | Target ID:
                        <?= intval($n['target_id']) ?></p>
                </div>
                <div>
                    <?php if($n['type']=='post'): ?>
                    <a href="approve_post.php?id=<?= intval($n['target_id']) ?>&act=delete"
                        class="btn btn-sm btn-danger">Delete Post</a>
                    <a href="../view_post_admin.php?id=<?= intval($n['target_id']) ?>"
                        class="btn btn-sm btn-outline-primary">View</a>
                    <?php else: ?>
                    <a href="../delete_comment.php?id=<?= intval($n['target_id']) ?>"
                        class="btn btn-sm btn-danger">Delete Comment</a>
                    <a href="../view_comment_admin.php?id=<?= intval($n['target_id']) ?>"
                        class="btn btn-sm btn-outline-primary">View</a>
                    <?php endif; ?>
                    <a href="mark_seen.php?id=<?= intval($n['id']) ?>" class="btn btn-sm btn-secondary">Mark Seen</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php endif; ?>
    </div>
</body>

</html>