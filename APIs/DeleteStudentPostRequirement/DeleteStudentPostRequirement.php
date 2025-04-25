<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");


require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');





	
		 $student_post_requirements_id = $_POST['student_post_requirements_id'];
		
		 $logged_in_student_id = $_POST['logged_in_student_id'];
		
		if($logged_in_student_id !="" && $student_post_requirements_id != "" )
		{
		
			$chk_post = $conn->query("SELECT * FROM student_post_requirements WHERE student_post_requirements_id = '".$student_post_requirements_id."' and logged_in_user_id = '".$logged_in_student_id."' ");
		
		
			if(mysqli_num_rows($chk_post)>0)
			{
				//// post_requirements_student_levels
				$del_level = $conn->query("DELETE FROM post_requirements_student_levels WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
				
				/////post_requirements_student_grade
				$del_grade = $conn->query("DELETE FROM post_requirements_student_grade WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
				
				////post_requirements_student_subjects
				$del_subject = $conn->query("DELETE FROM post_requirements_student_subjects WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
				
				/////post_requirements_TutorQualification
				$del_TutorQualification = $conn->query("DELETE FROM post_requirements_TutorQualification WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
				
				
				////post_requirements_TutorSchedule
				$del_TutorSchedule = $conn->query("DELETE FROM post_requirements_TutorSchedule WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
				
				
				////tbl_Student_Level_Grade_Subjects_Post_Requirement
				$del_Level_Grade_Subjects = $conn->query("DELETE FROM tbl_Student_Level_Grade_Subjects_Post_Requirement WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
				
				////student_post_requirements_streams
				$del_streams = $conn->query("DELETE FROM student_post_requirements_streams WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
				
				////tbl_Tutor_Schedules_Slot_Time_post_requirement
				$del_Slot_Time = $conn->query("DELETE FROM tbl_Tutor_Schedules_Slot_Time_post_requirement WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
				
				///student_post_requirement_amount_negotiate
				
				$del_negotiate_amount = $conn->query("DELETE FROM student_post_requirement_amount_negotiate WHERE student_post_requirement_id = '".$student_post_requirements_id."' ");
				
				
				$del_post  = $conn->query("DELETE FROM student_post_requirements WHERE student_post_requirements_id = '".$student_post_requirements_id."' and logged_in_user_id = '".$logged_in_student_id."' ");
				
              
				if($del_post)
				{
					$resultSet = array('status' => true, 'message' => 'Post Deleted Successfully.');
				}
				else{
				
				$resultSet = array('status' => true, 'message' => 'Not deleted.');
				
				}
				
				
				
				
			}
			else{
				
				$resultSet = array('status' => true, 'message' => 'No record found.');
				
			}
			
			
		
		
		}
		else
		{
			$resultSet = array('status' => true, 'message' => 'Please check the passive values.');
			
		}
	
		
		echo json_encode($resultSet);			
			
?>