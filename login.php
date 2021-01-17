<?php include_once('assets/php/database.php');
    if(isset($_SESSION['id'])) {
        header("location: ./");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/res/images/logo/logo.png">
    <title>Login - CGPA Calculator</title>

    <!-- css, js and font design-->
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    <script src="assets/js/functions.js"></script>
</head>
<body>
    <!-- login page -->
    <div class="auth-content">
        <div class="logo"></div>
        <div class="text">Enter email and password to sign in</div>
        <form action="" method="post">
            <div class="auth-field">
                <input type="text" name="loginEmail" required>
                <span class="fas fa-user"></span>
                <label>Email</label>
            </div>
            <div class="auth-field">
                <input type="password" name="loginPass" required>
                <span class="fas fa-lock"></span>
                <label>Password</label>
            </div>
            <button class="auth-btn" name="loginSubmit">Login</button>
            <div class="auth-link">
                <a href="register">Don't have account? Register</a>
            </div>
        </form>

        <?php
            if(isset($_POST['loginSubmit'])) {
                $email = $_POST['loginEmail'];
                $password = $_POST['loginPass'];
                
                $sqlForEmail = "SELECT id, name, email, password FROM users WHERE email = '$email'";
                $resultForEmail = mysqli_query($conn, $sqlForEmail);

                if ($resultForEmail && $resultForEmail->num_rows > 0) {
                    while($row = $resultForEmail->fetch_assoc()) {
                        if($password == $row["password"]){
                            $user_id = $row["id"];
                            $user_name = $row["name"];
                            $user_email = $row["email"];

                            $_SESSION['id'] = $user_id;
                            $_SESSION['name'] = $user_name;
                            $_SESSION['email'] = $user_email;
                            
                            header('location: ./');
                        } else {
                            echo "<p style='text-align:center; color:red; padding: 5px; margin-top: 10px; border-radius: 10px; background-color: #bbb;'>Incorrect Password</p>";
                        }
                    }
                } else {
                    echo "<p style='text-align:center; color:red; padding: 5px; margin-top: 10px; border-radius: 10px; background-color: #bbb;'>Account Does not Exist</p>";
                }
            }
        ?>
    </div>
</body>
</html>