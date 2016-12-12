<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>home</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <?php include_once('start_navbar.php'); ?>
    </head>
    <body>
      <?php
      
      try {
           include("pdo-tutors.php");
           $dbh = dbconnect();
         } catch (PDOException $e) {
           print "Error connecting to the database: " . $e->getMessage() . "<br/>";
           die();
         }


      session_start();
      if(isset($_POST['login']) && !empty($_POST['keycode']) ) {
              
        $keycode = $_POST['keycode'];
		$check = $dbh->prepare('SELECT keycode FROM admininfo WHERE keycode = :key');
		$check->bindParam(':key', $keycode, PDO::PARAM_STR);
		$check->execute();
		$numresults = $check->rowCount();

        if($numresults > 0){
         $_SESSION['username'] = 'admin';
         header("Location: admin_home.php");
         exit;
         
       }else{
         echo "Incorrect Password";
       }
     }

     ?>

     <h1 class="text-center">Admin Login</h1>
     <div class = "container">
      <form class = "form-signin" role = "form" 
      action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
      ?>" method = "post">
      
      <input type = "password" class = "form-control" 
      name = "keycode" placeholder = "password" 
      required autofocus></br>
      
      <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
      name = "login">Login</button>
      
    </form>
  </div>

</body>
</html>