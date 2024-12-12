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
			
			$arrayV = array();  
			$arrayV2 = array();  
			$arrayV3 = array();  
			
		//	print_r($array);
			
			// Extracting row by row
			foreach($array as $row => $value) 
			{
				
				//print_r($row);
			 if($row == 'Levels_search')
			 {
				foreach($value as $row2 => $value2) 
				{
					
					if($value2 != "" )
					{	
						$arrayV2[] = "('".$value2."')";				
					}	
				}
				
			 }
			 
				 if($row == 'student_sujects')
				 {
					foreach($value as $row3 => $value3) 
					{
						//echo $value3;
						if($value3 != "" )
						{	
							$arrayV3[] = "('".$value3."')";				
						}	
					}
					
				 }
				
			}
			
			
			
					
					if(empty($arrayV2) && empty($arrayV3))
					{
						
						$resultData = array('Status' => false, 'Message' => 'Please Select Levels or Subjects.');
						
					}
					else
					{	
				
						if(!empty($arrayV2))
						{
							$Levels_search_array = implode(', ', $arrayV2);
						}
						else{
							//$Levels_search_array = "''";
						}
						
						if(!empty($arrayV3))
						{
							$Subject_search_array = implode(', ', $arrayV3);
						}
						else{
							//$Subject_search_array = "''";
						}
						
						
						
					
						
											
							if( !empty($Levels_search_array) )
							{
								$cond = ' AND tbl_Student_Level_Grade_Subjects_Post_Requirement.Level IN('.$Levels_search_array.') ';
							}
							else{
								$cond = '';
							}
							
							if( !empty($Subject_search_array) )
							{
								$cond2 = ' AND tbl_Student_Subjects_Post_Requirement.ALL_Subjects IN('.$Subject_search_array.') ';
							}
							else{
								$cond2 = '';
							}
												
											
											
	$sql2 = $conn->query("SELECT DISTINCT student_post_requirements.student_post_requirements_id, 
       student_post_requirements.logged_in_user_id,
	   student_post_requirements.student_tution_type,
	   student_post_requirements.student_postal_code,
	   student_post_requirements.student_lat,
	   student_post_requirements.student_long,
	   student_post_requirements.student_postal_address,
	   student_post_requirements.tutor_duration_weeks,
	   student_post_requirements.tutor_duration_hours,
	   student_post_requirements.tutor_tution_fees,
	   student_post_requirements.tutor_tution_schedule_time,
	   student_post_requirements.tutor_tution_offer_amount_type,
	   student_post_requirements.tutor_tution_offer_amount,
	   student_post_requirements.amount_negotiate_by_tutor,
	   student_post_requirements.negotiate_by_tutor_amount_type,
	   student_post_requirements.amount_negotiate_by_student,
	   student_post_requirements.negotiate_by_student_amount_type,
	   student_post_requirements.booked_date,
	   student_post_requirements.post_updated_date,
	   student_post_requirements.total_days_for_expire_post,
	   student_post_requirements.post_expire_status,
	   student_post_requirements.post_delist_status,
	   student_post_requirements.tutor_booking_status,
	   student_post_requirements.offer_status,
	   student_post_requirements.student_offer_date,
	   student_post_requirements.student_offer_time,
	   student_post_requirements.student_date_time_offer_confirmation,
	   student_post_requirements.tutor_accept_date_time_status,
	   student_post_requirements.No_of_Students,
	   student_post_requirements.update_date_time,
	   
	   
       tbl_Student_Level_Grade_Subjects_Post_Requirement.Level FROM student_post_requirements INNER JOIN tbl_Student_Level_Grade_Subjects_Post_Requirement ON student_post_requirements.student_post_requirements_id = tbl_Student_Level_Grade_Subjects_Post_Requirement.student_post_requirements_id INNER JOIN tbl_Student_Subjects_Post_Requirement ON tbl_Student_Level_Grade_Subjects_Post_Requirement.student_post_requirements_id = tbl_Student_Subjects_Post_Requirement.student_post_requirements_id
WHERE 1 ".$cond.$cond2." ");
															
						
					
								
							//echo mysqli_num_rows($sql2);
											
								if(mysqli_num_rows($sql2)>0)
								{
									$requirement_sql = $sql2;
									
									
								
								
										$Output = array();
										$Response = array();
									
										while($tutor_result = mysqli_fetch_assoc($requirement_sql))
										{
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
																									  'Grade' => $student_subject_res['Grade'],
																									  'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
																									  'student_post_requirements_id' => $student_subject_res['student_post_requirements_id']
																									 );
												}
												
												if($student_subject_res['Level'] == "Secondary" && $student_subject_res['ALL_Subjects'] != "")
												{
													$Streams_array = array();
													
													$get_stream_sql = $conn->query("SELECT * FROM student_post_requirements_streams WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
													
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
											
											
											$student_name_sql = mysqli_fetch_array($conn->query("SELECT first_name,last_name FROM user_info WHERE user_id = '".$tutor_result['logged_in_user_id']."' "));
											
											
											
											//////
					
											$expired_post_sql = $conn->query("SELECT * FROM student_post_requirements WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
											
											$total_days_for_expire_post_val = mysqli_fetch_array($expired_post_sql);
											
											 $total_days_for_expire_post = $total_days_for_expire_post_val['total_days_for_expire_post'];
											
											if($total_days_for_expire_post<=1)
											{
												$total_days_expired_post = $total_days_for_expire_post.' day left';
											}
											if($total_days_for_expire_post > 1)
											{
												$total_days_expired_post = $total_days_for_expire_post.' days left';
											}
											/////
											
											
                                          
											$Response[] = array(
																'student_post_requirements_id' => $tutor_result['student_post_requirements_id'],
																'student_id' => $tutor_result['logged_in_user_id'],
                                              					'student_first_name' => $student_name_sql['first_name'],
																'student_last_name' => $student_name_sql['last_name'],
																'student_level' => $tutor_result['student_level'],
																'student_grade' => $tutor_result['student_grade'],
																'student_tution_type' => $tutor_result['student_tution_type'],
																'student_postal_code' => $tutor_result['student_postal_code'],
																'student_postal_address' => $tutor_result['student_postal_address'],
																
																'total_days_left_for_expired_post' => $total_days_expired_post,
																'No_of_Students' => $tutor_result['No_of_Students'],
																
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
																'tutor_booking_status' => $tutor_result['tutor_booking_status'],
																'offer_status' => $tutor_result['offer_status'],
																'student_level_grade_subjects' => $post_requirements_student_subjects,
																'tutor_qualification' => $Tutor_Qualification,
																'tutor_schedule_and_slot_times' => $Tutor_Schedule
																
															 );
											
											
										}	
								
								
									if(!empty($Response))
									{
									
										$resultData = array('Status' => true, 'Filter_Data' => $Response);
									}	
									else
									{
										$resultData = array('Status' => false, 'message' => 'No Result found. Insert right search keyword.');
									}
								
						
						
							}
						else{
							
							$resultData = array('Status' => false, 'message' => 'No Result found.', 'Filter_Data' => []);
							
						}
						
						
				
					}
					
					
					echo json_encode($resultData);
					
					
					
					
					
				
					
?>