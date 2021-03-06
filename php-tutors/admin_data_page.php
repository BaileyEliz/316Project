<?php
      session_start();
      $user = $_SESSION['username'];
      $a = 'admin';
      if($user!=$a){
        header("Location: admin_login.php");
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Data</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <?php include_once('admin_navbar.php'); ?>
    </head>
    <body>
      
      <h1 class="text-center">Data</h1>

      <div class="container">

        

        <a href="admin_add_teacher_request.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Add a Request</a>

        <br><br>

        <a href="admin_select_teacher_request.php" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-edit"></span> Edit Teacher Requests</a>

        <br><br>

        <a href="admin_select_site.php" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-edit"></span> Edit Sites</a>

        <br><br>

        <a href="admin_view_requests.php" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-eye-open"></span> View All Data</a>

        <br><br>

        <a href="admin_delete_all.php" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-remove"></span> Delete Data</a>

      </div>

    </body>
    </html>
