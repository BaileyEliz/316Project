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
  <div class="text-center">
    <h1>Delete Request</h1>
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
  if("" == trim($_POST['request_id'])){
    echo "Please choose a request to delete.";
  }      
  $request_id = $_POST["request_id"];
  $_SESSION["request_id"] = $request_id;
  echo $request_id;
	$statement = $dbh->prepare('DELETE FROM Request WHERE request_id = ?');
	$statement->bindParam(1, $request_id);
  try {
    $statement->execute();
    echo "<h4>The request has been deleted.</h4>";
  } catch (PDOException $e) {
     echo "Database error: " . $e->getMessage() . "<br/>";
     echo "<h4>The request was not deleted properly.</h4>";
     die();
   }
 ?>

</body>
</html>