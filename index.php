<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Alumni System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container mt-5">
        <div class="text-center">
            <h1 class="mb-4">Welcome to the Alumni System</h1>

            <?php if(isset($_SESSION['alumni_id'])): ?>
            <a href="profile.php" class="btn btn-primary btn-lg">Go to Profile</a>
            <a href="logout.php" class="btn btn-danger btn-lg">Logout</a>
            <?php else: ?>
            <a href="login.php" class="btn btn-primary btn-lg">Alumni Login</a>
            <a href="register.php" class="btn btn-success btn-lg">Alumni Register</a>
            <?php endif; ?>

            <hr class="my-4">

            <a href="admin/admin_login.php" class="btn btn-dark btn-lg">Admin Login</a>

            <div class="mt-3">
                <button id="themeToggle" class="btn btn-outline-primary btn-sm">Dark</button>
            </div>

        </div>
    </div>

    <script src="js/app.js"></script>
</body>

</html>