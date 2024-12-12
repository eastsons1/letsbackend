<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
		if($_GET['tutor_code'] !="")
		{
	
					
			//$query = "SELECT * FROM user_tutor_info as Tprof INNER JOIN tutor_booking_process as TBookp ON Tprof.user_id = TBookp.tutor_id WHERE Tprof.tutor_code = '".$_GET['tutor_code']."' ";
				
			$query = "SELECT * FROM user_tutor_info WHERE tutor_code = '".$_GET['tutor_code']."' ";
					
				
				
				
			$result = $conn->query($query) or die ("table not found");
			$numrows = mysqli_num_rows($result);
			
			
			if($numrows > 0)
			{
				$Response = array();
				
				while($tutor_resultD = mysqli_fetch_assoc($result))
				{
					
					$Tutor_book_process_sql = $conn->query("select * from tutor_booking_process where tutor_id = '".$tutor_resultD['user_id']."' ");
					
					$tutor_result = mysqli_fetch_array($Tutor_book_process_sql);
					
					$tutor_booking_process_StudentSubjects = array();
					$Tutor_Qualification  = array();
					$Tutor_Schedule   = array();
					$Tutor_slot_time = array();
					$Stream_Data_array = array();
					
					//get stream List
					/// For Tutor Schedule and Slot Times
					$stream_sql = $conn->query("select * from tutor_booking_process_streams where tutor_booking_process_id = '".$tutor_result['tutor_booking_process_id']."' ");
					
					while($Stream_Data = mysqli_fetch_array($stream_sql))
					{
						if($Stream_Data['streams'] != "")
						{
							$Stream_Data_array[] = array(
														 'tutor_booking_process_streams_id' => $Stream_Data['tutor_booking_process_streams_id'],
														 'streams' => $Stream_Data['streams'],
														  'tutor_booking_process_id' => $Stream_Data['tutor_booking_process_id']
														 );
						}
					}
					
					
					
					
					/// for Student Level, Grade and Subjects List
					$ss_query2 = $conn->query("select * from tutor_booking_process_Level_Grade_Subjects where tutor_booking_process_id = '".$tutor_result['tutor_booking_process_id']."' ");
					
					while($student_subject_res = mysqli_fetch_array($ss_query2))
					{
						if($student_subject_res['Level'] != "Secondary" && $student_subject_res['Grade'] != "" && $student_subject_res['ALL_Subjects'] != "")
						{
							$post_requirements_student_subjects[] = array(
																			 'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
																			  'ID' => $student_subject_res['ID'],
																			  'Level' => $student_subject_res['Level'],
																			  'Admission_Level' => $student_subject_res['Admission_Level'],
																			  'Grade' => $student_subject_res['Grade'],
																			  'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
																			  'tutor_booking_process_id' => $student_subject_res['tutor_booking_process_id']
																			  
																			 );
						}
						
						if($student_subject_res['Level'] == "Secondary" && $student_subject_res['Grade'] != "" && $student_subject_res['ALL_Subjects'] != "")
						{
							$post_requirements_student_subjects[] = array(
																			 'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
																			  'ID' => $student_subject_res['ID'],
																			  'Level' => $student_subject_res['Level'],
																			  'Admission_Level' => $student_subject_res['Admission_Level'],
																			  'Grade' => $student_subject_res['Grade'],
																			  'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
																			  'tutor_booking_process_id' => $student_subject_res['tutor_booking_process_id'],
																			  'Stream_Data_array' => $Stream_Data_array
																			 );
						}
						
					}
					
					
					/// For Tutor Schedule and Slot Times
					$TS_query2 = $conn->query("select * from tutor_booking_process_Schedules_Slot_Time where tutor_booking_process_id = '".$tutor_result['tutor_booking_process_id']."' ");
					
					while($Tutor_Schedule_res = mysqli_fetch_array($TS_query2))
					{
						if($Tutor_Schedule_res['tutor_schedule'] != "")
						{
							$Tutor_Schedule[] = array(
														 'post_requirement_Tutor_Schedules_Slot_Time_id' => $Tutor_Schedule_res['post_requirement_Tutor_Schedules_Slot_Time_id'],
														 'tutor_schedule' => $Tutor_Schedule_res['tutor_schedule'],
														  'slot_times' => $Tutor_Schedule_res['slot_times'],
														   'tutor_booking_process_id' => $Tutor_Schedule_res['tutor_booking_process_id']
														 );
						}
					}
					
					
					
					
					/// for Tutor_Qualification
					$TQ_query = $conn->query("select * from tutor_booking_process_TutorQualification where tutor_booking_process_id = '".$tutor_result['tutor_booking_process_id']."' ");
					
					while($Tutor_Qualification_res = mysqli_fetch_array($TQ_query))
					{
						if($Tutor_Qualification_res['Tutor_Qualification'] != "")
						{
							$Tutor_Qualification[] = array(
														 'tutor_booking_process_TutorQualification_id' => $Tutor_Qualification_res['tutor_booking_process_TutorQualification_id'],
														 'Tutor_Qualification' => $Tutor_Qualification_res['Tutor_Qualification']
														 );
						}
					}
					
					
					
					////////////
					$tutor_profile_data = mysqli_fetch_array($conn->query("SELECT * FROM user_tutor_info WHERE tutor_code = '".$_GET['tutor_code']."' "));
					
					
					//////////
					
					
					$Response[] = array(
                      				'tutor_booking_process_id' => $tutor_result['tutor_booking_process_id'],	
                      				'user_id' => $tutor_profile_data['user_id'],
									'booking_from' => $tutor_result['booking_from'],
									'qualification' => $tutor_profile_data['qualification'],
									'profile_image' => $tutor_profile_data['profile_image'],
									'age' => $tutor_profile_data['age'],
									'tutor_date_of_year' => $tutor_profile_data['date_of_year'],
									'gender' => $tutor_profile_data['gender'],
									'nationality' => $tutor_profile_data['nationality'],
									'flag' => $tutor_profile_data['flag'],
									'tutor_name_of_school' => $tutor_profile_data['name_of_school'],
									'tutor_course_exam' => $tutor_profile_data['Course_Exam'],
									'tutor_other_course_exam' => $tutor_profile_data['OtherCourse_Exam'],
									'tutor_graduation_year' => $tutor_profile_data['gra_year'],
									'tutor_status' => $tutor_profile_data['tutor_status'],
									'tutor_tuition_type' => $tutor_profile_data['tuition_type'],
									'tutor_location' => $tutor_profile_data['location'],
									'tutor_postal_code' => $tutor_profile_data['postal_code'],
									'travel_distance'	=> $tutor_profile_data['travel_distance'],
									'tutor_tutoring_experience_years' => $tutor_profile_data['tutor_tutoring_experience_years'],
									'tutor_tutoring_experience_months' => $tutor_profile_data['tutor_tutoring_experience_months'],
									'personal_statement' => $tutor_profile_data['personal_statement'],
									'lettitude' => $tutor_profile_data['lettitude'],
									'longitude' => $tutor_profile_data['longitude'],
									'stream' => $tutor_profile_data['stream'],
									'tutor_code' => $tutor_profile_data['tutor_code'],
                      
									 
									 'student_id' => $tutor_result['student_id'],
									 'student_level' => $tutor_result['student_level'],
									 'student_grade' => $tutor_result['student_grade'],
									 'student_tution_type' => $tutor_result['student_tution_type'],
                                     'tutor_booking_status' => $tutor_result['tutor_booking_status'],
									  'postal_code' => $tutor_result['postal_code'],
									   'postal_address' => $tutor_result['postal_address'],
                                      'offer_status' => $tutor_result['offer_status'],
                                       'student_offer_date' => $tutor_result['student_offer_date'],
                                      'student_offer_time' => $tutor_result['student_offer_time'],
                                       'tutor_offer_date' => $tutor_result['tutor_offer_date'],
                                      'tutor_offer_time' => $tutor_result['tutor_offer_time'],
									  'tutor_accept_date_time_status' => $tutor_result['tutor_accept_date_time_status'],
                                       'student_date_time_offer_confirmation' => $tutor_result['student_date_time_offer_confirmation'],
									 'tutor_id' => $tutor_result['tutor_id'],
									 'tutor_duration_weeks' => $tutor_result['tutor_duration_weeks'],
									 'tutor_duration_hours' => $tutor_result['tutor_duration_hours'],
									 'tutor_tution_fees' => $tutor_result['tutor_tution_fees'],
									 'tutor_tution_schedule_time' => $tutor_result['tutor_tution_schedule_time'],
									 'tutor_tution_offer_amount_type' => $tutor_result['tutor_tution_offer_amount_type'],
									 'tutor_tution_offer_amount' => $tutor_result['tutor_tution_offer_amount'],
                                      'amount_negotiate_by_tutor' => $tutor_result['amount_negotiate_by_tutor'],
									  'negotiate_by_tutor_amount_type' => $tutor_result['negotiate_by_tutor_amount_type'],
                                     'amount_negotiate_by_student' => $tutor_result['amount_negotiate_by_student'],
									 'negotiate_by_student_amount_type' => $tutor_result['negotiate_by_student_amount_type'],
									 'booked_date' => $tutor_result['booked_date'],
									 'tutor_booking_status' => $tutor_result['tutor_booking_status'],
									 'offer_status' => $tutor_result['offer_status'],
                      
                      
                      				'student_level_grade_subjects' => $post_requirements_student_subjects,
									
									 'tutor_schedule_and_slot_times' => $Tutor_Schedule,
                      				 'tutor_qualification' => $Tutor_Qualification,
                      				
                      				
									 
									 	
									 );
					
					
				}	
				
				if(!empty($Response))
				{
					$resultData = array('status' => true, 'output' => $Response);
				}
				else			
				{
					$resultData = array('status' => false, 'message' => 'No Record Found.');
				}				
				
				
			}
			else 
			{
				//$message1="Email Id Or Mobile Number not valid !";
				$resultData = array('status' => false, 'message' => 'No Record Found.');
			}
				

		}
		else{
			
			$resultData = array('status' => false, 'message' => 'Tutor code can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>