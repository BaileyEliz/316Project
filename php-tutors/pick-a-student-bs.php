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
      <div class="row"><div class="col-md-12"><div class="time">11:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">11:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">12:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">12:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">1:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">1:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">2:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">2:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">3:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">3:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">4:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">4:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">5:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">5:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">6:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">6:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">7:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">7:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">8:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">8:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">9:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="time">9:30</div></div></div>
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

    function max_overlap($times_array, $start_time, $end_time) {
      $maximum = 0;
      $start_hour = intval(substr($start_time, 0, 2));
      $start_minute = intval(substr($start_time, 3, 5));
      $end_hour = intval(substr($end_time, 0, 2));
      $end_minute = intval(substr($end_time, 3, 5));
      $temp_minute = $start_minute;
      for ($i = $start_hour; $i <= $end_hour; $i++) {
        for ($j = $temp_minute; (($j < $end_minute and $i == $end_hour) or ($j < 60 and $i < $end_hour)); $j = $j + 5) {
          if (count($times_array[$i][$j]) > $maximum) {
            $maximum = count($times_array[$i][$j]);
          }
        } 
        $temp_minute = 0;
      }
      if ($maximum == 0) {
        $maximum = 1;
      }
      return $maximum;
    }

    function time_print($time) {
      $h = intval(substr($time, 0, 2));
      $m = intval(substr($time, 3, 5));
      if ($m == 0) {
        $m = "00";
      }

      if ($h < 12) {
        return $h . ":" . $m . " AM";
      }
      else if ($h < 13) {
        return $h . ":" . $m . " PM";
      }
      else {
        return ($h - 12) . ":" . $m . " PM";
      }
    }

    function minutes_different($start_time, $end_time) {
      $start_hour = intval(substr($start_time, 0, 2));
      $start_minute = intval(substr($start_time, 3, 5));
      $end_hour = intval(substr($end_time, 0, 2));
      $end_minute = intval(substr($end_time, 3, 5));

      $temp_hour = $start_hour;
      $minutes = 0;

      if ($start_minute > 0) {
        $minutes += (60 - $start_minute);
        $temp_hour += 1;
      }

      $minutes += 60 * ($end_hour - $temp_hour);
      $minutes += $end_minute;
      return $minutes;

    }

    function top_margin($time) {
      return minutes_different("08:00:00", $time);
    }

    function html_print($index, $array) {
      if (count($array) == 0) {
        return "there's nothing here!";
      }
      $request_id = $array['request_id'];
      $build = "<div id ='option_" . $index . "'>";
      $build .= $array['name'] . "</br>" . $array['site_name'] . "</br>" . time_print($array['start_time']) . "</br>" . time_print($array['end_time']) . "</br>";
      $build .= "<form method=\"post\" action=\"request-details.php\">";
      $build .= "<input type=\"hidden\" name=\"request_id\" value=\"" . $request_id . "\">";
      $build .= "<input type=\"submit\" value=\"details\" id=\"link_button\">";
      $build .= "</form>";
      $build .= "</div>";
      return $build;
    }

    function css_print($times_array, $index, $array, $day) {
      
      $d = $array['day'];

      $build = "<script type='text/javascript'>";
      $build .= "var styles = {
        'background-color': 'red', 
        'position': 'absolute', 
        'top':'" . (6 * top_margin($array['start_time'])) . "px', 
        'float':'left',
        'height':'" . (6 * minutes_different($array['start_time'], $array['end_time'])) ."px',
        'width':'" . ((1 / max_overlap($times_array, $array['start_time'], $array['end_time'])) * 100) . "%'};";
      $build .= "$('#option_" . $index . "').css(styles);";
      $build .= "$('." . $day . "-contents').append($('#option_" . $index . "'));";
      $build .= "</script>";
      return $build;
    }

    $monday_times = array();

    for ($x = 0; $x < count($monday); $x++) {
    $session = $monday[$x];
    $start_hour = intval(substr($session['start_time'], 0, 2));
    $start_minute = intval(substr($session['start_time'], 3, 5));
    $end_hour = intval(substr($session['end_time'], 0, 2));
    $end_minute = intval(substr($session['end_time'], 3, 5));
    $temp_minute = $start_minute;
    for ($i = $start_hour; $i <= $end_hour; $i++) {
      for ($j = $temp_minute; (($j < $end_minute and $i == $end_hour) or ($j < 60 and $i < $end_hour)); $j = $j + 5) {
        $monday_times[$i][$j][] = $x;
      }
      $temp_minute = 0;
    }
  }

    $weekdaze = array($monday, $tuesday, $wednesday, $thursday, $friday);
    $weekdaze_names = array("monday", "tuesday", "wednesday", "thursday", "friday");
    //global $monday_times;

    for ($x = 0; $x < count($weekdaze); $x++) {
      $day_array = $weekdaze[$x];
      $day_name = $weekdaze_names[$x];
      for ($i = 0; $i < count($day_array); $i++){
        global $monday_times;
        echo html_print((($x * 100) + $i), $day_array[$i]);
        echo css_print($monday_times, (($x * 100) + $i), $day_array[$i], $day_name);
      }
    }

  ?>

Go <a href='all-students.php'>back</a>.
</body>
</html>