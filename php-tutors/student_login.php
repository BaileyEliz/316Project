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

    <h1 class="text-center">Student Login</h1>

    <div class="username">
      <div class = "container form-signin">
         
         <?php
         
           try {
    			
    			include("pdo-tutors.php");
    			$dbh = dbconnect();
  			} catch (PDOException $e) {
    			print "Error connecting to the database: " . $e->getMessage() . "<br/>";
    			die();
  			}
         
         	
         	
            $msg = '';
            
            if (isset($_POST['login']) && !empty($_POST['username']) ) {
				$input_name = $_POST['username'];
				//echo $input_name;
				
				// $check = $dbh->query('SELECT tutor_id FROM TUTORINFO WHERE tutor_id = 'jtb43'');
// 				$results = $check->fetch();
// 				echo $results;

				$check = $dbh->prepare('SELECT tutor_id FROM tutorinfo WHERE tutor_id = :id');
				$check->bindParam(':id', $input_name, PDO::PARAM_STR);
				$check->execute();
				$numresults = $check->rowCount();
				
				//echo "here is result         ";
				//echo $numresults;
				if($input_name == 'admin'){
               			header("Location: admin_login.php");
               			exit;
               		}
			
               if ($numresults > 0) {
            
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = $input_name;
                  header("Location: student_profile_home.php"); 
				  exit;
                  
                  $msg =  'In the System';
               }else {
                  $msg =  'Unrecognized net-id. Create a new profile.';
				  
               }
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
      
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type = "text" class = "form-control" 
               name = "username" placeholder = "net-id" 
               required autofocus></br>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
         </form>
			
         
      </div>
      <div class="text-center"><br>New to the site? Create a profile <a href = "student_info_create.php" title = "Create_profile">here!</a></div>
    </div>

  </body>
</html>