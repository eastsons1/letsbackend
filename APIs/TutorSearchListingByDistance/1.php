<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

		
		
			function distance($lat1, $lon1, $lat2, $lon2, $unit) 
			{

				$theta = $lon1 - $lon2;
				$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
				$dist = acos($dist);
				$dist = rad2deg($dist);
				$miles = $dist * 60 * 1.1515;
				$unit = strtoupper($unit);

				if ($unit == "K") {
					return ($miles * 1.609344);
				} else if ($unit == "N") {
					return ($miles * 0.8684);
				} else {
					return $miles;
				}
			}

		
	
			// Read the JSON file in PHP
			$data = file_get_contents("php://input");
			
			// Convert the JSON String into PHP Array
			$array = json_decode($data, true);
			
			$nation_array = array();
		
		if($array['postal_code']!="" && $array['student_lat'] != "" && $array['student_long'] != "" )
		{
			
			$student_lat = $array['student_lat'];
			$student_long = $array['student_long'];
			
			
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
			 
			
			
			//$check = "SELECT DISTINCT user_tutor_info.user_id, user_tutor_info.profile_image, user_tutor_info.age, user_tutor_info.gender, user_tutor_info.nationality, user_tutor_info.qualification, user_tutor_info.name_of_school, user_tutor_info.Course_Exam, user_tutor_info.OtherCourse_Exam, user_tutor_info.gra_year, user_tutor_info.tutor_status, user_tutor_info.tuition_type, user_tutor_info.location, user_tutor_info.postal_code, user_tutor_info.travel_distance, user_tutor_info.tutor_tutoring_experience_years, user_tutor_info.tutor_tutoring_experience_months, user_tutor_info.personal_statement, user_tutor_info.lettitude, user_tutor_info.longitude, user_tutor_info.stream, user_tutor_info.tutor_code, user_tutor_info.favourite_status, user_tutor_info.favourite_status_given_by_student_id FROM complete_user_profile_tutoring_detail INNER JOIN user_tutor_info ON complete_user_profile_tutoring_detail.user_id = user_tutor_info.user_id INNER JOIN complete_user_profile_tutoring_grade_detail ON user_tutor_info.user_id = complete_user_profile_tutoring_grade_detail.user_id INNER JOIN complete_user_profile_tutoring_tutoring_subjects_detail ON complete_user_profile_tutoring_grade_detail.user_id = complete_user_profile_tutoring_tutoring_subjects_detail.user_id WHERE user_tutor_info.postal_code = '".$array['postal_code']."' ".$TutoringLevel.$subjects.$grade.$stream.$qualification.$gender.$tutor_status.$nationality;
			
			 // $check = "SELECT DISTINCT complete_user_profile_tutoring_tutoring_subjects_detail.Tutoring_ALL_Subjects, complete_user_profile_tutoring_grade_detail.Tutoring_Grade, complete_user_profile_tutoring_detail.tutoring_detail_id,complete_user_profile_tutoring_detail.TutoringLevel, user_tutor_info.gender, user_tutor_info.tutor_status, user_tutor_info.nationality, user_tutor_info.stream, user_tutor_info.qualification, user_tutor_info.postal_code, user_tutor_info.lettitude, user_tutor_info.longitude, user_tutor_info.user_id FROM complete_user_profile_tutoring_detail INNER JOIN user_tutor_info ON complete_user_profile_tutoring_detail.user_id = user_tutor_info.user_id INNER JOIN complete_user_profile_tutoring_grade_detail ON user_tutor_info.user_id = complete_user_profile_tutoring_grade_detail.user_id INNER JOIN complete_user_profile_tutoring_tutoring_subjects_detail ON complete_user_profile_tutoring_grade_detail.user_id = complete_user_profile_tutoring_tutoring_subjects_detail.user_id WHERE user_tutor_info.postal_code = '".$array['postal_code']."' ".$TutoringLevel.$subjects.$grade.$stream.$qualification.$gender.$tutor_status.$nationality;
			
			
			 $check = "SELECT DISTINCT user_tutor_info.qualification, user_tutor_info.user_id, user_tutor_info.gender, user_tutor_info.nationality, user_tutor_info.tutor_status, user_tutor_info.tuition_type, user_tutor_info.postal_code, user_tutor_info.travel_distance, user_tutor_info.lettitude, user_tutor_info.longitude, user_tutor_info.stream FROM complete_user_profile_tutoring_detail INNER JOIN user_tutor_info ON complete_user_profile_tutoring_detail.user_id = user_tutor_info.user_id INNER JOIN complete_user_profile_tutoring_grade_detail ON user_tutor_info.user_id = complete_user_profile_tutoring_grade_detail.user_id INNER JOIN complete_user_profile_tutoring_tutoring_subjects_detail ON complete_user_profile_tutoring_grade_detail.user_id = complete_user_profile_tutoring_tutoring_subjects_detail.user_id WHERE 1 ";        //.$subjects.$TutoringLevel.$grade.$stream.$qualification.$gender.$tutor_status.$nationality;; 
			
			
			$check_res = $conn->query($check);
			
			$check_res_num = mysqli_num_rows($check_res);
			
		  if($check_res_num > 0)	
		  {
			  
			  $Response = array();
				
				while($Filter_Data = mysqli_fetch_assoc($check_res))
				{
					$lat = $Filter_Data['lettitude'];
					$long = $Filter_Data['longitude'];
					
					//echo $distance_value = distance($student_lat, $student_long, $lat, $long, "K") . " Kilometers<br>";
					 $distance_value = distance($student_lat, $student_long, $lat, $long, "K");

					//echo $distance_value.'<br>';	
					
					if($distance_value <= $Filter_Data['travel_distance'])  /// till 50 km
					{			
						//$distance_data[] = $distance_value;
						
						//$distance_bet =  array('between_distance' => $distance_value);
						$Response[] = array(
											'user_id' => $Filter_Data['user_id'],
											'gender' => $Filter_Data['gender'],
											'nationality' => $Filter_Data['nationality'],
											'qualification' => $Filter_Data['qualification'],
											'tutor_status' => $Filter_Data['tutor_status'],
											'tuition_type' => $Filter_Data['tuition_type'],
											'postal_code' => $Filter_Data['postal_code'],
											'travel_distance' => $Filter_Data['travel_distance'],
											'lettitude' => $Filter_Data['lettitude'],
											'longitude' => $Filter_Data['longitude'],
											'stream' => $Filter_Data['stream'],
											'between_distance' => $distance_value.' KM'
											
											
											);
					}
					else{
						$resultData = array('status' => false, 'message' => 'No record found.' );
					}	
						
					
					
					
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