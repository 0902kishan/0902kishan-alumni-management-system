<?php
include 'includes/connection.php';
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container mt-5">

        <h2 class="text-center mb-4">Alumni Login</h2>

        <div class="text-center mb-3">
            <button id="themeToggle" class="btn btn-outline-primary btn-sm">Dark</button>
        </div>

        <?php
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $email = $_POST['email'];
            $pass  = $_POST['password'];

            $sql = "SELECT * FROM alumni WHERE email='$email' AND approved=1";
            $res = mysqli_query($conn, $sql);

            if(mysqli_num_rows($res)==1){
                $row = mysqli_fetch_assoc($res);

                if(password_verify($pass, $row['password'])){
                    $_SESSION['alumni_id'] = $row['id'];
                    header("Location: profile.php");
                    exit;
                }
                else{
                    echo "<div class='alert alert-danger'>Wrong password!</div>";
                }
            }
            else{
                echo "<div class='alert alert-warning'>Not approved by Admin yet OR wrong email!</div>";
            }
        }
        ?>

        <form method="POST">
            <input class="form-control mb-3" name="email" placeholder="Email" required>
            <input class="form-control mb-3" type="password" name="password" placeholder="Password" required>
            <button class="btn btn-primary w-100">Login</button>
        </form>

    </div>

    <script src="js/app.js"></script>
</body>

</html>