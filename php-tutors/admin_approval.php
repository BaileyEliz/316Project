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
  <title>All Info</title>

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
          <h1>All Bookings</h1>
        </div>

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
        


        if (isset($_POST['remove']) ) {  
          $remove_book = $dbh->prepare(
            "DELETE
            FROM BOOKINGS
            WHERE BOOKINGS.tutor_id = ? and BOOKINGS.teacher_email = ? and BOOKINGS.day = ? and BOOKINGS.start_time= ? and BOOKINGS.end_time = ?");

          $id = $_POST["id"];
          $email = $_POST["email"];
          $day = $_POST["day"];
          $st = $_POST["start_time"];
          $et = $_POST["end_time"];
          
          try{

           $remove_book->execute(array($id,$email, $day, $st, $et));

         }  catch (PDOException $e){
           echo $e->getMessage() . "<br/>";
           echo "<h4>The booking slot was not removed properly.</h4>";
         }
       }


       if (isset($_POST['approve']) ) {  
        $approve_book = $dbh->prepare("UPDATE BOOKINGS SET isapproved = 'true' 
         WHERE BOOKINGS.tutor_id = ? and BOOKINGS.teacher_email = ? and BOOKINGS.day = ? and BOOKINGS.start_time= ? and BOOKINGS.end_time = ?");

        $id = $_POST["id"];
        $email = $_POST["email"];
        $day = $_POST["day"];
        $st = $_POST["start_time"];
        $et = $_POST["end_time"];
        
        try{

         $approve_book->execute(array($id,$email, $day, $st, $et));

       }  catch (PDOException $e){
         echo $e->getMessage() . "<br/>";
         echo "<h4>The booking slot was not approved properly.</h4>";
       }
     }

     try {
      $st = $dbh->query("SELECT * FROM Bookings WHERE isapproved = 'false' ORDER BY tutor_id");
      if (($bookings = $st->fetch())) {
        echo "<h3>Bookings Pending Approval</h3>";

        echo "<table class='table table-striped table-bordered'><th>Tutor Id</th><th>Teacher Email</th><th>Day</th><th>Start Time</th><th>End Time</th><th>Needs Van Transportation?</th><th>Approve</th><th>Remove</th>";
        do {
         echo "<tr><td>" . $bookings['tutor_id'] . "</td>";
         echo "<td>" . $bookings['teacher_email'] . "</td>";
         // echo "<td>" . $bookings['start_time'] . "</td>";
//          echo "<td>" . $bookings['end_time'] . "</td>";
         if($bookings['day'] == 1){
          echo '<td>Monday</td>';
        }
        if($bookings['day'] == 2){
          echo '<td>Tuesday</td>';
        }
        if($bookings['day'] == 3){
          echo '<td>Wednesday</td>';
        }
        if($bookings['day'] == 4){
          echo '<td>Thursday</td>';
        }
        if($bookings['day'] == 5){
          echo '<td>Friday</td>';
        }
        $needsVan = "No";
        if($bookings["needs_van"] == "true"){
          $needsVan = "Yes";
        }
        $starttime = date("g:i a", strtotime($bookings["start_time"]));
        $endtime = date("g:i a", strtotime($bookings["end_time"]));
        echo "<td>" . $starttime . "</td>";
        echo "<td>" . $endtime . "</td>";
        echo "<td>" . $needsVan . "</td>";
         //echo "<td>" . $bookings['isapproved'] . "</td>";
        
        ?>
        
        <form action='admin_approval.php' method='post'>
        	<input type='hidden' name='id' value='<?php echo $bookings['tutor_id']; ?>'>
          <input type='hidden' name='email' value='<?php echo $bookings['teacher_email']; ?>'>
          <input type='hidden' name='day' value='<?php echo $bookings['day']; ?>'>
          <input type='hidden' name='start_time' value='<?php echo $bookings['start_time']; ?>'>
          <input type='hidden' name='end_time' value=  '<?php echo $bookings['end_time']; ?>'>
          <td><button class='btn btn-primary' name='approve'>Approve</button></td>
        </form>
        
        <form action='admin_approval.php' method='post'>
        	<input type='hidden' name='id' value='<?php echo $bookings['tutor_id']; ?>'>
          <input type='hidden' name='email' value='<?php echo $bookings['teacher_email']; ?>'>
          <input type='hidden' name='day' value='<?php echo $bookings['day']; ?>'>
          <input type='hidden' name='start_time' value='<?php echo $bookings['start_time']; ?>'>
          <input type='hidden' name='end_time' value=  '<?php echo $bookings['end_time']; ?>'>
          <td><button class='btn btn-primary' name='remove'>Remove</button></td></tr>
        </form>

        <?php 
        
        
      } while ($bookings = $st->fetch());
      echo "</table>";
      echo "<br/>";
    }
    
    $st2 = $dbh->query("SELECT * FROM Bookings WHERE isapproved = 'true' ORDER BY tutor_id");
    if (($bookings2 = $st2->fetch())) {
      echo "<h3>Approved Bookings</h3>";
      echo "<table class='table table-striped table-bordered'><th>Tutor Id</th><th>Teacher Email</th><th>Day</th><th>Start Time</th><th>End Time</th><th>Needs Van Transportation?</th><th>Remove</th>";
      do {
       echo "<tr><td>" . $bookings2['tutor_id'] . "</td>";
       echo "<td>" . $bookings2['teacher_email'] . "</td>";
         // echo "<td>" . $bookings['start_time'] . "</td>";
//          echo "<td>" . $bookings['end_time'] . "</td>";
       if($bookings2['day'] == 1){
        echo '<td>Monday</td>';
      }
      if($bookings2['day'] == 2){
        echo '<td>Tuesday</td>';
      }
      if($bookings2['day'] == 3){
        echo '<td>Wednesday</td>';
      }
      if($bookings2['day'] == 4){
        echo '<td>Thursday</td>';
      }
      if($bookings2['day'] == 5){
        echo '<td>Friday</td>';
      }
      $needsVan = "No";
      if($bookings2["needs_van"] == "true"){
        $needsVan = "Yes";
      }
      $starttime2 = date("g:i a", strtotime($bookings2["start_time"]));
      $endtime2 = date("g:i a", strtotime($bookings2["end_time"]));
      echo "<td>" . $starttime2 . "</td>";
      echo "<td>" . $endtime2 . "</td>";
      echo "<td>" . $needsVan . "</td>";
         //echo "<td>" . $bookings['isapproved'] . "</td>";
      
      ?>
      
      <form action='admin_approval.php' method='post'>
       <input type='hidden' name='id' value='<?php echo $bookings2['tutor_id']; ?>'>
       <input type='hidden' name='email' value='<?php echo $bookings2['teacher_email']; ?>'>
       <input type='hidden' name='day' value='<?php echo $bookings2['day']; ?>'>
       <input type='hidden' name='start_time' value='<?php echo $bookings2['start_time']; ?>'>
       <input type='hidden' name='end_time' value=  '<?php echo $bookings2['end_time']; ?>'>
       <td><button class='btn btn-primary' name='remove'>Remove</button></td></tr>
     </form>

     <?php 
     
     
   } while ($bookings2 = $st2->fetch());
   echo "</table>";
 }
 
 
 
 
 
}
catch(PDOException $e){
  echo "Error: " . $e;
}
?>

<!--Maybe will also display bookings... However not sure how useful this page is in the scheme of the site. Useful for testing different functoinality
  across the whole site when manipulating data within the database. Look into this more later, but as of now, it will be helpful for observing how the 
  data is being changed.-->
</div>
</body>
</html>
