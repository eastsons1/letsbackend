<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

		
		
	
			// Read the JSON file in PHP
			$data = file_get_contents("php://input");
			
			// Convert the JSON String into PHP Array
			$array = json_decode($data, true);
			
			$nation_array = array();
		
		if($array['postal_code']!="" )
		{
			
			
			
			
			if($array['gender']!="")
			{
				$gender = " and user_tutor_info.gender = '".$array['gender']."' ";
			}
			else{
				$gender = "";
			}
			if($array['tutor_status']!="")
			{
				$tutor_status = " and user_tutor_info.tutor_status = '".$array['tutor_status']."' ";
			}
			else{
				$tutor_status = "";
			}
			
			
			
			//For Grade
			if(!empty($array['grade']))
			{
				
				$gradestring = "'" . implode("','", $array['grade']) . "'";

				$grade =  " and complete_user_profile_tutoring_grade_detail.Tutoring_Grade IN($gradestring)";
			}
			else
			{
			
				$grade = "";
			}	
			
			
			//For Subjects
			if(!empty($array['subjects']))
			{
				
				
				$subjectsstring = "'" . implode("','", $array['subjects']) . "'";

				$subjects =  " and complete_user_profile_tutoring_tutoring_subjects_detail.Tutoring_ALL_Subjects IN($subjectsstring)";
			}
			else
			{
			
				$grade = "";
			}	
			
			
			//For Multiple Nationality 
			
			if(!empty($array['nationality']))
			{
				$nationalitiesString = "'" . implode("','", $array['nationality']) . "'";

				$nationality =  " and user_tutor_info.nationality IN($nationalitiesString)";
			}
			else
			{
				$nationality = "";
			}	


			//For Multiple Stream 
			
			if(!empty($array['stream']))
			{
				$streamString = "'" . implode("','", $array['stream']) . "'";

				$stream =  " and user_tutor_info.stream IN($streamString)";
			}
			else
			{
				$stream = "";
			}	

			//For Multiple qualification 
			
			if(!empty($array['qualification']))
			{
				$qualificationString = "'" . implode("','", $array['qualification']) . "'";

				$qualification =  " and user_tutor_info.qualification IN($qualificationString)";
			}
			else
			{
				$qualification = "";
			}	

			
			//For Multiple Level 
			
			if(!empty($array['TutoringLevel']))
			{
				$TutoringLevelString = "'" . implode("','", $array['TutoringLevel']) . "'";

				$TutoringLevel =  " and complete_user_profile_tutoring_detail.TutoringLevel IN($TutoringLevelString)";
			}
			else
			{
				$TutoringLevel = "";
			}				
			 
			
			//$check = "SELECT * FROM complete_user_profile_tutoring_detail AS comp_user INNER JOIN user_tutor_info AS Uinfo ON comp_user.user_id = Uinfo.user_id WHERE Uinfo.postal_code = '".$array['postal_code']."' ".$TutoringLevel.$subjects.$grade.$stream.$qualification.$gender.$tutor_status.$nationality;
			
			
			$check = "SELECT DISTINCT user_tutor_info.user_id, user_tutor_info.profile_image, user_tutor_info.age, user_tutor_info.gender, user_tutor_info.nationality, user_tutor_info.qualification, user_tutor_info.name_of_school, user_tutor_info.Course_Exam, user_tutor_info.OtherCourse_Exam, user_tutor_info.gra_year, user_tutor_info.tutor_status, user_tutor_info.tuition_type, user_tutor_info.location, user_tutor_info.postal_code, user_tutor_info.travel_distance, user_tutor_info.tutor_tutoring_experience_years, user_tutor_info.tutor_tutoring_experience_months, user_tutor_info.personal_statement, user_tutor_info.lettitude, user_tutor_info.longitude, user_tutor_info.stream, user_tutor_info.tutor_code FROM complete_user_profile_tutoring_detail INNER JOIN user_tutor_info ON complete_user_profile_tutoring_detail.user_id = user_tutor_info.user_id INNER JOIN complete_user_profile_tutoring_grade_detail ON user_tutor_info.user_id = complete_user_profile_tutoring_grade_detail.user_id INNER JOIN complete_user_profile_tutoring_tutoring_subjects_detail ON complete_user_profile_tutoring_grade_detail.user_id = complete_user_profile_tutoring_tutoring_subjects_detail.user_id WHERE user_tutor_info.postal_code = '".$array['postal_code']."' ".$TutoringLevel.$subjects.$grade.$stream.$qualification.$gender.$tutor_status.$nationality;
			
		
		
	
		
		
		
			
			
			$check_res = $conn->query($check);
			
			$check_res_num = mysqli_num_rows($check_res);
			
		  if($check_res_num > 0)	
		  {
			  
			  $Response = array();
				
				while($Filter_Data = mysqli_fetch_assoc($check_res))
				{
					$Response[] = $Filter_Data;
				}
				
				
				if(!empty($Response))
				{
					$resultData = array('status' => true, 'Filter_Data_Records' => $Response);
				}
				else{
					$resultData = array('status' => false, 'message' => 'No Records Found.');
				}
				
			
		  }
		  else{
			
				$resultData = array('status' => false, 'message' => 'No Record Found.');
							
		  }
		
		
		}
		else{ 

			$resultData = array('status' => false, 'message' => 'Please Check The Passive Value.');
		}		
				
			echo json_encode($resultData);
			
?>