<html>
<head><title>A Title:</title></head>
<body>
<h1>A Header:</h1>

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
$fields = array('QID21_1', 'QID21_2', 'QID21_3', 'QID21_4', 'QID24_1_1', 'QID24_1_2', 'QID24_1_3', 'QID24_2_1', 'QID24_2_2', 'QID24_2_3', 'QID24_3_1', 'QID24_3_2', 'QID24_3_3', 'QID24_4_1', 'QID24_4_2', 'QID24_4_3', 'QID24_5_1', 'QID24_5_2', 'QID24_5_3'); 
$handle = fopen($file, "r");
$header = array_flip(fgetcsv($handle, $length, $separator));

$statement = $dbh->prepare("INSERT INTO Data VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

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