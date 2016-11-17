<html>
<head><title>Request</title></head>
<body>

<a href="admin-interface.php">Back to Admin Homepage</a>

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

  	$statement = $dbh->prepare("INSERT INTO Site VALUES (?, ?)");
  	$statement1 = $dbh->prepare("INSERT INTO Teacher VALUES (?, ?, ?)");
	$statement2 = $dbh->prepare("INSERT INTO Request VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

	$values = array();
	$values1 = array();
	$values2 = array();

	$name = $_POST["name"];
	$email = $_POST["email"];
	$school = $_POST["school"];
	$day = $_POST["day_of_week"];
	if($day == 'Monday'){
		$day = 1;
	}
	if($day == 'Tuesday'){
		$day = 2;
	}
	if($day == 'Wednesday'){
		$day = 3;
	}
	if($day == 'Thursday'){
		$day = 4;
	}
	if($day == 'Friday'){
		$day = 5;
	}
	$start = $_POST["start_time"];
	$end = $_POST["end_time"];
	$grade = $_POST["grade_level"];
	$language = $_POST["language"];
	$num_tutors = $_POST["num_tutors"];
	$description = $_POST["description"];

	$values[] = $school;
	$values[] = 'car';

	$values1[] = $school;
	$values1[] = $name;
	$values1[] = $email;

	$values2[] = $day;
	$values2[] = $grade;
	$values2[] = $start;
	$values2[] = $end;
	$values2[] = $email;
	$values2[] = $num_tutors;
	$values2[] = $language;
	$values2[] = $description;

	try{
		$statement->execute($values);
	} catch (PDOException $e){
        echo $e->getMessage() . "<br/>";
     }
	try{
		$statement1->execute($values1);
	} catch (PDOException $e){
        echo $e->getMessage() . "<br/>";
     }
	try{
		$statement2->execute($values2);
	} catch (PDOException $e){
        echo $e->getMessage() . "<br/>";
     }
?>


<!-- can implement later to use history.go when request fails due to some constraint violation or use index.php if the request succeeds -->
<!-- or will likely use form vaildation to ensure it doesn't fail, but on the off chance it does, the go back link can still be present -->

</body>
</html>