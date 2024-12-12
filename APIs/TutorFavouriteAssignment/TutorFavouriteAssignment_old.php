<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

		
		
		
		if($_POST['tutor_login_id']!="" && $_POST['student_post_requirements_id']!="" && $_POST['favourite']!="" )
		{
			
			  $insert = $conn->query("UPDATE student_post_requirements SET assigned_favourite_by_tutor = '".$_POST['favourite']."' ,assigned_favourite_by_tutor_id = '".$_POST['tutor_login_id']."' WHERE student_post_requirements_id = '".$_POST['student_post_requirements_id']."' ");
			 
			 	
				if($insert)
				{
					// check Favourite
					
					$check = mysqli_fetch_array($conn->query("select assigned_favourite_by_tutor from student_post_requirements where student_post_requirements_id = '".$_POST['student_post_requirements_id']."' "));
					
					if($check['assigned_favourite_by_tutor']=="" || $check['assigned_favourite_by_tutor']=="false")
					{
						$Favourite = 'false';
					}
					else{
						$Favourite = 'true';
					}
					
					$resultData = array('status' => true, 'message' => 'Given favourite added to this post requirement.', 'Favourite' => $Favourite );
				}
				else{
					$resultData = array('status' => false, 'message' => 'Favourite add error.');
				}
				
		}
		else{ 

			$resultData = array('status' => false, 'message' => 'Please Check The Passive Value.');
		}		
				
			echo json_encode($resultData);
			
?>