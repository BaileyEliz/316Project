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
        <div class="text-center">
          <h1>Edit a Request</h1>
          <a href="admin_select_site.php">Back to Choose a Site</a>
          <br>
          <br>
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
        if("" == trim($_POST['name'])){
          echo "Please choose a site to edit.";
        }      
        $site_name = $_POST["name"];
        $_SESSION["name"] = $site_name;
        $statement = $dbh->prepare('SELECT * FROM Site WHERE name = ?');
        $statement->bindParam(1, $site_name);
        try {
          $statement->execute();
          if ($myrow = $statement->fetch()) {
            ?><h4><?php echo "Name: " . $myrow["name"]; ?></h4>
            <h3>Edit Site</h3> 
            <form class="form-horizontal" method="post" action="admin_edit_site_success.php" id="editform">
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="grade_level">Transportation:</label>
                  <input type="text" class="form-control" name="transportation" value="<?php echo $myrow['transportation']; ?>"><br>
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4">
                  <label for="language">Travel Time (min):</label>
                  <input type="text" class="form-control" name="travel_time" value="<?php echo $myrow['travel_time']; ?>"/><br>
                </div>
              </div>
              <input class="btn btn-primary" type="submit" value="Update Site">
              <br>
              <br>
              <?php
            }
          } catch (PDOException $e) {
           print "Database error: " . $e->getMessage() . "<br/>";
           die();
         }
         ?> 
       </div>
       <script type="text/javascript">
       function checkvalue(val) {
        if(val==="Other")
         document.getElementById('language').style.display='block';
       else
         document.getElementById('language').style.display='none'; 
     }
     </script>

   </body>
   </html>
