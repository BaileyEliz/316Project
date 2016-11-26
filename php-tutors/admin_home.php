<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

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
      $user = $_SESSION['username'];
      $a = 'admin';
      if($user!=$a){
        header("Location: loginscreen.php");
      }
    ?>

    <h1 class="text-center">It's the Admin Home Page!</h1>

    <a href="index.php">Back to Homepage</a>

    <div class="login">
      Download CSVs
      Teacher Requests
      All bookings
      Student Info
      per teacher
      per student
    </div>

    <a href="admin_download.php">Download tables</a>

    <br><br>

    <div class="login">
      Upload CSV
      Teacher Requests
    </div>

    <a href="admin_upload.php">Upload a Qualtrics CSV</a>

    <br><br>

    <div class="login">
      Edit
    </div>

    <a href="admin_select_teacher_request.php">Edit teacher requests</a>

    <br><br>

    <a href="admin_add_teacher_request.php">Add an individual request</a>

    <br><br>

    <div class="login">
      View bookings per teacher
    </div>

    <a href="admin_view_requests.php">View all requests, teachers, and sites</a>

    <br><br>

    <div class="login">
      Delete requests and bookings and everything but students
    </div>

    <a href="admin_delete_all.php">Delete data</a>

    <br><br>

    <div class="login">
      Edit bookings/pendings/etc.
    </div>

</body>
</html>