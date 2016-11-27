<?php
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Edit</title>

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
<h1>Edit a Request</h1>
<a href="admin_select_teacher_request.php">Back to Choose a Request</a>
<br>

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
  	$request_id = $_POST["request_id"];
  	$_SESSION["request_id"] = $request_id;
	$statement = $dbh->prepare('SELECT * FROM Request, Teacher WHERE request_id = ? AND teacher_email = email');
	$statement->bindParam(1, $request_id);
  try {
    //$st = $dbh->query('SELECT * FROM Request, Teacher WHERE ');
    $statement->execute();
    if ($myrow = $statement->fetch()) {
    	echo "Name: " . $myrow["name"] . "<br>";
     	echo "Email: " . $myrow["teacher_email"] . "<br>";
     	$_SESSION['teacher_email'] = $myrow["teacher_email"];
     	echo "School: " . $myrow["site_name"] . "<br><br>";
  		echo "Edit Request<br><br>";
  		if($myrow["day"] == 1){
  			$day = 'Monday';
  			$selected = 1;
  		}
  		if($myrow["day"] == 2){
  			$day = 'Tuesday';
  			$selected = 2;
  		}
  		if($myrow["day"] == 3){
  			$day = 'Wednesday';
  			$selected = 3;
  		}
  		if($myrow["day"] == 4){
  			$day = 'Thursday';
  			$selected = 4;
  		}
  		if($myrow["day"] == 5){
  			$day = 'Friday';
  			$selected = 5;
  		}
  		?>
  		<form method="post" action="admin_edit_teacher_request_success.php" id="editform">
  			Day of the Week: <select name="day_of_week">
			<option <?php if($selected == 1){echo ("selected");}?> value="Monday">Monday</option>
			<option <?php if($selected == 2){echo ("selected");}?> value="Tuesday">Tuesday</option>
			<option <?php if($selected == 3){echo ("selected");}?> value="Wednesday">Wednesday</option>
			<option <?php if($selected == 4){echo ("selected");}?> value="Thursday">Thursday</option>
			<option <?php if($selected == 5){echo ("selected");}?> value="Friday">Friday</option>
			</select><br>
		Start Time: <input type="time" name="start_time" value="<?php echo $myrow['start_time']; ?>" required><br>
		End Time: <input type="time" name="end_time" value="<?php echo $myrow['end_time']; ?>" required><br>
  		Grade Level: <input type="text" name="grade_level" value="<?php echo $myrow['grade_level']; ?>"><br>
  		Language: <input type="text" name="language" value="<?php echo $myrow['language']; ?>"/><br>
		Number of Tutors: <input type="number" name="num_tutors" min="1" max="10" step="1" value="<?php echo $myrow['num_tutors']; ?>" required><br>
    Description:<br>
    <textarea rows="4" cols="30" name="description" form="editform"><?php echo $myrow['description']; ?></textarea><br>
		<input type="submit" value="Update Request"><br><br>
  		<?php
    }
 } catch (PDOException $e) {
 	echo "hi";
     print "Database error: " . $e->getMessage() . "<br/>";
     die();
   }
?> 

<script type="text/javascript">
function checkvalue(val) {
    if(val==="Other")
       document.getElementById('language').style.display='block';
    else
       document.getElementById('language').style.display='none'; 
}
</script>

</body>
</html>