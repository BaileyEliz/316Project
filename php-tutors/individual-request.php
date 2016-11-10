<html>
<head><title>Request</title></head>
<body>
<h1>Add a Request</h1>

<form action="request-success.php" method="post">
	Name: <input type="text" name="name" required><br>
	Email: <input type="email" name="email" required><br>
	School: <input type="text" name="school" required><br><br>
	Request<br><br>
	Day of the Week: <select name="day_of_week">
		<option value="monday">Monday</option>
		<option value="tuesday">Tuesday</option>
		<option value="wednesday">Wednesday</option>
		<option value="thursday">Thursday</option>
		<option value="friday">Friday</option>
	</select><br>
	Start Time: <input type="time" name="start_time" required><br> <!-- type time doesn't work with Firefox or IE10 and earlier-->
	End Time: <input type="time" name="end_time" required><br>
	Grade Level: <select name="grade_level">
		<option value="prek">Pre-K</option>
		<option value="k">Kindergarten</option>
		<option value="1">1st Grade</option>
		<option value="2">2nd Grade</option>
		<option value="3">3rd Grade</option>
		<option value="4">4th Grade</option>
		<option value="5">5th Grade</option>
		<option value="6">6th Grade</option>
		<option value="7">7th Grade</option>
		<option value="8">8th Grade</option>
		<option value="9">9th Grade</option>
		<option value="10">10th Grade</option>
		<option value="11">11th Grade</option>
		<option value="12">12th Grade</option>
	</select><br>
	Language: <select name="language">
		<option value="none">None</option>
		<option value="arabic">Arabic</option>
		<option value="chinese">Chinese</option>
		<option value="french">French</option>
		<option value="german">German</option>
		<option value="japanese">Japanese</option>
		<option value="spanish">Spanish</option>
	</select><br>
	Number of Tutors: <input type="number" name="num_tutors" min="1" max="10" step="1" value="1" required><br>
	<br>
	<input type="submit" value="Submit Request">
</form>

</body>
</html>