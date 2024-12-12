<?php
$servername = "localhost";
$username = "u337467332_tutorapp";
$password = "tU^%#*&8";
$dbname = "u337467332_tutorapp";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
?>

