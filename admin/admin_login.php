<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$inc_path = __DIR__ . '/../includes/connection.php';
if (!file_exists($inc_path)) {
    echo "<div style='padding:20px;font-family:Arial;'><h3 style='color:#b00;'>Missing include file</h3>
          <p>The file <code>includes/connection.php</code> was not found at: <strong>" . htmlspecialchars($inc_path) . "</strong></p>
          <p>Make sure <code>C:\\xampp\\htdocs\\alumni_project\\includes\\connection.php</code> exists.</p></div>";
    exit;
}
include $inc_path;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';
    $res = mysqli_query($conn, "SELECT * FROM admin WHERE username='$user' LIMIT 1");
    if ($row = mysqli_fetch_assoc($res)) {
        if ($pass === $row['password']) {
            $_SESSION['admin_id'] = $row['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            $err = "Invalid credentials.";
        }
    } else {
        $err = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
    body {
        background: var(--bg);
    }

    .box {
        max-width: 420px;
        margin: 60px auto;
    }
    </style>
</head>

<body>
    <div class="container box">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="card-title mb-0">Admin Login</h3>
                    <button id="themeToggle" class="btn btn-sm btn-outline-primary">Dark</button>
                </div>

                <?php if(!empty($err)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <input name="username" class="form-control mb-2" placeholder="Username" required>
                    <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>
                    <button class="btn btn-primary w-100">Login</button>
                    <a href="../index.php" class="btn btn-link mt-2 d-block text-center">Back to site</a>
                </form>

                <hr>
                <p class="small text-muted mb-0">Default admin: <strong>admin</strong> / <strong>admin123</strong></p>
            </div>
        </div>
    </div>

    <script src="../js/app.js"></script>
</body>

</html>