<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

		
		
		$logged_in_student_id = $_POST['logged_in_student_id'];
		$tutor_id = $_POST['tutor_id'];
		$favourite_status = $_POST['favourite_status'];
		
		if($logged_in_student_id != "" && $tutor_id != "" )
		{
			$check_tutor_data = mysqli_fetch_array($conn->query("SELECT favourite_status,user_type FROM user_info as userinfo INNER JOIN user_tutor_info as tutor_info ON userinfo.user_id=tutor_info.user_id WHERE tutor_info.user_id = '".$tutor_id."' "));
			
			if($check_tutor_data['user_type']=="I am an Educator")
			{
				$update_favourite_status = $conn->query("UPDATE user_tutor_info SET favourite_status = '".$favourite_status."', favourite_status_given_by_student_id = '".$logged_in_student_id."' WHERE user_id = '".$tutor_id."' ");
				
				if($update_favourite_status)
				{
					$resultData = array('status' => true, 'message' => 'Tutor favourite status has been updated.');
				}
				else{
					
					$resultData = array('status' => false, 'message' => 'Record update error.');
				}
				
				
			}
			else{
				
				$resultData = array('status' => false, 'message' => 'Tutor id '.$tutor_id.' is not a Tutor.');
			}
		}
		else{
			$resultData = array('status' => false, 'message' => 'Student login id and Tutor id can\'t blank.');
		}
		
		
		
		

					
			echo json_encode($resultData);
			
?>