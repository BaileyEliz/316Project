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

    <h1 class="text-center">Edit Student Profile</h1>

    <h1>Login Information</h1>

    <a href="student_login.php">Back to Login</a>
    <br>

    <form action="student_profile_upload.php" method="post">
      Name: <input type="text" name="name" required><br>
      NetID (Username): <input type="text" name="netid" required><br>
      <div class="car">Do you have a car?</div>
      <div class="save">
        When I click the save button this info writes to the database and I'm directed
        <a href="student_profile_home.php">here</a>
      </div>
    <input type="submit" value="Submit Profile">
    </form>

  </body>
</html>