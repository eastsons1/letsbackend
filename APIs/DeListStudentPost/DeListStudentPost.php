<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
 


		$student_post_requirements_id = $_POST['student_post_requirements_id'];
		$student_login_id = $_POST['student_login_id'];
		
		
		
		if($student_post_requirements_id != "")
		{
			
			
			$sql = $conn->query("SELECT total_days_for_expire_post FROM student_post_requirements WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
			
			
			if(mysqli_num_rows($sql)>0)
			{
				
				
				$total_days_for_expire_post_data = mysqli_fetch_array($sql);
				
				
				$total_days_for_expire_post = $total_days_for_expire_post_data['total_days_for_expire_post'];
				
				
				if($total_days_for_expire_post <= 45)
				{
					$postDlist = $conn->query("UPDATE student_post_requirements SET post_delist_status = 'Delist' WHERE student_post_requirements_id = '".$student_post_requirements_id."' and logged_in_user_id = '".$student_login_id."' ");
					
					if($postDlist)
					{
						
						$gdD = mysqli_fetch_array($conn->query("SELECT * FROM student_post_requirements WHERE student_post_requirements_id = '".$student_post_requirements_id."' and logged_in_user_id = '".$student_login_id."' "));
						
						if($gdD['post_delist_status'] !="")
						{
							
							$Delist = $gdD['post_delist_status'];
							$Delist_array = array('Student_post_requirements_id' => $student_post_requirements_id, 'Delist_status' => $Delist);
							
						}
						
							$resultData = array('status' => true, 'message' => 'This post is added in Delist.', 'Output' => $Delist_array);
					}
				}
				else{
						$resultData = array('status' => false, 'message' => 'Post has been expired.');
				}
				
				
				
			}
			else{
				$resultData = array('status' => false, 'message' => 'No record found.');
			}
			
			
			
		}
		else
		{
			$resultData = array('status' => false, 'message' => 'Student post requirement id can\'t blank.');
		}			



		echo json_encode($resultData);
		
		
		
		

?>