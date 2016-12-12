<?php
   session_start();
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
<h1>Added Request</h1>

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
    $foreign_key_check_teacher = $dbh->prepare("SELECT * FROM Teacher WHERE email = ?");
    $foreign_key_check_teacher->execute(array($_POST["email"]));
    // if there is no teacher with this email, add a new teacher
    if(count($foreign_key_check_teacher->fetchAll(PDO::FETCH_ASSOC)) < 1) {
      // when adding a teacher, we need to make sure that the site exists
      $foreign_key_check_site = $dbh->prepare("SELECT * FROM Site WHERE name = ?");
      $foreign_key_check_site->execute(array($_POST["school"]));
      // if the site does not exist, add a new site
      if(count($foreign_key_check_site->fetchAll(PDO::FETCH_ASSOC)) < 1) {
        $site_insert_statement = $dbh->prepare("INSERT INTO Site VALUES (?, ?, ?)");
        $site_insert_statement->execute(array($_POST["school"], $_POST["transportation_type"], $_POST["transportation_time"]));
      }
      // add the teacher
      $teacher_insert_statement = $dbh->prepare("INSERT INTO Teacher VALUES (?, ?, ?)");
      $teacher_insert_statement->execute(array($_POST["school"], $_POST["name"], $_POST["email"]));
    }
  } catch (PDOException $e) {
    print "Error in the database: " . $e->getMessage() . "<br/>";
    die();
  }

  $st = $dbh->prepare("INSERT INTO Request VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

  $values = array();
  if($_POST["day_of_week"] == "Monday"){
    $day = 1;
  }
  if($_POST["day_of_week"] == "Tuesday"){
    $day = 2;
  }
  if($_POST["day_of_week"] == "Wednesday"){
    $day = 3;
  }
  if($_POST["day_of_week"] == "Thursday"){
    $day = 4;
  }
  if($_POST["day_of_week"] == "Friday"){
    $day = 5;
  }

  $values[] = $day;
  $values[] = $_POST["grade_level"];
  $values[] = $_POST["start_time"];
  $values[] = $_POST["end_time"];
  $values[] = $_POST["email"];
  $values[] = $_POST["num_tutors"];
  $values[] = $_POST["language"];
  $values[] = $_POST["description"];

  if($_POST["is_hidden"] == "Yes"){
    $values[] = "TRUE";
  } else {
    $values[] = "FALSE";
  }

  try{
  	$st->execute($values);
    echo "<h4>The request has been updated.</h4>";
  }  catch (PDOException $e){
    echo $e->getMessage() . "<br/>";
    echo "<h4>The request was not updated properly.</h4>";
  }
?>

<table class='table table-striped table-bordered'>
  <th>Request ID</th><th>Teacher Name</th><th>Teacher Email</th><th>Site</th><th>Grade Level</th><th>Day of the Week</th><th>Start Time</th><th>End Time</th><th># of Tutors</th><th>Language</th><th>Description</th><th>Is Hidden</th>
  <tr>
    <td>calculated</td>
    <td><?php echo $_POST["name"];?></td>
    <td><?php echo $_POST["email"];?></td>
    <td><?php echo $_POST["school"];?></td>
    <td><?php echo $_POST["grade_level"];?></td>
    <td><?php echo $_POST["day_of_week"]?></td>
    <td><?php echo (date("g:i a", strtotime($_POST["start_time"])));?></td>
    <td><?php echo (date("g:i a", strtotime($_POST["end_time"])));?></td>
    <td><?php echo $_POST["num_tutors"]?></td>
    <td><?php echo $_POST["language"];?></td>
    <td><?php echo $_POST["description"];?></td>
    <td><?php echo $_POST["is_hidden"]; ?></td>
  </tr>
</table>

<a href="admin_add_teacher_request.php">Add Another Request</a>
<br>
</div>
</body>
</html>