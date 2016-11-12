<html>
<head><title>Request</title></head>
<body>

<a href="loginscreen.php">Back to Login </a>

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
  	$statement = $dbh->prepare("INSERT INTO TutorInfo VALUES (?, ?)");
  	$name = $_POST["name"];
	$netid = $_POST["netid"];
	try{
		$statement->execute($name, $netid);
	} catch (PDOException $e){
        echo $e->getMessage() . "<br/>";
     }
?>

</body>
</html>
