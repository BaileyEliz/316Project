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
$handle = fopen($file, "r");
$header = array_flip(fgetcsv($handle, $length, $separator));

$statement = $dbh->prepare("INSERT INTO Data VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

while(($csvData = fgetcsv($handle, $length, $separator)) !== false){

	$values = array();

    foreach ($fields as $field){
    	$values[] = $csvData[$header[$field]];
    	echo $csvData[$header[$field]] . "<br/>";
	}
	try {
		$statement->execute($values);
	}
	catch (PDOException $e) {
		echo $e->getMessage() . "<br/>";
	}
}

fclose($handle);

?>

</body>

</html>