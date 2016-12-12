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
        if("" == trim($_POST['request_id'])){
          echo "Please choose a request to edit.";
        }      
        $request_id = $_POST["request_id"];
        $_SESSION["request_id"] = $request_id;
        $statement = $dbh->prepare('SELECT * FROM Request, Teacher WHERE request_id = ? AND teacher_email = email');
        $statement->bindParam(1, $request_id);
        try {
          $statement->execute();
          if ($myrow = $statement->fetch()) {
           ?><h4><?php echo "Name: " . $myrow["name"]; ?></h4>
           <h4><?php echo "Email: " . $myrow["teacher_email"]; ?></h4>
           <h4><?php echo "School: " . $myrow["site_name"]; ?></h4>
           <h3>Edit Request</h3> <?php
           $_SESSION['name'] = $myrow["name"];
           $_SESSION['teacher_email'] = $myrow["teacher_email"];
           $_SESSION['site_name'] = $myrow["site_name"];
           $_SESSION['day'] = $myrow["day"];
           $_SESSION['start_time'] = $myrow["start_time"];
           $_SESSION['end_time'] = $myrow["end_time"];
           if($myrow["day"] == 1){
             $day = 'Monday';
             $selected = 1;
           }
           if($myrow["day"] == 2){
             $day = 'Tuesday';
             $selected = 2;
           }
           if($myrow["day"] == 3){
             $day = 'Wednesday';
             $selected = 3;
           }
           if($myrow["day"] == 4){
             $day = 'Thursday';
             $selected = 4;
           }
           if($myrow["day"] == 5){
             $day = 'Friday';
             $selected = 5;
           }
           ?>
           <form class="form-horizontal" method="post" action="admin_edit_teacher_request_success.php" id="editform">
             <div class="form-group">
              <div class="col-xs-4">
                <label for="day_of_week">Day of the Week:</label>
                <select class="form-control" name="day_of_week">
                  <option <?php if($selected == 1){echo ("selected");}?> value="Monday">Monday</option>
                  <option <?php if($selected == 2){echo ("selected");}?> value="Tuesday">Tuesday</option>
                  <option <?php if($selected == 3){echo ("selected");}?> value="Wednesday">Wednesday</option>
                  <option <?php if($selected == 4){echo ("selected");}?> value="Thursday">Thursday</option>
                  <option <?php if($selected == 5){echo ("selected");}?> value="Friday">Friday</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-4">
                <label for="start_time">Start Time:</label>
                <input type="time" class="form-control"  name="start_time" value="<?php echo $myrow['start_time']; ?>" required><br>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-4">
                <label for="end_time">End Time:</label>
                <input type="time" class="form-control" name="end_time" value="<?php echo $myrow['end_time']; ?>" required><br>
              </div> 
            </div>
            <div class="form-group">
              <div class="col-xs-4">
                <label for="grade_level">Grade Level:</label>
                <input type="text" class="form-control" name="grade_level" value="<?php echo $myrow['grade_level']; ?>"><br>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-4">
                <label for="language">Language:</label>
                <input type="text" class="form-control" name="language" value="<?php echo $myrow['language']; ?>"/><br>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-4">
                <label for="num_tutors">Number of Tutors:</label>
                <input type="number" class="form-control" name="num_tutors" min="1" max="10" step="1" value="<?php echo $myrow['num_tutors']; ?>" required><br>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-8">
                <label for="descripton">Description:</label>
                <textarea class="form-control" rows="4" cols="30" name="description" form="editform"><?php echo $myrow['description']; ?></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-4">
                <label for="num_tutors">Is Hidden:</label>
                <select class="form-control" name="is_hidden">
                 <option <?php if($myrow["is_hidden"]){echo ("selected");}?> value="Yes">Yes</option>
                 <option <?php if(!$myrow["is_hidden"]){echo ("selected");}?> value="No">No</option>
               </select>
             </div>
           </div>
           <input class="btn btn-primary" type="submit" value="Update Request">
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
