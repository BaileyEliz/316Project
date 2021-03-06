<?php
	session_start();
    $user = "generic";
    if($_SESSION['username']) {
    	$user = $_SESSION['username'];
    }else{
      	header("Location: student_login.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Student Selector</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <?php include_once('student_navbar.php'); 

      if (!isset($_POST['needs_van'])) {
        $needs_van = 0;
      }
      else {
        $needs_van = $_POST['needs_van'];
        if ($needs_van == 1) {
          $needs_van = 1;
        }
        else {
          $needs_van = 0;
        }
      }
    //echo "Welcome to the booking page ". $_SESSION['username'] . "!"."<br/>";?>
  </head>
  <body>
    <div class="container">
      <?php
      $r = $_SESSION['sreq'];
      $s = unserialize($r);
      unset($_SESSION['sreq']);
      
      $tutor_id = $_SESSION['username'];
      $teacher_email = $s['teacher_email'];
      $day = $s['day'];
      $start_time = $s['start_time'];
      $end_time = $s['end_time'];
      $teacher_name = $s['name'];
      $site_name = $s['site_name'];
      $transportation = $s['transportation'];
      $num_tutors = $s['num_tutors'];
      
      
      try {
       include("pdo-tutors.php");
       $dbh = dbconnect();
     } catch (PDOException $e) {
       print "Error connecting to the database: " . $e->getMessage() . "<br/>";
       die();
     }
     
     $statement = $dbh->prepare("INSERT INTO BOOKINGS VALUES (?, ?, ?, ?, ?, ?, ?)");
     $getNum = $dbh->prepare("SELECT * 
       FROM BOOKINGS 
       WHERE
       teacher_email = ? and
       day = ? and 
       start_time = ? and
       end_time = ?");


     try{
      $getNum->execute(array($teacher_email, $day, $start_time, $end_time));
      $count = $getNum->fetchAll(PDO::FETCH_ASSOC);
      $num = count($count);
    } catch (PDOException $e){
      echo $e->getMessage() . "<br/>";
    }  
    
    try{
      if($tutor_id != '' and $num<$num_tutors){		
       $f = 'false';
       $statement->execute(array($tutor_id, $teacher_email, $day, $start_time, $end_time, $needs_van, $f));
       
     }else{
      echo "<br/>";
      echo "<h1>Unable to book</h1>";
      echo "<a href='student_bookings_page.php'>Back to Bookings Page</a>";
      die();
    }
    
  } catch (PDOException $e){
    echo $e->getMessage() . "<br/>";
  }
  

  ?> 
  <h1>Your request has been booked.</h1>

  <div class="save">
    Now to your student
    <a href="student_profile_home.php">home</a>
  </div>
</div>
</body>

</html>