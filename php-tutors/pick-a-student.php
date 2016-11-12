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
      "SELECT TutorInfo.name, Teacher.name, Request.day, Request.start_time, Request.end_time 
      FROM Request, TutorAvailable, Teacher, TutorInfo
      WHERE TutorInfo.name = ? and TutorInfo.tutor_id = TutorAvailable.tutor_id and TutorAvailable.day = Request.day and Request.teacher_email = Teacher.email and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time
      ORDER BY Request.day, Request.start_time");
    $st->execute(array($student));
    $values = $st->fetchAll(PDO::FETCH_ASSOC);
    if ($st->rowCount() == 0) {
      die('There are no matches for ' . $student . ' in the database.');
    }

    echo "<br/>\n";

    $weekdays = $dbh->prepare(
      "SELECT TutorInfo.name, Teacher.name, Request.day, Request.start_time, Request.end_time 
      FROM Request, TutorAvailable, Teacher, TutorInfo
      WHERE Request.day = ? and TutorInfo.name = ? and TutorInfo.tutor_id = TutorAvailable.tutor_id and TutorAvailable.day = Request.day and Request.teacher_email = Teacher.email and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time
      ORDER BY Request.day, Request.start_time");

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

<table id="calendar" style="width:100%">
  <tr>
    <th>Monday</th>
    <th>Tuesday</th>
    <th>Wednesday</th>
    <th>Thursday</th>
    <th>Friday</th>
  </tr>

<form method = "post" action = "book-slot.php"> 

  <?php 

    function special_print($array) {
      $build;
      foreach ($array as $item) {
         $build .= $item . "<br/>";
      }
      return $build;
    }
    

    $biggest = max(count($monday), count($tuesday), count($wednesday), count($thursday), count($friday));

    for($x = 0; $x < $biggest; $x++){
      echo "<tr>";
      echo "<td id = \"monday\">" . special_print($monday[$x])      .  "<input type='checkbox' name='req' value='" . $monday[$x] . "'/>" .  "</td>";
      echo "<td id = \"tuesday\">" . special_print($tuesday[$x])    .  "<input type='checkbox' name='req' value='" . $tuesday[$x] . "'/>". "</td>";
      echo "<td id = \"wednesday\">" . special_print($wednesday[$x]).  "<input type='checkbox' name='req' value='" . $wednesday[$x] . "'/>" . "</td>";
      echo "<td id = \"thursday\">" . special_print($thursday[$x])  .  "<input type='checkbox' name='req' value='" . $thursday[$x] . "'/>". "</td>";
      echo "<td id = \"friday\">" . special_print($friday[$x])      .  "<input type='checkbox' name='req' value='" . $friday[$x] . "'/>". "</td>";
      echo "</tr>";
    }

  ?>
<input type="submit" value="book"/> 
</form>
</table>

Go <a href='all-students.php'>back</a>.
</body>
</html>