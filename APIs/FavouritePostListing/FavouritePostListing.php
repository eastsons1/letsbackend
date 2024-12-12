<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
		if($_GET['student_id'] !="")
		{
			
	
			$query = "SELECT DISTINCT postR.student_post_requirements_id, postR.* FROM student_post_requirements as postR INNER JOIN student_post_requirements_Favourite_Assigned as pFrA ON postR.student_post_requirements_id = pFrA.student_post_requirements_id where pFrA.favourite = 'true' and postR.logged_in_user_id = '".$_GET['student_id']."' order by postR.update_date_time desc  ";
			
			//$query = "SELECT * FROM student_post_requirements where logged_in_user_id = '".$_GET['student_id']."' order by update_date_time desc  ";
			
			
				
			$result = $conn->query($query) or die ("table not found");
			$numrows = mysqli_num_rows($result);
			
			
			if($numrows > 0)
			{
				$Response = array();
				
				
				
				
				
				while($tutor_result = mysqli_fetch_assoc($result))
				{
					//echo date("d-m-y");
					
					$str = $tutor_result['booked_date'];
					 $str2 = strtotime(date("d-m-Y")) - (strtotime($str));
					 $total_days_for_expire_post =  round($str2/3600/24);
					
					$expiredValue = round(45);
					
					$Total_days_for_expired_post_val = $expiredValue - $total_days_for_expire_post;
					
					if($Total_days_for_expired_post_val>1)
					{
						$Total_days_for_expired_post = $Total_days_for_expired_post_val.' days left';
					}
					elseif($Total_days_for_expired_post_val==1)
					{
						
						$Total_days_for_expired_post = $Total_days_for_expired_post_val.' day left';
					}
					else{
						$Total_days_for_expired_post = '0 day left';
					}
					
					
					if($total_days_for_expire_post > $expiredValue )
					{
						$post_expire_status = 'Expired';
						
						$student_post_update_for_expireSQL = $conn->query("UPDATE student_post_requirements SET total_days_for_expire_post = '".$Total_days_for_expired_post_val."', post_expire_status = '".$post_expire_status."' WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' "); 
			
					}
					else					
					{
						$post_expire_status = '';
						$student_post_update_for_expireSQL = $conn->query("UPDATE student_post_requirements SET total_days_for_expire_post = '".$Total_days_for_expired_post_val."', post_expire_status = '".$post_expire_status."' WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' "); 
			
					}
					
					
					
					
					
				//	if($total_days_for_expire_post < 45 )
				//	{	
					
						
					
					$post_requirements_student_subjects = array();
					$Tutor_Qualification  = array();
					$Tutor_Schedule   = array();
					$Tutor_slot_time = array();
					
					
					
					
					/// for Student Level, Grade and Subjects List
					$ss_query = $conn->query("select * from tbl_Student_Level_Grade_Subjects_Post_Requirement where student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
					
					while($student_subject_res = mysqli_fetch_array($ss_query))
					{
						if($student_subject_res['Level'] != "Secondary" && $student_subject_res['ALL_Subjects'] != "")
						{
							$post_requirements_student_subjects[] = array(
																			 'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
																			  'ID' => $student_subject_res['ID'],
																			  'Level' => $student_subject_res['Level'],
																			  'Admission_Level' => $student_subject_res['Admission_Level'],
																			  'Grade' => $student_subject_res['Grade'],
																			  'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
																			  'student_post_requirements_id' => $student_subject_res['student_post_requirements_id']
																			 );
						}
						
						if($student_subject_res['Level'] == "Secondary" && $student_subject_res['ALL_Subjects'] != "")
						{
							$Streams_array = array();
							
							$get_stream_sql = $conn->query("SELECT * FROM student_post_requirements_streams WHERE student_post_requirements_id = '".$student_subject_res['student_post_requirements_id']."' ");
							
							while($get_streams = mysqli_fetch_array($get_stream_sql))
							{
								$Streams_array[] = $get_streams['student_post_requirements_streams'];
							}
							
							
							
							$post_requirements_student_subjects[] = array(
																			 'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
																			  'ID' => $student_subject_res['ID'],
																			  'Level' => $student_subject_res['Level'],
																			  'Grade' => $student_subject_res['Grade'],
																			  'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
																			  'student_post_requirements_id' => $student_subject_res['student_post_requirements_id'],
																			  'Streams' =>  $Streams_array
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
														 'Tutor_Qualification_id' => $Tutor_Qualification_res['Tutor_Qualification_id'],
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
					
					
					
					
					
					
					
					
					
		   ///// Tutor profile start
								
				//$tutor_profile = mysqli_fetch_assoc($conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor appT INNER JOIN user_tutor_info tutor ON appT.tutor_login_id = tutor.user_id  WHERE appT.student_post_requirements_id  = '".$tutor_result['student_post_requirements_id']."' "));	
				
				$tutor_data = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor appT INNER JOIN user_tutor_info tutor ON appT.tutor_login_id = tutor.user_id INNER JOIN user_info info ON tutor.user_id=info.user_id  WHERE appT.student_post_requirements_id  = '".$tutor_result['student_post_requirements_id']."' and appT.apply_tag = 'true' ");
				
				 $Total_no_of_Tutor_Applied = mysqli_num_rows($tutor_data);
				
				//echo $Total_no_of_Tutor_Applied;
				
				
				
				
				
				if($Total_no_of_Tutor_Applied===0)
				{
					$Total_no_of_Tutor_Applied_status=0;
				}
				else{
					$Total_no_of_Tutor_Applied_status=1;
				}
				
				
					
					$tutor_arr = array();
					
					
					
					while($tutor_profile = mysqli_fetch_array($tutor_data))
					{	

						if($tutor_result['student_post_requirements_id']==$tutor_profile['student_post_requirements_id'])	
						{
							
							//echo $tutor_profile['student_post_requirements_id'];
							//echo $tutor_profile['tutor_login_id'];
									
						///////////////
						
								$Interested_Tutor = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor WHERE student_post_requirements_id = '".$tutor_profile['student_post_requirements_id']."' and apply_tag = 'true' ");
								
							
								
								
								$Interested_Tutor_No = mysqli_num_rows($Interested_Tutor);
								
						
								
								if($Interested_Tutor_No != 0 )						
								{
									//echo $Interested_Tutor_No;
									
									$tutor_login_idV = mysqli_fetch_array($Interested_Tutor);
									
									//////////////////
										
										
										//echo $tutor_login_idV['tutor_login_id'];
										//echo $tutor_profile['student_post_requirements_id'];
										
										$ssql = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor appT INNER JOIN user_tutor_info tutor ON appT.tutor_login_id = tutor.user_id INNER JOIN user_info info ON tutor.user_id=info.user_id  WHERE appT.student_post_requirements_id  = '".$tutor_profile['student_post_requirements_id']."' and appT.tutor_login_id = '".$tutor_profile['tutor_login_id']."' and appT.apply_tag='true' ");
										
									$interested_Tutor_arra = array();
										
										while($Interested_Tutor_detail_Data = mysqli_fetch_array($ssql))
										{
									
									
										//echo $Interested_Tutor_detail_Data['tutor_login_id'];
									
									
									//echo $Interested_Tutor_detail_Data['student_post_requirements_id'];
										
										//if($Interested_Tutor_detail_Data['student_post_requirements_id'] !="" )
										//{
										
										$Apply_Tag_sql = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor WHERE student_post_requirements_id = '".$tutor_profile['student_post_requirements_id']."' and tutor_login_id = '".$Interested_Tutor_detail_Data['tutor_login_id']."' and apply_tag='true'");

										$Apply_Tag = mysqli_fetch_array($Apply_Tag_sql);
										
										
										
										$Tutor_profile_img = mysqli_fetch_array($conn->query("SELECT profile_image FROM user_tutor_info WHERE user_id = '".$Interested_Tutor_detail_Data['tutor_login_id']."' "));


										//////
										$sql_update_amount = $conn->query("SELECT * FROM student_post_requirement_amount_negotiate WHERE student_post_requirement_id = '".$Interested_Tutor_detail_Data['student_post_requirements_id']."' and tutor_login_id = '".$Interested_Tutor_detail_Data['tutor_login_id']."' ");

										$sql_update_amount_data = mysqli_fetch_array($sql_update_amount);

										$student_negotiate_amount = $sql_update_amount_data['student_negotiate_amount'];

										$tutor_negotiate_amount = $sql_update_amount_data['tutor_negotiate_amount'];

										$final_accepted_amount = $sql_update_amount_data['final_accepted_amount'];

										$final_accepted_status = $sql_update_amount_data['status'];	
										$negotiate_by = $sql_update_amount_data['negotiate_by'];	

										$amount_negotiate_tutor_ID = $sql_update_amount_data['tutor_login_id'];	
										
										
										
										
										$tutor_tution_offer_amount_type = mysqli_fetch_array($conn->query("select tutor_tution_offer_amount_type,tutor_tution_fees,tutor_tution_offer_amount,logged_in_user_id from student_post_requirements where student_post_requirements_id = '".$Interested_Tutor_detail_Data['student_post_requirements_id']."' "));
							
										$spramNeo = mysqli_fetch_array($conn->query("select final_accepted_amount,tutor_negotiate_amount from student_post_requirement_amount_negotiate where student_post_requirement_id = '".$Interested_Tutor_detail_Data['student_post_requirements_id']."' and tutor_login_id = '".$Interested_Tutor_detail_Data['tutor_login_id']."'  "));
							
									$favoutite_type = mysqli_fetch_array($conn->query("select favourite from student_post_requirements_Favourite_Assigned where student_post_requirements_id = '".$Interested_Tutor_detail_Data['student_post_requirements_id']."' and tutor_login_id = '".$Interested_Tutor_detail_Data['tutor_login_id']."' and favourite = 'true' "));
							
									
									if($favoutite_type['favourite'] !="" || $favoutite_type['favourite'] != NULL)
									{
										
										$interested_Tutor_arra = array(
										
															'post_apply_id' => $Interested_Tutor_detail_Data['post_apply_id'],
															'student_post_requirements_id' => $Interested_Tutor_detail_Data['student_post_requirements_id'],
															'apply_tag' => $Apply_Tag['apply_tag'],
															'tutor_login_id' => $Interested_Tutor_detail_Data['tutor_login_id'],
															'applied_date' => $Interested_Tutor_detail_Data['applied_date'],
															'applied_time' => $Interested_Tutor_detail_Data['applied_time'],
															'student_response' => $Interested_Tutor_detail_Data['student_response'],
															'student_loggedIn_id' => $tutor_tution_offer_amount_type['logged_in_user_id'],
															
															'student_negotiate_amount' => $student_negotiate_amount,
															'tutor_negotiate_amount' => $tutor_negotiate_amount,
															'final_accepted_amount' => $final_accepted_amount,
                                          					'final_accepted_status' => $final_accepted_status,
															'negotiate_by' => $negotiate_by,
															'amount_negotiate_tutor_ID' => $amount_negotiate_tutor_ID,
															
															'user_id' => $Interested_Tutor_detail_Data['user_id'],
															'adminusername' => $Interested_Tutor_detail_Data['adminusername'],
															'first_name' => $Interested_Tutor_detail_Data['first_name'],
															'last_name' => $Interested_Tutor_detail_Data['last_name'],
															'email' => $Interested_Tutor_detail_Data['email'],
															
															'profile_image' => $Tutor_profile_img['profile_image'],
															'age' => $Interested_Tutor_detail_Data['age'],
															'gender' => $Interested_Tutor_detail_Data['gender'],
															'nationality' => $Interested_Tutor_detail_Data['nationality'],
															'qualification' => $Interested_Tutor_detail_Data['qualification'],
															'name_of_school' => $Interested_Tutor_detail_Data['name_of_school'],
															'Course_Exam' => $Interested_Tutor_detail_Data['Course_Exam'],
															'gra_year' => $Interested_Tutor_detail_Data['gra_year'],
															'tutor_status' => $Interested_Tutor_detail_Data['tutor_status'],
															'tuition_type' => $Interested_Tutor_detail_Data['tuition_type'],
															'location' => $Interested_Tutor_detail_Data['location'],
															'postal_code' => $Interested_Tutor_detail_Data['postal_code'],
															'travel_distance' => $Interested_Tutor_detail_Data['travel_distance'],
															'tutor_tutoring_experience_years' => $Interested_Tutor_detail_Data['tutor_tutoring_experience_years'],
															'tutor_tutoring_experience_months' => $Interested_Tutor_detail_Data['tutor_tutoring_experience_months'],
															'personal_statement' => $Interested_Tutor_detail_Data['personal_statement'],
															'lettitude' => $Interested_Tutor_detail_Data['lettitude'],
															'longitude' => $Interested_Tutor_detail_Data['longitude'],
															'stream' => $Interested_Tutor_detail_Data['stream'],
															'tutor_code' => $Interested_Tutor_detail_Data['tutor_code'],
															'tutor_tution_offer_amount_type' => $tutor_tution_offer_amount_type['tutor_tution_offer_amount_type'],
															'final_accepted_amount' => $spramNeo['final_accepted_amount'],
															'tutor_negotiate_amount' => $spramNeo['tutor_negotiate_amount'],
															'tutor_tution_offer_amount' => $tutor_tution_offer_amount_type['tutor_tution_offer_amount'],
															'tutor_tution_fees' => $tutor_tution_offer_amount_type['tutor_tution_fees'],
															'favourite' => $favoutite_type['favourite'],
															'Interested_Tutor'=> $Interested_Tutor_No,
															'history_academy_arr' => $HA,
																										//'history_academy_result' => $HAR,
															'tutoring_detail_arr' => $TD
												
														);
									
									}		
									
										
											//}				
														
										}
												
												
									if(!empty($interested_Tutor_arra))
									{										
												
										$tutor_arr[] = array(
																 
																 'Interested_Tutor_Details' => $interested_Tutor_arra
																 
															);
														
														
									}					
											
									
									
									
									
									while($tutor_details_by_interestedTutor = mysqli_fetch_array($Interested_Tutor))
									{
										$tutor_login_id = $tutor_details_by_interestedTutor['tutor_login_id'];
										
										
										//////////
										
										////  For complete_user_profile_history_academy
								
											$HA = array();
											$tutor_arr2 = array();
											
											
										
											$userHA = $conn->query("SELECT * FROM complete_user_profile_history_academy WHERE user_id = '".$tutor_login_id."' ");
											
											while($user_list_HA = mysqli_fetch_assoc($userHA))
											{
												$HAR = array();
												////  For complete_user_profile_history_academy Results start
												
													$rest = $conn->query("SELECT * FROM complete_user_profile_history_academy_result WHERE user_id = '".$tutor_login_id."' and record_id = '".$user_list_HA['record_id']."'  ");
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
										
										////////////
										
								////////////  For complete_user_profile_tutoring_detail
									
									$TD = array();
									
									$userTD = $conn->query("SELECT * FROM complete_user_profile_tutoring_detail WHERE user_id = '".$tutor_login_id."' ");
									
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
										
										
										
										
											
										
										
									}
									
									
									
									
									
									
									
									
									
									
								
								
								/**
								$tutor_arr[] = array(
													'Interested_Tutor'=> $Interested_Tutor_No,
													'post_apply_id' => $tutor_profile['post_apply_id'],
													'student_post_requirements_id' => $tutor_profile['student_post_requirements_id'],
													'apply_tag' => $Apply_Tag['apply_tag'],
													'tutor_login_id' => $tutor_profile['tutor_login_id'],
													'applied_date' => $tutor_profile['applied_date'],
													'applied_time' => $tutor_profile['applied_time'],
													'student_response' => $tutor_profile['student_response'],
													'student_loggedIn_id' => $tutor_profile['student_loggedIn_id'],
													
													'user_id' => $tutor_profile['user_id'],
													'adminusername' => $tutor_profile['adminusername'],
													'first_name' => $tutor_profile['first_name'],
													'last_name' => $tutor_profile['last_name'],
													'email' => $tutor_profile['email'],
													
													'profile_image' => $Tutor_profile_img['profile_image'],
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
													
												**/	
													
													
													
													
													
								
								/**
								}
								else{
									$tutor_arr[] = "";
								}
								**/
								
						}
								
								
													
					  }
				}
				
					
					
					
					
					
					////  For tbl_Student_Level_Grade_Subjects_Post_Requirement grade
									
									$student_grade = array();
									$student_Level = array();
									
									
									$student_gradeSql = $conn->query("SELECT * FROM tbl_Student_Level_Grade_Subjects_Post_Requirement WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
									
									while($student_gradeList = mysqli_fetch_assoc($student_gradeSql))
									{
										$streams_array = array();
										
										$streams_sql = $conn->query("SELECT * FROM student_post_requirements_streams WHERE student_post_requirements_id = '".$student_gradeList['student_post_requirements_id']."' ");
										
										while($streams_Data = mysqli_fetch_array($streams_sql))
										{
											$streams_array[] = array(
																	'student_post_requirements_stream_id' =>  $streams_Data['student_post_requirements_stream_id'],
																	'student_post_requirements_streams' =>  $streams_Data['student_post_requirements_streams'],
																	'student_post_requirements_id' =>  $streams_Data['student_post_requirements_id']
																	);
										}
										
										
										
										$student_grade[] = array('Level_Grdade_Subjects_Post_Requirement_id ' => $student_gradeList['Level_Grade_Subjects_Post_Requirement_id'],
														'Grade' => $student_gradeList['Grade'],
														'student_post_requirements_id' => $student_gradeList['student_post_requirements_id']
														
										
										);
										
										
										$student_Level[] = array('Level_Grade_Subjects_Post_Requirement_id ' => $student_gradeList['Level_Grade_Subjects_Post_Requirement_id'],
														'Level' => $student_gradeList['Level'],
														'Admission_Level' => $student_gradeList['Admission_Level'],
														'student_post_requirements_id' => $student_gradeList['student_post_requirements_id'],
														'streams_array' => $streams_array
														
										
										);
										
									}
									
					
					///////////
					
					$Favourite_type_Interested_Tutor = $conn->query("SELECT * FROM student_post_requirements_Favourite_Assigned WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' and favourite = 'true' ");           
		
					$NO_of_Favourite_type_Interested_Tutor = mysqli_num_rows($Favourite_type_Interested_Tutor);
					
                  
                 
                  
                  
					//$sql_applicant = $conn->query("SELECT count(student_post_requirement_id) FROM student_post_requirement_amount_negotiate WHERE student_post_requirement_id = '".$tutor_result['student_post_requirements_id']."' ");
					
					//$applicant_data = mysqli_fetch_array($sql_applicant);
					
					//$NO_of_applicant = $applicant_data['count(student_post_requirement_id)'];
					///////////
					
					
					
					///////////
					
					
					
					///////////
					
					
					
					
					$Response[] = array(
										'student_post_requirements_id' => $tutor_result['student_post_requirements_id'],
										'student_id' => $tutor_result['logged_in_user_id'],
										'No_of_Students' => $tutor_result['No_of_Students'],
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
										'total_days_for_expire_post' => $Total_days_for_expired_post,
										'post_expire_status' => $post_expire_status,
										'post_delist_status' => $tutor_result['post_delist_status'],
										'applicant' => $NO_of_Favourite_type_Interested_Tutor,
										'student_negotiate_amount' => $student_negotiate_amount,
										'tutor_negotiate_amount' => $tutor_negotiate_amount,
										'final_accepted_amount' => $final_accepted_amount,
                                        'amount_negotiate_tutor_ID' => $amount_negotiate_tutor_ID,
										
										
                                        'amount_negotiate_tutor_ID' => $amount_negotiate_tutor_ID,
										'tutor_booking_status' => $tutor_result['tutor_booking_status'],
										'offer_status' => $tutor_result['offer_status'],
										'student_level' => $student_Level,
										'student_grade' => $student_grade,
										'student_level_grade_subjects' => $post_requirements_student_subjects,
										'tutor_qualification' => $Tutor_Qualification,
										'tutor_schedule_and_slot_times' => $Tutor_Schedule,
										'tutor_details' => $tutor_arr
									 	
									 );
									 
									 
									 
				//	}
				//	else			
				//	{
				//		$resultData = array('status' => false, 'message' => 'All post expired.');
				//	}				 
					
					
				}	
				
				if(!empty($Response))
				{
					$resultData = array('status' => true, 'output' => $Response);
				}
				else			
				{
					$resultData = array('status' => false, 'message' => 'No Record Found.', 'output' => []);
				}				
				
				
			}
			else 
			{
				//$message1="Email Id Or Mobile Number not valid !";
				$resultData = array('status' => false, 'message' => 'No Post Requirement Record Found.', 'output' => []);
			}
				

		}
		else{
			
			$resultData = array('status' => false, 'message' => 'Student id can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>