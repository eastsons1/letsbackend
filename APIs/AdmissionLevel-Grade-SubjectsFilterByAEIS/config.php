<?php
$servername = "localhost";
$username = "u337467332_tutorapp_ver2";
$password = "u2%Tu*&35app";
$dbname = "u337467332_tutorapp_ver2";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
?>

