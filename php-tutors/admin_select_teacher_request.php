<?php
   session_start();
?>

<html>
<head><title>Edit</title></head>
<body>
<h1>Edit a Request</h1>

<a href="admin_home.php">Back to Admin Homepage</a>

<!-- <form action="edit-success.php" method="post">
	Request ID: <input type="text" name="request_id"><br><br>
	OR<br><br>

</form> -->
<?php
  try {
    // Including connection info (including database password) from outside
    // the public HTML directory means it is not exposed by the web server,
    // so it is safer than putting it directly in php code:
    include("pdo-tutors.php");
    $dbh = dbconnect();
  } catch (PDOException $e) {
    print "Error connecting to the database: " . $e->getMessage() . "<br/>";
    die();
  }
  try {
    $st = $dbh->query('SELECT * FROM Request, Teacher WHERE teacher_email = email ORDER BY request_id');
    if (($myrow = $st->fetch())) {
?>

<form method="post" action="admin_edit_teacher_request.php">
Select a request below to edit:<br/>
<?php
	echo "<table border='1'><th><td><b>Request ID</b></td><td><b>Teacher Name</b></td><td><b>Teacher Email</b></td><td><b>Day of the Week</b></td><td><b>Start Time</b></td><td><b>End Time</b></td></th>";
      do {
        echo "<tr><td><input type='radio' name='request_id' value='" . $myrow['request_id'] . "'/></td>";
        if($myrow['day'] == 1){
        	$day = 'Monday';
        }
        if($myrow['day'] == 2){
        	$day = 'Tuesday';
        }
		if($myrow['day'] == 3){
        	$day = 'Wednesday';
        }
		if($myrow['day'] == 4){
        	$day = 'Thursday';
        }
		if($myrow['day'] == 5){
        	$day = 'Friday';
        }
        $starttime = date("g:i a", strtotime($myrow["start_time"]));
        $endtime = date("g:i a", strtotime($myrow["end_time"]));
        echo "<td>" . $myrow['request_id'] . "</td><td>" . $myrow['name'] . "</td><td>" . $myrow['teacher_email'] . "</td><td>" . $day . "</td><td>" . $starttime . "</td><td>" . $endtime . "</td></tr>";
      } while ($myrow = $st->fetch());
      
?>
<input type="submit" value="GO!"/>
</form>
<?php
    } else {
      echo "There are no requests in the database.";
    }
  } catch (PDOException $e) {
    print "Database error: " . $e->getMessage() . "<br/>";
    die();
  }
?> 

</body>
</html>