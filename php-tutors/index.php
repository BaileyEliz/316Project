<?php
session_start();
?>


<html>

<head>
	<title>PFS Database Demo</title>
</head>

<body>

	<center><h1>PFS Database Demo</h1></center>

	<?php
	if($_SESSION['username']){
		echo "Username: ". $_SESSION['username'] . ".<br>" . " Logged in!";
	}
	?>

	<p>
		<a href="homepage.php">Go To Home Page</a>
	</p>

	<p>
		<a href="logout.php">Log out</a>
	</p>


	<p>
		<a href="TEMP_all_teachers.php">List all teachers</a>
	</p>

	<p>
		<a href="TEMP_all_students.php">List all students</a>
	</p>

	<p>
		<a href="loginscreen.php">Login Page</a>
	</p>

	<p>
		<a href="admin_upload.php">Administrator Upload</a>
	</p>


	<p>
		The following shows useful information about your PHP configuration.
	</p>
	<? phpinfo(); ?>

</body>

</html>
