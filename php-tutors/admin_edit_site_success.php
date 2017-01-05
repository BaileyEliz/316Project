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
  <title>Edit </title>

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
        <h1>Edit a Site</h1>

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
        $st = $dbh->prepare("UPDATE Site SET transportation = ?, travel_time = ?, is_van_eligible = ? WHERE name = ?");
        $values = array();
        $values[] = $_POST["transportation"];
        $values[] = $_POST["travel_time"];
        if($_POST["is_van_eligible"] == "Yes"){
          $values[] = "TRUE";
        } else {
          $values[] = "FALSE";
        }
        $values[] = $_SESSION["name"];

        try{
         $st->execute($values);
         echo "<h4>The request has been updated.</h4>";
       }  catch (PDOException $e){
        echo $e->getMessage() . "<br/>";
        echo "<h4>The request was not updated properly.</h4>";
      }
      ?>

      <table class='table table-striped table-bordered'>
        <th>Name</th><th>Transportation</th><th>Travel Time (min)</th><th>Is Van Eligible</th>
        <tr>
          <td><?php echo $_SESSION["name"];?></td>
          <td><?php echo $_POST["transportation"];?></td>
          <td><?php echo $_POST["travel_time"];?></td>
          <td><?php 
            if ($_POST['is_van_eligible']) {
              echo "Yes";
            } else {
              echo "No";
            }?></td>
        </tr>
      </table>
      <a href="admin_home.php">Back to Admin Homepage</a>
      <br>
      <a href="admin_select_site.php">Back to Choose a Site</a>
      <br>
    </div>
  </body>
  </html>
