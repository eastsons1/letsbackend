<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

		
		$student_post_requirements_id = $_POST['student_post_requirements_id'];
		
		$booked_date = date('d-m-Y');
		
		 $update_date_time = date('d-m-Y H:i:s');
		
		if($student_post_requirements_id != "")
		{
			$chk = $conn->query("SELECT * FROM student_post_requirements WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
		
			if(mysqli_num_rows($chk)>0)
			{
				
				$updateSql = $conn->query("UPDATE student_post_requirements SET booked_date = '".$booked_date."', total_days_for_expire_post = '', post_expire_status = '', post_delist_status = '', update_date_time = '".$update_date_time."' WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
				
				if($updateSql)
				{
					$resultData = array('status' => true, 'message' => 'Post has been repost successfully.');
				}
				else{
					$resultData = array('status' => false, 'message' => 'No repost.');
				}
			
			}
			else{
				
				$resultData = array('status' => false, 'message' => 'No record found.');
				
			}
		
		}
		else
		{
			$resultData = array('status' => false, 'message' => 'Student post requirements id can not blank.');
		}
		
		
					
			echo json_encode($resultData);
			
?>