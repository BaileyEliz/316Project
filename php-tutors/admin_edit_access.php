<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Edit Admin Access</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

 
    <?php include_once('admin_navbar.php'); ?>
</head>
    
<body>
    <?php
      session_start();
      $user = $_SESSION['username'];
      $a = 'admin';
      if($user!=$a){
        header("Location: admin_login.php");
      }
      
      
      if (!empty($_POST['keycode'])){
      	try {
    		include("pdo-tutors.php");
    		$dbh = dbconnect();
  		} catch (PDOException $e) {
    		print "Error connecting to the database: " . $e->getMessage() . "<br/>";
    		die();
  		}
  		$statement = $dbh->prepare("INSERT INTO AdminInfo VALUES(?)");
  		$statement->bindParam(1, $_POST['keycode']); 
  		try{
    		$statement->execute();
    	} catch (PDOException $e) {
         print "Database error: " . $e->getMessage() . "<br/>";
         die();
       }
      }
    

  		
	?>
        
 <div class="container">
            <h1 class="text-center">Edit Admin Access</h1>

            <br>
            <h4>Add New Password: </h4>
            <form class="form-horizontal" action="admin_edit_access.php" method="post">
              <div class="form-group">
                <div class="col-xs-4">
                  <input type="text" class="form-control" name="keycode" placeholder="New Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'New Password'" />
                </div>
              </div>
              <input type="submit" class="btn btn-primary" value="Update Access">
            </form>
     </div>
</body>
</html>