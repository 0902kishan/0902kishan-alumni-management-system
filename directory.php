<?php
session_start();
include 'includes/connection.php';

$name   = isset($_GET['name']) ? mysqli_real_escape_string($conn, $_GET['name']) : '';
$batch  = isset($_GET['batch']) ? mysqli_real_escape_string($conn, $_GET['batch']) : '';
$branch = isset($_GET['branch']) ? mysqli_real_escape_string($conn, $_GET['branch']) : '';
$city   = isset($_GET['city']) ? mysqli_real_escape_string($conn, $_GET['city']) : '';

$where = "approved = 1";
if ($name !== '')  $where .= " AND name LIKE '%$name%'";
if ($batch !== '') $where .= " AND batch = '$batch'";
if ($branch !== '') $where .= " AND branch = '$branch'";
if ($city !== '')   $where .= " AND city LIKE '%$city%'";

$sql = "SELECT id, name, email, batch, branch, city, linkedin FROM alumni WHERE $where ORDER BY name";
$res = mysqli_query($conn, $sql);

$batches = mysqli_query($conn, "SELECT DISTINCT batch FROM alumni WHERE approved=1 AND batch<>'' ORDER BY batch DESC");
$branches = mysqli_query($conn, "SELECT DISTINCT branch FROM alumni WHERE approved=1 AND branch<>'' ORDER BY branch");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Alumni Directory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Alumni Directory</h3>
            <div class="top-controls">
                <a href="index.php" class="btn btn-sm btn-outline-secondary">Home</a>

                <?php if(isset($_SESSION['alumni_id']) && $_SESSION['alumni_id']): ?>
                <a href="create_post.php" class="btn btn-sm btn-outline-primary">Create Post</a>
                <?php else: ?>
                <a href="login.php" class="btn btn-sm btn-outline-primary">Login to Post</a>
                <?php endif; ?>

                <a href="posts.php" class="btn btn-sm btn-outline-success">Show Posts</a>

                <?php if(isset($_SESSION['alumni_id']) && $_SESSION['alumni_id']): ?>
                <a href="own_posts.php" class="btn btn-sm btn-outline-warning">My Posts</a>
                <a href="profile.php" class="btn btn-sm btn-outline-info">My Profile</a>
                <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
                <?php else: ?>
                <a href="login.php" class="btn btn-sm btn-outline-info">My Profile</a>
                <?php endif; ?>

                <button id="themeToggle" class="btn btn-sm btn-outline-primary">Dark</button>
            </div>
        </div>

        <div class="card p-3 mb-3">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <input name="name" value="<?= htmlspecialchars($name) ?>" class="form-control"
                        placeholder="Search by name">
                </div>
                <div class="col-md-2">
                    <select name="batch" class="form-select">
                        <option value="">All batches</option>
                        <?php mysqli_data_seek($batches, 0); while($b = mysqli_fetch_assoc($batches)): ?>
                        <option value="<?= htmlspecialchars($b['batch']) ?>"
                            <?= ($batch===$b['batch'])?'selected':''; ?>><?= htmlspecialchars($b['batch']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="branch" class="form-select">
                        <option value="">All branches</option>
                        <?php mysqli_data_seek($branches, 0); while($br = mysqli_fetch_assoc($branches)): ?>
                        <option value="<?= htmlspecialchars($br['branch']) ?>"
                            <?= ($branch===$br['branch'])?'selected':''; ?>><?= htmlspecialchars($br['branch']) ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input name="city" value="<?= htmlspecialchars($city) ?>" class="form-control" placeholder="City">
                </div>
                <div class="col-md-1 text-end">
                    <button class="btn btn-primary w-100">Search</button>
                </div>
            </form>
        </div>

        <div class="card p-3">
            <?php if(!$res || mysqli_num_rows($res) == 0): ?>
            <div class="alert alert-info">No alumni found. Try different filters.</div>
            <?php else: ?>
            <div class="list-group">
                <?php while($r = mysqli_fetch_assoc($res)): ?>
                <a href="view_alumni.php?id=<?= intval($r['id']) ?>"
                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?= htmlspecialchars($r['name']) ?></strong><br>
                        <small><?= htmlspecialchars($r['branch']) ?> — Batch <?= htmlspecialchars($r['batch']) ?> —
                            <?= htmlspecialchars($r['city']) ?></small>
                    </div>
                    <div class="text-end">
                        <?php if(!empty($r['linkedin'])): ?>
                        <a href="<?= htmlspecialchars($r['linkedin']) ?>" target="_blank"
                            class="btn btn-sm btn-outline-primary">LinkedIn</a>
                        <?php endif; ?>
                        <a href="view_alumni.php?id=<?= intval($r['id']) ?>"
                            class="btn btn-sm btn-secondary ms-2">View</a>
                    </div>
                </a>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
        </div>

    </div>

    <script src="js/app.js"></script>
</body>

</html>