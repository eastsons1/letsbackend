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
	
	
			 $query = "SELECT * FROM tutor_booking_process where student_id = '".$_GET['student_id']."' order by tutor_booking_process_id desc ";
					
				
			$result = $conn->query($query) or die ("table not found");
			
			$numrows = mysqli_num_rows($result);
			
			
			if($numrows > 0)
			{
				$Response = array();
				
				while($tutor_result = mysqli_fetch_assoc($result))
				{
					$tutor_booking_process_StudentSubjects = array();
					$Tutor_Qualification  = array();
					$Tutor_Schedule   = array();
					$Tutor_slot_time = array();
					$Stream_Data_array = array();
					
					
					
					if($tutor_result['booking_from']=="Search")
					{
						
						$stream_sql = $conn->query("select * from tutor_booking_process_streams where tutor_booking_process_id = '".$tutor_result['tutor_booking_process_id']."' ");
						
						while($Stream_Data = mysqli_fetch_array($stream_sql))
						{
							if($Stream_Data['streams'] != "")
							{
								$Stream_Data_array[] = $Stream_Data['streams'];
							}
						}
					
					}
					
					
					
					
					
					
					if($tutor_result['booking_from']=="Firm" || $tutor_result['booking_from']=="Negotiate")
					{
						//echo "SELECT * FROM student_post_requirements_streams WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ";
						
						$streams_sql = $conn->query("SELECT * FROM student_post_requirements_streams WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
								
							while($streams_Data22 = mysqli_fetch_array($streams_sql))
							{
								
								
								if($streams_Data22['student_post_requirements_streams'] != "")
								{
								
									$Stream_Data_array[] = $streams_Data22['student_post_requirements_streams'];
								}
							}
					}
					
					
					//echo "select * from tutor_booking_process_Level_Grade_Subjects where tutor_booking_process_id = '".$tutor_result['tutor_booking_process_id']."' ";
					
					/// for Student Level, Grade and Subjects List
					$ss_query2 = $conn->query("select * from tutor_booking_process_Level_Grade_Subjects where tutor_booking_process_id = '".$tutor_result['tutor_booking_process_id']."' ");
					
					$post_requirements_student_subjects = array();
					while($student_subject_res = mysqli_fetch_array($ss_query2))
					{
						
						//if($tutor_result['tutor_booking_process_id'] == $student_subject_res['tutor_booking_process_id'])
						///{
						
						
						//echo $student_subject_res['tutor_booking_process_id'];
						
							if($student_subject_res['Level'] != "Secondary" && $student_subject_res['ALL_Subjects'] != "")
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
							
							if($student_subject_res['Level'] == "Secondary" && $student_subject_res['ALL_Subjects'] != "")
							{
								$post_requirements_student_subjects[] = array(
																				 'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
																				  'ID' => $student_subject_res['ID'],
																				  'Level' => $student_subject_res['Level'],
																				  'Admission_Level' => $student_subject_res['Admission_Level'],
																				  'Grade' => $student_subject_res['Grade'],
																				  'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
																				  'tutor_booking_process_id' => $student_subject_res['tutor_booking_process_id'],
																				  'streams' => $Stream_Data_array
																				 );
							}
							
						//}	
						
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
					$tutor_profile_data = mysqli_fetch_array($conn->query("SELECT * FROM user_tutor_info as Tprof INNER JOIN tutor_booking_process as TBookp ON Tprof.user_id = TBookp.tutor_id WHERE TBookp.student_id = '".$tutor_result['student_id']."' "));
					
					$tutor_image = mysqli_fetch_array($conn->query("SELECT profile_image FROM user_tutor_info where user_id = '".$tutor_result['tutor_id']."' "));
					
					
					$tutor_ProfileDataList =  mysqli_fetch_array($conn->query("SELECT * FROM user_tutor_info WHERE user_id = '".$tutor_result['tutor_id']."' "));
					
					//////////
					
					
					$tutor_detailsData = mysqli_fetch_array($conn->query("select first_name,last_name,email,mobile from user_info where user_id = '".$tutor_result['tutor_id']."' "));
					
					$first_name = $tutor_detailsData['first_name'];
					$last_name = $tutor_detailsData['last_name'];
					$email = $tutor_detailsData['email'];
					$mobile = $tutor_detailsData['mobile'];
					
					
					
					///// Rating
					 //echo $tutor_result['tutor_id'];
					  $rating_val = mysqli_fetch_array($conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$tutor_result['tutor_id']."' "));
						
						if($rating_val['rating_no'] == null || $rating_val['rating_no'] =="")		
						{
							$rating_val_f = 0;
						}
						else{
							$rating_val_f = $rating_val['rating_no'];
						}
					
					
					
					//// Average Rating of student_date_time_offer_confirmation
					
							$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$tutor_result['tutor_id']."' ");
							
							
							if(mysqli_num_rows($avg_rating_sql)>0)
							{
							
								$nn = 0;
								$sn = 0;
								while($avg_rating = mysqli_fetch_array($avg_rating_sql))
								{
									$sn = $sn+1;
									$nn = $nn+$avg_rating['rating_no'];
									 $rating_val_f2 = $avg_rating['rating_no'];
								}
								
								
								if($nn !=0 && $sn !=0)
								{
									
									 $avg_rating_val = round($nn/$sn); 
								}
								else
								{
									 $avg_rating_val = 'No rating.';
								}

							}
							else{
								$avg_rating_val = 'No rating.';
							}
							
							
							
					
					
					$Response[] = array(
                      				'tutor_booking_process_id' => $tutor_result['tutor_booking_process_id'],
									'No_of_Students' => $tutor_result['No_of_Students'],
									'average_rating' => $avg_rating_val,									
									'negotiate_by' => $tutor_result['negotiateby'],
									'Cancelled_By' => $tutor_result['Cancelled_By'],
									'rating_val' => $rating_val_f,
                      				'acceptby' => $tutor_result['acceptby'],
									 'api_hit_date_by_confirmed_user' => $tutor_result['api_hit_date_by_confirmed_user'],
									 'api_hit_time_by_confirmed_user' => $tutor_result['api_hit_time_by_confirmed_user'],
									'date_time_update_by' => $tutor_result['date_time_update_by'],
									'booking_from' => $tutor_result['booking_from'],
									'qualification' => $tutor_ProfileDataList['qualification'],
									'tutor_image' => $tutor_image['profile_image'],
									'tutor_age' => $tutor_ProfileDataList['age'],
									'tutor_date_of_year' => $tutor_ProfileDataList['date_of_year'],
									'tutor_gender' => $tutor_ProfileDataList['gender'],
									'tutor_nationality' => $tutor_ProfileDataList['nationality'],
									'tutor_flag' => $tutor_ProfileDataList['flag'],
									'tutor_name_of_school' => $tutor_ProfileDataList['name_of_school'],
									'tutor_course_exam' => $tutor_ProfileDataList['Course_Exam'],
									'tutor_other_course_exam' => $tutor_ProfileDataList['OtherCourse_Exam'],
									'tutor_graduation_year' => $tutor_ProfileDataList['gra_year'],
									'tutor_status' => $tutor_ProfileDataList['tutor_status'],
									'tutor_tuition_type' => $tutor_ProfileDataList['tuition_type'],
									'tutor_location' => $tutor_ProfileDataList['location'],
									'tutor_postal_code' => $tutor_ProfileDataList['postal_code'],
									'tutor_travel_distance'	=> $tutor_ProfileDataList['travel_distance'],
									'tutor_tutoring_experience_years' => $tutor_ProfileDataList['tutor_tutoring_experience_years'],
									'tutor_tutoring_experience_months' => $tutor_ProfileDataList['tutor_tutoring_experience_months'],
									'tutor_personal_statement' => $tutor_ProfileDataList['personal_statement'],
									'tutor_lettitude' => $tutor_ProfileDataList['lettitude'],
									'tutor_longitude' => $tutor_ProfileDataList['longitude'],
									'tutor_stream' => $tutor_ProfileDataList['stream'],
									'tutor_code' => $tutor_ProfileDataList['tutor_code'],
                      
									 
									 'negotiateby' => $tutor_result['negotiateby'],
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
									 'tutor_first_name' => $first_name,
									 'tutor_last_name' => $last_name,
									 'tutor_email' => $email,
									 'tutor_mobile' => $mobile,
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
				$resultData = array('status' => false, 'message' => 'No Booking Record Found.');
			}
				

		}
		else{
			
			$resultData = array('status' => false, 'message' => 'Student id can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>