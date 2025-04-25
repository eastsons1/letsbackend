<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header('Content-Type: multipart/form-data; boundary=any-string');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');



$servername = "localhost";
$username = "eastsons_studylab";
$password = "studyLab@321";
$dbname = "eastsons_studylab";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

			
			
			
			if($_GET['student_id'] !="")
			{
				$student_id = $_GET['student_id'];
				$negotiable_amount = $_GET['negotiable_amount'];
			}
			
			if($_POST['student_id'] !="")
			{
				$student_id = $_POST['student_id'];
				$negotiable_amount = $_POST['negotiable_amount'];
			}

		
				
				if($student_id !="")
				{
				
					$sql = $conn->query("SELECT * FROM tbl_book_tutor_by_student WHERE student_id = '".$student_id."' ");
					
					if(mysqli_num_rows($sql)>0)
					{
						
						$update = $conn->query("UPDATE tbl_book_tutor_by_student SET negotiable_amount = '".$negotiable_amount."' WHERE student_id = '".$student_id."' ");
						
						if($update)
						{
							$resultData = array('Status' => true, 'Message' => 'Student negotiable amount updated.');
						}
						else{
							
							$resultData = array('Status' => false, 'Message' => 'Update Error.');
						}
						
						
					}

				}
				else
					{
						$resultData = array('Status' => false, 'Message' => 'Student Id Can\'t Blank.');
					}
				
				
				
				echo json_encode($resultData);
				
				
				
				
	
			
?>