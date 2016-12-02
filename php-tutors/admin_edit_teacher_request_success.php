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
    <?php include_once('admin_navbar.php'); ?>
  </head>
<body>
<h1>Edit a Request</h1>

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
  $st = $dbh->prepare("UPDATE Request SET day = ?, grade_level = ?, start_time = ?, end_time = ?, teacher_email = ?, num_tutors = ?, language = ?, description = ?, is_hidden = ? WHERE request_id = ?");

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

  if($_POST["is_hidden"] == "Yes"){
    $values[] = "TRUE";
  } else {
    $values[] = "FALSE";
  }
  
  $values[] = $_SESSION["request_id"];

  try{
  	$st->execute($values);
    echo "<h4>The request has been updated.</h4>";
  }  catch (PDOException $e){
    echo $e->getMessage() . "<br/>";
    echo "<h4>The request was not updated properly.</h4>";
  }
?>

<table class='table table-striped table-bordered'>
  <th>Request ID</th><th>Teacher Name</th><th>Teacher Email</th><th>Site</th><th>Grade Level</th><th>Day of the Week</th><th>Start Time</th><th>End Time</th><th># of Tutors</th><th>Language</th><th>Description</th><th>Is Hidden</th>
  <tr>
    <td><?php echo $_SESSION["request_id"];?></td>
    <td><?php echo $_SESSION["name"];?></td>
    <td><?php echo $_SESSION["teacher_email"];?></td>
    <td><?php echo $_SESSION["site_name"];?></td>
    <td><?php echo $_POST["grade_level"];?></td>
    <td><?php echo $_POST["day_of_week"]?></td>
    <td><?php echo (date("g:i a", strtotime($_POST["start_time"])));?></td>
    <td><?php echo (date("g:i a", strtotime($_POST["end_time"])));?></td>
    <td><?php echo $_POST["num_tutors"]?></td>
    <td><?php echo $_POST["language"];?></td>
    <td><?php echo $_POST["description"];?></td>
    <td><?php echo $_POST["is_hidden"]; ?></td>
  </tr>
</table>

<a href="admin_select_teacher_request.php">Back to Choose a Request</a>
<br>

</body>
</html>