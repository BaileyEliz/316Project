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
  </head>
<body>
<h1>Add an availability</h1>

<?php
  $user = "generic";
  if($_SESSION['username']) {
    $user = $_SESSION['username'];
  }


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
  $st = $dbh->prepare("INSERT INTO TutorAvailable VALUES (?, ?, ?, ?)");
  $values = array();
  $day = 0;
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
  $values[] = $user;
  $values[] = $day;
  $values[] = $_POST["start_time"];
  $values[] = $_POST["end_time"];

  var_dump($values);

  try{
    $st->execute($values);
    header("Refresh:0; url=student_availability_edit.php");
  }  catch (PDOException $e){
    echo $e->getMessage() . "<br/>";
    echo "<h4>The request was not updated properly.</h4>";
  }
?>


</body>
</html>