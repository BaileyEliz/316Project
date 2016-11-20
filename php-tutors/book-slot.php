
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
  
  $statement = $dbh->prepare("INSERT INTO BOOKINGS VALUES (?, ?, ?, ?, ?)");
  $teacher_email = $req[teacher_email];
  $day = $req[day];
  $start = $req[start_time];
  $end = $req[end_time];
  $num_tutors = $req[num_tutors];
  $tutor_id = $_SESSION['username'];
  
  $getNum = $dbh->prepare("SELECT * 
  FROM BOOKINGS 
  WHERE
  		teacher_email = ? and
  		day = ? and 
  		start_time = ? and
  		end_time = ?");
  

	try{
		$getNum->execute(array($teacher_email, $day, $start, $end));
		$count = $getNum->fetchAll(PDO::FETCH_ASSOC);
		$num = count($count);
		echo $num."<br/>";
	} catch (PDOException $e){
        echo $e->getMessage() . "<br/>";
     }  
  
	try{
		if($tutor_id != '' and $num<$num_tutors){		
			$statement->execute(array($tutor_id, $teacher_email, $day, $start, $end));
			
		}else{
		    echo "<br/>";
			echo "Nah!";
		}
		
	} catch (PDOException $e){
        echo $e->getMessage() . "<br/>";
     }
?>




