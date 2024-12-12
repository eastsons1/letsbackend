<?php
$servername = "localhost";
$username = "mytutors_tutorapp_ver3";
$password = "^%&^*&TYY6567*(&uyur$7";
$dbname = "mytutors_tutorapp_ver3";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
?>

