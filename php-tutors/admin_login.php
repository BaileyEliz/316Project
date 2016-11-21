<?php

   session_start();
	if(isset($_POST['login']) && !empty($_POST['password']) ) {
		echo "<br/>".$_POST['password']."<br/>";
		if($_POST['password']=='admin'){
			$_SESSION['username'] = 'admin';
			header("Location: admin-interface.php");
			exit;
            
		}else{
			echo "Incorrect Password";
		}
	}

?>


<form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            
            <input type = "text" class = "form-control" 
               name = "password" placeholder = "password" 
               required autofocus></br>
               
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
               
</form>