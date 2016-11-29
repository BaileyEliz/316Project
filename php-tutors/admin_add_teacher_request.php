<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Admin Upload</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>
<h1>Add a Request</h1>

<a href="admin_home.php">Back to Admin Homepage</a>

<form class='form-horizontal' action="admin_edit_teacher_request_success.php" method="post" id="requestform">
	<div class="form-group">
		<div class="col-xs-4">
			<label for="name">Name:</label>
		 	<input type="text" class="form-control" name="name" required>
		 </div>
	</div>
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
	Description:<br><textarea rows="4" cols="30" name="description" form="requestform"></textarea><br>
	<input type="submit" value="Submit Request">
</form>

</body>
</html>