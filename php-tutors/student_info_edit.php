<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Edit Profile</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <?php include_once('student_navbar.php'); ?>
    </head>
    <body>
      <?php

  session_start();
  $user = "generic";
  if($_SESSION['username']) {
    $user = $_SESSION['username'];
  }else{
      	 header("Location: student_login.php");
    }
  try {
    include("pdo-tutors.php");
    $dbh = dbconnect();
  } catch (PDOException $e) {
    print "Error connecting to the database: " . $e->getMessage() . "<br/>";
    die();
  }
  $statement = $dbh->prepare("SELECT * FROM TutorInfo WHERE tutor_id = ?");
  $statement->bindParam(1, $user);
  try{
    $statement->execute();
    
    if ($myrow = $statement->fetch()) {


?>
          <div class="container">
            <h1 class="text-center">Edit Student Profile</h1>

            <h1>Login Information</h1>
            <br>
            <h4>NetID (Username): <?php echo $myrow['tutor_id']; ?></h4>
            <form class="form-horizontal" action="student_profile_update.php" method="post">
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="name">Name:</label>
                  <input type="text" class="form-control" name="name" value="<?php echo $myrow['name']; ?>">
                  <label for="name">Password:</label>
                  <input type="text" class="form-control" name="password" value="">
                </div>
              </div>

              <input type="submit" class="btn btn-primary" value="Update Profile">
            </form>
            <?php
          }
        } catch (PDOException $e) {
         print "Database error: " . $e->getMessage() . "<br/>";
         die();
       }
       ?> 

     </div>
   </body>
   </html>
