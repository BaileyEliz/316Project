<html>
<head><title>All Info</title></head>
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
<h1>All Teachers</h1>
<?php 
try{
  $st = $dbh->query('SELECT Teacher.name AS teacher_name, Teacher.email AS teacher_email, Teacher.site_name AS site_name FROM Teacher, Site WHERE site_name = Site.name');
  if(($myrow = $st->fetch())){
    do{
      echo $myrow['teacher_name'] . " ";
      echo $myrow['teacher_email'] . " ";
      echo $myrow['site_name'] . "<br><br>";
    } while ($myrow = $st->fetch());
  }
}
catch (PDOException $e){
  echo "Error: " . $e;
}
?>
<h1>All Sites</h1>
<?php
try{
  $st = $dbh->query('SELECT * FROM Site');
  if(($myrow = $st->fetch())){
    do{
      echo $myrow['name'] . " ";
      echo $myrow['transportation'] . "<br><br>";
    } while ($myrow = $st->fetch());
  }
}
catch (PDOException $e){
  echo "Error: " . $e;
}
?>
<h1>All Tutors</h1>
<?php
try{
  $st = $dbh->query('SELECT * FROM TutorInfo ORDER BY tutor_id');
  if(($myrow = $st->fetch())){
    do{
      echo $myrow['tutor_id'] . " ";
      echo $myrow['name'] . "<br><br>";
    } while ($myrow = $st->fetch());
  }
}
catch (PDOException $e){
  echo "Error: " . $e;
}
?>

<h1>Tutor Availability</h1>
<?php
try{
  $st = $dbh->query('SELECT * FROM TutorAvailable ORDER BY tutor_id');
  if(($myrow = $st->fetch())){
    echo "<table border='1'><td><b>Tutor ID</b></td><td><b>Day</b></td><td><b>Start Time</b></td><td><b>End Time</b></td>";
    do{
      if($myrow['day'] == 1){
        $day = "Monday";
      }
      if($myrow['day'] == 2){
        $day = "Tuesday";
      }
      if($myrow['day'] == 3){
        $day = "Wednesday";
      }
      if($myrow['day'] == 4){
        $day = "Thursday";
      }
      if($myrow['day'] == 5){
        $day = "Friday";
      }
      $starttime = date("g:i a", strtotime($myrow["start_time"]));
      $endtime = date("g:i a", strtotime($myrow["end_time"]));
      echo "<tr><td>" . $myrow['tutor_id'] . "</td><td>" . $day . "</td><td>" . $starttime . "</td><td>" . $endtime . "</td></tr>";
    } while ($myrow = $st->fetch());
    echo "</table>";
  }
}
catch (PDOException $e){
  echo "Error: " . $e;
}
?>
<!--Maybe will also display bookings... However not sure how useful this page is in the scheme of the site. Useful for testing different functoinality
  across the whole site when manipulating data within the database. Look into this more later, but as of now, it will be helpful for observing how the 
  data is being changed.-->
</body>
</html>
      