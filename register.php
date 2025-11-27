<?php include 'includes/connection.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Alumni Registration</h2>

        <div class="text-center mb-3">
            <button id="themeToggle" class="btn btn-outline-primary btn-sm">Dark</button>
        </div>

        <?php
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $batch = $_POST['batch'];
            $branch = $_POST['branch'];

            $hashed = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "INSERT INTO alumni (name,email,password,batch,branch) VALUES
                    ('$name','$email','$hashed','$batch','$branch')";

            if(mysqli_query($conn, $sql)){
                echo "<div class='alert alert-success'>Registered! Wait for admin approval.</div>";
            } else {
                echo "<div class='alert alert-danger'>Email may already exist!</div>";
            }
        }
        ?>

        <form method="POST">
            <input class="form-control mb-3" name="name" placeholder="Full Name" required>
            <input class="form-control mb-3" name="email" placeholder="Email" required>
            <input class="form-control mb-3" type="password" name="password" placeholder="Password" required>
            <input class="form-control mb-3" name="batch" placeholder="Batch (e.g., 2022)">
            <input class="form-control mb-3" name="branch" placeholder="Branch">
            <button class="btn btn-primary w-100">Register</button>
        </form>
    </div>

    <script src="js/app.js"></script>
</body>

</html>