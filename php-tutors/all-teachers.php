<html>
<head><title>All Teachers</title></head>
<body>
<h1>All Teachers</h1>

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
    $st = $dbh->query('SELECT * FROM Teacher');
    if (($myrow = $st->fetch())) {
?>

<form method="post" action="teacher-info.php">
Select a teacher below to view more information:<br/>
<?php
      do {
        echo "<input type='radio' name='teacher' value='" . $myrow['name'] . "'/>";
        echo $myrow['name'] . "<br/>";
      } while ($myrow = $st->fetch());
      
?>
<?= $st->rowCount() ?> teacher(s) found in the database.<br/>
<input type="submit" value="GO!"/>
</form>
<?php
    } else {
      echo "There is no teacher in the database.";
    }
  } catch (PDOException $e) {
    print "Database error: " . $e->getMessage() . "<br/>";
    die();
  }
?> 

<form enctype="multipart/form-data" action="somepage.php" method="POST">
  <input type="file" name="userfile" size="100000" maxlength="200000"> <br>
  <input type = "submit" name="upload" value="Upload">
</form>

</body>

</html>
