<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
			$student_login_id = $_GET['student_login_id'];
			
			if($student_login_id !="" )
			{	
		
				//$query = "SELECT * FROM student_post_requirements as requirem INNER JOIN student_post_requirements_Applied_by_tutor as apply ON requirem.student_post_requirements_id = apply.student_post_requirements_id WHERE requirem.logged_in_user_id = '".$student_login_id."' and apply.apply_tag = 'true' ";
				
				$query = "SELECT * FROM student_post_requirements WHERE logged_in_user_id = '".$student_login_id."'  ";
				
				
				$result = $conn->query($query) or die ("table not found");
				$numrows = mysqli_num_rows($result);
			
			
			if($numrows > 0)
			{
				$Response = array();
				$Response2 = array();
				$Tutor_Profile_arr = array();
				
				while($tutor_result = mysqli_fetch_assoc($result))
				{
					
					
					
					///print_r($tutor_result);
					
					$post_requirements_student_subjects = array();
					$Tutor_Qualification  = array();
					$Tutor_Schedule   = array();
					$Tutor_slot_time = array();
					
					
					/// for Student Level, Grade and Subjects List
					$ss_query = $conn->query("select * from tbl_Student_Level_Grade_Subjects_Post_Requirement where student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
					
					while($student_subject_res = mysqli_fetch_array($ss_query))
					{
						if($student_subject_res['Level'] != "" && $student_subject_res['Grade'] != "" && $student_subject_res['ALL_Subjects'] != "")
						{
							$post_requirements_student_subjects[] = array(
																			 'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
																			  'ID' => $student_subject_res['ID'],
																			  'Level' => $student_subject_res['Level'],
																			  'Grade' => $student_subject_res['Grade'],
																			  'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
																			  'student_post_requirements_id' => $student_subject_res['student_post_requirements_id']
																			 );
						}
					}
					
					/// for Tutor_Qualification
					$TQ_query = $conn->query("select * from post_requirements_TutorQualification where student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
					
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
					
					/// For Tutor Schedule and Slot Times
					$TS_query = $conn->query("select * from tbl_Tutor_Schedules_Slot_Time_post_requirement where student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
					
					while($Tutor_Schedule_res = mysqli_fetch_array($TS_query))
					{
						if($Tutor_Schedule_res['tutor_schedule'] != "")
						{
							$Tutor_Schedule[] = array(
														'post_requirement_Tutor_Schedules_Slot_Time_id' => $Tutor_Schedule_res['post_requirement_Tutor_Schedules_Slot_Time_id'],
														'tutor_schedule' => $Tutor_Schedule_res['tutor_schedule'],
														'slot_times' => $Tutor_Schedule_res['slot_times'],
														'student_post_requirements_id' => $Tutor_Schedule_res['student_post_requirements_id']
													  );
						}
					}
					
					
					
					
					if($student_login_id !="")
					{
						
						$aply_sql = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' and apply_tag = 'true' ");
						
						if(mysqli_num_rows($aply_sql)>0)
						{
						
						$tutor_arr = array();
						
						while($tutor_applied = mysqli_fetch_assoc($aply_sql))
						{
							
							
							
							///// Tutor profile start
								
								$tutor_profile = mysqli_fetch_assoc($conn->query("SELECT * FROM user_tutor_info as prof INNER JOIN user_info as info ON prof.user_id = info.user_id WHERE prof.user_id = '".$tutor_applied['tutor_login_id']."' "));	
											
											

									////  For complete_user_profile_history_academy
							
								$HA = array();
								
								
								$userHA = $conn->query("SELECT * FROM complete_user_profile_history_academy WHERE user_id = '".$tutor_applied['tutor_login_id']."' ");
								
								while($user_list_HA = mysqli_fetch_assoc($userHA))
								{
									$HAR = array();
									////  For complete_user_profile_history_academy Results start
									
										$rest = $conn->query("SELECT * FROM complete_user_profile_history_academy_result WHERE user_id = '".$tutor_id."' and record_id = '".$user_list_HA['record_id']."'  ");
										while($HARD = mysqli_fetch_array($rest))
										{
											if($HARD['record_id'] !="" )
											{
												$HAR[] = array(
															'HistoryID' => $HARD['record_id'],
															'subject' => $HARD['subject'],
															'grade' => $HARD['grade']
												
												);
											}	
										}
									
									
									////  For complete_user_profile_history_academy Results end
									
									
									
									$HA[] = array('history_academy_id' => $user_list_HA['history_academy_id'],
									'HistoryID' => $user_list_HA['record_id'],
									'school' => $user_list_HA['school'],
									'exam' => $user_list_HA['exam'],
									'user_id' => $user_list_HA['user_id'],
									'result' => $HAR
									
									
									
									);
									
								}
								
								
							
								
								////  For complete_user_profile_tutoring_detail
								
								$TD = array();
								
								$userTD = $conn->query("SELECT * FROM complete_user_profile_tutoring_detail WHERE user_id = '".$tutor_applied['tutor_login_id']."' ");
								
								while($user_list_TD = mysqli_fetch_assoc($userTD))
								{
									
									
									$TD[] = array('tutoring_detail_id' => $user_list_TD['tutoring_detail_id'],
													'TutoringLevel' => $user_list_TD['TutoringLevel'],
													'AdmissionLevel' => $user_list_TD['AdmissionLevel'],
													'Tutoring_Grade' => $user_list_TD['Tutoring_Grade'],
													'Tutoring_ALL_Subjects' => $user_list_TD['Tutoring_ALL_Subjects'],
													'Tutoring_Year' => $user_list_TD['Tutoring_Year'],
													'Tutoring_Month' => $user_list_TD['Tutoring_Month']
									
									);
									
								}
								
					
							
							if($tutor_applied['post_apply_id'] !="")
							{
							
							$tutor_arr[] = array(
												'post_apply_id' => $tutor_applied['post_apply_id'],
												'student_post_requirements_id' => $tutor_applied['student_post_requirements_id'],
												'apply_tag' => $tutor_applied['apply_tag'],
												'tutor_login_id' => $tutor_applied['tutor_login_id'],
												'applied_date' => $tutor_applied['applied_date'],
												'applied_time' => $tutor_applied['applied_time'],
												'student_response' => $tutor_applied['student_response'],
												'student_loggedIn_id' => $tutor_applied['student_loggedIn_id'],
												
												'user_id' => $tutor_profile['user_id'],
												'adminusername' => $tutor_profile['adminusername'],
												'first_name' => $tutor_profile['first_name'],
												'last_name' => $tutor_profile['last_name'],
												'email' => $tutor_profile['email'],
												
												'profile_image' => $tutor_profile['profile_image'],
												'age' => $tutor_profile['age'],
												'gender' => $tutor_profile['gender'],
												'nationality' => $tutor_profile['nationality'],
												'qualification' => $tutor_profile['qualification'],
												'name_of_school' => $tutor_profile['name_of_school'],
												'Course_Exam' => $tutor_profile['Course_Exam'],
												'gra_year' => $tutor_profile['gra_year'],
												'tutor_status' => $tutor_profile['tutor_status'],
												'tuition_type' => $tutor_profile['tuition_type'],
												'location' => $tutor_profile['location'],
												'postal_code' => $tutor_profile['postal_code'],
												'travel_distance' => $tutor_profile['travel_distance'],
												'tutor_tutoring_experience_years' => $tutor_profile['tutor_tutoring_experience_years'],
												'tutor_tutoring_experience_months' => $tutor_profile['tutor_tutoring_experience_months'],
												'personal_statement' => $tutor_profile['personal_statement'],
												'lettitude' => $tutor_profile['lettitude'],
												'longitude' => $tutor_profile['longitude'],
												'stream' => $tutor_profile['stream'],
												'tutor_code' => $tutor_profile['tutor_code'],
												
												'history_academy_arr' => $HA,
																							//'history_academy_result' => $HAR,
												'tutoring_detail_arr' => $TD
												);
							}
							else{
								$tutor_arr[] = "";
							}	
												
												
						}
						
					
					
					
					
					
					
						$Response2[] = array(
									'student_post_requirements_id' => $tutor_result['student_post_requirements_id'],
									'student_id' => $tutor_result['logged_in_user_id'],
									'student_level' => $tutor_result['student_level'],
									'student_grade' => $tutor_result['student_grade'],
									'student_tution_type' => $tutor_result['student_tution_type'],
									'student_postal_code' => $tutor_result['student_postal_code'],
									'student_postal_address' => $tutor_result['student_postal_address'],
									'tutor_booking_status' => $tutor_result['tutor_booking_status'],
									'offer_status' => $tutor_result['offer_status'],
									'student_offer_date' => $tutor_result['student_offer_date'],
									'student_offer_time' => $tutor_result['student_offer_time'],
									'tutor_offer_date' => $tutor_result['tutor_offer_date'],
									'tutor_offer_time' => $tutor_result['tutor_offer_time'],
									'tutor_accept_date_time_status' => $tutor_result['tutor_accept_date_time_status'],
									'student_date_time_offer_confirmation' => $tutor_result['student_date_time_offer_confirmation'],
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
									
									'post_updated_date' => $tutor_result['post_updated_date'],
									'total_days_for_expire_post' => $tutor_result['total_days_for_expire_post'],
									'post_expire_status' => $tutor_result['post_expire_status'],
									
									'tutor_booking_status' => $tutor_result['tutor_booking_status'],
									'offer_status' => $tutor_result['offer_status'],
									
									'student_level_grade_subjects' => $post_requirements_student_subjects,
									'tutor_qualification' => $Tutor_Qualification,
									'tutor_schedule_and_slot_times' => $Tutor_Schedule,
									'tutor_details' => $tutor_arr
									
									 	
									 );
									 
									 
						}	

						
						
						
					}				 
								
								
					
				}	
				
				
				//$Response[] =  array_merge(array_unique($Response2),$Tutor_Profile_arr);
				
				
				
				if(!empty($Response2))
				{
					$resultData = array('status' => true, 'output' => $Response2);
				}
				else			
				{
					$resultData = array('status' => false, 'message' => 'No Record Found.');
				}				
				
				
			}
			else 
			{
				$resultData = array('status' => false, 'message' => 'No Record Found.');
			}
				

			}
			else 
			{
				$resultData = array('status' => false, 'message' => 'Student login id can not be blank.');
			}
			
							
			echo json_encode($resultData);
					
			
?>