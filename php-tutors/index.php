<?php
session_start();
?>


<html>

<head>
<title>PFS Database Demo</title>
</head>

<body>

<center><h1>PFS Database Demo</h1></center>

<div class="topcorner"><a href="admin-interface.php">Administrators</a></div>

<?php
if($_SESSION['username']){
echo "Username: ". $_SESSION['username'] . ".<br>" . " Logged in!";
}
?>
<p>
<a href="logout.php">Log out</a>
</p>


<p>
<a href="all-teachers.php">List all teachers</a>
</p>

<p>
<a href="all-students.php">List all students</a>
</p>

<p>
<a href="loginscreen.php">Login Page</a>
</p>

<p>
	<a href="admin-upload.php">Administrator Upload</a>
</p>


<p>
The following shows many useful information about your PHP configuration.
</p>
<? phpinfo(); ?>

</body>

<style type="text/css">
 .topcorner{
   position:absolute;
   top:5;
   right:5;
  }
</style>

</html>
