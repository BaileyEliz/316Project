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
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="password">Password:</label>
                  <input type="text" class="form-control" name="password" value="<?php echo $myrow['password']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="birth_date">Birth Date:</label>
                  <input type="text" class="form-control" name="birth_date" value="<?php echo $myrow['birth_date']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="name">Duke Email:</label>
                  <input type="text" class="form-control" name="duke_email" value="<?php echo $myrow['duke_email']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="graduation_year">Graduation Year (format as '20XX'):</label>
                  <input type="text" class="form-control" name="graduation_year" value="<?php echo $myrow['graduation_year']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="course">Which PFS service-learning course are you enrolled in this semester?</label>
                  <input type="text" class="form-control" name="course" value="<?php echo $myrow['course']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="major_and_minor">What is your declared or intended major and/or minor?</label>
                  <input type="text" class="form-control" name="major_and_minor" value="<?php echo $myrow['major_and_minor']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="has_previous_experience">Have you previously taken a service-learning course that worked with PFS?</label>
                  <input type="text" class="form-control" name="has_previous_experience" value="<?php echo $myrow['has_previous_experience']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="is_education_minor">Have you declared an Education minor?</label>
                  <input type="text" class="form-control" name="is_education_minor" value="<?php echo $myrow['is_education_minor']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="is_licensure_track">Are you currently enrolled in a teaching licensure track?</label>
                  <input type="text" class="form-control" name="is_licensure_track" value="<?php echo $myrow['is_licensure_track']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="is_america_reads_america_counts_tutor">Are you an America Reads/America Counts tutor this semster?</label>
                  <input type="text" class="form-control" name="is_america_reads_america_counts_tutor" value="<?php echo $myrow['is_america_reads_america_counts_tutor']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="is_varsity_athlete">Are you on a varsity athletic team?</label>
                  <input type="text" class="form-control" name="is_varsity_athlete" value="<?php echo $myrow['is_varsity_athlete']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="varsity_team">If yes, which team?</label>
                  <input type="text" class="form-control" name="varsity_team" value="<?php echo $myrow['varsity_team']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="varsity_academic_advisor">If yes, who is your academic advisor?</label>
                  <input type="text" class="form-control" name="varsity_academic_advisor" value="<?php echo $myrow['varsity_academic_advisor']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="other_languages">If you speak a language(s) other than English, what other language(s) do you speak?</label>
                  <input type="text" class="form-control" name="other_languages" value="<?php echo $myrow['other_languages']; ?>">
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
