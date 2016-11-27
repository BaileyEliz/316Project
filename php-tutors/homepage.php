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

    <h1 class="text-center">Welcome to the Partners For Success Scheduler!</h1>

    <div class="login text-center">
      <form action="student_login.php" method="post">
        <input class = "btn btn-lg btn-primary" type="submit" value="Student Log In">
      </form>
      <!--Students log in 
      <a href="student_login.php">here</a>-->
    </div>

    <br>

    <div class="login text-center">
      <form action="admin_login.php" method="post">
        <input class = "btn btn-lg btn-primary" type="submit" value="Administrator Log In">
      </form>
      <!--Administrators log in 
      <a href="admin_login.php">here</a>-->
    </div>

  </body>
</html>