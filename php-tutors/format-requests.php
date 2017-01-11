<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Uploaded</title>

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
        <?php
        try {
    // Including connection info (including database password) from outside
    // the public HTML directory means it is not exposed by the web server,
    // so it is safer than putting it directly in php code:
          include("pdo-tutors.php");
          $dbh = dbconnect();
        } catch (PDOException $e) {
          print "Error connecting to the database: " . $e->getMessage() . "<br/>";
          die();
        }

        if(empty($_FILES['userfile']['tmp_name'])){
          echo "No file was selected to upload. Please choose a file to upload.";
          ?>
          <br><br>
          <a href="admin_upload.php">Back to Upload</a>
          <?php
          die();
        }
        else if (!is_uploaded_file($_FILES['userfile']['tmp_name'])) {
          echo "File did not upload!\n";
          echo $_FILES['userfile']['error'];
          die();
        }
        else {
          echo "<div class='text-center'><h3>CSV Uploaded</h3>";
          echo "<a href='admin_home.php'>Back to Home</a>";
          $count = 0;
          $file = $_FILES['userfile']['tmp_name'];
          $separator = ",";
          $length = 1000; 
          $fields = array('Name', 'Email', 'Phone Number', 'School', 'Grade Level', 'Monday Block 1', 'Monday Block 2', 'Monday Block 3', 'Monday Block 4', 'Monday Block 5', 'Tuesday Block 1', 'Tuesday Block 2', 'Tuesday Block 3', 'Tuesday Block 4', 'Tuesday Block 5', 'Wednesday Block 1', 'Wednesday Block 2', 'Wednesday Block 3', 'Wednesday Block 4', 'Wednesday Block 5', 'Thursday Block 1', 'Thursday Block 2', 'Thursday Block 3', 'Thursday Block 4', 'Thursday Block 5', 'Friday Block 1', 'Friday Block 2', 'Friday Block 3', 'Friday Block 4', 'Friday Block 5', 'Max Tutors Per Slot', 'Total Tutors', 'Language', 'Description'); 
          $timeslots = array('Monday Block 1', 'Monday Block 2', 'Monday Block 3', 'Monday Block 4', 'Monday Block 5', 'Tuesday Block 1', 'Tuesday Block 2', 'Tuesday Block 3', 'Tuesday Block 4', 'Tuesday Block 5', 'Wednesday Block 1', 'Wednesday Block 2', 'Wednesday Block 3', 'Wednesday Block 4', 'Wednesday Block 5', 'Thursday Block 1', 'Thursday Block 2', 'Thursday Block 3', 'Thursday Block 4', 'Thursday Block 5', 'Friday Block 1', 'Friday Block 2', 'Friday Block 3', 'Friday Block 4', 'Friday Block 5');
          $handle = fopen($file, "r");
          $header = array_flip(fgetcsv($handle, $length, $separator));

          $statement = $dbh->prepare("INSERT INTO Site VALUES (?, ?, ?, ?)");
          $statement1 = $dbh->prepare("INSERT INTO Teacher VALUES(?, ?, ?, ?, ?)");
          $statement2 = $dbh->prepare("INSERT INTO Request VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");

          while(($csvData = fgetcsv($handle, $length, $separator)) !== false){

           $values = array();
           $statement1values = array();

           $name = $csvData[$header['Name']];
           $email = $csvData[$header['Email']];
           $phone_number = $csvData[$header['Phone Number']];
           $school = $csvData[$header['School']];
           $grade = $csvData[$header['Grade Level']];
           $num_tutors = $csvData[$header['Max Tutors Per Slot']];
           $language = $csvData[$header['Language']];
           $description = $csvData[$header['Description']];

           $values[] = $school;
           $values[] = 'car';
           $values[] = 30;
           $values[] = 0;
           try {
            $statement->execute($values);
          }
          catch (PDOException $e){
            //echo $e->getMessage() . "<br/>";
          }

          $statement1values[] = $school;
          $statement1values[] = $name;
          $statement1values[] = $email;
          $statement1values[] = $phone_number;
          $statement1values[] = 0;
          try {
            $statement1->execute($statement1values);
          }
          catch (PDOException $e){
            //echo $e->getMessage() . "<br/>";
          }

          foreach ($timeslots as $timeslot){
            $statement2values = array();
            if($csvData[$header[$timeslot]] != ""){
              $times = explode("-", $csvData[$header[$timeslot]]);
              if(substr($timeslot, 0, 6) == "Monday"){
                $statement2values[] = 1;
              }
              if(substr($timeslot, 0, 7) == "Tuesday"){
                $statement2values[] = 2;
              }
              if(substr($timeslot, 0, 9) == "Wednesday"){
                $statement2values[] = 3;
              }
              if(substr($timeslot, 0, 8) == "Thursday"){
                $statement2values[] = 4;
              }
              if(substr($timeslot, 0, 6) == "Friday"){
                $statement2values[] = 5;
              }
              $statement2values[] = $grade;
              $statement2values[] = $times[0];
              $statement2values[] = $times[1];
              $statement2values[] = $email;
              $statement2values[] = intval($num_tutors);
              $statement2values[] = $language;
              $statement2values[] = $description;
              $statement2values[] = 0;
              try {
                $statement2->execute($statement2values);
                if($count == 0){
                  echo "<h3>Upload Successful</h3>";
                  $count++;
                }
              }
              catch (PDOException $e){
                //echo $e->getMessage() . "<br/>";
              }
            }
          }
        }

        fclose($handle);

      }

      ?>
    </div>
  </body>
  </html>