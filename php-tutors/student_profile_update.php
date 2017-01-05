<?php
  session_start();
  $user = "generic";
  if($_SESSION['username']) {
    $user = $_SESSION['username'];
  }else{
      	 header("Location: student_login.php");
  }
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

  <title>Profile Updated</title>
</head>

<body>

  <br>

  Profile updated successfully!

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
 
  
  $user = $_SESSION["username"];
  $name = $_POST["name"];
  $pass = $_POST["password"];
  $birth_date = $_POST["birth_date"];
  $duke_email = $_POST["duke_email"];
  $graduation_year = $_POST["graduation_year"];
  $course = $_POST["course"];
  $major_and_minor = $_POST["major_and_minor"];
  $has_previous_experience = $_POST["has_previous_experience"];
  $is_education_minor = $_POST["is_education_minor"];
  $is_licensure_track = $_POST["is_licensure_track"];
  $is_america_reads_america_counts_tutor = $_POST["is_america_reads_america_counts_tutor"];
  $is_varsity_athlete = $_POST["is_varsity_athlete"];
  $varsity_team = $_POST["varsity_team"];
  $varsity_academic_advisor = $_POST["varsity_academic_advisor"];
  $other_languages = $_POST["other_languages"];

  $statement = $dbh->prepare("UPDATE TutorInfo SET name = ?, password = ?, birth_date = ?, duke_email = ?, graduation_year = ?, course = ?, major_and_minor = ?, has_previous_experience = ?, is_education_minor = ?, is_licensure_track = ?, is_america_reads_america_counts_tutor = ?, is_varsity_athlete = ?, varsity_team = ?, varsity_academic_advisor = ?, other_languages = ? WHERE tutor_id = ?");

  try{
    $statement->execute(array($name, $pass, $birth_date, $duke_email, $graduation_year, $course, $major_and_minor, $has_previous_experience, $is_education_minor, $is_licensure_track, $is_america_reads_america_counts_tutor, $is_varsity_athlete, $varsity_team, $varsity_academic_advisor, $other_languages, $user));
  } catch (PDOException $e){
    echo $e->getMessage() . "<br/>";
  }
  header("Location: student_profile_home.php");

  ?>

</body>
</html>
