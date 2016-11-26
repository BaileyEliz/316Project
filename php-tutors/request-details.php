<?php
  if (!isset($_POST['request_id'])) {
    echo "You need to specify a request. Please <a href='all-students.php'>try again</a>.";
    die();
  }
  $request_id = $_POST['request_id'];
?>

<html>
<link rel="stylesheet" type="text/css" href="style.css">
<head><title>Request ID: <?= $request_id ?></title></head>
<body>

<h1>Request Details: <?=$request_id ?></h1>

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
      "SELECT * 
      FROM Request
      WHERE Request.request_id = ?");
    $st->execute(array($request_id));
    $values = $st->fetchAll(PDO::FETCH_ASSOC);
    if ($st->rowCount() == 0) {
      die('There are no matches for request id' . $request_id . ' in the database.');
    }

    function print_day($number) {
      if ($number == 1) {
        return 'Monday';
      }
      else if ($number == 2) {
        return 'Tuesday';
      }
      else if ($number == 3) {
        return 'Wednesday';
      }
      else if ($number == 4) {
        return 'Thursday';
      }
      else if ($number == 5) {
        return 'Friday';
      }
    }

    foreach ($values as $details){
        $teacher_email = $details['teacher_email'];
        $day = $details['day'];
        $start_time = $details['start_time'];
        $end_time = $details['end_time'];

        $existingTutorsStatement = $dbh->prepare(
        "SELECT TutorInfo.tutor_id, TutorInfo.name 
        FROM Bookings, TutorInfo
        WHERE teacher_email = ? and day = ? and start_time = ? and end_time = ? and Bookings.tutor_id = TutorInfo.tutor_id");
        $existingTutorsStatement->execute(array($teacher_email, $day, $start_time, $end_time));
        $existingTutors = $existingTutorsStatement->fetchAll(PDO::FETCH_ASSOC);

        echo "Day: " . print_day($day) . "<br/>";
        echo "Grade Level: " . $details['grade_level'] . "<br/>";
        echo "Start Time: " . $start_time . "<br/>";
        echo "End Time: " . $end_time . "<br/>";
        echo "Number of Tutors: " . $details['num_tutors'] . "<br/>";
        echo "Language: " . $details['language'] . "<br/>";
        echo "Description: " . $details['description'] . "<br/>";
        echo "Existing Tutors: " . "<br/>";

        foreach ($existingTutors as $tutor) {
          echo $tutor['name'] . "<br/>";

        }
    }

    } catch (PDOException $e) {
    print "Database error: " . $e->getMessage() . "<br/>";
    die();
  }

?>

</body>
</html>