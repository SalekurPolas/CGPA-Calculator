<?php ob_start(); include_once('assets/php/database.php');
    if(!isset($_SESSION['id'])) {
        header("location: login");
    } else {
        $id = $_SESSION['id'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/res/images/logo/logo.png">
    <title>Update Course - CGPA Calculator</title>

    <!-- css, js and font design-->
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    <script src="assets/js/functions.js"></script>
</head>
<body>
    <div class="auth-content">
        <div class="logo"></div>
        <div class="text">Update Course</div>
        <form action="" method="post">
            <div class="auth-field">
                <input type="text" name="courseName" required>
                <span class="fas fa-book"></span>
                <label>Course</label>
            </div>
            <div class="auth-field">
                <input type="text" name="courseCredit" required>
                <span class="fas fa-gavel"></span>
                <label>Credit</label>
            </div>
            <div class="auth-field" required>
                <input type="text" name="courseSemester" required>
                <span class="fas fa-university"></span>
                <label>Semester</label>
            </div>
            <div class="auth-field" required>
                <input type="text" name="courseGrade" required>
                <span class="fas fa-graduation-cap"></span>
                <label>Grade</label>
            </div>
            <button class="auth-btn" name="courseSubmit">Update Course</button>
            <div class="auth-link">
            <a href="./">Back</a> or <a href="course">Add Course</a>
            </div>
        </form>
        <?php
            if(isset($_POST['courseSubmit'])) {
                $name = $_POST['courseName'];
                $credit = $_POST['courseCredit'];
                $semester = $_POST['courseSemester'];
                $grade = $_POST['courseGrade'];

                $searchByCourse = "SELECT * FROM grades WHERE course = '$name'";
                $result = mysqli_query($conn, $searchByCourse);
                if(mysqli_num_rows($result) > 0) {
                    $update_course_sql = "UPDATE grades SET course ='$name', credits ='$credit', semester ='$semester', grade ='$grade' WHERE course ='$name'";
                    if(mysqli_query($conn, $update_course_sql)) {
                        header('location: ./');
                    } else {
                        echo "<p style='text-align:center; color:red; padding: 5px; margin-top: 10px; border-radius: 10px; background-color: #bbb;'>Course update failed</p>";
                    }
                } else {
                    echo "<p style='text-align:center; color:red; padding: 5px; margin-top: 10px; border-radius: 10px; background-color: #bbb;'>Course not Found</p>";
                }
            }
        ?>
    </div>
</body>
</html>