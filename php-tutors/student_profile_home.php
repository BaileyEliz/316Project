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
    <?php
      session_start();
      $user = "generic";
      if($_SESSION['username']) {
        $user = $_SESSION['username'];
      }else{
      	 header("Location: student_login.php");
      }

      include 'php-functions.php';

      try {
        include("pdo-tutors.php");
        $dbh = dbconnect();
      } catch (PDOException $e) {
        print "Error connecting to the database: " . $e->getMessage() . "<br/>";
        die();

    }
    
    $statement = $dbh->prepare("SELECT * FROM TutorInfo WHERE tutor_id = ?");
    $statement->bindParam(1, $user);
    try{
      $statement->execute();
      if(($myrow = $statement->fetch())){
        $student_name = $myrow["name"];
      }
    }catch (PDOException $e){
      echo "Error: " . $e;
    }
    
    ?>

    <h1 class="text-center">Student Profile</h1>

    <h2 class="text-center">Student Information</h2>

    <div class="name text-center">
      <h4>Student Name: <?= $student_name?></h4>
      <h4>Student ID: <?= $user?></h4>
      <br>
    </div>

    <div class="text-center">
      <h2>Availability</h2> 
      <a href="student_availability_edit.php" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add Availability</a>
    </div>
    <br>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-1">O'Clock
          <div class="row"><div class="col-md-12"><div class="mini_time">8:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">8:30</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">9:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">9:30</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">10:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">10:30</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">11:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">11:30</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">12:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">12:30</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">1:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">1:30</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">2:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">2:30</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">3:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">3:30</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">4:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">4:30</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">5:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">5:30</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">6:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">6:30</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">7:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">7:30</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">8:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">8:30</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">9:00</div></div></div>
          <div class="row"><div class="col-md-12"><div class="mini_time">9:30</div></div></div>
        </div>
        <div class="col-md-2">Monday
          <div class="row">
            <div class="col-md-12">
              <div class="monday-contents"></div>
            </div>
          </div>
        </div>
        <div class="col-md-2">Tuesday
          <div class="row">
            <div class="col-md-12">
              <div class="tuesday-contents"></div>
            </div>
          </div>
        </div>
        <div class="col-md-2">Wednesday
          <div class="row">
            <div class="col-md-12">
              <div class="wednesday-contents"></div>
            </div>
          </div>
        </div>
        <div class="col-md-2">Thursday
          <div class="row">
            <div class="col-md-12">
              <div class="thursday-contents"></div>
            </div>
          </div>
        </div>
        <div class="col-md-2">Friday
          <div class="row">
            <div class="col-md-12">
              <div class="friday-contents"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php 

    try {
      $stmt = $dbh->prepare(
        "SELECT TutorAvailable.start_time, TutorAvailable.end_time
        FROM TutorAvailable
        WHERE TutorAvailable.tutor_id = ? and TutorAvailable.day = ?");

      $stmt->execute(array($user, 1));
      $monday = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $stmt->execute(array($user, 2));
      $tuesday = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $stmt->execute(array($user, 3));
      $wednesday = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $stmt->execute(array($user, 4));
      $thursday = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $stmt->execute(array($user, 5));
      $friday = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      print "Database error: " . $e->getMessage() . "<br/>";
      die();
    }

    $weekdaze = array($monday, $tuesday, $wednesday, $thursday, $friday);
    $weekdaze_names = array("monday", "tuesday", "wednesday", "thursday", "friday");

    for ($x = 0; $x < count($weekdaze); $x++) {
      for ($i = 0; $i < count($weekdaze[$x]); $i++) {
        echo simple_html_print((($x * 100) + $i), $weekdaze[$x][$i]) . "<br/>";
        echo simple_css_print((($x * 100) + $i), $weekdaze[$x][$i], $weekdaze_names[$x]);
      }
    }

    ?>
    <div class="text-center">
      <h2>Bookings</h2>
      <a href="student_matches_all_days.php" class="btn btn-warning"><span class="glyphicon glyphicon-eye-open"></span> View Matches</a>
    </div>
    <br><br>

    <?php
    $statement = $dbh->prepare("SELECT * FROM Bookings, Teacher WHERE Bookings.tutor_id = ? AND Teacher.email = Bookings.teacher_email");
    try{
      $statement->bindParam(1, $user);
      $statement->execute();
      if($row = $statement->fetch()){
        echo "<table class='table table-striped table-bordered'><th>Day</th><th>Start Time</th><th>End Time</th><th>School</th><th>Teacher</th><th>Teacher Email</th><th>Approved?</th>";
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
          echo "<td>" . $isApproved . "</td></tr>";
        } while($row = $statement->fetch());
        echo "</table>";

      }
    } catch (PDOException $e){
      echo "Error" . $e;
    }
    
    ?>

    <br>
    <br>
  </div>
</body>
</html>