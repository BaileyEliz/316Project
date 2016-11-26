<?php
  if (!isset($_POST['student'])) {
    echo "You need to specify a student. Please <a href='all-students.php'>try again</a>.";
    die();
  }
  $student = $_POST['student'];
  // In production code, you might want to "cleanse" the $drinker string
  // to remove potential hacks before doing something with it (e.g.,
  // passing it to the DBMS).  That said, using prepared statements
  // (see below for details) can prevent SQL injection attack even if
  // $drinker contains potentially malicious character sequences.
?>

<html>
<link rel="stylesheet" type="text/css" href="style.css">
<head><title>Student Information: <?= $student ?></title></head>
<body>

<h1>Student Information: <?=$student ?></h1>




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
    // One could construct a parameterized query manually as follows,
    // but it is prone to SQL injection attack:
    // $st = $dbh->query("SELECT address FROM Drinker WHERE name='" . $drinker . "'");
    // A much safer method is to use prepared statements:
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

<form method = "post" action = "book-slot.php"> 
<input type="submit" value="book"/> 
</form>

<table id="calendar" style="width:100%">
  <tr>
    <th>Monday</th>
    <th>Tuesday</th>
    <th>Wednesday</th>
    <th>Thursday</th>
    <th>Friday</th>
  </tr>

  <?php 

    function special_print($array) {
      if (count($array) == 0) {
        return "";
      }
      $request_id = $array['request_id'];
      $build .= $request_id . "</br>" . $request_id . "</br>" . $array['name'] . "</br>" . $array['site_name'] . "</br>" . $array['start_time'] . "</br>" . $array['end_time'] . "</br>";
      $build .= "<form method=\"post\" action=\"request-details.php\">";
      $build .= "<input type=\"hidden\" name=\"request_id\" value=\"" . $request_id . "\">";
      $build .= "<input type=\"submit\" value=\"details\" id=\"link_button\">";
      $build .= "</form>";
      return $build;
    }
    

    $biggest = max(count($monday), count($tuesday), count($wednesday), count($thursday), count($friday));

    for($x = 0; $x < $biggest; $x++){
      echo "<tr>";
      $mon_ser = serialize($monday[$x]);
      echo "<td id = \"monday\">" . special_print($monday[$x])      .  "<input type='checkbox' name='req' value='" . $mon_ser . "'/>". "</td>";
      $tues_ser = serialize($tuesday[$x]);
      echo "<td id = \"tuesday\">" . special_print($tuesday[$x])    .  "<input type='checkbox' name='req' value='" . $tues_ser . "'/>". "</td>";
      $wed_ser = serialize($wednesday[$x]);
      echo "<td id = \"wednesday\">" . special_print($wednesday[$x]).  "<input type='checkbox' name='req' value='" . $wed_ser . "'/>" . "</td>";
      $thurs_ser = serialize($thursday[$x]);
      echo "<td id = \"thursday\">" . special_print($thursday[$x])  .  "<input type='checkbox' name='req' value='" . $thurs_ser . "'/>". "</td>";
      $fri_ser = serialize($friday[$x]);
      echo "<td id = \"friday\">" . special_print($friday[$x])      .  "<input type='checkbox' name='req' value='" . $fri_ser . "'/>". "</td>";
      echo "</tr>";
    }

  ?>
</table>

Go <a href='all-students.php'>back</a>.
</body>
</html>