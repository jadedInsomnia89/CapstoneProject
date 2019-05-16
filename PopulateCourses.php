<?php
require_once('DBConfig.php'); 
$courseID = $_POST['ID']; // the ID is the course subject string value

$user_check_query = "SELECT course_number FROM Courses WHERE subject = '$courseID' ORDER BY course_number;";
  $result = mysqli_query($conn, $user_check_query);
  while($row = $result->fetch_assoc() ){
    $subject = $row['course_number'];
    echo "<option id='$subject'>$subject</option>";
  }
?>