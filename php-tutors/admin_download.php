<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Edit</title>

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
	<h1>Download a CSV</h1>

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
  // try{
  //   $statement = $dbh->query("SELECT * FROM Teacher");
  //   $list = array();
  //   array_push($list, array("## START OF USER TABLE ##"));
  //   if($row = $statement->fetch()){
  //     do{
  //       array_push($list, array_values($row));
  //       } while($row = $statement->fetch());
  //     }
  //   array_push($list, array("## END OF USER TABLE ##"));
  //   $filename = "TeacherData".'-'.date('d.m.Y').'.csv';
  //   $fp = fopen($filename, 'w');
  //   foreach ($list as $ferow) {
  //     fputcsv($fp, $ferow);
  //   }
  //   header('Content-Type: text/csv');
  //   header('Content-Disposition: attachment; filename="' . $filename . '"');
    
  //   fclose($fp);
    //header('Content-type: csv');
    //header('Content-Disposition: attachment;filename="'.$filename.'"');
    //readfile($filename);
  // } catch (PDOEXception $e) {
  //   echo $e->getMessage() . "<br/>";
  // }
  

  ?>

</body>
</html>