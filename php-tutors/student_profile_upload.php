<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <title>Profile Created</title>
</head>

<body>

  Do we want to keep this page? Or just connect them directly to their home page?

  <br>

  Profile created successfully!

  <a href="student_login.php">Back to Login </a>

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
  $_SESSION['username'] = $netid;
  try{		
    $statement->execute(array($netid, $name));
  } catch (PDOException $e){
    echo $e->getMessage() . "<br/>";
  }
  header("Location: student_profile_home.php");
  ?>

</body>
</html>
