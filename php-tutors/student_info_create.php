<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Create Profile</title>

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
    <h1 class="text-center">Create Student Profile</h1>

    <h1>Login Information</h1>

    <a href="student_login.php">Back to Login</a>
    <br>
    <form class="form-horizontal" action="student_profile_upload.php" method="post">
      <div class="form-group">
        <div class="col-xs-4">
          <label for="name">Name:</label>
          <input type="text" class="form-control" name="name" required>
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-4">
          <label for="netid">NetID (Username):</label>
          <input type="text" class="form-control" name="netid" required>
        </div>
      </div>
    <input type="submit" class="btn btn-primary" value="Submit Profile">
    </form>

  </body>
</html>