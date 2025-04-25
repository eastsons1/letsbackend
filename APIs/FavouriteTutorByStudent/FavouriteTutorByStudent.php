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
			$check_tutor_data = $conn->query("SELECT user_type FROM user_info as userinfo INNER JOIN user_tutor_info as tutor_info ON userinfo.user_id=tutor_info.user_id WHERE tutor_info.user_id = '".$tutor_id."' ");
			
			if(mysqli_num_rows($check_tutor_data)>0)
			{
				/////
				
				$check_student_id = $conn->query("SELECT user_id FROM user_info  WHERE user_id = '".$logged_in_student_id."' ");
			
				if(mysqli_num_rows($check_student_id)>0)
				{
				
				
				 
					  $check = $conn->query("select * from favourite_tutor_by_student where tutor_id = '".$tutor_id."' and logged_in_student_id = '".$logged_in_student_id."' ");
					  
					  if(mysqli_num_rows($check)>0)
					  {
						 
							$insert = $conn->query("UPDATE favourite_tutor_by_student SET favourite = '".$favourite_status."' WHERE tutor_id = '".$tutor_id."' and logged_in_student_id = '".$logged_in_student_id."' ");
					
					 }
					 else{
						 $insert = $conn->query("INSERT INTO favourite_tutor_by_student SET favourite = '".$favourite_status."' ,tutor_id = '".$tutor_id."', logged_in_student_id = '".$logged_in_student_id."' ");
					
					 }
				  
				  
					
					if($insert)
					{
						// check Favourite
						
						$check = mysqli_fetch_array($conn->query("select favourite from favourite_tutor_by_student where tutor_id = '".$tutor_id."' and logged_in_student_id = '".$logged_in_student_id."' "));
						
						if($check['favourite']=="" || $check['favourite']=="false")
						{
							$Favourite = 'false';
						}
						else{
							
							$Favourite = 'true';
						}
						
						$resultData = array('status' => true, 'message' => 'Given favourite added to tutor.', 'Favourite' => $Favourite );
					}
					else{
						$resultData = array('status' => false, 'message' => 'Favourite add error.');
					}
				
				/////
				
				
				
				
			}
			else{
				
				$resultData = array('status' => false, 'message' => 'Please check the pasive values.');
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