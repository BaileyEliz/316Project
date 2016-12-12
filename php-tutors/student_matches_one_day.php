<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <link rel="stylesheet" type="text/css" href="style.css">

  <title>Matches</title>
  <?php include_once('student_navbar.php'); ?>
</head>

<body>

  <?php

  session_start();
  $user = "generic";
  if($_SESSION['username']) {
    $user = $_SESSION['username'];
  }else{
      	 header("Location: student_login.php");

      }

  if (!isset($_POST['day'])) {
    echo "Specify a day. Please <a href='student_matches_all_days.php'>try again</a>.";
    die();
  }
  if (!isset($_POST['student'])) {
    echo "Specify a student. Please <a href='student_login.php'>try again</a>.";
    die();
  }
  $day = $_POST['day'];
  $student = $_POST['student'];

  include 'php-functions.php';
  ?>

  <?php 
	//$day = 1; 
	//$student = "Bailey Wall";
  ?>

  <h1>Student Information: <?= $student ?></h1>
  <a href="student_matches_all_days.php">Back to All Matches</a>
  <p></p>

  <!-- Bootstrap Framework -->

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-1">O'Clock
        <div class="row time_row"><div class="col-md-12"><div class="time">8:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">8:30</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">9:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">9:30</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">10:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">10:30</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">11:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">11:30</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">12:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">12:30</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">1:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">1:30</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">2:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">2:30</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">3:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">3:30</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">4:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">4:30</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">5:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">5:30</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">6:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">6:30</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">7:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">7:30</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">8:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">8:30</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">9:00</div></div></div>
        <div class="row time_row"><div class="col-md-12"><div class="time">9:30</div></div></div>
      </div>
      <div class="col-md-11">
       <?php
       echo print_day($day);
       ?>
       <div class="row">
        <div class="col-md-12">
          <div class="monday-contents"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

try {
  include("pdo-tutors.php");
  $dbh = dbconnect();
} catch (PDOException $e) {
  print "Error connecting to the database: " . $e->getMessage() . "<br/>";
  die();
}

try {
  $weekdays = $dbh->prepare(
    "SELECT TutorInfo.name, Teacher.name, Teacher.site_name, Request.day, Request.start_time, Request.end_time, Request.teacher_email, Request.num_tutors, Request.request_id 
    FROM Request, TutorAvailable, Teacher, TutorInfo
    WHERE Request.day = ? and TutorInfo.tutor_id = ? and TutorInfo.name = ? and TutorInfo.tutor_id = TutorAvailable.tutor_id and TutorAvailable.day = Request.day and Request.teacher_email = Teacher.email and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time and Request.is_hidden IS FALSE
    ORDER BY Request.start_time");

   $bookings = $dbh->prepare(
        "SELECT TutorInfo.name, Teacher.name, Teacher.site_name, Request.day, Request.start_time, Request.end_time, Request.teacher_email, Request.num_tutors, Request.request_id 
        FROM Request, Bookings, Teacher, TutorInfo
        WHERE Request.day = ? and TutorInfo.tutor_id = ? and TutorInfo.name = ? and TutorInfo.tutor_id = Bookings.tutor_id and Bookings.day = Request.day and Bookings.teacher_email = Request.teacher_email and Request.teacher_email = Teacher.email and Bookings.start_time = Request.start_time and Bookings.end_time = Request.end_time and Request.is_hidden IS FALSE
        ORDER BY Request.start_time");

  $weekdays->execute(array($day, $user, $student));
  $day_sessions = $weekdays->fetchAll(PDO::FETCH_ASSOC);

  $bookings->execute(array($day, $user, $student));
  $day_bookings = $bookings->fetchAll(PDO::FETCH_ASSOC);

  $number_of_tutors = $dbh->prepare(
        "SELECT Request.day, Request.start_time, Request.end_time, Request.teacher_email, Request.num_tutors, Request.request_id, Bookings.tutor_id 
        FROM Request, Bookings
        WHERE Bookings.teacher_email = ? and Bookings.day = ? and Bookings.start_time = ? and Bookings.end_time = ? and Bookings.teacher_email = Request.teacher_email and Bookings.day = Request.day and Bookings.start_time = Request.start_time and Bookings.end_time = Request.end_time and Request.is_hidden IS FALSE
        ORDER BY Request.start_time");

} catch (PDOException $e) {
  print "Database error: " . $e->getMessage() . "<br/>";
  die();
}

  //echo count($day_sessions);

?>

<!-- Display the data on the screen. Functions called in php-functions.php. -->

<?php

echo "$daily_times";

$daily_times = all_times($day_sessions);
$daily_maximum = daily_maximum($daily_times, $day_sessions);
$daily_layout = blank_layout($daily_maximum);

	//echo $daily_times;

for ($i = 0; $i < count($day_sessions); $i++){
  $number_of_tutors->execute(array($day_sessions[$i]['teacher_email'], $day_sessions[$i]['day'], $day_sessions[$i]['start_time'], $day_sessions[$i]['end_time']));
  $num_tutors = $number_of_tutors->fetchAll(PDO::FETCH_ASSOC);
  $tutors_booked = count($num_tutors);
  echo "tutors booked: " . $tutors_booked . "<br>";

  echo html_print((($x * 100) + $i), $day_sessions[$i]);
  $returns = css_print($daily_maximum, $daily_layout, $daily_times, $i, $day_sessions[$i], "monday", $day_bookings, $tutors_booked);
  echo $returns[0];
  $daily_layout = $returns[1];
}

?>

</body>
</html>