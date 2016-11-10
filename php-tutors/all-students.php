<html>
<head><title>All Students</title></head>
<body>
<h1>All Students</h1>

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
    $st = $dbh->query('SELECT * FROM TutorInfo');
    if (($myrow = $st->fetch())) {
?>

<form method="post" action="pick-a-student.php">
Select a student below to view times that they can tutor for:<br/>
<?php
      do {
        echo "<input type='radio' name='student' value='" . $myrow['name'] . "'/>";
        echo $myrow['name'] . "<br/>";
      } while ($myrow = $st->fetch());
      
?>
<?= $st->rowCount() ?> student(s) found in the database.<br/>
<input type="submit" value="GO!"/>
</form>
<?php
    } else {
      echo "There is no student in the database.";
    }
  } catch (PDOException $e) {
    print "Database error: " . $e->getMessage() . "<br/>";
    die();
  }
?> 

</body>

</html>