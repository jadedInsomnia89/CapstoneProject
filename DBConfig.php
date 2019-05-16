<?php
// Create connection
$conn = new mysqli('localhost', 'user', 'a123456') or die("Connection failed: " . $conn->connect_error);

// Select Database
mysqli_select_db($conn, 'data') or die("Could not open the database.");
?>