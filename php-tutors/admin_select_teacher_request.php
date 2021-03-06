<?php
      session_start();
      $user = $_SESSION['username'];
      $a = 'admin';
      if($user!=$a){
        header("Location: admin_login.php");
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Edit Request</title>

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
      <div class="container">
        <div class="text-center">
          <h1>Edit a Request</h1>
          <h4>Warning: Editing a request will remove it from students' bookings.</h4>
          <br>
        </div>

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
  $teacher_st = $dbh->query('SELECT * FROM Teacher');
  if (($myrow = $teacher_st->fetch())) {
    ?>

    <h4>Select a teacher below to hide all of their requests:</h4>
    <form method="post" action="admin_hide_teacher_request.php">

      <?php
      echo "<table class='table table-striped table-bordered table-hover'><th><td><b>Name</b></td><td><b>Site</b></td><td><b>Is Hidden</b></td></th>";
      do {
        echo "<tr><td><input type='radio' name='teacher_name' value='" . $myrow['name'] . "'/></td>";
        echo "<td>" . $myrow['name'] . "</td><td>" . $myrow['site_name'] . "</td>";
        if ($myrow['is_hidden']) {
          echo "<td>Yes</td></tr>";
        } else {
          echo "<td>No</td></tr>";
        }
      } while ($myrow = $teacher_st->fetch());
      echo "</table>";
      
      ?>
      
      <input class='btn btn-primary' type="submit" value="SELECT"/>
    </form>

  <?php
  }

  $st = $dbh->query('SELECT * FROM Request, Teacher WHERE teacher_email = email ORDER BY request_id');
  if (($myrow = $st->fetch())) {
    ?>

    <br>
    <h4>Select a request below to edit:</h4>
    <form method="post" action="admin_edit_teacher_request.php">
      <?php
      echo "<table class='table table-striped table-bordered table-hover'><th><td><b>Request ID</b></td><td><b>Teacher Name</b></td><td><b>Teacher Email</b></td><td><b>Site</b></td><td><b>Grade Level</b></td><td><b>Day of the Week</b></td><td><b>Start Time</b></td><td><b>End Time</b></td><td><b># of Tutors</b></td><td><b>Language</b></td><td><b>Description</b></td><td><b>Is Hidden</b></td></th>";
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
        echo "<td>" . $myrow['request_id'] . "</td><td>" . $myrow['name'] . "</td><td>" . $myrow['teacher_email'] . "</td><td>" . $myrow['site_name'] . "</td><td>" . $myrow['grade_level'] . "</td><td>" . $day . "</td><td>" . $starttime . "</td><td>" . $endtime . "</td><td>" . $myrow['num_tutors'] . "</td><td>" . $myrow['language'] . "</td><td>" . $myrow['description'] . "</td>";
        if ($myrow['is_hidden']) {
          echo "<td>Yes</td></tr>";
        } else {
          echo "<td>No</td></tr>";
        }
      } while ($myrow = $st->fetch());
      echo "</table>";
      
      ?>
      <input class='btn btn-primary' type="submit" value="SELECT"/>
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
</div>
</body>
</html>