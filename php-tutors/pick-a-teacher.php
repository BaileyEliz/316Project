<?php
  if (!isset($_POST['teacher'])) {
    echo "You need to specify a teacher. Please <a href='all-teachers.php'>try again</a>.";
    die();
  }
  $teacher = $_POST['teacher'];
  // In production code, you might want to "cleanse" the $drinker string
  // to remove potential hacks before doing something with it (e.g.,
  // passing it to the DBMS).  That said, using prepared statements
  // (see below for details) can prevent SQL injection attack even if
  // $drinker contains potentially malicious character sequences.
?>

<html>
<link rel="stylesheet" type="text/css" href="style.css">
<head><title>Teacher Information: <?= $teacher ?></title></head>
<body>

<h1>Teacher Information: <?=$teacher ?></h1>

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
      "SELECT tutor_id, request_id, Request.teacher_id, Request.day, Request.start_time, Request.end_time 
      FROM Request, TutorAvailable, Teacher
      WHERE TutorAvailable.day = Request.day and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time and Request.teacher_id = Teacher.teacher_id and Teacher.name = ?
      ORDER BY Request.day, Request.start_time");
    $st->execute(array($teacher));
    $values = $st->fetchAll(PDO::FETCH_ASSOC);

    foreach ($values as $value) {
      echo "All matches " . count($value);
      foreach ($value as $item) {
        echo $item . "<br/>";
      }
    }

    if ($st->rowCount() == 0) {
      die('There are no matches for ' . $teacher . ' in the database.');
    }

    echo "<br/>\n";

    $weekdays = $dbh->prepare(
      "SELECT tutor_id, request_id, Request.teacher_id, Request.day, Request.start_time, Request.end_time 
      FROM Request, TutorAvailable, Teacher
      WHERE Request.day = ? and TutorAvailable.day = Request.day and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time and Request.teacher_id = Teacher.teacher_id and Teacher.name = ?
      ORDER BY Request.day, Request.start_time");

    $weekdays->execute(array(1, $teacher));
    $monday = $weekdays->fetchAll(PDO::FETCH_ASSOC);

    $weekdays->execute(array(2, $teacher));
    $tuesday = $weekdays->fetchAll(PDO::FETCH_ASSOC);

    $weekdays->execute(array(3, $teacher));
    $wednesday = $weekdays->fetchAll();

    $weekdays->execute(array(4, $teacher));
    $thursday = $weekdays->fetchAll();

    $weekdays->execute(array(5, $teacher));
    $friday = $weekdays->fetchAll();

  } catch (PDOException $e) {
    print "Database error: " . $e->getMessage() . "<br/>";
    die();
  }

?>

<table style="width:100%">
  <tr>
    <th>Monday</th>
    <th>Tuesday</th>
    <th>Wednesday</th>
    <th>Thursday</th>
    <th>Friday</th>
  </tr>
  <tr>
    <td name = "monday_one">
      <?php
        foreach ($monday[0] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
    <td name = "tuesday_one">
      <?php
        foreach ($tuesday[0] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
    <td name = "wednesday_one">
      <?php
        foreach ($wednesday[0] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
    <td name = "thursday_one">
      <?php
        foreach ($thursday[0] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
    <td name = "friday_one">
      <?php
        foreach ($friday[0] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
  </tr>
  <tr>
    <td name = "monday_two">
      <?php
        foreach ($monday[1] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
    <td name = "tuesday_two">
      <?php
        foreach ($tuesday[1] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
    <td name = "wednesday_two">
      <?php
        foreach ($wednesday[1] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
    <td name = "thursday_two">
      <?php
        foreach ($thursday[1] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
    <td name = "friday_two">
      <?php
        foreach ($friday[1] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
  </tr>
  <tr>
    <td name = "monday_three">
      <?php
        foreach ($monday[2] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
    <td name = "tuesday_three">
      <?php
        foreach ($tuesday[2] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
    <td name = "wednesday_three">
      <?php
        foreach ($wednesday[2] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
    <td name = "thursday_three">
      <?php
        foreach ($thursday[2] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
    <td name = "friday_three">
      <?php
        foreach ($friday[2] as $item) {
          echo $item . "<br/>";
        }?>
    </td>
  </tr>
</table>

Go <a href='all-teachers.php'>back</a>.
</body>
</html>