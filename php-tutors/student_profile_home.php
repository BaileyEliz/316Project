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

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>

    <?php
      session_start();
      $user = "generic";
      if($_SESSION['username']) {
        $user = $_SESSION['username'];
      }

      include 'php-functions.php';

      try {
        include("pdo-tutors.php");
        $dbh = dbconnect();
      } catch (PDOException $e) {
        print "Error connecting to the database: " . $e->getMessage() . "<br/>";
        die();
      }
    ?>

    <h1 class="text-center">Student Profile</h1>

    <h2 class="text-center">Student Information</h2>

    <div class="name">
      Student Name: <?= $user?>
    </div>

    <div class="car">
      Has car?
    </div>

    <div class="edit">
        Welcome to your home.
    </div>

    <div class="temporary">
        Edit your information
      <a href="student_info_edit.php">here</a>
    </div>

    <h2 class="text-center">Availability</h2>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-1">O'Clock
      <div class="row"><div class="col-md-12"><div class="mini_time">8:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">8:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">9:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">9:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">10:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">10:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">11:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">11:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">12:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">12:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">1:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">1:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">2:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">2:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">3:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">3:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">4:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">4:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">5:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">5:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">6:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">6:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">7:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">7:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">8:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">8:30</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">9:00</div></div></div>
      <div class="row"><div class="col-md-12"><div class="mini_time">9:30</div></div></div>
    </div>
    <div class="col-md-2">
      <div class="row">
        <div class="col-md-12">
          <div class="monday-contents">Monday</div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="row">
        <div class="col-md-12">
          <div class="tuesday-contents">Tuesday</div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="row">
        <div class="col-md-12">
          <div class="wednesday-contents">Wednesday</div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="row">
        <div class="col-md-12">
          <div class="thursday-contents">Thursday</div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="row">
        <div class="col-md-12">
          <div class="friday-contents">Friday</div>
        </div>
      </div>
    </div>
  </div>
</div>

    <?php 

      try {
      $stmt = $dbh->prepare(
      "SELECT TutorAvailable.start_time, TutorAvailable.end_time
      FROM TutorAvailable
      WHERE TutorAvailable.tutor_id = ? and TutorAvailable.day = ?");

      $stmt->execute(array($user, 1));
      $monday = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $stmt->execute(array($user, 2));
      $tuesday = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $stmt->execute(array($user, 3));
      $wednesday = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $stmt->execute(array($user, 4));
      $thursday = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $stmt->execute(array($user, 5));
      $friday = $stmt->fetchAll(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    print "Database error: " . $e->getMessage() . "<br/>";
    die();
  }

    $weekdaze = array($monday, $tuesday, $wednesday, $thursday, $friday);
    $weekdaze_names = array("monday", "tuesday", "wednesday", "thursday", "friday");

      for ($x = 0; $x < count($weekdaze); $x++) {
        for ($i = 0; $i < count($weekdaze[$x]); $i++) {
          echo simple_html_print((($x * 100) + $i), $weekdaze[$x][$i]) . "<br/>";
          echo simple_css_print((($x * 100) + $i), $weekdaze[$x][$i], $weekdaze_names[$x]);
        }
      }

    ?>

    <div class="temporary">
        Edit your availability
      <a href="student_availability_edit.php">here</a>
    </div>

    <h2 class="text-center">Current Bookings</h2>
        <div class="edit">
        	These are your current bookings. 
    	</div>
	<?php
		try {
      		$booking_select = $dbh->prepare(
      				"SELECT *
      				FROM Bookings
      				 WHERE BOOKINGS.tutor_id = ?");

      		$booking_select->execute(array($user));
      		$all_bookings = $booking_select->fetchAll(PDO::FETCH_ASSOC);
      		foreach ($all_bookings as $books){
      				echo "<br/>";
					foreach($books as $key => $value)
					{
  						echo $key." : ". $value."<br/>";
					}
      		}

  		} catch (PDOException $e) {
    		print "Database error: " . $e->getMessage() . "<br/>";
    		die();
  		}
 
	?>


    <div class="edit">
        Do we want to add a pending something? Can display here.
    </div>

    <h2 class="text-center">Add Bookings</h2>

    <div class="temporary">
        View your matches
      <a href="student_matches_all_days.php">here</a>
    </div>

  </body>
</html>