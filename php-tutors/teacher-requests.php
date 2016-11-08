<html>
<head><title>Teacher Requests</title></head>
<body>
<h1>Teacher Requests</h1>

<form action="request-success.php" method="post">
	Name: <input type="text" name="name"><br>
	Email: <input type="text" name="email"><br>
	School: <input type="text" name="school"><br><br>
	Request 1<br><br>
	Day of the Week: <select name="day_of_week">
		<option value="monday">Monday</option>
		<option value="tuesday">Tuesday</option>
		<option value="wednesday">Wednesday</option>
		<option value="thursday">Thursday</option>
		<option value="friday">Friday</option>
	</select><br>
	Start Time: <input type="time" name="start_time"><br> <!-- type time doesn't work with Firefox or IE10 and earlier-->
	End Time: <input type="time" name="end_time"><br>
	<input type="submit" value="Submit Request">
</form>

</body>
</html>

