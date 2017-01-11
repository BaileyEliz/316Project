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
  <title>Download</title>

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
       <h1>Download a CSV</h1>

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
    //$dbh->query("COPY (SELECT * FROM Teacher) TO '/tmp/export.csv' WITH DELIMITER ',' CSV HEADER");
    //$dbh->execute
      } catch (PDOEXception $e) {
        echo $e->getMessage() . "<br/>";
      }
      

      ?>

      <?php

      function create_csv($info, $headers, $filename) {

    //unlink($_SERVER['DOCUMENT_ROOT'] . "/php-tutors/csvs_for_download/" . $filename);
        $new_file = fopen($_SERVER['DOCUMENT_ROOT'] . "/php-tutors/csvs_for_download/" . $filename, "w");

        foreach ($headers as $column) {
          fwrite($new_file, $column);
          fwrite($new_file, ",");
        }
        fwrite($new_file, "\n");

        foreach ($info as $one_row) {
          foreach ($one_row as $one_cell) {
            fwrite($new_file, $one_cell);
            fwrite($new_file, ",");
          }
          fwrite($new_file, "\n");
        }
        fclose($new_file);
      }

      try{
    // create the all_teachers csv
        $teachers = $dbh->prepare("SELECT * FROM Teacher");
        $teachers->execute();
        $all_teachers = $teachers->fetchAll(PDO::FETCH_ASSOC);
        $teachers_headers = array("Site", "Name", "Email");
        create_csv($all_teachers, $teachers_headers, "all_teachers.csv");

    // create the all_requests csv
        $requests = $dbh->prepare("SELECT * FROM Request");
        $requests->execute();
        $all_requests = $requests->fetchAll(PDO::FETCH_ASSOC);
        $requests_headers = array("Day", "Grade Level", "Start Time", "End Time", "Teacher Email", "Number of Tutors", "Language", "Description", "Is Hidden", "Request ID");
        create_csv($all_requests, $requests_headers, "all_requests.csv");

    // create the master_list csv
        $tutors = $dbh->prepare("SELECT * FROM TutorInfo");
        $tutors->execute();
        $all_tutors = $tutors->fetchAll(PDO::FETCH_ASSOC);

        foreach ($all_tutors as $one_tutor) {
          $tutor_id = $one_tutor['tutor_id'];
          $served_teachers = $dbh->prepare("SELECT DISTINCT Teacher.email, Teacher.name, Teacher.site_name FROM TutorInfo, Bookings, Teacher WHERE TutorInfo.tutor_id = ? and TutorInfo.tutor_id = Bookings.tutor_id and Bookings.teacher_email = Teacher.email");
          $served_teachers->execute(array($tutor_id));
          $all_teachers = $served_teachers->fetchAll(PDO::FETCH_ASSOC);

          foreach ($all_teachers as $one_teacher) {
            $teacher_id = $one_teacher['email'];

            $row_bookings = $dbh->prepare("SELECT * FROM TutorInfo, Bookings WHERE TutorInfo.tutor_id = ? and TutorInfo.tutor_id = Bookings.tutor_id and Bookings.teacher_email = ?");
            $row_bookings->execute(array($tutor_id, $teacher_id));
            $valid_bookings = $row_bookings->fetchAll(PDO::FETCH_ASSOC);

            $one_row[] = $one_tutor['name'];
            $one_row[] = $one_tutor['tutor_id'];
            $one_row[] = $one_tutor['duke_email'];
            $one_row[] = $one_tutor['graduation_year'];
            $one_row[] = $one_tutor['course'];
            $one_row[] = $one_tutor['professor'];

            $one_row[] = $one_teacher['name'];
            $one_row[] = $one_teacher['site_name'];

            // !!! here we're assuming there are only 3 bookings for each tutor and teacher
            foreach ($valid_bookings as $one_valid_booking) {

              if($one_valid_booking['day'] == 1){
                $one_row[] = "Monday";
              }
              if($one_valid_booking['day'] == 2){
                $one_row[] = "Tuesday";
              }
              if($one_valid_booking['day'] == 3){
                $one_row[] = "Wednesday";
              }
              if($one_valid_booking['day'] == 4){
                $one_row[] = "Thursday";
              }
              if($one_valid_booking['day'] == 5){
                $one_row[] = "Friday";
              }

              $one_row[] = $one_valid_booking['start_time'];
              $one_row[] = $one_valid_booking['end_time'];
            }

            $num_bookings = count($valid_bookings);
            for ($i = $num_bookings; $i <= 3 - $num_bookings; $i++) {
              $one_row[] = "";
              $one_row[] = "";
              $one_row[] = "";
            }

            $all_rows[] = $one_row;

            unset($one_row);

          }
        }

        $master_headers = array("Name", "Tutor ID", "Duke Email", "Graduation Year", "Course", "Professor", "Teacher Name", "Site", "Day 1", "Start Time 1", "End Time 1", "Day 2", "Start Time 2", "End Time 2", "Day 3", "Start Time 3", "End Time 3");
        create_csv($all_rows, $master_headers, "master_list.csv");

      } catch (PDOException $e) {
        print "Database error: " . $e->getMessage() . "<br/>";
        die();
      }

      ?>

      <a href="csvs_for_download/all_teachers.csv" target="_blank">Teachers</a>
      <br>
      <a href="csvs_for_download/all_requests.csv" target="_blank">Requests</a>
      <br>
      <a href="csvs_for_download/master_list.csv" target="_blank">Master List</a>
    </div>
  </body>
  </html>
