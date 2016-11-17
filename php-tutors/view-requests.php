<html>
<head><title>Requests</title></head>
<body>
<h1>All Requests</h1>

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
    $st = $dbh->query('SELECT * FROM Request, Teacher WHERE teacher_email = email');
     if (($myrow = $st->fetch())) {
       do {
         echo $myrow['name'] . " ";
         echo $myrow['teacher_email'] . " ";
         echo $myrow['school'] . " ";
         echo $myrow['grade_level'] . " ";
         if($myrow['day'] == 1){
          echo 'Monday' . " ";
         }
         if($myrow['day'] == 2){
          echo 'Tuesday' . " ";
         }
         if($myrow['day'] == 3){
          echo 'Wednesday' . " ";
         }
         if($myrow['day'] == 4){
          echo 'Thursday' . " ";
         }
         if($myrow['day'] == 5){
          echo 'Friday' . " ";
         }
         echo $myrow['start_time'] . " ";
         echo $myrow['end_time'] . " ";
         echo $myrow['num_tutors'] . " ";
         echo $myrow['language'] . " ";
         echo $myrow['description'] . "<br><br>";
       } while ($myrow = $st->fetch());
     }
  }
  catch(PDOException $e){
    echo "Error: " . $e;
  }
?>

</body>
</html>
      