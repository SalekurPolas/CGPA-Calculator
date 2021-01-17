<?php include_once('assets/php/database.php');
    if(isset($_SESSION['id'])) {
        ob_end_flush();
        header("location: index");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/res/images/logo/logo.png">
    <title>Register - CGPA Calculator</title>

    <!-- css, js and font design-->
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    <script src="assets/js/functions.js"></script>
</head>
<body>
    <div class="auth-content">
        <div class="logo"></div>
        <div class="text">Create a new account</div>
        <form action="" method="post">
            <div class="auth-field">
                <input type="text" name="regName" required>
                <span class="fas fa-user-circle"></span>
                <label>Full Name</label>
            </div>
            <div class="auth-field">
                <input type="text" name="regEmail" required>
                <span class="fas fa-envelope"></span>
                <label>Email</label>
            </div>
            <div class="auth-field" required>
                <input type="password" name="regPass" required>
                <span class="fas fa-lock"></span>
                <label>Password</label>
            </div>
            <button class="auth-btn" name="regSubmit">Register</button>
            <div class="auth-link">
                <a href="login">Have an Account? Login</a>
            </div>
        </form>
        <?php
            if(isset($_POST['regSubmit'])) {
                $name = $_POST['regName'];
                $email = $_POST['regEmail'];
                $password = $_POST['regPass'];

                $searchByEmail = "SELECT * FROM users WHERE email = '$email'";
                $accountByEmail = mysqli_query($conn, $searchByEmail);
                if(mysqli_num_rows($accountByEmail) > 0) {
                    echo "<p style='text-align:center; color:red; padding: 5px; margin-top: 10px; border-radius: 10px; background-color: #bbb;'>Account already exist</p>";
                } else {
                    $sql = "INSERT INTO users (name, email, password) VALUES('$name', '$email', '$password')";
                            
                    if(mysqli_query($conn, $sql)) {
                        header('location: login');
                    } else {
                        echo "<p style='text-align:center; color:red; padding: 5px; margin-top: 10px; border-radius: 10px; background-color: #bbb;'>Registration Failed</p>";
                    }
                }
            }
        ?>
    </div>
</body>
</html>