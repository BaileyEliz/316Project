<!-- 
<?php
  if (!isset($_POST['req'])) {
    echo "You need to choose a request";
    die();
  }
  	$reqinfo = $_POST['req'];
  	echo '<pre>';
	print_r($reqinfo);
	echo '</pre>';
	
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
  
  $statement = $dbh->prepare("INSERT INTO Site MATCHES (?, ?)");


?>

 -->

