<?php
  if (!isset($_POST['req'])) {
    echo "You need to choose a request";
    die();
  }
  	$reqinfo = $_POST['req'];
  	echo '<pre>';
	print_r($reqinfo);
	echo '</pre>';
?>


