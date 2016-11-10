<?php
   ob_start();
   session_start();
?>

<?
   // error_reporting(E_ALL);
   // ini_set("display_errors", 1);
?>

<html lang = "en">
   
   <head>
      <title>PFS Login</title>
            
      
   </head>
	
   <body>
      
      <h2>Enter Username and Password</h2> 
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
            
            if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
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
				
               if ($numresults > 0) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = $input_name;
                  
                  $msg =  'In the System';
               }else {
                  $msg = 'Not in the system';
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
               name = "username" placeholder = "username = open" 
               required autofocus></br>
            <input type = "password" class = "form-control"
               name = "password" placeholder = "password = please" required>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
         </form>
			
         Click here to clean <a href = "logout.php" tite = "Logout">Session.
         
      </div> 
      
   </body>
</html>