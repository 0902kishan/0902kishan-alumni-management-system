<?php
session_start();
include '../includes/connection.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}
$pending_alumni_count = 0;
$pending_posts_count = 0;
$r1 = mysqli_query($conn, "SELECT COUNT(*) as c FROM alumni WHERE approved=0");
if ($r1) { $pending_alumni_count = intval(mysqli_fetch_assoc($r1)['c']); }
$r2 = mysqli_query($conn, "SELECT COUNT(*) as c FROM posts WHERE approved=0");
if ($r2) { $pending_posts_count = intval(mysqli_fetch_assoc($r2)['c']); }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
    .card-link {
        text-decoration: none;
        color: inherit;
    }

    .badge-notify {
        font-size: .8rem;
        margin-left: 6px;
    }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Admin Dashboard</h2>
            <div class="top-controls">
                <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">Refresh</a>
                <a href="approve_alumni.php?action=logout" class="btn btn-sm btn-danger">Logout</a>
                <button id="themeToggle" class="btn btn-sm btn-outline-primary">Dark</button>
            </div>
        </div>

        <div class="row mt-4 g-3">
            <div class="col-md-4">
                <a class="card-link" href="pending_alumni.php">
                    <div class="card shadow-sm p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Approve Alumni</h5>
                                <small class="text-muted">Approve or remove new registrations</small>
                            </div>
                            <div>
                                <?php if($pending_alumni_count > 0): ?>
                                <span class="badge bg-danger badge-notify"><?= $pending_alumni_count ?></span>
                                <?php else: ?>
                                <span class="badge bg-secondary badge-notify">0</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a class="card-link" href="pending_posts.php">
                    <div class="card shadow-sm p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Approve Pending Posts</h5>
                                <small class="text-muted">Approve or delete posts submitted by alumni</small>
                            </div>
                            <div>
                                <?php if($pending_posts_count > 0): ?>
                                <span class="badge bg-danger badge-notify"><?= $pending_posts_count ?></span>
                                <?php else: ?>
                                <span class="badge bg-secondary badge-notify">0</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a class="card-link" href="manage_posts.php">
                    <div class="card shadow-sm p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Manage All Posts</h5>
                                <small class="text-muted">View, delete or inspect all posts</small>
                            </div>
                            <div>
                                <span class="badge bg-info badge-notify">All</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <hr class="mt-4">
        <p class="text-muted small">Use the tiles above to manage registrations and posts. Click a tile to open the
            corresponding list and take action.</p>
    </div>

    <script src="../js/app.js"></script>
</body>

</html>