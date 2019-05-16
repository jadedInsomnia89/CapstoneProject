<?php
require_once('DBConfig.php'); 
$subject = $_POST['courseSubject'];
$courseNumber = $_POST['courseNum']; 

$user_check_query = "SELECT title FROM Courses WHERE subject = '$subject' AND course_number = '$courseNumber';";
  $result = mysqli_query($conn, $user_check_query);
  while($row = $result->fetch_assoc() ){
    $subject = $row['title'];
    echo "<option id='$subject' disabled selected>$subject</option>";
  }
?>

