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
  <title>All Info</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link rel='stylesheet' type='text/css' href='data_tables_style.css'>

    <!-- jquery for table sorting -->
  <script src="jquery-3.1.1.min.js"></script>
  <script src="jquery.tablesorter.min.js"></script>

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
        <h1>All Requests</h1>

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

        try {
          $st = $dbh->query('SELECT * FROM Request, Teacher WHERE teacher_email = email ORDER BY Teacher.name');
          if (($myrow = $st->fetch())) {
            echo "<table id='requests_table' class='table table-striped table-bordered' class='tablesorter'><thead><th>Teacher Name</th><th>Email</th><th>Site</th><th>Grade Level</th><th>Day</th><th>Start Time</th><th>End Time</th><th># of Tutors</th><th>Language</th><th>Description</th><th>Is Hidden</th></thead><tbody>";
            do {
             echo "<tr><td>" . $myrow['name'] . "</td>";
             echo "<td>" . $myrow['teacher_email'] . "</td>";
             echo "<td>" . $myrow['site_name'] . "</td>";
             echo "<td>" . $myrow['grade_level'] . "</td>";
             if($myrow['day'] == 1){
              echo '<td>Monday</td>';
            }
            if($myrow['day'] == 2){
              echo '<td>Tuesday</td>';
            }
            if($myrow['day'] == 3){
              echo '<td>Wednesday</td>';
            }
            if($myrow['day'] == 4){
              echo '<td>Thursday</td>';
            }
            if($myrow['day'] == 5){
              echo '<td>Friday</td>';
            }
            $starttime = date("g:i a", strtotime($myrow["start_time"]));
            $endtime = date("g:i a", strtotime($myrow["end_time"]));
            echo "<td>" . $starttime . "</td>";
            echo "<td>" . $endtime . "</td>";
            echo "<td>" . $myrow['num_tutors'] . "</td>";
            echo "<td>" . $myrow['language'] . "</td>";
            echo "<td><div class='description_cell'>" . $myrow['description'] . "</div></td>";
            if ($myrow['is_hidden']) {
              echo "<td>Yes</td></tr>";
            } else {
              echo "<td>No</td></tr>";
            }
          } while ($myrow = $st->fetch());
          echo "</tbody></table>";
        }
      }
      catch(PDOException $e){
        echo "Error: " . $e;
      }
      ?>

      <h1>All Teachers</h1>
      <?php 
      try{
        $st = $dbh->query('SELECT Teacher.name AS teacher_name, Teacher.email AS teacher_email, Teacher.site_name AS site_name FROM Teacher, Site WHERE site_name = Site.name ORDER BY teacher_name');
        $num_requests = $dbh->prepare('SELECT * FROM Request WHERE Request.teacher_email = ?');
        $num_tutors_requested = $dbh->prepare('SELECT SUM(num_tutors) FROM Request WHERE Request.teacher_email = ?');
        $num_tutors = $dbh->prepare('SELECT * FROM Bookings WHERE Bookings.teacher_email = ?');

        if(($myrow = $st->fetch())){

          echo "<table id='teacher_table' class='table table-striped table-bordered' class='tablesorter'><thead><th>Name</th><th>Email</th><th>Site</th><th># of Requests Made</th><th># of Tutors Requested</th><th># of Tutors Matched</th></thead><tbody>";
          do{
            $teacher_requests = $num_requests->execute(array($myrow['teacher_email']));
            $all_teacher_requests = $num_requests->fetchAll(PDO::FETCH_ASSOC);

            $num_tutors_requested->execute(array($myrow['teacher_email']));
            $teacher_number_of_tutors = $num_tutors_requested->fetch(PDO::FETCH_ASSOC);

            $num_tutors->execute(array($myrow['teacher_email']));
            $matched_tutors = $num_tutors->fetchAll(PDO::FETCH_ASSOC);

            echo "<tr><td>" . $myrow['teacher_name'] . "</td>";
            echo "<td>" . $myrow['teacher_email'] . "</td>";
            echo "<td>" . $myrow['site_name'] . "</td>";
            echo "<td>" . count($all_teacher_requests) . "</td>";
            echo "<td>" . $teacher_number_of_tutors['sum'] . "</td>";
            echo "<td>" . count($matched_tutors) . "</td></tr>";
          } while ($myrow = $st->fetch());
          echo "</tbody></table>";
        }
      }
      catch (PDOException $e){
        echo "Error: " . $e;
      }
      ?>
      <h1>All Sites</h1>
      <?php
      try{
        $st = $dbh->query('SELECT * FROM Site ORDER BY name');
        if(($myrow = $st->fetch())){
          echo "<table id='site_table' class='table table-striped table-bordered' class='tablesorter'><thead><th>Site Name</th><th>Transportation</th><th>Travel Time (min)</th><th>Is Van Eligible</th></thead><tbody>";
          do{
            echo "<tr><td>" . $myrow['name'] . "</td><td>" . $myrow["transportation"] . "</td><td>" . $myrow["travel_time"] . "</td>";
            if ($myrow['is_van_eligible']) {
              echo "<td>Yes</td></tr>";
            } else {
              echo "<td>No</td></tr>";
            }
          } while ($myrow = $st->fetch());
          echo "</tbody></table>";
        }
      }
      catch (PDOException $e){
        echo "Error: " . $e;
      }
      ?>

      <h1>All Tutors</h1>
      <?php
      try{
        $st = $dbh->query('SELECT * FROM TutorInfo ORDER BY tutor_id');
        if(($myrow = $st->fetch())){
          echo "<table id ='tutors_table' class='table table-striped table-bordered' class='tablesorter'><thead><th>Tutor ID</th><th>Name</th></thead><tbody>";
          do{
            echo "<tr><td>" . $myrow['tutor_id'] . "</td>";
            echo "<td>" . $myrow['name'] . "</td></tr>";
          } while ($myrow = $st->fetch());
          echo "</tbody></table>";
        }
      }
      catch (PDOException $e){
        echo "Error: " . $e;
      }
      ?>

      <h1>Tutor Availability</h1>
      <?php
      try{
        $st = $dbh->query('SELECT * FROM TutorAvailable ORDER BY tutor_id, day');
        if(($myrow = $st->fetch())){
          echo "<table id='tutor_availability_table' class='table table-striped table-bordered' class='tablesorter'><thead><th>Tutor ID</th><th>Day</th><th>Start Time</th><th>End Time</th></thead><tbody>";
          do{
            if($myrow['day'] == 1){
              $day = "Monday";
            }
            if($myrow['day'] == 2){
              $day = "Tuesday";
            }
            if($myrow['day'] == 3){
              $day = "Wednesday";
            }
            if($myrow['day'] == 4){
              $day = "Thursday";
            }
            if($myrow['day'] == 5){
              $day = "Friday";
            }
            $starttime = date("g:i a", strtotime($myrow["start_time"]));
            $endtime = date("g:i a", strtotime($myrow["end_time"]));
            echo "<tr><td>" . $myrow['tutor_id'] . "</td><td>" . $day . "</td><td>" . $starttime . "</td><td>" . $endtime . "</td></tr>";
          } while ($myrow = $st->fetch());
          echo "</tbody></table>";
        }
      }
      catch (PDOException $e){
        echo "Error: " . $e;
      }
      ?>
<!--Maybe will also display bookings... However not sure how useful this page is in the scheme of the site. Useful for testing different functoinality
  across the whole site when manipulating data within the database. Look into this more later, but as of now, it will be helpful for observing how the 
  data is being changed.-->
</div>

<script>
        $(document).ready(function(){
          $(function(){
            $("#requests_table").tablesorter();
            $("#teacher_table").tablesorter();
            $("#site_table").tablesorter();
            $("#tutors_table").tablesorter();
            $("#tutor_availability_table").tablesorter();
          });
        });
      </script>

</body>
</html>
