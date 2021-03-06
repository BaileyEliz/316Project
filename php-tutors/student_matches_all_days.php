<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- jQuery -->
  <script src="jquery-3.1.1.min.js"></script>

  <?php include_once('student_navbar.php');

      session_start();
      $user = "generic";
      if($_SESSION['username']) {
        $user = $_SESSION['username'];
      }else{
      	 header("Location: student_login.php");
      }

  try {
    include("pdo-tutors.php");
    $dbh = dbconnect();
  } catch (PDOException $e) {
    print "Error connecting to the database: " . $e->getMessage() . "<br/>";
    die();
  }

  $student_selector = $dbh->prepare(
    "SELECT TutorInfo.name
    FROM TutorInfo
    WHERE TutorInfo.tutor_id = ?");
  $student_selector->execute(array($user));
  $student_values = $student_selector->fetchAll(PDO::FETCH_ASSOC);
  $student = $student_values[0]["name"];

      //TEMP keep this so all students still works; take it out when dev is done
  if (isset($_POST['student'])) {
    $student = $_POST['student'];
  }

  include 'php-functions.php';
  ?>

  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Matches</title></head>
  <body>

    <h1>Student Information: <?=$student ?></h1>
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
        <div class="col-md-2">
          <div class="day-title">
            <form id="monday-form" action="student_matches_one_day.php" method="post">
              <input name="day" type="hidden" value=1 />
              <?php echo "<input name='student' type='hidden' value='" . $student . "' />"; ?>
              <a href="#" onclick="document.getElementById('monday-form').submit();">Monday</a>
            </form>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="monday-contents"></div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="day-title">
            <form id="tuesday-form" action="student_matches_one_day.php" method="post">
              <input name="day" type="hidden" value=2 />
              <?php echo "<input name='student' type='hidden' value='" . $student . "' />"; ?>
              <a href="#" onclick="document.getElementById('tuesday-form').submit();">Tuesday</a>
            </form>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="tuesday-contents"></div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="day-title">
            <form id="wednesday-form" action="student_matches_one_day.php" method="post">
              <input name="day" type="hidden" value=3 />
              <?php echo "<input name='student' type='hidden' value='" . $student . "' />"; ?>
              <a href="#" onclick="document.getElementById('wednesday-form').submit();">Wednesday</a>
            </form>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="wednesday-contents"></div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="day-title">
            <form id="thursday-form" action="student_matches_one_day.php" method="post">
              <input name="day" type="hidden" value=4 />
              <?php echo "<input name='student' type='hidden' value='" . $student . "' />"; ?>
              <a href="#" onclick="document.getElementById('thursday-form').submit();">Thursday</a>
            </form>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="thursday-contents"></div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="day-title">
            <form id="friday-form" action="student_matches_one_day.php" method="post">
              <input name="day" type="hidden" value=5 />
              <?php echo "<input name='student' type='hidden' value='" . $student . "' />"; ?>
              <a href="#" onclick="document.getElementById('friday-form').submit();">Friday</a>
            </form>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="friday-contents"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Get values from database -->

    <?php

    try {
      $st = $dbh->prepare(
        "SELECT TutorInfo.name, Teacher.name, Teacher.site_name, Request.day, Request.start_time, Request.end_time, Request.request_id
        FROM Request, TutorAvailable, Teacher, TutorInfo
        WHERE TutorInfo.name = ? and TutorInfo.tutor_id = ? and TutorInfo.tutor_id = TutorAvailable.tutor_id and TutorAvailable.day = Request.day and Request.teacher_email = Teacher.email and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time
        ORDER BY Request.day, Request.start_time");
      $st->execute(array($student, $user));
      $values = $st->fetchAll(PDO::FETCH_ASSOC);
      if ($st->rowCount() == 0) {
        die('There are no matches for ' . $student . ' in the database.');
      }

      $weekdays = $dbh->prepare(
        "SELECT TutorInfo.name, Teacher.name, Teacher.site_name, Request.day, Request.start_time, Request.end_time, Request.teacher_email, Request.num_tutors, Request.request_id, Site.transportation 
        FROM Request, TutorAvailable, Teacher, TutorInfo, Site
        WHERE Request.day = ? and TutorInfo.tutor_id = ? and TutorInfo.name = ? and TutorInfo.tutor_id = TutorAvailable.tutor_id and TutorAvailable.day = Request.day and Request.teacher_email = Teacher.email and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time and Site.name = Teacher.site_name and Request.is_hidden IS FALSE and Teacher.is_hidden IS FALSE
        ORDER BY Request.start_time");

      $bookings = $dbh->prepare(
        "SELECT TutorInfo.name, Teacher.name, Teacher.site_name, Request.day, Request.start_time, Request.end_time, Request.teacher_email, Request.num_tutors, Request.request_id 
        FROM Request, Bookings, Teacher, TutorInfo
        WHERE Request.day = ? and TutorInfo.tutor_id = ? and TutorInfo.name = ? and TutorInfo.tutor_id = Bookings.tutor_id and Bookings.day = Request.day and Bookings.teacher_email = Request.teacher_email and Request.teacher_email = Teacher.email and Bookings.start_time = Request.start_time and Bookings.end_time = Request.end_time and Request.is_hidden IS FALSE
        ORDER BY Request.start_time");

      $weekdays->execute(array(1, $user, $student));
      $monday = $weekdays->fetchAll(PDO::FETCH_ASSOC);

      $bookings->execute(array(1, $user, $student));
      $monday_bookings = $bookings->fetchAll(PDO::FETCH_ASSOC);

      $weekdays->execute(array(2, $user, $student));
      $tuesday = $weekdays->fetchAll(PDO::FETCH_ASSOC);

      $bookings->execute(array(2, $user, $student));
      $tuesday_bookings = $bookings->fetchAll(PDO::FETCH_ASSOC);

      $weekdays->execute(array(3, $user, $student));
      $wednesday = $weekdays->fetchAll(PDO::FETCH_ASSOC);

      $bookings->execute(array(3, $user, $student));
      $wednesday_bookings = $bookings->fetchAll(PDO::FETCH_ASSOC);

      $weekdays->execute(array(4, $user, $student));
      $thursday = $weekdays->fetchAll(PDO::FETCH_ASSOC);

      $bookings->execute(array(4, $user, $student));
      $thursday_bookings = $bookings->fetchAll(PDO::FETCH_ASSOC);

      $weekdays->execute(array(5, $user, $student));
      $friday = $weekdays->fetchAll(PDO::FETCH_ASSOC);

      $bookings->execute(array(5, $user, $student));
      $friday_bookings = $bookings->fetchAll(PDO::FETCH_ASSOC);

      $number_of_tutors = $dbh->prepare(
        "SELECT Request.day, Request.start_time, Request.end_time, Request.teacher_email, Request.num_tutors, Request.request_id, Bookings.tutor_id 
        FROM Request, Bookings
        WHERE Bookings.teacher_email = ? and Bookings.day = ? and Bookings.start_time = ? and Bookings.end_time = ? and Bookings.teacher_email = Request.teacher_email and Bookings.day = Request.day and Bookings.start_time = Request.start_time and Bookings.end_time = Request.end_time and Request.is_hidden IS FALSE
        ORDER BY Request.start_time");

    } catch (PDOException $e) {
      print "Database error: " . $e->getMessage() . "<br/>";
      die();
    }

    ?>

    <!-- Display the data on the screen. Functions called in php-functions.php. -->

    <?php

    $weekdaze = array($monday, $tuesday, $wednesday, $thursday, $friday);
    $day_bookings = array($monday_bookings, $tuesday_bookings, $wednesday_bookings, $thursday_bookings, $friday_bookings);
    $weekdaze_names = array("monday", "tuesday", "wednesday", "thursday", "friday");

    $weekdaze_times = array(all_times($monday), all_times($tuesday), all_times($wednesday), all_times($thursday), all_times($friday));
    $weekdaze_maximums = array(
      daily_maximum($weekdaze_times[0], $monday),
      daily_maximum($weekdaze_times[1], $tuesday),
      daily_maximum($weekdaze_times[2], $wednesday),
      daily_maximum($weekdaze_times[3], $thursday),
      daily_maximum($weekdaze_times[4], $friday));
    $weekdaze_layouts = array(
      blank_layout($weekdaze_maximums[0]), 
      blank_layout($weekdaze_maximums[1]), 
      blank_layout($weekdaze_maximums[2]), 
      blank_layout($weekdaze_maximums[3]), 
      blank_layout($weekdaze_maximums[4]));

    for ($x = 0; $x < count($weekdaze); $x++) {
      $day_array = $weekdaze[$x];
      $day_name = $weekdaze_names[$x];
      $daily_maximum = $weekdaze_maximums[$x];
      for ($i = 0; $i < count($day_array); $i++){
        $number_of_tutors->execute(array($day_array[$i]['teacher_email'], $day_array[$i]['day'], $day_array[$i]['start_time'], $day_array[$i]['end_time']));
        $num_tutors = $number_of_tutors->fetchAll(PDO::FETCH_ASSOC);
        $tutors_booked = count($num_tutors);

        echo html_print((($x * 100) + $i), $day_array[$i]);
        $returns = css_print($daily_maximum, $weekdaze_layouts[$x], $weekdaze_times[$x], (($x * 100) + $i), $day_array[$i], $day_name, $day_bookings[$x], $tutors_booked);
        echo $returns[0];
        $weekdaze_layouts[$x] = $returns[1];
      }
    }

    ?>

  </body>
  </html>
