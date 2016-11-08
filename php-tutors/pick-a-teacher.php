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
    $st = $dbh->prepare("SELECT tutor_id, request_id, teacher_id, Request.day, Request.start_time, Request.end_time 
FROM Request, TutorAvailable, Teacher
WHERE TutorAvailable.day = Request.day and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time and Request.request_id = Teacher.teacher_id and Teacher.name = ?
ORDER BY Request.day, Request.start_time;");
    $values = $st->execute(array($teacher));
    if ($st->rowCount() == 0) {
      die('There is no teacher named ' . $teacher . ' in the database.');
    }
    
    foreach ($values as $value) {
      echo $value;
    }

    echo "<br/>\n";

  } catch (PDOException $e) {
    print "Database error: " . $e->getMessage() . "<br/>";
    die();
  }

?>
Go <a href='all-teachers.php'>back</a>.
</body>
</html>