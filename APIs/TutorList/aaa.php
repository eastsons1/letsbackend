<?php
///// Tutor profile start
								
								$tutor_profile = mysqli_fetch_assoc($conn->query("
SELECT * FROM user_info info INNER JOIN student_post_requirements spr ON info.user_id = spr.logged_in_user_id WHERE spr.student_post_requirements_id  = '".$tutor_result['student_post_requirements_id']."' "));	
											
											

									////  For complete_user_profile_history_academy
							
								$HA = array();
								
								
								$userHA = $conn->query("SELECT * FROM complete_user_profile_history_academy WHERE user_id = '".$_GET['student_id']."' ");
								
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
												
												
						
						
						
						?>