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
  <title>Edit Site</title>

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
          <h1>Edit a Site</h1>
        </div>

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
          $st = $dbh->query('SELECT * FROM Site ORDER BY name');
          if (($myrow = $st->fetch())) {
            ?>
            <form method="post" action="admin_edit_site.php">
              <h4>Select a site below to edit:</h4>
              <?php
              echo "<table class='table table-striped table-bordered table-hover'><th><td><b>Name</b></td><td><b>Transportation</b></td><td><b>Travel Time (min)</b></td><td><b>Is Van Eligible</b></td></th>";
              do {
                echo "<tr><td><input type='radio' name='name' value='" . $myrow['name'] . "'/></td>";
                echo "<td>" . $myrow['name'] . "</td><td>" . $myrow['transportation'] . "</td><td>" . $myrow['travel_time'] . "</td>";
                if ($myrow['is_van_eligible']) {
                  echo "<td>Yes</td></tr>";
                } else {
                  echo "<td>No</td></tr>";
                }
              } while ($myrow = $st->fetch());
              
              ?>
              <input class='btn btn-primary' type="submit" value="SELECT"/>
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
      </div>
    </body>
    </html>
