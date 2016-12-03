<?php
   session_start();



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
    if (!isset($_POST['book'])) {
    echo "You need to choose a request";
    die();
  }
    echo "Welcome to the booking page ". $_SESSION['username'] . "!"."<br/>";?>
  </head>
<body>
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
	
	$statement = $dbh->prepare("INSERT INTO BOOKINGS VALUES (?, ?, ?, ?, ?, ?)");
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
			$statement->execute(array($tutor_id, $teacher_email, $day, $start_time, $end_time, $f));
			
		}else{
		    echo "<br/>";
			echo "Unable to book";
		}
		
	} catch (PDOException $e){
        echo $e->getMessage() . "<br/>";
     }
	

 ?> 
<h1>Yay you booked something!</h1>

  <div class="save">
        Now go
        <a href="student_profile_home.php">home</a>
        Or back to the calendar
        <a href="student_profile_home.php">home</a>
    </div>

  </body>

</html>