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

<?php
  if (!isset($_POST['student'])) {
    echo "You need to specify a student. Please <a href='all-students.php'>try again</a>.";
    die();
  }
  $student = $_POST['student'];
?>

<link rel="stylesheet" type="text/css" href="style.css">
<title>Student Information: <?= $student ?></title></head>
<body>

<h1>Student Information: <?=$student ?></h1>

<?php

try {
    include("pdo-tutors.php");
    $dbh = dbconnect();
  } catch (PDOException $e) {
    print "Error connecting to the database: " . $e->getMessage() . "<br/>";
    die();
  }

  try {
    $st = $dbh->prepare(
      "SELECT TutorInfo.name, Teacher.name, Teacher.site_name, Request.day, Request.start_time, Request.end_time, Request.request_id
      FROM Request, TutorAvailable, Teacher, TutorInfo
      WHERE TutorInfo.name = ? and TutorInfo.tutor_id = TutorAvailable.tutor_id and TutorAvailable.day = Request.day and Request.teacher_email = Teacher.email and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time
      ORDER BY Request.day, Request.start_time");
    $st->execute(array($student));
    $values = $st->fetchAll(PDO::FETCH_ASSOC);
    if ($st->rowCount() == 0) {
      die('There are no matches for ' . $student . ' in the database.');
    }

    $weekdays = $dbh->prepare(
      "SELECT TutorInfo.name, Teacher.name, Teacher.site_name, Request.day, Request.start_time, Request.end_time, Request.teacher_email, Request.num_tutors, Request.request_id 
      FROM Request, TutorAvailable, Teacher, TutorInfo
      WHERE Request.day = ? and TutorInfo.name = ? and TutorInfo.tutor_id = TutorAvailable.tutor_id and TutorAvailable.day = Request.day and Request.teacher_email = Teacher.email and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time
      ORDER BY Request.start_time");

    $weekdays->execute(array(1, $student));
    $monday = $weekdays->fetchAll(PDO::FETCH_ASSOC);

    $weekdays->execute(array(2, $student));
    $tuesday = $weekdays->fetchAll(PDO::FETCH_ASSOC);

    $weekdays->execute(array(3, $student));
    $wednesday = $weekdays->fetchAll(PDO::FETCH_ASSOC);

    $weekdays->execute(array(4, $student));
    $thursday = $weekdays->fetchAll(PDO::FETCH_ASSOC);

    $weekdays->execute(array(5, $student));
    $friday = $weekdays->fetchAll(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    print "Database error: " . $e->getMessage() . "<br/>";
    die();
  }

?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-2">O'Clock
      <div class="row"><div class="col-md-12"><div class="time">8:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">8:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">9:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">9:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">10:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">10:30</div></div></div>
    </div>
    <div class="col-md-2">Monday
      <div class="row">
        <div class="col-md-12">
          <div class="monday-contents">Here's monday</div>
        </div>
      </div>
    </div>
    <div class="col-md-2">Tuesday
      <div class="row">
        <div class="col-md-12">Here's monday</div>
      </div>
    </div>
    <div class="col-md-2">Wednesday
      <div class="row">
        <div class="col-md-12">Here's monday</div>
      </div>
    </div>
    <div class="col-md-2">Thursday
      <div class="row">
        <div class="col-md-12">Here's monday</div>
      </div>
    </div>
    <div class="col-md-2">Friday
      <div class="row">
        <div class="col-md-12">Here's monday</div>
      </div>
    </div>
  </div>
</div>

  <?php 

    function html_print($index, $array) {
      if (count($array) == 0) {
        return "there's nothing here!";
      }
      $request_id = $array['request_id'];
      $build = "<div id ='option_" . $index . "'>";
      $build .= $array['name'] . "</br>" . $array['site_name'] . "</br>" . $array['start_time'] . "</br>" . $array['end_time'] . "</br>";
      $build .= "<form method=\"post\" action=\"request-details.php\">";
      $build .= "<input type=\"hidden\" name=\"request_id\" value=\"" . $request_id . "\">";
      $build .= "<input type=\"submit\" value=\"details\" id=\"link_button\">";
      $build .= "</form>";
      $build .= "</div>";
      return $build;
    }

    function css_print($index, $array) {

      $h = intval(substr($array['start_time'], 0, 2));
      $m = intval(substr($array['start_time'], 3, 5));
      $d = $array['day'];

      $build = "<script type='text/javascript'>";
      $build .= "var styles = {'background-color': 'red', 'position': 'relative', 'bottom':'" . 0 . "px', 'left':'" . 0 . "px'};";
      $build .= "$('#option_" . $index . "').css(styles);";
      $build .= "</script>";
      return $build;
    }

    for ($i = 0; $i < count($values); $i++){
      echo html_print($i, $values[$i]);
      echo css_print($i, $values[$i]);
    }

  ?>

<script>
  $(".monday-contents").append($("#option_0"));
</script>

Go <a href='all-students.php'>back</a>.
</body>
</html>