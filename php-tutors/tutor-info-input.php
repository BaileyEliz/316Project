<html>
<head><title>Student Profile</title></head>
<body>
<h1>Add Information</h1>

<div class="topcorner"><a href="loginscreen.php">Back to Login</a></div>

<form action="profile-input.php" method="post">
	Name: <input type="text" name="name" required><br>
	NetID (Username): <input type="text" name="netid" required><br>
	<input type="submit" value="Submit Profile">
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