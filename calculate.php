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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="assets/res/images/logo/logo.png">
    <title>CGPA Calculator</title>

    <!-- custom css and js -->
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/js/functions.js"></script>
</head>
<body>
    <!-- navbar section -->
    <header class="sticky">
        <!-- navbar logo -->
        <a href="./"><img src="assets/res/images/logo/logo.png" alt="logo" class="logo"/></a>
        
        <!-- navbar search -->
        <form action="search" method="get">
            <input type="text" name="q" placeholder="Search course or grades">
            <button><i class="fas fa-search"></i></button>
        </form>
        
        <!-- navbar links -->
        <nav>
            <ul>
                <li><a href="./">Home</a></li>
                <li><a href="https://www.facebook.com/ayesha.siddika.54922" target="_blank">Contact</a></li>
                <li><a href="">Github</a></li>
            </ul>
            
            <!-- nav links logout -->
            <a href="assets/php/logout.php"><button class="logout"><i class="fas fa-sign-out-alt"></i></button></a>
        </nav>
    </header>

    <div class="content">
        <div class="left_sidebar sticky">
            <!-- my profile box -->
            <div class="item">
                <p class="title">My Profile</p><hr>
                <div class="box">
                    <!-- user profile image -->
                    <img class="profile_image" src="assets/res/images/logo/profile.png" alt="Image">
                    
                    <!-- user profile info -->
                    <p class="info"><i class="fas fa-user-alt"></i><?php if (isset($_SESSION['name'])) { echo $_SESSION['name']; } ?></p>
                    <p class="info"><i class="fas fa-envelope-open-text"></i><?php if (isset($_SESSION['email'])) { echo $_SESSION['email']; } ?></p>
                    <p class="info"><i class="fas fa-check-circle"></i><?php if (isset($_SESSION['email'])) {
                        $sql = "SELECT g.user, g.credits, g.grade, u.id, u.email
                        FROM grades AS g JOIN users AS u ON g.user = u.id
                        WHERE g.grade != 'F' AND u.email = '$email'";

                        $credits = 0;
                        $result = mysqli_query($conn, $sql);
                        if ($result && $result->num_rows > 0) { while($row = $result->fetch_assoc()) { $credits = $credits + $row["credits"]; } }
                        echo "Credit Passed: " .$credits;
                    } ?></p>
                    <p class="info"><i class="fas fa-graduation-cap"></i><?php if (isset($_SESSION['email'])) {
                        $sql = "SELECT g.user, g.credits, g.grade, u.id, u.email, s.grade, s.points
                        FROM grades AS g JOIN users AS u JOIN scale as s
                        ON ( g.user = u.id AND g.grade = s.grade )
                        WHERE g.grade != 'F' AND u.email = '$email'";

                        $points = 0; $cgpa = 0;
                        $result = mysqli_query($conn, $sql);
                        if ($result && $result->num_rows > 0) { while($row = $result->fetch_assoc()) { $points = $points + ($row["points"] * $row["credits"]); } }
                        if($credits == 0) { $cgpa = 0.00; } else { $cgpa = $points / $credits; }
                        echo "Current CGPA: " .round($cgpa, 2);
                    } ?></p>
                </div>
            </div>

            <!-- feature box -->
            <div class="item">
                <p class="title">Features</p><hr>
                <button><i class="fas fa-eye"></i><a href="./">Back to Home</a></button>
            </div>
        </div>

        <div class="main_content sticky">
            <!-- calculate cgpa -->
            <div class="item calculate_cgpa">
                <p class="title">Calculate CGPA</p><hr>
                <div class="box">
                    <table id="calclate_gpa_table">
                        <thead>
                            <tr>
                                <td>Course</th>
                                <td>Credit</th>
                                <td>Semester</th>
                                <td>Grade</th>
                                <td>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="course_name" placeholder="Course"></td>
                                <td><input type="text" name="course_credit" placeholder="Credit"></td>
                                <td><input type="text" name="course_semester" placeholder="Semester"></td>
                                <td><input type="text" name="course_grade" placeholder="Grade"></td>
                                <td><button disabled="disabled" class="remove_course" style="margin-top: 0; margin-bottom: 0; cursor: not-allowed;"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><button id="add_new_course"><i class="fas fa-plus"></i> Add Course</button></td>
                                <td><button id="calculate_gpa"><i class="fas fa-calculator"></i> Calculate GPA</button></td>
                                <td><button id="save_new_course"><i class="fas fa-cloud"></i> Save Course </button></td>
                            </tr>
                            <tr>
                                <td>Credits: <b id="total_credits">0.0</b></td>
                                <td>GPA: <b id="current_cgpa">0.00</b></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
        </div>

        <div class="right_sidebar sticky">
            <!-- grading scale -->
            <div class="item">
                <p class="title">Grading Scale</p><hr>
                <div class="box">
                    <table>
                        <thead>
                            <tr>
                                <td>Marks</td>
                                <td>Grade</td>
                                <td>Points</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT grade, points, marks FROM scale";
                                $result = mysqli_query($conn, $sql);
                                while($row = $result->fetch_assoc()) {
                                    $marks = $row["marks"];
                                    $grade = $row["grade"];
                                    $points = $row["points"];

                                    ?>
                                        <tr>
                                            <td><?php echo $marks ?></td>
                                            <td><?php echo $grade ?></td>
                                            <td><?php echo $points ?></td>
                                        </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- top 10 grades -->
            <div class="item">
                <p class="title">Last 10 Grades</p><hr>
                <div class="box">
                    <table>
                        <thead>
                            <tr>
                                <td>Course</td>
                                <td>Credit</td>
                                <td>Semester</td>
                                <td>Grade</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT g.id, g.user, g.course, g.credits, g.semester, g.grade, u.id, u.email
                                FROM grades AS g
                                JOIN users AS u
                                ON g.user = u.id
                                WHERE u.email = '$email'
                                ORDER BY g.semester DESC";
                                
                                $counter = 0;
                                $result = mysqli_query($conn, $sql);
                                
                                if ($result && $result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        if ($counter <= 9) {
                                            $counter = $counter + 1;
                                            $course = $row["course"];
                                            $credits = $row["credits"];
                                            $semster = $row["semester"];
                                            $grade = $row["grade"];
    
                                            ?>
                                                <tr>
                                                    <td><?php echo $course ?></td>
                                                    <td><?php echo $credits ?></td>
                                                    <td><?php echo $semster ?></td>
                                                    <td><?php echo $grade ?></td>
                                                </tr>
                                            <?php
                                        }
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- failed grades -->
            <div class="item">
                <p class="title">Failed Courses</p><hr>
                <div class="box">
                    <table>
                        <thead>
                            <tr>
                                <td>Course</td>
                                <td>Credit</td>
                                <td>Semester</td>
                                <td>Grade</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT g.id, g.user, g.course, g.credits, g.semester, g.grade, u.id, u.email
                                FROM grades AS g
                                JOIN users AS u
                                ON g.user = u.id
                                WHERE g.grade='F'
                                AND u.email = '$email'
                                ORDER BY g.semester DESC";
                                
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $course = $row["course"];
                                        $credits = $row["credits"];
                                        $semster = $row["semester"];
                                        $grade = $row["grade"];

                                        ?>
                                            <tr>
                                                <td><?php echo $course ?></td>
                                                <td><?php echo $credits ?></td>
                                                <td><?php echo $semster ?></td>
                                                <td><?php echo $grade ?></td>
                                            </tr>
                                        <?php
                                    }
                                } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>
</html>