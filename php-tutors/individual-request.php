<html>
<head><title>Request</title></head>
<body>
<h1>Add a Request</h1>

<div class="topcorner"><a href="admin-interface.php">Back to Admin Homepage</a></div>

<form action="request-success.php" method="post">
	Name: <input type="text" name="name" required><br>
	Email: <input type="email" name="email" required><br>
	School: <input type="text" name="school" required><br><br>
	Request<br><br>
	Day of the Week: <select name="day_of_week">
		<option value="Monday">Monday</option>
		<option value="Tuesday">Tuesday</option>
		<option value="Wednesday">Wednesday</option>
		<option value="Thursday">Thursday</option>
		<option value="Friday">Friday</option>
	</select><br>
	Start Time: <input type="time" name="start_time" required><br> <!-- type time doesn't work with Firefox or IE10 and earlier-->
	End Time: <input type="time" name="end_time" required><br>
	Grade Level: <input type="text" name="grade_level"><br>
	Language: <select name="language">
		<option value="None">None</option>
		<option value="Arabic">Arabic</option>
		<option value="Chinese">Chinese</option>
		<option value="French">French</option>
		<option value="German">German</option>
		<option value="Japanese">Japanese</option>
		<option value="Spanish">Spanish</option>
	</select><br>
	Number of Tutors: <input type="number" name="num_tutors" min="1" max="10" step="1" value="1" required><br>
	<br>
	<input type="submit" value="Submit Request">
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