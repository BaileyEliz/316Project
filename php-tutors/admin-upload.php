<html>
<head><title>Admin Upload</title></head>
<body>
<h1>Upload a Qualtrics CSV</h1>

<div class="topcorner"><a href="admin-interface.php">Back to Admin Homepage</a></div>

	<form enctype="multipart/form-data" action="format-requests.php" method="POST">
  		<input type="file" name="userfile" size="100000" maxlength="200000"> <br>
  		<input type = "submit" name="upload" value="Upload">
	</form>

<style type="text/css">
 .topcorner{
   position:absolute;
   top:5;
   right:5;
  }
</style>

</body>
</html>