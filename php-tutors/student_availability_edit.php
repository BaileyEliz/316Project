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
    <?php include_once('student_navbar.php'); ?>

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

//post actions if an availability was just removed

  if (isset($_POST['remove']) ) {
    $input_name = $_POST['username'];
    //echo $input_name;
        
    $remove_avail = $dbh->prepare(
        "DELETE
        FROM TutorAvailable
        WHERE TutorAvailable.tutor_id = ? and TutorAvailable.day = ? and TutorAvailable.start_time = ?");


    if($_POST["day"] == "Monday"){
      $day = 1;
    }
    if($_POST["day"] == "Tuesday"){
      $day = 2;
    }
    if($_POST["day"] == "Wednesday"){
      $day = 3;
    }
    if($_POST["day"] == "Thursday"){
      $day = 4;
    }
    if($_POST["day"] == "Friday"){
      $day = 5;
    }
     // $st = $dbh->prepare("INSERT INTO TutorAvailable VALUES tutor_id = ?, day = ?, start_time = ?, end_time = ?");
      $values = array();
      $values[] = $user;
      $values[] = $day;
      $values[] = $_POST["start_time"];

  try{
    $remove_avail->execute($values);
  } catch (PDOException $e){
    echo $e->getMessage() . "<br/>";
    echo "<h4>The availability was not removed properly.</h4>";
    }
  }
  if (isset($_POST['add']) ) {
    $addz = $dbh->prepare("INSERT INTO TutorAvailable VALUES (?, ?, ?, ?)");
    $values = array();
    $day = 0;
    if($_POST["day_of_week"] == "Monday"){
      $day = 1;
    }
    if($_POST["day_of_week"] == "Tuesday"){
      $day = 2;
    }
    if($_POST["day_of_week"] == "Wednesday"){
      $day = 3;
    }
    if($_POST["day_of_week"] == "Thursday"){
      $day = 4;
    }
    if($_POST["day_of_week"] == "Friday"){
      $day = 5;
    }
    $values[] = $user;
    $values[] = $day;
    $values[] = $_POST["start_time"];
    $values[] = $_POST["end_time"];
    try{
      $addz->execute($values);
    }  catch (PDOException $e){
      echo $e->getMessage() . "<br/>";
      echo "<h4>The availability was not added properly.</h4>";
      }
    }
        // $check = $dbh->query('SELECT tutor_id FROM TUTORINFO WHERE tutor_id = 'jtb43'');
//        $results = $check->fetch();
//        echo $results;

  //end justin's stuff


//start displaying current availability
  $student_avails = $dbh->prepare(
      "SELECT *
      FROM TutorAvailable
      WHERE TutorAvailable.tutor_id = ?");
  
  $student_avails->execute(array($user));
  $student_values = $student_avails->fetchAll(PDO::FETCH_ASSOC);
  include 'php-functions.php';
?>


<div class="container">
  </head>
  <body>
    <div class="text-center">
      <h1 >Student Availability</h1>
    </div>
      <h2 class="text-center">Current Availability</h2>
<table class="table table-striped table-bordered">
<tr>
    <th>Day</th>
    <th>Start Time</th> 
    <th>End Time</th>
    <th></th>
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
   // echo "<tr><td>" . $day . "</td><td>" . $starttime . "</td><td>" . $endtime . "</td><td href='student_availability_edit.php'>Remove</td></tr>";
    
    $day_array = ["","Monday","Tuesday", "Wednesday", "Thursday", "Friday"];
    ?>
    <form action='student_availability_edit.php' method='post'>
 
 <?php echo "<tr><td>" . $day_array[$day] . "</td>"; ?> 
 <?php echo "<td>" . date("g:i a", strtotime($starttime)) . "</td>"; ?>
 <?php echo "<td>" . date("g:i a", strtotime($endtime)) . "</td>"; ?>
	<input type='hidden' name='day' value='<?php echo $day_array[$day]; ?>'>
      

      <input type='hidden' name='start_time' value='<?php echo $starttime; ?>'>
  
      <input type='hidden' name='end_time' value=  '<?php $endtime; ?> '>
    
      <td><button name='remove' class='btn btn-primary'>Remove</button></td></tr>
    </form>
    <br/>
    <?php
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

<form class="form-horizontal" action="student_availability_edit.php" method="post">
  <div class="form-group">
    <div class="col-xs-4">
      <label for="day_of_week">Day of the Week:</label>
        <select class="form-control" name="day_of_week">
          <option value="Monday">Monday</option>
          <option value="Tuesday">Tuesday</option>
          <option value="Wednesday">Wednesday</option>
          <option value="Thursday">Thursday</option>
          <option value="Friday">Friday</option>
        </select>
    </div>
  </div>
  <div class="form-group">
    <div class="col-xs-4">
      <label for="start_time">Start Time:</label>
        <input type="time" class="form-control"  name="start_time" required>
      </div>
    </div>
  <div class="form-group">
    <div class="col-xs-4">
      <label for="end_time">End Time:</label>
        <input type="time" class="form-control"name="end_time" required>
    </div>
  </div>
  
  <input type="submit" class="btn btn-primary" name='add' value="Add Availability">
</form>
<br>
<br>

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
</div>

  </body>
</html>