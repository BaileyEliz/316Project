<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>home</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<?php
  session_start();
  $user = "generic";
  if($_SESSION['username']) {
    $user = $_SESSION['username'];
  }
  try {
    include("pdo-tutors.php");
    $dbh = dbconnect();
  } catch (PDOException $e) {
    print "Error connecting to the database: " . $e->getMessage() . "<br/>";
    die();
  }
  $student_avails = $dbh->prepare(
      "SELECT *
      FROM TutorAvailable
      WHERE TutorAvailable.tutor_id = ?");
  
  $student_avails->execute(array($user));
  $student_values = $student_avails->fetchAll(PDO::FETCH_ASSOC);

  include 'php-functions.php';
?>



  </head>
  <body>

    <h1 class="text-center">Student Availability Edited Here!</h1>

    <h2 class="text-center">Current Availability</h2>
<table>
<tr>
    <th>Day</th>
    <th>Start Time</th> 
    <th>End Time</th>
</tr>

<?php
    
  foreach($student_values as $row) {
    $day = $row['day'];
    $starttime = $row['start_time'];
    $endtime = $row['end_time'];
    $remove_avail = $dbh->prepare(
      "DELETE
      FROM TutorAvailable
      WHERE TutorAvailable.tutor_id = ? and TutorAvailable.day = ? and TutorAvailable.start_time = ?");

    //$remove_avail->execute(array($user, $day, $starttime));
    //$student_values = $student_avails->fetchAll(PDO::FETCH_ASSOC);

    echo "<tr><td>" . $day . "</td><td>" . $starttime . "</td><td>" . $endtime . "</td><td href='student_availability_edit.php'>Remove</td></tr>";

    //<!--TODO: actually delete the entry! should maybe be with $remove_avail. parameters might be wrong though so check if it is start_time or something else, etc-->

}


  ?>
</table>
<!--
    <div class="name">
      Day
    </div>

    <div class="name">
      Time start
    </div>

    <div class="name">
      Time end
    </div>

    <div class="save">
        When I click the remove button this info is deleted from the database and the page is refreshed
        <a href="student_availability_edit.php">here</a>
    </div>

-->



    <h2 class="text-center">Add a Time Slot</h2>

<form action="student_availability_add_success.php" method="post">
  Day of the Week: <select name="day_of_week">
    <option value="Monday">Monday</option>
    <option value="Tuesday">Tuesday</option>
    <option value="Wednesday">Wednesday</option>
    <option value="Thursday">Thursday</option>
    <option value="Friday">Friday</option>
  </select><br>
  Start Time: <input type="time" name="start_time" required><br> <!-- type time doesn't work with Firefox or IE10 and earlier-->
  End Time: <input type="time" name="end_time" required><br>
  
  <input type="submit" value="Submit Availability">
</form>


<!--
    <div class="name">
      Day
    </div>

    <div class="name">
      Time start
    </div>

    <div class="name">
      Time end
    </div>

    <div class="save">
        When I click the save button this info writes to the database and the page is refreshed
        <a href="student_availability_edit.php">here</a>
    </div>
-->
    <h2 class="text-center">Go Back to your Profile</h2>

    <div class="save">
        When I click this button I go back to my profile
        <a href="student_profile_home.php">here</a>
    </div>

  </body>
</html>