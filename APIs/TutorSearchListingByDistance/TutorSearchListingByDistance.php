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
			
			
			$student_lat = $array['student_lat'];
			$student_long = $array['student_long'];	
			$logged_in_student_id = $array['logged_in_student_id'];
			
			
			
		
		if($array['postal_code']!="" && $array['student_lat'] != "" && $array['student_long'] != "" )
		{
			
			//// get between distance start
			
			$sql_Q = $conn->query("select tuition_type,user_id,lettitude,longitude,travel_distance from user_tutor_info  ");
			
			$i=0;
			$a = array();
			
				while($get_Data = mysqli_fetch_assoc($sql_Q))
				{
				    
				    if($get_Data['tuition_type'] != "")
					{
				    
    					if($get_Data['lettitude'] !="" && $get_Data['longitude'] !="")
    					{
    						$lat = $get_Data['lettitude'];
    						$long = $get_Data['longitude'];
    					}
    					
    					//echo $distance_value = distance($student_lat, $student_long, $lat, $long, "K") . " Kilometers<br>";
    					 $distance_value = distance($student_lat, $student_long, $lat, $long, "K");
						
						  $travel_distance = $get_Data['travel_distance'];
						
						 $distance_valueT = (int)$distance_value;
						 
						// echo $distance_valueT.'==';
						 
						// echo (int)$distance_valueT.'++';
    					//echo $travel_distance.'++';
    					
    					if($distance_valueT <= $travel_distance)  /// till 50 km
    					{
    						 $distance_value_status = 1;
    						 $a[]=$get_Data['user_id'];
    						 //$i++;
    						//echo $distance_value.'=';
    						//echo $get_Data['user_id'].'=';
    						
    					}
    					else{
    						//$distance_value_status = 0;
    					}
    					
					
					}
					
	
				}
			//// end
			
			
			//echo $distance_value_status;
			
			
			if($distance_value_status == 1)
			{
				$stV = array();
				foreach ($a as $val) {
					// Since $a is indexed by user IDs, you probably want to use $val directly
					$stV[] = $val;
				}

				// Now, implode the array elements to form a comma-separated list for SQL
				 $user_rec_by_distance = "user_tutor_info.user_id IN ('" . implode("','", $stV) . "')";
				
				//$postal_lat_long = " user_tutor_info.postal_code = '".$array['postal_code']."' and user_tutor_info.lettitude = '".$array['student_lat']."' and user_tutor_info.longitude = '".$array['student_long']."' ";
				
				//$postal_lat_long = " and user_tutor_info.postal_code = '".$array['postal_code']."' or user_tutor_info.lettitude = '".$array['student_lat']."' and user_tutor_info.longitude = '".$array['student_long']."' ";
			}
			else{
				//$postal_lat_long = "";
			}
			
			if(!empty($array['sorting']))
			{
				
				foreach($array['sorting'] as $sort)
				{
					//echo $sort;
					
					if($sort=="Newest")
					{
						$sorting = "  ORDER BY user_tutor_info.create_date ASC ";
					}
					if($sort=="Oldest")
					{
						$sorting = "  ORDER BY user_tutor_info.create_date DESC ";
					}
					if($sort=="HigherR")
					{
						$sorting = "  ORDER BY tbl_rating.rating_no DESC ";
					}
					if($sort=="LowestR")
					{
						$sorting = "  ORDER BY tbl_rating.rating_no ASC ";
					}
					
				}
				
				
				
			}
			else{
				$sorting = "";
			}
			
			if(!empty($array['gender']))
			{
				$gender_arr = "'" . implode("','", $array['gender']) . "'";
				
				$gender = " and user_tutor_info.gender IN($gender_arr) ";
			}
			else{
				$gender = "";
			}
			if(!empty($array['tutor_status']))
			{
				$tutor_status_arr = "'" . implode("','", $array['tutor_status']) . "'";
				
				$tutor_status = " and user_tutor_info.tutor_status IN($tutor_status_arr) ";
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
			
			/**
			//For Subjects
			if(!empty($array['subjects']))
			{
				
				$subjectsstring = "'" . implode("','", $array['subjects']) . "'";

				$subjects =  " and complete_user_profile_tutoring_tutoring_subjects_detail.Tutoring_ALL_Subjects IN($subjectsstring)";
			}
			else
			{
			
				$subjects = "";
			}	
			
			
			
			
			
			
			
			// For Subjects
			if (!empty($array['subjects'])) {
				// Initialize an array to store LIKE conditions
				$subjectConditions = [];

				// Loop through each subject and create a LIKE condition
				foreach ($array['subjects'] as $subject) {
					// Use '%' wildcards for partial matching
					$subjectConditions[] = "complete_user_profile_tutoring_tutoring_subjects_detail.Tutoring_ALL_Subjects LIKE '%" . $subject . "%'";
				}

				// Join the conditions with OR to match any subject
				$subjects = " AND (" . implode(" OR ", $subjectConditions) . ")";
			} else {
				$subjects = "";
			}
			
			**/
			
			
			
			
			// Map for specific subjects (like "Science") to related terms
				$subjectMappings = [
					'Science' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
					'Computer' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
					'Physics' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
					'Chemistry' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
					'English' => ['English', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
					'Math' => ['Math', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics'],
					'Chinese' => ['Chinese', 'Chinese H1', 'Chinese H2', 'Mandarin', 'Higher Chinese'],
					'Economics' => ['Economics', 'Economics H1', 'Economics H2', 'Mandarin'],
					// Add other mappings if needed
				];

				// For Subjects
				if (!empty($array['subjects'])) {
					// Initialize an array to store LIKE conditions
					$subjectConditions = [];

					// Loop through each subject and create LIKE conditions based on mappings
					foreach ($array['subjects'] as $subject) {
						if (array_key_exists($subject, $subjectMappings)) {
							// If subject has a mapping, create LIKE conditions for each related term
							foreach ($subjectMappings[$subject] as $mappedSubject) {
								$subjectConditions[] = "complete_user_profile_tutoring_tutoring_subjects_detail.Tutoring_ALL_Subjects = '" . $mappedSubject . "'";
							}
						} else {
							// If no mapping, use the subject itself
							$subjectConditions[] = "complete_user_profile_tutoring_tutoring_subjects_detail.Tutoring_ALL_Subjects = '" . $subject . "'";
						}
					}

					// Join the conditions with OR to match any related subject
					$subjects = " AND (" . implode(" OR ", $subjectConditions) . ")";
				} else {
					$subjects = "";
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


			//For Multiple Stream 
			
			if(!empty($array['stream']))
			{
				$streamString = "'" . implode("','", $array['stream']) . "'";
				
				$stream_V =  " and complete_user_profile_tutoring_admission_stream.Stream IN($streamString)";
			}
			else
			{
				$stream_V = "";
			}	
			
			 
			 
			 if($user_rec_by_distance =="" && $stream_V == "" && $TutoringLevel == "" && $qualification == "" && $nationality == "" && $subjects == "" && $grade == "" && $tutor_status == "" && $gender == "" && $sorting == "")
			 {
				 $All = 1;
			 }
			 else{
				 $All = "";
			 }
			
			
			
			  //echo $check = "SELECT DISTINCT user_tutor_info.profile_image,user_tutor_info.age,user_tutor_info.tutor_code, user_tutor_info.personal_statement, user_tutor_info.tutor_tutoring_experience_months, user_tutor_info.tutor_tutoring_experience_years, user_tutor_info.postal_code, user_tutor_info.gra_year, user_tutor_info.OtherCourse_Exam, user_tutor_info.Course_Exam, user_tutor_info.name_of_school, user_tutor_info.flag, user_tutor_info.date_of_year, user_tutor_info.age, user_tutor_info.qualification, user_tutor_info.user_id, user_tutor_info.gender, user_tutor_info.nationality, user_tutor_info.tutor_status, user_tutor_info.tuition_type, user_tutor_info.postal_code, user_tutor_info.travel_distance, user_tutor_info.lettitude, user_tutor_info.longitude, user_tutor_info.stream FROM user_tutor_info LEFT JOIN complete_user_profile_tutoring_detail ON user_tutor_info.user_id =  complete_user_profile_tutoring_detail.user_id LEFT JOIN complete_user_profile_tutoring_grade_detail ON complete_user_profile_tutoring_detail.user_id = complete_user_profile_tutoring_grade_detail.user_id LEFT JOIN complete_user_profile_tutoring_tutoring_subjects_detail ON complete_user_profile_tutoring_grade_detail.user_id = complete_user_profile_tutoring_tutoring_subjects_detail.user_id LEFT JOIN complete_user_profile_tutoring_admission_stream ON complete_user_profile_tutoring_tutoring_subjects_detail.user_id = complete_user_profile_tutoring_admission_stream.user_id LEFT JOIN tbl_rating ON user_tutor_info.user_id = tbl_rating.tutor_id WHERE ".$user_rec_by_distance.$gender.$tutor_status.$nationality.$subjects.$TutoringLevel.$grade.$qualification.$stream_V.$sorting.$All;        //; 






			//echo "SELECT DISTINCT user_tutor_info.user_id, complete_user_profile_tutoring_tutoring_subjects_detail.Tutoring_ALL_Subjects, user_tutor_info.profile_image,user_tutor_info.age,user_tutor_info.tutor_code, user_tutor_info.personal_statement, user_tutor_info.tutor_tutoring_experience_months, user_tutor_info.tutor_tutoring_experience_years, user_tutor_info.postal_code, user_tutor_info.gra_year, user_tutor_info.OtherCourse_Exam, user_tutor_info.Course_Exam, user_tutor_info.name_of_school, user_tutor_info.flag, user_tutor_info.date_of_year, user_tutor_info.age, user_tutor_info.qualification, user_tutor_info.user_id, user_tutor_info.gender, user_tutor_info.nationality, user_tutor_info.tutor_status, user_tutor_info.tuition_type, user_tutor_info.postal_code, user_tutor_info.travel_distance, user_tutor_info.lettitude, user_tutor_info.longitude, user_tutor_info.stream FROM user_tutor_info LEFT JOIN complete_user_profile_tutoring_detail ON user_tutor_info.user_id =  complete_user_profile_tutoring_detail.user_id LEFT JOIN complete_user_profile_tutoring_grade_detail ON complete_user_profile_tutoring_detail.user_id = complete_user_profile_tutoring_grade_detail.user_id LEFT JOIN complete_user_profile_tutoring_tutoring_subjects_detail ON complete_user_profile_tutoring_grade_detail.user_id = complete_user_profile_tutoring_tutoring_subjects_detail.user_id LEFT JOIN complete_user_profile_tutoring_admission_stream ON complete_user_profile_tutoring_tutoring_subjects_detail.user_id = complete_user_profile_tutoring_admission_stream.user_id LEFT JOIN tbl_rating ON user_tutor_info.user_id = tbl_rating.tutor_id WHERE ".$user_rec_by_distance.$gender.$tutor_status.$nationality.$subjects.$TutoringLevel.$grade.$qualification.$stream_V.$sorting.$All." GROUP BY user_tutor_info.user_id"; 



		  $check = "SELECT DISTINCT user_tutor_info.user_id, complete_user_profile_tutoring_tutoring_subjects_detail.Tutoring_ALL_Subjects, user_tutor_info.profile_image,user_tutor_info.age,user_tutor_info.tutor_code, user_tutor_info.personal_statement, user_tutor_info.tutor_tutoring_experience_months, user_tutor_info.tutor_tutoring_experience_years, user_tutor_info.postal_code, user_tutor_info.gra_year, user_tutor_info.OtherCourse_Exam, user_tutor_info.Course_Exam, user_tutor_info.name_of_school, user_tutor_info.flag, user_tutor_info.date_of_year, user_tutor_info.age, user_tutor_info.qualification, user_tutor_info.user_id, user_tutor_info.gender, user_tutor_info.nationality, user_tutor_info.tutor_status, user_tutor_info.tuition_type, user_tutor_info.postal_code, user_tutor_info.travel_distance, user_tutor_info.lettitude, user_tutor_info.longitude, user_tutor_info.stream FROM user_tutor_info LEFT JOIN complete_user_profile_tutoring_detail ON user_tutor_info.user_id =  complete_user_profile_tutoring_detail.user_id LEFT JOIN complete_user_profile_tutoring_grade_detail ON complete_user_profile_tutoring_detail.user_id = complete_user_profile_tutoring_grade_detail.user_id LEFT JOIN complete_user_profile_tutoring_tutoring_subjects_detail ON complete_user_profile_tutoring_grade_detail.user_id = complete_user_profile_tutoring_tutoring_subjects_detail.user_id LEFT JOIN complete_user_profile_tutoring_admission_stream ON complete_user_profile_tutoring_tutoring_subjects_detail.user_id = complete_user_profile_tutoring_admission_stream.user_id LEFT JOIN tbl_rating ON user_tutor_info.user_id = tbl_rating.tutor_id WHERE ".$All.$user_rec_by_distance.$gender.$tutor_status.$nationality.$subjects.$TutoringLevel.$grade.$qualification.$stream_V." GROUP BY user_tutor_info.user_id ".$sorting;        //;  


			

			
			/**
			$check = "SELECT DISTINCT user_tutor_info.profile_image, user_tutor_info.age, user_tutor_info.tutor_code, user_tutor_info.personal_statement, user_tutor_info.tutor_tutoring_experience_months, user_tutor_info.tutor_tutoring_experience_years, user_tutor_info.postal_code, user_tutor_info.gra_year, user_tutor_info.OtherCourse_Exam, user_tutor_info.Course_Exam, user_tutor_info.name_of_school, user_tutor_info.flag, user_tutor_info.date_of_year, user_tutor_info.age, user_tutor_info.qualification, user_tutor_info.user_id, user_tutor_info.gender, user_tutor_info.nationality, user_tutor_info.tutor_status, user_tutor_info.tuition_type, user_tutor_info.postal_code, user_tutor_info.travel_distance, user_tutor_info.lettitude, user_tutor_info.longitude, user_tutor_info.stream 
FROM user_tutor_info 
LEFT JOIN complete_user_profile_tutoring_detail ON user_tutor_info.user_id = complete_user_profile_tutoring_detail.user_id 
LEFT JOIN complete_user_profile_tutoring_grade_detail ON complete_user_profile_tutoring_detail.user_id = complete_user_profile_tutoring_grade_detail.user_id 
LEFT JOIN complete_user_profile_tutoring_tutoring_subjects_detail ON complete_user_profile_tutoring_grade_detail.user_id = complete_user_profile_tutoring_tutoring_subjects_detail.user_id 
LEFT JOIN complete_user_profile_tutoring_admission_stream ON complete_user_profile_tutoring_tutoring_subjects_detail.user_id = complete_user_profile_tutoring_admission_stream.user_id 
LEFT JOIN tbl_rating ON user_tutor_info.user_id = tbl_rating.tutor_id 
WHERE 1=1 " .$user_rec_by_distance.$gender.$tutor_status.$nationality.$subjects.$TutoringLevel.$grade.$qualification.$stream_V.$sorting.$All;
**/
			
			
			$check_res = $conn->query($check);
			
			 $check_res_num = mysqli_num_rows($check_res);
			 
			 
			 //echo '==='.$check_res_num.'==';
			
		  if($check_res_num > 0)	
		  {
			  
			  $Response = array();
				
				while($Filter_Data = mysqli_fetch_assoc($check_res))
				{
					$profile_history_academy_data_array = array();
					$profile_history_academy_result_data_array = array();
					$profile_tutoring_detail_result_data_array = array();
					$complete_user_profile_tutoring_grade_detail_array = array();
					$complete_user_profile_tutoring_tutoring_subjects_detail = array();
					$tutoring_subjects_detail_result_data_array = array();
					
					$lat = $Filter_Data['lettitude'];
					$long = $Filter_Data['longitude'];
					
					//echo $distance_value = distance($student_lat, $student_long, $lat, $long, "K") . " Kilometers<br>";
					 $distance_value = distance($student_lat, $student_long, $lat, $long, "K");

					//echo $distance_value.'<br>';



					// profile_history_academy start

					
						$profile_history_academy = $conn->query("SELECT * FROM complete_user_profile_history_academy WHERE user_id = '".$Filter_Data['user_id']."' ");		
						
						while($profile_history_academy_data = mysqli_fetch_array($profile_history_academy))
						{
							$profile_history_academy_data_array[] = array(
																		'history_academy_id' => $profile_history_academy_data['history_academy_id'],
																		'record_id' => $profile_history_academy_data['record_id'],
																		'school' => $profile_history_academy_data['school'],
																		'exam' => $profile_history_academy_data['exam'],
																		'user_id' => $profile_history_academy_data['user_id']
																		);
						}
						

					// profile_history_academy end	
					
					
					// complete_user_profile_history_academy_result start

					
						$profile_history_academy_result = $conn->query("SELECT * FROM complete_user_profile_history_academy_result WHERE user_id = '".$Filter_Data['user_id']."' ");		
						
						while($profile_history_academy_result_data = mysqli_fetch_array($profile_history_academy_result))
						{
							$profile_history_academy_result_data_array[] = array(
																				'history_academy_result_id' => $profile_history_academy_result_data['history_academy_result_id'],
																				'record_id' => $profile_history_academy_result_data['record_id'],
																				'subject' => $profile_history_academy_result_data['subject'],
																				'grade' => $profile_history_academy_result_data['grade'],
																				'user_id' => $profile_history_academy_result_data['user_id']
																				);
						}
						

					// complete_user_profile_history_academy_result end	
					
					
					// profile_tutoring_detail_result start

					
						$profile_tutoring_detail_result = $conn->query("SELECT * FROM complete_user_profile_tutoring_detail WHERE user_id = '".$Filter_Data['user_id']."' ");		
						
						while($profile_tutoring_detail_result_data = mysqli_fetch_array($profile_tutoring_detail_result))
						{
							
							
							//////
							
							
							
							if($profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'] !="" && empty($array['TutoringLevel']))
							{

							
							$string = $profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'];
							$wordsArray = $array['subjects'];

							$found = false;
							foreach ($wordsArray as $word) {
								if (str_contains($string, $word)) {
									$found = true;
									//echo "The word '$word' was found in the string.<br>";
								

							

								$profile_tutoring_detail_result_data_array[] = array(
											
										'tutoring_detail_id' => $profile_tutoring_detail_result_data['tutoring_detail_id'],
										'TutoringLevel' => $profile_tutoring_detail_result_data['TutoringLevel'],
										'AdmissionLevel' => $profile_tutoring_detail_result_data['AdmissionLevel'],
										'Tutoring_Grade' => $profile_tutoring_detail_result_data['Tutoring_Grade'],
										'Tutoring_ALL_Subjects' => $profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'],
										'Tutoring_Year' => $profile_tutoring_detail_result_data['Tutoring_Year'],
										'Tutoring_Month' => $profile_tutoring_detail_result_data['Tutoring_Month'],
										'user_id' => $profile_tutoring_detail_result_data['user_id']
										
										);

							}	




						}




						}
						
						
						
						
						
						
						if($profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'] !="" && !empty($array['TutoringLevel']))
						{
							

							///Level search
								
							$wordsArray2 = $array['TutoringLevel'];
							$word2 = $profile_tutoring_detail_result_data['TutoringLevel'];

							if (in_array(strtolower($word2), array_map('strtolower', $wordsArray2))) {
								 $Find_Level = $word2;
							} 

							
							//echo $Find_Level;

							
							$string = $profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'];
							$wordsArray = $array['subjects'];

							$found = false;
							foreach ($wordsArray as $word) {
								if (str_contains($string, $word)) {
									$found = true;
									//echo "The word '$word' was found in the string.<br>";
								
								if($word2 == $Find_Level)
								{	

								$profile_tutoring_detail_result_data_array[] = array(
											
										'tutoring_detail_id' => $profile_tutoring_detail_result_data['tutoring_detail_id'],
										'TutoringLevel' => $word2,
										'AdmissionLevel' => $profile_tutoring_detail_result_data['AdmissionLevel'],
										'Tutoring_Grade' => $profile_tutoring_detail_result_data['Tutoring_Grade'],
										'Tutoring_ALL_Subjects' => $profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'],
										'Tutoring_Year' => $profile_tutoring_detail_result_data['Tutoring_Year'],
										'Tutoring_Month' => $profile_tutoring_detail_result_data['Tutoring_Month'],
										'user_id' => $profile_tutoring_detail_result_data['user_id']
										
										);
								}		

							}	




						}

						


						}
							
							
							
							//////
							
							
							/**
							$string = $profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'];
								$wordsArray = $array['subjects'];

								$found = false;
								foreach($wordsArray as $word) 
								{
									if(str_contains($string, $word)) 
									{
										$found = true;
							        //echo $word;
							
							$profile_tutoring_detail_result_data_array[] = array(
																				'tutoring_detail_id' => $profile_tutoring_detail_result_data['tutoring_detail_id'],
																				'TutoringLevel' => $profile_tutoring_detail_result_data['TutoringLevel'],
																				'AdmissionLevel' => $profile_tutoring_detail_result_data['AdmissionLevel'],
																				'Tutoring_Grade' => $profile_tutoring_detail_result_data['Tutoring_Grade'],
																				'Tutoring_ALL_Subjects' => $profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'],
																				'Tutoring_Year' => $profile_tutoring_detail_result_data['Tutoring_Year'],
																				'Tutoring_Month' => $profile_tutoring_detail_result_data['Tutoring_Month'],
																				'user_id' => $profile_tutoring_detail_result_data['user_id']
																				);
																				
									}

								}	

							**/














								
						}
						

					// profile_tutoring_detail_result end


					

					// complete_user_profile_tutoring_grade_detail start

					
						$complete_user_profile_tutoring_grade_detail_result = $conn->query("SELECT * FROM complete_user_profile_tutoring_grade_detail WHERE user_id = '".$Filter_Data['user_id']."' ");		
						
						while($complete_user_profile_tutoring_grade_detail_result_data = mysqli_fetch_array($complete_user_profile_tutoring_grade_detail_result))
						{
							$complete_user_profile_tutoring_grade_detail_array[] = array(
																						'tutoring_grade_detail_id' => $complete_user_profile_tutoring_grade_detail_result_data['tutoring_grade_detail_id'],
																						'Tutoring_Grade' => $complete_user_profile_tutoring_grade_detail_result_data['Tutoring_Grade'],
																						'user_id' => $complete_user_profile_tutoring_grade_detail_result_data['user_id']
																						
																						);
						}
						

					// complete_user_profile_tutoring_grade_detail end	



					// complete_user_profile_tutoring_tutoring_subjects_detail start

					
						$tutoring_subjects_detail_result = $conn->query("SELECT * FROM complete_user_profile_tutoring_tutoring_subjects_detail WHERE Tutoring_ALL_Subjects = '".$Filter_Data['Tutoring_ALL_Subjects']."' ");		
						
						
						while($tutoring_subjects_detail_result_data = mysqli_fetch_array($tutoring_subjects_detail_result))
						{
							$tutoring_subjects_detail_result_data_array[] = array(
																						'tutoring_subject_detail_id' => $tutoring_subjects_detail_result_data['tutoring_subject_detail_id'],
																						'Tutoring_ALL_Subjects' => $tutoring_subjects_detail_result_data['Tutoring_ALL_Subjects'],
																						'user_id' => $tutoring_subjects_detail_result_data['user_id']
																						
																						);
						}
						

					// complete_user_profile_tutoring_tutoring_subjects_detail end			

					
					$user_main_data = mysqli_fetch_array($conn->query("select * from user_info where user_id = '".$Filter_Data['user_id']."' "));
					
					
					
					if($distance_value <= $Filter_Data['travel_distance'])  /// till 50 km
					{		
                      
                      
					  if($logged_in_student_id !="")
					  {
						 
						  $tutor_favrourite_val = mysqli_fetch_array($conn->query("SELECT * FROM favourite_tutor_by_student WHERE tutor_id = '".$Filter_Data['user_id']."' and logged_in_student_id = '".$logged_in_student_id."' "));
						  $favourite_val = $tutor_favrourite_val['favourite'];
					  }
					  else{
						  $favourite_val = 'false';
					  }
                      
					  if($favourite_val==null || $favourite_val=="")
					  {
						  $favourite_val = 'false';
					  }
                      
					 
					 
					 ///// Rating
					 
					  $rating_val = mysqli_fetch_array($conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$Filter_Data['user_id']."' "));
						
						if($rating_val['rating_no'] == null || $rating_val['rating_no'] =="")		
						{
							$rating_val_f = 0;
						}
						else{
							$rating_val_f = $rating_val['rating_no'];
						}
                      
					  
					  
					  
					   //// Average Rating of student_date_time_offer_confirmation
					
					
					$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$Filter_Data['user_id']."' ");
					
					
					
					$nn = 0;
					$sn = 0;
					while($avg_rating = mysqli_fetch_array($avg_rating_sql))
					{
						$sn = $sn+1;
						$nn = $nn+$avg_rating['rating_no'];
					}
					
					
					if($nn !=0 && $sn !=0)
					{
						
						 $avg_rating = round($nn/$sn); 
					}
					else
					{
						 $avg_rating = 'No rating.';
					}
					 
					  
					  
						
						$Response[] = array(
											'user_id' => $Filter_Data['user_id'],
											'first_name' => $user_main_data['first_name'],
											'last_name' => $user_main_data['last_name'],
                          					'favourite' => $favourite_val,
											'rating_val' => $rating_val_f,
											'Average_rating' => $avg_rating,
											'email' => $user_main_data['email'],
											'mobile' => $user_main_data['mobile'],
											'address1' => $user_main_data['address1'],
											'age' => $Filter_Data['age'],
											'profile_image' => $Filter_Data['profile_image'],
											'flag' => $Filter_Data['flag'],
											'personal_statement' => $Filter_Data['personal_statement'],
											'tutor_code' => $Filter_Data['tutor_code'],
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
											'between_distance' => $distance_value.' KM',
											'profile_history_academy_data_array' => $profile_history_academy_data_array,
											'profile_history_academy_result_data_array' => $profile_history_academy_result_data_array,
											'profile_tutoring_detail_result_data_array' => $profile_tutoring_detail_result_data_array,
											'complete_user_profile_tutoring_grade_detail_array' => $complete_user_profile_tutoring_grade_detail_array,
											'tutoring_subjects_detail_result_data_array' => $tutoring_subjects_detail_result_data_array
											);
					}
					else{
						$resultData = array('status' => false, 'message' => 'No record found.' );
					}	
						
					
					
					
				}
				
				
				if(!empty($Response))
				{
					$resultData = array('status' => true, 'Search_Data_Records' => $Response);
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