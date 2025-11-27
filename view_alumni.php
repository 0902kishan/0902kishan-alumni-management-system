<?php
include 'includes/connection.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "Invalid ID";
    exit;
}

$res = mysqli_query($conn, "SELECT id,name,email,batch,branch,phone,city,linkedin,created_at FROM alumni WHERE id = $id AND approved=1 LIMIT 1");
if (!$res || mysqli_num_rows($res) == 0) {
    echo "Alumni not found or not approved.";
    exit;
}
$a = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($a['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <a href="directory.php" class="btn btn-sm btn-outline-secondary">&larr; Back</a>
            <button id="themeToggle" class="btn btn-sm btn-outline-primary">Dark</button>
        </div>

        <div class="card mt-3 p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <h4><?= htmlspecialchars($a['name']) ?></h4>
                    <p class="mb-1"><strong>Batch:</strong> <?= htmlspecialchars($a['batch']) ?> &nbsp;
                        <strong>Branch:</strong> <?= htmlspecialchars($a['branch']) ?>
                    </p>

                    <p class="mb-1"><strong>City:</strong> <?= htmlspecialchars($a['city']) ?> &nbsp;
                        <strong>Phone:</strong> <?= htmlspecialchars($a['phone']) ?>
                    </p>

                    <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($a['email']) ?></p>
                </div>

                <div class="text-end">
                    <?php if(!empty($a['linkedin'])): ?>
                    <a href="<?= htmlspecialchars($a['linkedin']) ?>" target="_blank"
                        class="btn btn-primary">LinkedIn</a>
                    <?php endif; ?>
                </div>
            </div>

            <hr>
            <p class="small muted">Member since: <?= htmlspecialchars($a['created_at']) ?></p>
        </div>
    </div>

    <script src="js/app.js"></script>
</body>

</html>