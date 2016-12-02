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
  </head>
  <body>
<?php

   session_start();
	if(isset($_POST['login']) && !empty($_POST['password']) ) {
		echo "<br/>".$_POST['password']."<br/>";
		if($_POST['password']=='admin'){
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
            
            <input type = "text" class = "form-control" 
               name = "password" placeholder = "password" 
               required autofocus></br>
               
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
               
</form>
</div>

</body>
</html>