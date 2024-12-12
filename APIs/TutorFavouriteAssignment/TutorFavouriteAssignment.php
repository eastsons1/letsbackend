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
			
			  //$insert = $conn->query("UPDATE student_post_requirements SET assigned_favourite_by_tutor = '".$_POST['favourite']."' ,assigned_favourite_by_tutor_id = '".$_POST['tutor_login_id']."' WHERE student_post_requirements_id = '".$_POST['student_post_requirements_id']."' ");
			  
			  $check = $conn->query("select favourite from student_post_requirements_Favourite_Assigned where tutor_login_id = '".$_POST['tutor_login_id']."' and student_post_requirements_id = '".$_POST['student_post_requirements_id']."'  ");
			  
			  if(mysqli_num_rows($check)>0)
			  {
				  //$del_rec = $conn->query("delete from favourite_student_post_requirement_by_tutor where tutor_login_id = '".$_POST['tutor_login_id']."', student_post_requirements_id = '".$_POST['student_post_requirements_id']."' ");
					$insert = $conn->query("UPDATE student_post_requirements_Favourite_Assigned SET favourite = '".$_POST['favourite']."' WHERE tutor_login_id = '".$_POST['tutor_login_id']."' and student_post_requirements_id = '".$_POST['student_post_requirements_id']."' ");
			 
			 }
			 else{
				 $insert = $conn->query("INSERT INTO student_post_requirements_Favourite_Assigned SET favourite = '".$_POST['favourite']."' ,tutor_login_id = '".$_POST['tutor_login_id']."', student_post_requirements_id = '".$_POST['student_post_requirements_id']."' ");
			 
			 }
			  
			  
			 	
				if($insert)
				{
					// check Favourite
					
					$check = mysqli_fetch_array($conn->query("select favourite from student_post_requirements_Favourite_Assigned where student_post_requirements_id = '".$_POST['student_post_requirements_id']."' and tutor_login_id = '".$_POST['tutor_login_id']."' "));
					
					if($check['favourite']=="" || $check['favourite']=="false")
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
			
?>]