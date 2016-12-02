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
    <title>Delete</title>

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
  <div class="text-center">
    <h1>Delete Teacher</h1>
    <a href="admin_delete_all.php">Back to Delete Page</a>
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
  if("" == trim($_POST['email'])){
    echo "Please choose a teacher to delete.";
  }      
  $teacher_email = $_POST["email"];
  echo $teacher_email;
	$statement = $dbh->prepare('DELETE FROM Request WHERE teacher_email = ?');
	$statement->bindParam(1, $teacher_email);
  try {
    $statement->execute();
    echo "<h4>The teacher's requests have been deleted.</h4>";
  } catch (PDOException $e) {
     echo "Database error: " . $e->getMessage() . "<br/>";
     echo "<h4>The teacher's requests were not deleted properly.</h4>";
     die();
   }
   $statement = $dbh->prepare('DELETE FROM Teacher WHERE email = ?');
   $statement->bindParam(1, $teacher_email);
  try {
    $statement->execute();
    echo "<h4>The teacher has been deleted.</h4>";
  } catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "<br/>";
    echo "<h4>The teacher was not deleted properly.</h4>";
    die();
  }
 ?>

</body>
</html>