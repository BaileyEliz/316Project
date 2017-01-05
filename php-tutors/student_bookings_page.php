<?php
      session_start();
      $user = "generic";
      if($_SESSION['username']) {
        $user = $_SESSION['username'];
      }else{
      	 header("Location: student_login.php");

      }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Student Home</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <link rel="stylesheet" type="text/css" href="style.css">
  <?php include_once('student_navbar.php'); ?>
</head>
<body>
  <div class="container">
    <div class="text-center">
      <h1>Bookings</h1>
      <h3>Current Bookings</h3>
    </div>
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
    $statement = $dbh->prepare("SELECT * FROM Bookings, Teacher WHERE Bookings.tutor_id = ? AND Teacher.email = Bookings.teacher_email");
    try{
      $statement->bindParam(1, $user);
      $statement->execute();
      if($row = $statement->fetch()){
        echo "<table class='table table-striped table-bordered'><th>Day</th><th>Start Time</th><th>End Time</th><th>School</th><th>Teacher</th><th>Teacher Email</th><th>Need Van Transportation?</th><th>Approved?</th>";
        do{
          if($row["day"] == 1){
            $day = "Monday";
          }
          if($row["day"] == 2){
            $day = "Tuesday";
          }
          if($row["day"] == 3){
            $day = "Wednesday";
          }
          if($row["day"] == 4){
            $day = "Thursday";
          }
          if($row["day"] == 5){
            $day = "Friday";
          }
          $needsVan = "No";
          if($row["needs_van"] == "true"){
            $needsVan = "Yes";
          }
          $isApproved = "No";
          if($row["isapproved"] == "true"){
            $isApproved = "Yes";
          }
          $starttime = date("g:i a", strtotime($row["start_time"]));
          $endtime = date("g:i a", strtotime($row["end_time"]));
          echo "<tr><td>" . $day . "</td>";
          echo "<td>" . $starttime . "</td>";
          echo "<td>" . $endtime . "</td>";
          echo "<td>" . $row["site_name"] . "</td>";
          echo "<td>" . $row["name"] . "</td>";
          echo "<td>" . $row["teacher_email"] . "</td>";
          echo "<td>" . $needsVan . "</td>";
          echo "<td>" . $isApproved . "</td></tr>";
        } while($row = $statement->fetch());
        echo "</table>";

      }
    } catch (PDOException $e){
      echo "Error" . $e;
    }
    ?>
    <div class="text-center">
      <h3>Matches</h3>

      <a href="student_matches_all_days.php" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-eye-open"></span> View Matches</a>
    </div>
    <br><br>
  </div>
</body>
</html>
