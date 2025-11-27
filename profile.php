<?php
session_start();
include 'includes/connection.php';

if (!isset($_SESSION['alumni_id'])) {
    header("Location: login.php");
    exit;
}

$alumni_id = intval($_SESSION['alumni_id']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $linkedin = mysqli_real_escape_string($conn, $_POST['linkedin']);
    $batch = mysqli_real_escape_string($conn, $_POST['batch']);
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);

    $sql = "UPDATE alumni SET name='$name', phone='$phone', city='$city', linkedin='$linkedin', batch='$batch', branch='$branch' WHERE id = $alumni_id";
    mysqli_query($conn, $sql);
    $msg = "Profile updated.";
}

$res = mysqli_query($conn, "SELECT * FROM alumni WHERE id = $alumni_id LIMIT 1");
$alumni = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Profile - Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Your Profile</h3>
            <div>
                <a href="directory.php" class="btn btn-sm btn-outline-secondary">Directory</a>
                <a href="create_post.php" class="btn btn-sm btn-outline-primary">Create Post</a>
                <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
                <button id="themeToggle" class="btn btn-sm btn-outline-primary">Dark</button>
            </div>
        </div>

        <?php if (!empty($msg)): ?>
        <div class="alert alert-success mt-3"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <form method="POST" class="mt-3">
            <div class="mb-2">
                <label class="form-label">Name</label>
                <input name="name" value="<?= htmlspecialchars($alumni['name'] ?? '') ?>" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="form-label">Batch</label>
                    <input name="batch" value="<?= htmlspecialchars($alumni['batch'] ?? '') ?>" class="form-control">
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Branch</label>
                    <input name="branch" value="<?= htmlspecialchars($alumni['branch'] ?? '') ?>" class="form-control">
                </div>
            </div>
            <div class="mb-2">
                <label class="form-label">Phone</label>
                <input name="phone" value="<?= htmlspecialchars($alumni['phone'] ?? '') ?>" class="form-control">
            </div>
            <div class="mb-2">
                <label class="form-label">City</label>
                <input name="city" value="<?= htmlspecialchars($alumni['city'] ?? '') ?>" class="form-control">
            </div>
            <div class="mb-2">
                <label class="form-label">LinkedIn</label>
                <input name="linkedin" value="<?= htmlspecialchars($alumni['linkedin'] ?? '') ?>" class="form-control">
            </div>

            <button class="btn btn-primary">Save</button>
        </form>
    </div>

    <script src="js/app.js"></script>
</body>

</html>