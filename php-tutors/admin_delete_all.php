<?php
      session_start();
      $user = $_SESSION['username'];
      $a = 'admin';
      if($user!=$a){
        header("Location: admin_login.php");
      }
?>

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
      <?php include_once('admin_navbar.php'); ?>
    </head>
    <body>
      <div class="container">
        <div class="text-center">
         <h1>Delete Teachers, Requests, and Sites</h1>
       </div>

       <p>Click below to delete all data (matches, requests, sites teachers).</p>
       <form class="form-horizontal" method="post" action="admin_delete_success.php">
        <input type="submit" class="btn btn-primary" value="DELETE ALL">
      </form>
      <br>



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
      ?>
      <?php
      try {
        $st = $dbh->query('SELECT * FROM Request, Teacher WHERE teacher_email = email ORDER BY request_id');
        if (($myrow = $st->fetch())) {
          ?>

          <form method="post" action="admin_delete_teacher_request.php">
            <h3>Delete a Request</h3>
            <?php
            echo "<table class='table table-striped table-bordered table-hover'><th><td><b>Request ID</b></td><td><b>Teacher Name</b></td><td><b>Teacher Email</b></td><td><b>Site</b></td><td><b>Grade Level</b></td><td><b>Day of the Week</b></td><td><b>Start Time</b></td><td><b>End Time</b></td><td><b># of Tutors</b></td><td><b>Language</b></td><td><b>Description</b></td></th>";      do {
              echo "<tr><td><input type='radio' name='request_id' value='" . $myrow['request_id'] . "'/></td>";
              if($myrow['day'] == 1){
                $day = 'Monday';
              }
              if($myrow['day'] == 2){
                $day = 'Tuesday';
              }
              if($myrow['day'] == 3){
                $day = 'Wednesday';
              }
              if($myrow['day'] == 4){
                $day = 'Thursday';
              }
              if($myrow['day'] == 5){
                $day = 'Friday';
              }
              $starttime = date("g:i a", strtotime($myrow["start_time"]));
              $endtime = date("g:i a", strtotime($myrow["end_time"]));
              echo "<td>" . $myrow['request_id'] . "</td><td>" . $myrow['name'] . "</td><td>" . $myrow['teacher_email'] . "</td><td>" . $myrow['site_name'] . "</td><td>" . $myrow['grade_level'] . "</td><td>" . $day . "</td><td>" . $starttime . "</td><td>" . $endtime . "</td><td>" . $myrow['num_tutors'] . "</td><td>" . $myrow['language'] . "</td><td>" . $myrow['description'] . "</td></tr>";
            } while ($myrow = $st->fetch());
            
            ?>
            <input class='btn btn-primary' type="submit" value="DELETE"/>

          </form>

          <?php
        } else {
          echo "There are no requests in the database.";
        }
      } catch (PDOException $e) {
        print "Database error: " . $e->getMessage() . "<br/>";
        die();
      }
      ?>
      <div>
        <?php
        try {
          $st = $dbh->query('SELECT * FROM Teacher ORDER BY name');
          if (($myrow = $st->fetch())) {
            ?>

            <form method="post" action="admin_delete_teacher.php">

              <?php
              echo "<table class='table table-striped table-bordered table-hover'><th><td><b>Name</b></td><td><b>Email</b></td><td><b>School</b></td></th>";
              do {
                echo "<tr><td><input type='radio' name='email' value='" . $myrow['email'] . "'/></td>";
                echo "<td>" . $myrow['name'] . "</td><td>" . $myrow['email'] . "</td><td>" . $myrow['site_name'] . "</td></tr>";
              } while ($myrow = $st->fetch());
              ?>
              <h3>Delete a Teacher</h3>
              <input class='btn btn-primary' type="submit" value="DELETE"/>
            </form>

            <?php
          } else {
            echo "There are no teachers in the database.";
          }
        } catch (PDOException $e) {
          print "Database error: " . $e->getMessage() . "<br/>";
          die();
        }
        ?>
      </div>
    </body>
    </html>
