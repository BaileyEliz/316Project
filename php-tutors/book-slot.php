
<a href="pick-a-student.php">Back to booking </a>
<?php
  session_start();

  if (!isset($_POST['req'])) {
    echo "You need to choose a request";
    die();
  }
  	echo "Welcome to the booking page ". $_SESSION['username'] . "!"."<br/>";
  	

  	
	$reqinfo = $_POST['req'] ;
	//echo $reqinfo;
	
	$req = unserialize($reqinfo);
	
	echo "<br/>";
	foreach($req as $key => $value)
	{
  		echo $key." : ". $value."<br/>";
	}
  	
	
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
  
  $statement = $dbh->prepare("INSERT INTO MATCHES VALUES (?, ?, ?, ?, ?)");
  $teacher_name = $req[name];
  $day = $req[day];
  $start = $req[start_time];
  $end = $req[end_time];
  $tutor_id = $_SESSION['username'];
	try{		
		$statement->execute(array($tutor_id, $teacher_name, $day, $start, $end));
	} catch (PDOException $e){
        echo $e->getMessage() . "<br/>";
     }
?>




