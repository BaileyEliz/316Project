 


<?php
	session_start();
	$user = $_SESSION['username'];
	$a = 'admin';
	if($user!=$a){
		header("Location: loginscreen.php");
	}
?>



<html>
<head><title>Administrators</title></head>
<body>
<h1>Administrator Homepage</h1>

<div class="topcorner"><a href="index.php">Back to Homepage</a></div>

<a href="view-requests.php">View all requests, teachers, and sites</a>

<br><br>

<a href="admin-upload.php">Upload a Qualtrics CSV</a>

<br><br>

<a href="individual-request.php">Add an individual request</a>

<br><br>

<a href="download-table.php">Download tables</a>

<br><br>

<a href="edit-request.php">Edit a request</a>

<br><br>

<a href="delete-all.php">Delete data</a>

<br><br>

<style type="text/css">
 .topcorner{
   position:absolute;
   top:5;
   right:5;
  }
</style>

</body>
</html>