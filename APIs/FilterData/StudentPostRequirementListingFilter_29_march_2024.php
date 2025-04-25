<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
		if($_GET['student_post_requirements_id'] !="")
		{
	
	
			$query = "SELECT * FROM student_post_requirements where student_post_requirements_id = '".$_GET['student_post_requirements_id']."' ";
					
				
			$result = $conn->query($query) or die ("table not found");
			$numrows = mysqli_num_rows($result);
			
			
			if($numrows > 0)
			{
				$Response = array();
				
				while($tutor_result = mysqli_fetch_assoc($result))
				{
					$post_requirements_student_subjects = array();
					$Tutor_Qualification  = array();
					$Tutor_Schedule   = array();
					$Tutor_slot_time = array();
					$student_streams_data_arr = array();
					
					
					
					/// for Student Streams
					$student_streams = $conn->query("select * from student_post_requirements_streams where student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
					
					while($student_streams_data = mysqli_fetch_array($student_streams))
					{
						if($student_streams_data['student_post_requirements_streams'] != "" )  
						{
                          
							$student_streams_data_arr[] =  $student_streams_data['student_post_requirements_streams'];  //array(
															//	'student_post_requirements_streams' => $student_streams_data['student_post_requirements_streams']
															  //  );
						}
					}
					
					
					
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
				
				$tutor_data = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor appT INNER JOIN user_tutor_info tutor ON appT.tutor_login_id = tutor.user_id INNER JOIN user_info info ON tutor.user_id=info.user_id  WHERE appT.student_post_requirements_id  = '".$tutor_result['student_post_requirements_id']."' ");
				
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
							
						
								////  For complete_user_profile_history_academy
								
									$HA = array();
									$tutor_arr2 = array();
									
									
									
									
								
									$userHA = $conn->query("SELECT * FROM complete_user_profile_history_academy WHERE user_id = '".$tutor_profile['tutor_login_id']."' ");
									
									while($user_list_HA = mysqli_fetch_assoc($userHA))
									{
										$HAR = array();
										////  For complete_user_profile_history_academy Results start
										
											$rest = $conn->query("SELECT * FROM complete_user_profile_history_academy_result WHERE user_id = '".$tutor_profile['tutor_login_id']."' and record_id = '".$user_list_HA['record_id']."'  ");
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
									
									$userTD = $conn->query("SELECT * FROM complete_user_profile_tutoring_detail WHERE user_id = '".$tutor_profile['tutor_login_id']."' ");
									
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
									
									
						
								
								if($Total_no_of_Tutor_Applied_status != 0 )						
								{ 
									
								
								
									$tutor_arr[] = array(
														'post_apply_id' => $tutor_profile['post_apply_id'],
														'student_post_requirements_id' => $tutor_profile['student_post_requirements_id'],
														'apply_tag' => $tutor_profile['apply_tag'],
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
									
									/**
									}
									else{
										$tutor_arr[] = "";
									}
									**/
								
								}
								
								
													
					   }
					}
				
					
					
                  
					//////// 
								
						$query_post_requiret = mysqli_fetch_array($conn->query("SELECT * FROM student_post_requirements where logged_in_user_id = '".$tutor_result['logged_in_user_id']."' "));
	
						
						$str = $query_post_requiret['booked_date'];
						$str = strtotime(date("M d Y ")) - (strtotime($str));
						$total_days_for_expire_post =  round($str/3600/24);
						
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
						////////////
					
					
              
                  
                  
                  
                  
                  
          
					//////////////////////// 
					
					
					$student_post_data_sql = $conn->query("SELECT * FROM tbl_Student_Level_Grade_Subjects_Post_Requirement WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
					
					$student_post_data_array = array();
					
					while($student_post_data = mysqli_fetch_array($student_post_data_sql))
					{
						if($student_post_data['Level'] != "")
						{
							
							if($student_post_data['Level']=="Secondary")
							{
								$student_post_requirements_streams  = array();
								
								$stream_sql = $conn->query("SELECT * FROM student_post_requirements_streams WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
								
								$stream_List_array = array();
								
								while($stream_List = mysqli_fetch_array($stream_sql))
								{
									
									if($stream_List['student_post_requirements_streams'] != "")
									{
									
										$stream_List_array[] = $stream_List['student_post_requirements_streams'];
									}	
									
									  
								}
								
							}
							
							
							
							$student_post_data_array[] = array(
																'Level_Grade_Subjects_Post_Requirement_id' => $student_post_data['Level_Grade_Subjects_Post_Requirement_id'],
																'ID' => $student_post_data['ID'],
																'Level' => $student_post_data['Level'],
																'Admission_Level' => $student_post_data['Admission_Level'],
																'Grade' => $student_post_data['Grade'],
																'ALL_Subjects' => $student_post_data['ALL_Subjects'],
																'student_post_requirements_id' => $student_post_data['student_post_requirements_id'],
																'Streams' => $stream_List_array
							
															  );
						}
					}
					
					
					///////////////////////////
                  
                  
                  
                  
                  
                  
                  
                  
                  
					
					$Response[] = array(
										'student_post_requirements_id' => $tutor_result['student_post_requirements_id'],
										'student_id' => $tutor_result['logged_in_user_id'],
                      					'Total_days_for_expired_post' => $Total_days_for_expired_post,
										'post_expire_status' => $post_expire_status,
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
										'tutor_qualification' => $Tutor_Qualification,
										'tutor_schedule_and_slot_times' => $Tutor_Schedule,
										'Total_no_of_Tutor_Applied' => $Total_no_of_Tutor_Applied,
										'tutor_details' => $tutor_arr,
                      					'Streams' => $student_streams_data_arr,
                      					'Student_Level_Grade_Subjects' => $student_post_data_array
									 	
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
				$resultData = array('status' => false, 'message' => 'No Post Requirement Record Found.');
			}
				

		}
		else{
			
			$resultData = array('status' => false, 'message' => 'Student post requirement id can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>