<html>
<head><title>Uploaded</title></head>
<body>

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

  if (!is_uploaded_file($_FILES['userfile']['tmp_name'])) {
    echo "File did not upload!\n";
    echo $_FILES['userfile']['error'];
  }
  
$file = $_FILES['userfile']['tmp_name'];
$separator = ",";
$length = 1000; 
$fields = array('Name', 'Email', 'School', 'Grade Level', 'Monday Block 1', 'Monday Block 2', 'Monday Block 3', 'Tuesday Block 1', 'Tuesday Block 2', 'Tuesday Block 3', 'Wednesday Block 1', 'Wednesday Block 2', 'Wednesday Block 3', 'Thursday Block 1', 'Thursday Block 2', 'Thursday Block 3', 'Friday Block 1', 'Friday Block 2', 'Friday Block 3', 'Max Tutors Per Slot', 'Total Tutors', 'Language', 'Description'); 
$timeslots = array('Monday Block 1', 'Monday Block 2', 'Monday Block 3', 'Tuesday Block 1', 'Tuesday Block 2', 'Tuesday Block 3', 'Wednesday Block 1', 'Wednesday Block 2', 'Wednesday Block 3', 'Thursday Block 1', 'Thursday Block 2', 'Thursday Block 3', 'Friday Block 1', 'Friday Block 2', 'Friday Block 3');
$handle = fopen($file, "r");
$header = array_flip(fgetcsv($handle, $length, $separator));

$statement = $dbh->prepare("DELETE FROM Request");

try{
  $statement->execute();
}
catch (PDOException $e) {
  echo $e->getMessage() . "<br/>";
}

$statement = $dbh->prepare("DELETE FROM Data");

try{
  $statement->execute();
}
catch (PDOException $e) {
  echo $e->getMessage() . "<br/>";
}

$statement = $dbh->prepare("DELETE FROM Teacher");
try{
  $statement->execute();
}
catch (PDOException $e) {
  echo $e->getMessage() . "<br/>";
}

$statement = $dbh->prepare("DELETE FROM Site");

try{
  $statement->execute();
}
catch (PDOException $e) {
  echo $e->getMessage() . "<br/>";
}

//$statement = $dbh->prepare("INSERT INTO Data VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$statement = $dbh->prepare("INSERT INTO Site VALUES (?, ?)");
$statement1 = $dbh->prepare("INSERT INTO Teacher VALUES(?, ?, ?)");
$statement2 = $dbh->prepare("INSERT INTO Request VALUES(?, ?, ?, ?, ?, ?, ?)");

while(($csvData = fgetcsv($handle, $length, $separator)) !== false){

	$values = array();
  $statement1values = array();

  $name = $csvData[$header['Name']];
  $email = $csvData[$header['Email']];
  $school = $csvData[$header['School']];
  $grade = $csvData[$header['Grade Level']];
  $num_tutors = $csvData[$header['Max Tutors Per Slot']];
  $language = $csvData[$header['Language']];
  echo $name . " " . $email . " " . $school . " " . $grade . "<br/>";

 //    foreach ($fields as $field){
 //    	$values[] = $csvData[$header[$field]];
 //    	//echo $csvData[$header[$field]] . "<br/>";
	// }
	// try {
	// 	$statement->execute($values);
	// }
	// catch (PDOException $e) {
	// 	echo $e->getMessage() . "<br/>";
	// }
  $values[] = $school;
  $values[] = 'car';
  try {
    $statement->execute($values);
  }
  catch (PDOException $e){
    echo $e->getMessage() . "<br/>";
  }

  $statement1values[] = $school;
  $statement1values[] = $name;
  $statement1values[] = $email;
  try {
    $statement1->execute($statement1values);
  }
  catch (PDOException $e){
    echo $e->getMessage() . "<br/>";
  }

  foreach ($timeslots as $timeslot){
    $statement2values = array();
    if($csvData[$header[$timeslot]] != ""){
      $times = explode("-", $csvData[$header[$timeslot]]);
      echo $times[0] . "<br/>";
      echo $times[1] . "<br/>";
      echo $csvData[$header[$timeslot]] . "<br/>";
      if(substr($timeslot, 0, 6) == "Monday"){
        echo "monday!" . "<br/>";
        $statement2values[] = 1;
      }
      if(substr($timeslot, 0, 7) == "Tuesday"){
        $statement2values[] = 1;
        echo "tuesday!" . "<br/>";;
      }
      if(substr($timeslot, 0, 9) == "Wednesday"){
        $statement2values[] = 1;
        echo "wednesday!" . "<br/>";
      }
      if(substr($timeslot, 0, 8) == "Thursday"){
        $statement2values[] = 1;
        echo "thursday!" . "<br/>";
      }
      if(substr($timeslot, 0, 6) == "Friday"){
        $statement2values[] = 1;
        echo "friday!" . "<br/>";
      }
        $statement2values[] = $grade;
        $statement2values[] = $times[0];
        $statement2values[] = $times[1];
        $statement2values[] = $email;
        $statement2values[] = intval($num_tutors);
        $statement2values[] = $language;
      try {
        $statement2->execute($statement2values);
      }
      catch (PDOException $e){
        echo $e->getMessage() . "<br/>";
      }
    }
  }
}

fclose($handle);

?>

</body>

</html>