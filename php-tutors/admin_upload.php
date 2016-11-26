<html>
<head><title>Admin Upload</title></head>
<body>
<h1>Upload a Qualtrics CSV</h1>

<a href="admin_home.php">Back to Admin Homepage</a>

	<form enctype="multipart/form-data" action="format-requests.php" method="POST">
  		<input type="file" name="userfile" size="100000" maxlength="200000"> <br>
  		<input type = "submit" name="upload" value="Upload">
	</form>

</body>
</html>