<?php
   session_start();
?>

<html>
<head><title>Edit</title></head>
<body>
<h1>Edit a Request</h1>

<div class="topcorner"><a href="admin-interface.php">Back to Admin Homepage</a></div>

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
  $st = $dbh->prepare("UPDATE Request SET day = ?, grade_level = ?, start_time = ?, end_time = ?, teacher_email = ?, num_tutors = ?, language = ?, description = ? WHERE request_id = ?");
  $values = array();
  if($_POST["day_of_week"] == "Monday"){
    $day = 1;
  }
  if($_POST["day_of_week"] == "Tuesday"){
    $day = 2;
  }
  if($_POST["day_of_week"] == "Wednesday"){
    $day = 3;
  }
  if($_POST["day_of_week"] == "Thursday"){
    $day = 4;
  }
  if($_POST["day_of_week"] == "Friday"){
    $day = 5;
  }

  $values[] = $day;
  $values[] = $_POST["grade_level"];
  $values[] = $_POST["start_time"];
  $values[] = $_POST["end_time"];
  $values[] = $_SESSION["teacher_email"];
  $values[] = $_POST["num_tutors"];
  $values[] = $_POST["language"];
  $values[] = $_POST["description"];
  $values[] = $_SESSION["request_id"];

  try{
  	$st->execute($values);
    echo "The request has been updated.";
  }  catch (PDOException $e){
    echo $e->getMessage() . "<br/>";
    echo "The request was not updated properly!";
  }
?>
<br><br>
<a href="edit-request.php">Back to Choose a Request</a> 
<style type="text/css">
 .topcorner{
   position:absolute;
   top:5;
   right:5;
  }
</style>

</body>
</html>