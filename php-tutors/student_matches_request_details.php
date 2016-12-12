<?php
 session_start();
  $user = "generic";
  if($_SESSION['username']) {
    $user = $_SESSION['username'];
  }else{
      	 header("Location: student_login.php");

      }?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php include_once('student_navbar.php');
      if (!isset($_POST['request_id'])) {
      echo "Please specify a request. <a href='student_matches_all_days.php'>Try again</a>";
      die();
      }
      $request_id = $_POST['request_id'];
    ?>

    <title>Request ID: <?= $request_id ?></title>



  </head>

<body>

<h1>Request Details: <?=$request_id ?></h1>

<!--<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">Details
      <div class="row">
      </div>
    </div>
    <div class="col-md-6">Other Tutors
      <div class="row">
      </div>
    </div>
  </div>
</div>-->

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

  include 'php-functions.php';

  try {
    // One could construct a parameterized query manually as follows,
    // but it is prone to SQL injection attack:
    // $st = $dbh->query("SELECT address FROM Drinker WHERE name='" . $drinker . "'");
    // A much safer method is to use prepared statements:
    $st = $dbh->prepare(
      "SELECT Request.day, Request.grade_level, Request.start_time, Request.end_time, Request.teacher_email, Request.num_tutors, Request.language, Request.description, Teacher.name, Teacher.site_name, Site.transportation 
      FROM Request, Teacher, Site
      WHERE Request.request_id = ? and Request.teacher_email = Teacher.email and Site.name = Teacher.site_name");
    $st->execute(array($request_id));
    $values = $st->fetchAll(PDO::FETCH_ASSOC);
    if ($st->rowCount() == 0) {
      die('There are no matches for request id' . $request_id . ' in the database.');
    }
	$req_array;
    foreach ($values as $details){
    	$req_array = $details;
        $teacher_email = $details['teacher_email'];
        $day = $details['day'];
        $start_time = $details['start_time'];
        $end_time = $details['end_time'];
        $teacher_name = $details['name'];
        $site_name = $details['site_name'];
        $transportation = $details['transportation'];

        $existingTutorsStatement = $dbh->prepare(
        "SELECT TutorInfo.tutor_id, TutorInfo.name 
        FROM Bookings, TutorInfo
        WHERE teacher_email = ? and day = ? and start_time = ? and end_time = ? and Bookings.tutor_id = TutorInfo.tutor_id");
        $existingTutorsStatement->execute(array($teacher_email, $day, $start_time, $end_time));
        $existingTutors = $existingTutorsStatement->fetchAll(PDO::FETCH_ASSOC);

        echo "<br>";
        echo "<h4>Day: " . print_day($day) . "<br/></h4>";
        echo "<h4>Teacher: " . $teacher_name . "<br/></h4>";
        echo "Site: " . $site_name . "<br/>";
        echo "Transportation: " . $transportation . "<br/>";
        echo "Grade Level: " . $details['grade_level'] . "<br/>";
        echo "Start Time: " . date("g:i a", strtotime($start_time)) . "<br/>";
        echo "End Time: " . date("g:i a", strtotime($end_time)) . "<br/>";
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
  $ser_req = serialize($req_array);
  $_SESSION['sreq'] = $ser_req;

?>
	<br>
	<form action = "student_matches_book_request.php" method = "post">
    		<input type="submit" class="btn btn-primary"name="book" value = "Book" />
    </form>  
	
    <br>
    <a href="student_matches_all_days.php">Back to Matches</a>


</body>
</html>