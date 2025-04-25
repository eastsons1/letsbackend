<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
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




	
			// Read the JSON file in PHP
			$data = file_get_contents("php://input");
			
			// Convert the JSON String into PHP Array
			$array = json_decode($data, true);
			
			
			
			$arrayV = array();  
			$arrayV2 = array(); 
			
			
			// Extracting row by row
			foreach($array as $row => $value) 
			{
				
				 $sql_multi_delete = "DELETE FROM tbl_book_tutor_by_student WHERE book_id='".$value["book_id"]."'";
				 $res_multi_delete = $conn->query($sql_multi_delete) or die(" query  not executed");
				
				if($res_multi_delete)
				{
					
					$sql_multi_delete_subject = $conn->query("DELETE FROM tbl_book_tutor_by_student_subjects WHERE booking_id = '".$value["book_id"]."'");
					
					$status = 1;
				}
				else
				{
					$status = 0;
				}					
					
			}	


				
					if($status==1)
					{				
							$resultData = array('status' => true, 'Message' => "Selected Multiple Students Records Deleted Successfully");
						
					}
					else
					{
							$resultData = array('status' => false, 'Message' => "Student Delete Error");
					}
					
					
					echo json_encode($resultData);
					
							
			
?>