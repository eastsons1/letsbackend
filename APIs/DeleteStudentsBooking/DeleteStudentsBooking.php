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


			$book_id = $_POST['book_id'];

				/// check user_tutor_info record
			
			$chk_rec = $conn->query("select * from tbl_book_tutor_by_student where book_id = '".$book_id."' ");
			
			
			
			if(mysqli_num_rows($chk_rec)>0)
			{
				
				$GET_Book_ID = mysqli_fetch_array($chk_rec);
				
				$tqsg = $conn->query("delete from tbl_book_tutor_by_student_subjects where booking_id = '".$GET_Book_ID['book_id']."' ");
				
				$del_tinfo = $conn->query("delete from tbl_book_tutor_by_student where book_id = '".$GET_Book_ID['book_id']."' ");
				
				
					if($del_tinfo)
					{
						$resultData = array('status' => true, 'Message' => 'Record Deleted Successfully.');
					}
					
					
				
				
			}
			else			
			{	

	
				$resultData = array('status' => false, 'Message' => 'No Record Found.');	
					
					

			}
				
				
				
				
				echo json_encode($resultData);
			
?>