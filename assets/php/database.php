<?php ob_start();
	if(session_status()== PHP_SESSION_NONE) {
		session_start();
	} if(session_id()=='') {
		session_start();
	}

	$conn = mysqli_connect('localhost', 'root', '');
	$db = mysqli_select_db($conn, 'calculator');

	$check_users_table = mysqli_query($conn, 'select 1 from `users`');
	$check_grades_table = mysqli_query($conn, 'select 1 from `grades`');
	$check_scale_table = mysqli_query($conn, 'select 1 from `scale`');

	if ( $check_users_table == FALSE ) {
		$create_users_table = "CREATE TABLE users (
			id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(100) NOT NULL,
			email VARCHAR(100) NOT NULL,
			password VARCHAR(100) NOT NULL
		)";

		if (!mysqli_query($conn, $create_users_table)) {
			echo "Error found on users table! Please try again later. <br>";
		}
	}

	if ( $check_grades_table == FALSE ) {
		$check_grades_table = "CREATE TABLE grades (
			id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			user VARCHAR(100) NOT NULL,
			course VARCHAR(100) NOT NULL,
			credits VARCHAR(100) NOT NULL,
			semester VARCHAR(100) NOT NULL,
			grade VARCHAR(100) NOT NULL
		)";

		if (!mysqli_query($conn, $check_grades_table)) {
			echo "Error found on grades table! Please try again later. <br>";
		}
	}

	if ( $check_scale_table == FALSE ) {
		$check_scale_table = "CREATE TABLE scale (
			grade VARCHAR(100) NOT NULL,
			points VARCHAR(100) NOT NULL,
			marks VARCHAR(100) NOT NULL
		)";

		if (!mysqli_query($conn, $check_scale_table)) {
			echo "Error found on scale table! Please try again later. <br>";
		}
	}
?>