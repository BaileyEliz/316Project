<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Delete</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>

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
  try{
  	$st = $dbh->query('DROP TABLE Request');
  }
  catch(PDOException $e){
    echo "Error: " . $e;
  }
  try{
  	$st = $dbh->query('DROP TABLE Teacher');
  }
  catch(PDOException $e){
    echo "Error: " . $e;
  }
  try{
  	$st = $dbh->query('DROP TABLE Site');
  }
  catch(PDOException $e){
    echo "Error: " . $e;
  }
  try{
  	$st = $dbh->query('CREATE TABLE Site
	(
 	name VARCHAR(256) NOT NULL,
 	transportation VARCHAR(256) NOT NULL,
	 PRIMARY KEY (name)
	);');
  }
  catch(PDOException $e){
    echo "Error: " . $e;
  }
  try{
  	$st = $dbh->query('CREATE TABLE Teacher
	(site_name VARCHAR(256) NOT NULL,
	 name VARCHAR(256) NOT NULL,
	 email VARCHAR(256) NOT NULL,
	 PRIMARY KEY (email),
	FOREIGN KEY (site_name) REFERENCES Site(name)
);');
  }
  catch(PDOException $e){
    echo "Error: " . $e;
  }
  try{
  	$st = $dbh->query('CREATE TABLE Request
	(day INTEGER NOT NULL CHECK (day >= 1 AND day <= 5),
 	grade_level VARCHAR(256) NOT NULL,
 	start_time TIME(0) NOT NULL,
 	end_time TIME(0) NOT NULL,
 	teacher_email VARCHAR(256) NOT NULL,
 	num_tutors INTEGER NOT NULL,
 	language VARCHAR(256) NOT NULL,
 	description VARCHAR(1024),
 	request_id SERIAL,
 	PRIMARY KEY (teacher_email, day, start_time, end_time),
 	FOREIGN KEY (teacher_email) REFERENCES Teacher(email)
	);');
  }
  catch(PDOException $e){
    echo "Error: " . $e;
  }
  
  //will also need to delete and recreate the Matches/Bookings table once we have those completed

  ?>
<div class="text-center">
  <h1>Deletion Successful</h1>
  <a href="admin_home.php">Back to Admin Homepage</a>
</div>

</body>
</html>