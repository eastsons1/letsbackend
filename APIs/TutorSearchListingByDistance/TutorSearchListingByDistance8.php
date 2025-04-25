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
			
			
			
		
		if($array['postal_code']!="" && $array['student_lat'] != "" && $array['student_long'] != "" )
		{
			
			//// get between distance start
			
			$sql_Q = $conn->query("select tuition_type,user_id,lettitude,longitude,travel_distance from user_tutor_info  ");
			
			$i=0;
			$a = array();
				while($get_Data = mysqli_fetch_assoc($sql_Q))
				{
					
					if($get_Data['tuition_type']=="Home Tuition")
					{
						
						if($get_Data['lettitude'] !="" && $get_Data['longitude'] !="")
						{
							$lat = $get_Data['lettitude'];
							$long = $get_Data['longitude'];
						}
						
						//echo $distance_value = distance($student_lat, $student_long, $lat, $long, "K") . " Kilometers<br>";
						 $distance_value = distance($student_lat, $student_long, $lat, $long, "K");

						
						
						if($distance_value <= $get_Data['travel_distance'])  /// till 50 km
						{
							
							 $a[]=$get_Data['user_id'];
							 //$i++;
							//echo $distance_value.'=';
							//echo $get_Data['user_id'].'=';
							$distance_value_status = 1;
						}
						else{
							$distance_value_status = 0;
						}
					
						
					
					}
					
					
					
	
				}
			//// end
			
			
			
			
			
			
			
			
			
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
			
			 
			
			
			
			
			 //$check = "SELECT DISTINCT user_tutor_info.profile_image,user_tutor_info.tutor_code, user_tutor_info.personal_statement, user_tutor_info.tutor_tutoring_experience_months, user_tutor_info.tutor_tutoring_experience_years, user_tutor_info.postal_code, user_tutor_info.gra_year, user_tutor_info.OtherCourse_Exam, user_tutor_info.Course_Exam, user_tutor_info.name_of_school, user_tutor_info.flag, user_tutor_info.date_of_year, user_tutor_info.age, user_tutor_info.qualification, user_tutor_info.user_id, user_tutor_info.gender, user_tutor_info.nationality, user_tutor_info.tutor_status, user_tutor_info.tuition_type, user_tutor_info.postal_code, user_tutor_info.travel_distance, user_tutor_info.lettitude, user_tutor_info.longitude, user_tutor_info.stream FROM complete_user_profile_tutoring_detail INNER JOIN user_tutor_info ON complete_user_profile_tutoring_detail.user_id = user_tutor_info.user_id INNER JOIN complete_user_profile_tutoring_grade_detail ON user_tutor_info.user_id = complete_user_profile_tutoring_grade_detail.user_id INNER JOIN complete_user_profile_tutoring_tutoring_subjects_detail ON complete_user_profile_tutoring_grade_detail.user_id = complete_user_profile_tutoring_tutoring_subjects_detail.user_id INNER JOIN complete_user_profile_tutoring_admission_stream ON complete_user_profile_tutoring_tutoring_subjects_detail.user_id = complete_user_profile_tutoring_admission_stream.user_id WHERE 1 ".$postal_lat_long.$gender.$tutor_status.$nationality.$subjects.$TutoringLevel.$grade.$qualification.$stream_V;        //; 
			
			//echo $check = "SELECT * FROM user_tutor_info WHERE ".$postal_lat_long;        //; 
			
			 $check = "SELECT DISTINCT user_tutor_info.profile_image,user_tutor_info.age,user_tutor_info.tutor_code, user_tutor_info.personal_statement, user_tutor_info.tutor_tutoring_experience_months, user_tutor_info.tutor_tutoring_experience_years, user_tutor_info.postal_code, user_tutor_info.gra_year, user_tutor_info.OtherCourse_Exam, user_tutor_info.Course_Exam, user_tutor_info.name_of_school, user_tutor_info.flag, user_tutor_info.date_of_year, user_tutor_info.age, user_tutor_info.qualification, user_tutor_info.user_id, user_tutor_info.gender, user_tutor_info.nationality, user_tutor_info.tutor_status, user_tutor_info.tuition_type, user_tutor_info.postal_code, user_tutor_info.travel_distance, user_tutor_info.lettitude, user_tutor_info.longitude, user_tutor_info.stream FROM user_tutor_info LEFT JOIN complete_user_profile_tutoring_detail ON user_tutor_info.user_id =  complete_user_profile_tutoring_detail.user_id     LEFT JOIN complete_user_profile_tutoring_grade_detail ON complete_user_profile_tutoring_detail.user_id = complete_user_profile_tutoring_grade_detail.user_id LEFT JOIN complete_user_profile_tutoring_tutoring_subjects_detail ON complete_user_profile_tutoring_grade_detail.user_id = complete_user_profile_tutoring_tutoring_subjects_detail.user_id LEFT JOIN complete_user_profile_tutoring_admission_stream ON complete_user_profile_tutoring_tutoring_subjects_detail.user_id = complete_user_profile_tutoring_admission_stream.user_id WHERE ".$user_rec_by_distance.$gender.$tutor_status.$nationality.$subjects.$TutoringLevel.$grade.$qualification.$stream_V;        //; 

			
			
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

					
						$tutoring_subjects_detail_result = $conn->query("SELECT * FROM complete_user_profile_tutoring_tutoring_subjects_detail WHERE user_id = '".$Filter_Data['user_id']."' ");		
						
						
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
						//$distance_data[] = $distance_value;
						
						//$distance_bet =  array('between_distance' => $distance_value);
						$Response[] = array(
											'user_id' => $Filter_Data['user_id'],
											'first_name' => $user_main_data['first_name'],
											'last_name' => $user_main_data['last_name'],
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