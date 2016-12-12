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
	<title>Admin Upload</title>

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
  	<div class="container">
  		<div class="text-center">
  			<h1>Add a Request</h1>
  		</div>

  		<form class='form-horizontal' action="admin_add_teacher_request_success.php" method="post" id="requestform">
  			<div class="form-group">
  				<div class="col-xs-4">
  					<label for="name">Name:</label>
  					<input type="text" class="form-control" name="name" required>
  				</div>
  			</div>
  			<div class="form-group">
  				<div class="col-xs-4">
  					<label for="email">Email:</label>
  					<input type="email" class="form-control" name="email" required>
  				</div>
  			</div>
  			<div class="form-group">
  				<div class="col-xs-4">
  					<label for="school">School:</label>
  					<select class="form-control" name="school" required>
  						<option value="Crest Street Tutorial Project">Crest Street Tutorial Project</option>
  						<option value="Lyon Park Community Scholars">Lyon Park Community Scholars</option>
  						<option value="Durham Nativity School">Durham Nativity School</option>
  						<option value="YEP at the Durham Literacy Center">YEP at the Durham Literacy Center</option>
  						<option value="Partners for Youth Opportunity">Partners for Youth Opportunity</option>
  						<option value="Student U">Student U</option>
  						<option value="Emily K Center">Emily K Center</option>
  						<option value="Y.E. Smith">Y.E. Smith</option>
  						<option value="Carter Community School">Carter Community School</option>
  						<option value="Lakewood Elementary">Lakewood Elementary</option>
  						<option value="Lakewood Montessori Middle">Lakewood Montessori Middle</option>
  						<option value="Forest View Elementary">Forest View Elementary</option>
  						<option value="E.K. Powe">E.K. Powe</option>
  						<option value="George Watts Montessori">George Watts Montessori</option>
  						<option value="Durham School of the Arts">Durham School of the Arts</option>
  					</select>
  				</div>
  			</div>
  			<div class="form-group">
  				<div class="col-xs-4">
  					<label for="transportation_type">Transportation Options:</label>
  					<input type="text" class="form-control" name="transportation_type" value="Car" required>
  				</div>
  			</div>
  			<div class="form-group">
  				<div class="col-xs-4">
  					<label for="transportation_time">Minutes to Budget for Transportation:</label>
  					<input type="number" class="form-control" name="transportation_time" min="5" max="60" step="5" value="30" required>
  				</div>
  			</div>
  			<h3>Request</h3>
  			<div class="form-group">
  				<div class="col-xs-4">
  					<label for="day_of_week">Day of the Week:</label>
  					<select class="form-control" name="day_of_week">
  						<option value="Monday">Monday</option>
  						<option value="Tuesday">Tuesday</option>
  						<option value="Wednesday">Wednesday</option>
  						<option value="Thursday">Thursday</option>
  						<option value="Friday">Friday</option>
  					</select>
  				</div>
  			</div>
  			<div class="form-group">
  				<div class="col-xs-4">
  					<label for="start_time">Start Time:</label>
  					<input class="form-control" type="time" name="start_time" required> <!-- type time doesn't work with Firefox or IE10 and earlier-->
  				</div>
  			</div>
  			<div class="form-group">
  				<div class="col-xs-4">
  					<label for="end_time">End Time:</label>
  					<input type="time" class="form-control" name="end_time" required>
  				</div>
  			</div>
  			<div class="form-group">
  				<div class="col-xs-4">
  					<label for="grade_level">Grade Level:</label>
  					<input type="text" class="form-control" name="grade_level">
  				</div>
  			</div>
  			<div class="form-group">
  				<div class="col-xs-4">
  					<label for="language">Language:</label>
  					<select name="language" class="form-control">
  						<option value="None">None</option>
  						<option value="Arabic">Arabic</option>
  						<option value="Chinese">Chinese</option>
  						<option value="French">French</option>
  						<option value="German">German</option>
  						<option value="Japanese">Japanese</option>
  						<option value="Spanish">Spanish</option>
  					</select>
  				</div>
  			</div>
  			<div class="form-group">
  				<div class="col-xs-4">
  					<label for="num_tutors">Number of Tutors:</label>
  					<input type="number" class="form-control" name="num_tutors" min="1" max="10" step="1" value="1" required>
  				</div>
  			</div>
  			<div class="form-group">
  				<div class="col-xs-8">
  					<label for="description">Description:</label>
  					<textarea class="form-control" rows="4" cols="30" name="description" form="requestform"></textarea><br>
  				</div>
  			</div>
  			<div class="form-group">
  				<div class="col-xs-4">
  					<label for="num_tutors">Is Hidden:</label>
  					<select class="form-control" name="is_hidden">
  						<option <?php if($myrow["is_hidden"]){echo ("selected");}?> value="Yes">Yes</option>
  						<option <?php if(!$myrow["is_hidden"]){echo ("selected");}?> value="No">No</option>
  					</select>
  				</div>
  			</div>
  			<input type="hidden" value="-1" name="request_id"/>
  			<input type="submit" class="btn btn-primary" value="Submit Request"/>
  		</form>
  		<br>
  		<br>
  	</div>
  </body>
  </html>
