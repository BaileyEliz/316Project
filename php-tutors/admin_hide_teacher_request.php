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
          <h1>Edit a Teacher's Visibility</h1>
          <a href="admin_select_teacher_request.php">Back to Choose a Request</a>
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
        if("" == trim($_POST['teacher_name'])){
          echo "Please choose a teacher to edit.";
        }      
        $teacher_name = $_POST["teacher_name"];
        $_SESSION["teacher_name"] = $teacher_name;
        $statement = $dbh->prepare('SELECT * FROM Request, Teacher WHERE name = ? AND teacher_email = email');
        $statement->bindParam(1, $teacher_name);
        try {
          $statement->execute();
          if ($myrow = $statement->fetch()) {
           ?><h4><?php echo "Name: " . $myrow["name"]; ?></h4>
           <h4><?php echo "Email: " . $myrow["teacher_email"]; ?></h4>
           <h4><?php echo "School: " . $myrow["site_name"]; ?></h4>
           <?php $_SESSION["site_name"] = $myrow["site_name"]; ?>
           <h3>Edit Request</h3>
           <form class="form-horizontal" method="post" action="admin_hide_teacher_success.php" id="hideform">
            <div class="form-group">
              <div class="col-xs-4">
                <label for="num_tutors">Is Hidden:</label>
                <select class="form-control" name="is_hidden">
                 <option <?php if($myrow["is_hidden"]){echo ("selected");}?> value="Yes">Yes</option>
                 <option <?php if(!$myrow["is_hidden"]){echo ("selected");}?> value="No">No</option>
               </select>
             </div>
           </div>
           <input class="btn btn-primary" type="submit" value="Update Teacher">
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
