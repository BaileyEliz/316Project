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
  if("" == trim($_POST['site_name'])){
    echo "Please choose a site to delete.";
  }      
  $site_name = $_POST["site_name"];
  echo $site_name;
	// $statement = $dbh->prepare('DELETE FROM Request WHERE name = ?');
	// $statement->bindParam(1, $site_name);
 //  try {
 //    $statement->execute();                                                            //delete requests of teachers at that site, then teachers at
 //    echo "<h4>The site's teachers' requests have been deleted.</h4>";                 //that site, then the site itself
 //  } catch (PDOException $e) {
 //     echo "Database error: " . $e->getMessage() . "<br/>";
 //     echo "<h4>The teacher's requests were not deleted properly.</h4>";
 //     die();
 //   }
 ?>

</body>
</html>