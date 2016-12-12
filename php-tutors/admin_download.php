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
  <title>Edit</title>

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
    // create the all_teachers txt
        $teachers = $dbh->prepare("SELECT * FROM Teacher");
        $teachers->execute();
        $all_teachers = $teachers->fetchAll(PDO::FETCH_ASSOC);
        $teachers_headers = array("Site", "Name", "Email");
        create_csv($all_teachers, $teachers_headers, "all_teachers.csv");

    // create the all_requests txt
        $requests = $dbh->prepare("SELECT * FROM Request");
        $requests->execute();
        $all_requests = $requests->fetchAll(PDO::FETCH_ASSOC);
        $requests_headers = array("Site", "Name", "Email");
        create_csv($all_requests, $requests_headers, "all_requests.csv");

      } catch (PDOException $e) {
        print "Database error: " . $e->getMessage() . "<br/>";
        die();
      }

      ?>

      <a href="csvs_for_download/all_teachers.txt" target="_blank">Teachers</a>
      <br>
      <a href="csvs_for_download/all_requests.txt" target="_blank">Requests</a>
    </div>
  </body>
  </html>
