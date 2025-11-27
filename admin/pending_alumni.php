<?php
session_start();
include '../includes/connection.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}
$res = mysqli_query($conn, "SELECT * FROM alumni WHERE approved=0 ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pending Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <h3>Pending Alumni Registrations</h3>
            <div class="top-controls">
                <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">Back</a>
                <button id="themeToggle" class="btn btn-sm btn-outline-primary">Dark</button>
            </div>
        </div>

        <?php if(!$res || mysqli_num_rows($res) == 0): ?>
        <div class="alert alert-info mt-3">No pending registrations.</div>
        <?php else: ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Batch</th>
                    <th>Branch</th>
                    <th>Registered At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($r = mysqli_fetch_assoc($res)): ?>
                <tr>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td><?= htmlspecialchars($r['email']) ?></td>
                    <td><?= htmlspecialchars($r['batch']) ?></td>
                    <td><?= htmlspecialchars($r['branch']) ?></td>
                    <td><?= htmlspecialchars($r['created_at']) ?></td>
                    <td>
                        <a href="approve_alumni.php?id=<?= intval($r['id']) ?>&act=approve"
                            class="btn btn-sm btn-success">Approve</a>
                        <a href="approve_alumni.php?id=<?= intval($r['id']) ?>&act=delete" class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this registration?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php endif; ?>

    </div>

    <script src="../js/app.js"></script>
</body>

</html>