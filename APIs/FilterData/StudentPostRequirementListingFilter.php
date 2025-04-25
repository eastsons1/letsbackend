<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	//and tutor_login_id = '".$_GET['tutor_login_id']."'
	
	
		if($_GET['student_post_requirements_id'] !="" )
		{
	
			/// for tutor_details sql
			 $query = "SELECT * FROM student_post_requirements where student_post_requirements_id = '".$_GET['student_post_requirements_id']."'  ";
					
				
			$result = $conn->query($query) or die ("table not found");
			$numrows = mysqli_num_rows($result);
			
			
			if($numrows > 0)
			{
				
				$sql_tDL = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor appT INNER JOIN user_tutor_info tutor ON appT.tutor_login_id = tutor.user_id INNER JOIN user_info info ON tutor.user_id=info.user_id  WHERE appT.student_post_requirements_id  = '".$_GET['student_post_requirements_id']."' and appT.booking_status <> 'booked'   ");
				
				//$sql_tDL = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor appT INNER JOIN user_tutor_info tutor ON appT.tutor_login_id = tutor.user_id INNER JOIN user_info info ON tutor.user_id=info.user_id  WHERE appT.student_post_requirements_id  = '".$_GET['student_post_requirements_id']."' and appT.booking_status <> 'booked' and appT.apply_tag = 'true'  ");
				
				/**
				$sql_tDL = $conn->query($aa="SELECT appT.*, tutor.*, info.*, nego.* 
FROM student_post_requirements_Applied_by_tutor appT
INNER JOIN user_tutor_info tutor 
    ON appT.tutor_login_id = tutor.user_id
INNER JOIN user_info info 
    ON tutor.user_id = info.user_id
INNER JOIN student_post_requirement_amount_negotiate nego
    ON appT.student_post_requirements_id = nego.student_post_requirement_id
WHERE nego.student_post_requirement_id = '".$_GET['student_post_requirements_id']."' 
  AND appT.booking_status <> 'booked' 
  AND appT.apply_tag = 'true'
GROUP BY appT.student_post_requirements_id, tutor.user_id, info.user_id, nego.student_post_requirement_id
ORDER BY nego.add_negotiate_tag DESC");
				
				
				
			echo $aa;	
			
			**/
				
				
				
				if(mysqli_num_rows($sql_tDL) > 0)
				{	
					  									
				
				$Response = array();
				
				while($tutor_result = mysqli_fetch_assoc($result))
				{
					$post_requirements_student_subjects = array();
					$Tutor_Qualification  = array();
					$Tutor_Schedule   = array();
					$Tutor_slot_time = array();
					$student_streams_data_arr = array();
					
					
					/**
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
					
					**/
					
					
					
					
					/// for Student Level, Grade and Subjects List
					$ss_query = $conn->query("select * from tbl_Student_Level_Grade_Subjects_Post_Requirement where student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
					
					while($student_subject_res = mysqli_fetch_array($ss_query))
					{
						if($student_subject_res['Level'] != "" && $student_subject_res['Grade'] != "" && $student_subject_res['ALL_Subjects'] != "")
						{
							
							if($student_subject_res['Level']=="Secondary")
							{
								$streams_sql = $conn->query("SELECT * FROM student_post_requirements_streams WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
							
							
								
								$streams_Data_array = array();
								
								while($streams_Data = mysqli_fetch_array($streams_sql))
								{
									$streams_Data_array[] =  $streams_Data['student_post_requirements_streams'];
								}
								
								$post_requirements_student_subjects[] = array(
																		 'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
																		  'ID' => $student_subject_res['ID'],
																		  'Level' => $student_subject_res['Level'],
																		  'Admission_Level' => $student_subject_res['Admission_Level'],
																		  'Grade' => $student_subject_res['Grade'],
																		  'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
																		  'student_post_requirements_id' => $student_subject_res['student_post_requirements_id'],
																		  'Streams' => $streams_Data_array
																		 );
								
								
							}
							else{
							
							
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
				
				//echo $Total_no_of_Tutor_Applied_status;
					
					
					
					while($tutor_profile = mysqli_fetch_array($tutor_data))
					{	

						if($tutor_result['student_post_requirements_id']==$tutor_profile['student_post_requirements_id'])	
						{
							
						
								
									
									
						
								
								if($Total_no_of_Tutor_Applied_status != 0 )						
								{ 
									
									$sql_update_amount = $conn->query("SELECT * FROM student_post_requirement_amount_negotiate WHERE student_post_requirement_id = '".$tutor_profile['student_post_requirements_id']."'  ");

									$sql_update_amount_data = mysqli_fetch_array($sql_update_amount);

									$amount_negotiate_tutor_ID = $sql_update_amount_data['tutor_login_id'];
		
									$student_negotiate_amount = $sql_update_amount_data['student_negotiate_amount'];
									$tutor_negotiate_amount = $sql_update_amount_data['tutor_negotiate_amount'];
									$final_accepted_amount = $sql_update_amount_data['final_accepted_amount'];
									$final_accepted_status = $sql_update_amount_data['status'];
								
								
								
								}
								
								
								
													
					   }
					   
					   
					   
					   
					   
					  //////////////////
					
				//echo $_GET['student_post_requirements_id'].'===';	


				/// Rest of interested tutor
					//$RestOfInterested_Tutor = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor as apply INNER JOIN tutor_booking_process as booking ON apply.tutor_login_id <> booking.tutor_id  ");
				
					//$RestOfInterested_Tutor = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor WHERE student_post_requirements_id = '".$_GET['student_post_requirements_id']."' and apply_tag = 'true' and booking_status <> 'booked'  ");
				
				$RestOfInterested_Tutor = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor WHERE student_post_requirements_id = '".$_GET['student_post_requirements_id']."' and booking_status <> 'booked'  ");
				
					$RestOfInterested_Tutor_No = mysqli_num_rows($RestOfInterested_Tutor);
					
					$RestOfInterested_TutorID = mysqli_fetch_array($RestOfInterested_Tutor);
					
					//echo $RestOfInterested_TutorID['tutor_login_id'];
				
					  
					
					  
					 			
										
										$tutor_login_id = mysqli_fetch_array($conn->query("select tutor_login_id from student_post_requirements_Applied_by_tutor where student_post_requirements_id = '".$_GET['student_post_requirements_id']."' "));
										
										
										
										while($Interested_Tutor_detail_Data = mysqli_fetch_array($sql_tDL))
										{
									
										
									
										if($Interested_Tutor_detail_Data['student_post_requirements_id'] !="" && $Interested_Tutor_detail_Data['student_post_requirements_id'] != NULL)
										{
										
										$Apply_Tag_sql = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor WHERE student_post_requirements_id = '".$_GET['student_post_requirements_id']."' and tutor_login_id = '".$Interested_Tutor_detail_Data['tutor_login_id']."' ");

										$Apply_Tag = mysqli_fetch_array($Apply_Tag_sql);
										
										
										
										$Tutor_profile_img = mysqli_fetch_array($conn->query("SELECT profile_image FROM user_tutor_info WHERE user_id = '".$Interested_Tutor_detail_Data['tutor_login_id']."' "));


										//////
										
										$student_loggedIn_idVal = mysqli_fetch_array($conn->query("select logged_in_user_id from student_post_requirements where student_post_requirements_id = '".$Interested_Tutor_detail_Data['student_post_requirements_id']."' "));
									
										
									
									$tutor_tution_offer_amount_type = mysqli_fetch_array($conn->query("select tutor_tution_offer_amount_type,tutor_tution_fees,tutor_tution_offer_amount,logged_in_user_id from student_post_requirements where student_post_requirements_id = '".$Interested_Tutor_detail_Data['student_post_requirements_id']."' "));
							
									
								  
								  
								  
								  
								  
								  
								   //// Average Rating of student_date_time_offer_confirmation
					
									$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$Interested_Tutor_detail_Data['tutor_login_id']."' ");
									
									
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
									
								  
								  
								
					
								
									
								  /**
										
										$tutor_arr[] = array(
										
															'post_apply_id' => $Interested_Tutor_detail_Data['post_apply_id'],
															'student_post_requirements_id' => $Interested_Tutor_detail_Data['student_post_requirements_id'],
															'add_negotiate_tag' => $Interested_Tutor_detail_Data['add_negotiate_tag'],
															'apply_tag' => $Apply_Tag['apply_tag'],
															'tutor_login_id' => $Interested_Tutor_detail_Data['tutor_login_id'],
															'flag' => $Interested_Tutor_detail_Data['flag'],
															'Average_rating' => $avg_rating_val,
															'applied_date' => $Interested_Tutor_detail_Data['applied_date'],
															'applied_time' => $Interested_Tutor_detail_Data['applied_time'],
															'student_response' => $Interested_Tutor_detail_Data['student_response'],
															'student_loggedIn_id' => $student_loggedIn_idVal['logged_in_user_id'],
															
															'student_negotiate_amount' => $student_negotiate_amount,
															'tutor_negotiate_amount' => $tutor_negotiate_amount,
															'final_accepted_amount' => $final_accepted_amount,
                                          					'final_accepted_status' => $final_accepted_status,
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
															'student_loggedIn_id' => $tutor_tution_offer_amount_type['logged_in_user_id'],
															'tutor_tution_offer_amount_type' => $tutor_tution_offer_amount_type['tutor_tution_offer_amount_type'],
															'tutor_tution_offer_amount' => $tutor_tution_offer_amount_type['tutor_tution_offer_amount'],
															'tutor_tution_fees' => $tutor_tution_offer_amount_type['tutor_tution_fees'],
															'favourite' => $favourite['favourite'],
															'history_academy_arr' => $HA,
																										//'history_academy_result' => $HAR,
															'tutoring_detail_arr' => $TD
												
														);
														
													
											**/

											
														
														
														
														
									
										
									
										/**		
									$tutor_arr[] = array(
															 'Interested_Tutor'=> $Interested_Tutor_No,
															 'Interested_Tutor_Details' => $interested_Tutor_arra
															 
														);
														
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
							else{
							
							
							
							$student_post_data_array[] = array(
																'Level_Grade_Subjects_Post_Requirement_id' => $student_post_data['Level_Grade_Subjects_Post_Requirement_id'],
																'ID' => $student_post_data['ID'],
																'Level' => $student_post_data['Level'],
																'Admission_Level' => $student_post_data['Admission_Level'],
																'Grade' => $student_post_data['Grade'],
																'ALL_Subjects' => $student_post_data['ALL_Subjects'],
																'student_post_requirements_id' => $student_post_data['student_post_requirements_id']
																
							
															  );
															  
							}								  
						}
					}
					
					
					///////////////////////////
                  
				  
				  $tutor_data = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor appT INNER JOIN user_tutor_info tutor ON appT.tutor_login_id = tutor.user_id INNER JOIN user_info info ON tutor.user_id=info.user_id  WHERE appT.student_post_requirements_id  = '".$tutor_result['student_post_requirements_id']."' ");

				  $No_applicant = mysqli_num_rows($tutor_data);
                  
				  //$sql_applicant = $conn->query("SELECT count(student_post_requirement_id) FROM student_post_requirement_amount_negotiate WHERE student_post_requirement_id = '".$tutor_result['student_post_requirements_id']."' ");
				  
				 // $sql_applicant_data = mysqli_fetch_array($sql_applicant);
                  
                  //$No_applicant = $sql_applicant_data['count(student_post_requirement_id)'];
                  
				  
				  ///////
				  
				  
				  $sql_minbid = mysqli_fetch_array($conn->query("SELECT min(tutor_negotiate_amount) FROM student_post_requirement_amount_negotiate as nego INNER JOIN student_post_requirements_Applied_by_tutor as apply ON nego.tutor_login_id = apply.tutor_login_id WHERE nego.tutor_negotiate_amount <> 0.00  "));
					
					
					
					$Min_bid_amount = $sql_minbid['min(tutor_negotiate_amount)'];
				  
				  
				  
				  /////////////  INTERESTED TUTOR
				  
				 /**
								$rec = $conn->query("SELECT * 
										FROM student_post_requirement_amount_negotiate
										WHERE student_post_requirement_id = '".$tutor_result['student_post_requirements_id']."' 
										 ORDER BY add_negotiate_tag ASC");
					**/
					
					
					
					
					
					
										 
							 $rec_chk = $conn->query("SELECT * 
														FROM student_post_requirement_amount_negotiate
														WHERE student_post_requirement_id = '".$tutor_result['student_post_requirements_id']."' 
														ORDER BY 
															CASE WHEN IPT = 'New' THEN 1 ELSE 2 END;
														");
														
													
														
							if($RestOfInterested_Tutor_No > 0 && mysqli_num_rows($rec_chk) > 0)
							{
								$rec = $conn->query("SELECT * 
														FROM student_post_requirement_amount_negotiate
														WHERE student_post_requirement_id = '".$tutor_result['student_post_requirements_id']."' 
														ORDER BY 
															CASE WHEN IPT = 'New' THEN 1 ELSE 2 END;
														");
							}
							if($RestOfInterested_Tutor_No > 0 && mysqli_num_rows($rec_chk) == 0)
							{
								
								$rec = $conn->query("SELECT * 
														FROM student_post_requirements as spr INNER JOIN student_post_requirements_Applied_by_tutor as spabt ON spr.student_post_requirements_id = spabt.student_post_requirements_id
														WHERE spr.student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' 
														
														");
							}

										
														


										
								$tutor_arr = array();
								
								while($Interested_Tutor_detail_DataD = mysqli_fetch_array($rec))
								{
									//echo $Interested_Tutor_detail_DataD['add_negotiate_tag'];	
									
									
									//echo $Interested_Tutor_detail_DataD['tutor_login_id'].'=='.$applyed['tutor_login_id'];
									
									if($Interested_Tutor_detail_DataD['student_post_requirement_id'] != "")
									{
										$student_post_requirement_idV = $Interested_Tutor_detail_DataD['student_post_requirement_id'];
										
										$applyed = mysqli_fetch_array($conn->query("SELECT * 
										FROM student_post_requirements_Applied_by_tutor
										WHERE student_post_requirements_id = '".$Interested_Tutor_detail_DataD['student_post_requirement_id']."' and tutor_login_id = '".$Interested_Tutor_detail_DataD['tutor_login_id']."' and booking_status <> 'booked' "));
									
									}
									if($Interested_Tutor_detail_DataD['student_post_requirements_id'] != "")
									{
										$student_post_requirement_idV = $Interested_Tutor_detail_DataD['student_post_requirements_id'];
										
										$applyed = mysqli_fetch_array($conn->query("SELECT * 
										FROM student_post_requirements_Applied_by_tutor
										WHERE student_post_requirements_id = '".$student_post_requirement_idV."' and tutor_login_id = '".$Interested_Tutor_detail_DataD['tutor_login_id']."' "));
									
										
									}
									
									
									if($applyed['tutor_login_id'] != "")
									{
										$tutor_login_idV = $applyed['tutor_login_id'];
									}
									if($Interested_Tutor_detail_DataD['tutor_login_id'] != "")
									{
										$tutor_login_idV = $Interested_Tutor_detail_DataD['tutor_login_id'];
									}
									
									
									
									
									
									if($applyed['apply_tag'] == 'false')
									{
										$Post_Type = 'Withdraw';
									}
									if($applyed['apply_tag'] == 'true')
									{
										$Post_Type = '';
									}
									
									
									
									
									$tutor_details = mysqli_fetch_array($conn->query("SELECT * 
										FROM user_tutor_info as tinfo INNER JOIN user_info as info ON tinfo.user_id = info.user_id
										WHERE info.user_id = '".$tutor_login_idV."'  "));
										
									$tutor_image = mysqli_fetch_array($conn->query("SELECT profile_image 
										FROM user_tutor_info WHERE user_id = '".$tutor_login_idV."'  "));	
									//echo $aa;
									
									$student_post_requirements = mysqli_fetch_array($conn->query("SELECT * 
										FROM student_post_requirements
										WHERE student_post_requirements_id = '".$Interested_Tutor_detail_DataD['student_post_requirement_id']."'  "));
									
									if($student_post_requirements['tutor_tution_offer_amount'] != "")
									{
										$tutor_tution_offer_amountV = $student_post_requirements['tutor_tution_offer_amount'];
									}
									if($Interested_Tutor_detail_DataD['tutor_tution_offer_amount'] != "")
									{
										$tutor_tution_offer_amountV = $Interested_Tutor_detail_DataD['tutor_tution_offer_amount'];
									}
									
									if($student_post_requirements['tutor_tution_fees'] != "")
									{
										$tutor_tution_feesV = $student_post_requirements['tutor_tution_fees'];
									}
									if($Interested_Tutor_detail_DataD['tutor_tution_fees'] != "")
									{
										$tutor_tution_feesV = $Interested_Tutor_detail_DataD['tutor_tution_fees'];
									}
									
									if($student_post_requirements['tutor_tution_offer_amount_type'] != "")
									{
										$tutor_tution_offer_amount_typeV = $student_post_requirements['tutor_tution_offer_amount_type'];
									}
									if($Interested_Tutor_detail_DataD['tutor_tution_offer_amount_type'] != "")
									{
										$tutor_tution_offer_amount_typeV = $Interested_Tutor_detail_DataD['tutor_tution_offer_amount_type'];
									}
									
									
									
									
									///////
								  $favourite = mysqli_fetch_array($conn->query("SELECT favAssign.favourite FROM student_post_requirements_Applied_by_tutor as applyT INNER JOIN student_post_requirements_Favourite_Assigned as favAssign ON applyT.tutor_login_id = favAssign.tutor_login_id WHERE favAssign.student_post_requirements_id = '".$student_post_requirement_idV."' and favAssign.tutor_login_id = '".$tutor_login_idV."' and favAssign.student_login_id = '".$student_loggedIn_idVal['logged_in_user_id']."' "));
								  
								  ///////
									
									
																																																																											
								


			///// Tutor profile start
								
				//$tutor_profile = mysqli_fetch_assoc($conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor appT INNER JOIN user_tutor_info tutor ON appT.tutor_login_id = tutor.user_id  WHERE appT.student_post_requirements_id  = '".$tutor_result['student_post_requirements_id']."' "));	
				
				$tutor_data = $conn->query("SELECT * FROM student_post_requirements_Applied_by_tutor appT INNER JOIN user_tutor_info tutor ON appT.tutor_login_id = tutor.user_id INNER JOIN user_info info ON tutor.user_id=info.user_id  WHERE appT.student_post_requirements_id  = '".$student_post_requirement_idV."' ");
				
				 $Total_no_of_Tutor_Applied = mysqli_num_rows($tutor_data);
				
				//echo $Total_no_of_Tutor_Applied;
				
				if($Total_no_of_Tutor_Applied===0)
				{
					$Total_no_of_Tutor_Applied_status=0;
				}
				else{
					$Total_no_of_Tutor_Applied_status=1;
				}
				
				
					
					
					
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
									
					}
					}	
						
								
								//if($Total_no_of_Tutor_Applied_status != 0 )						
								//{

										//echo $Interested_Tutor_detail_DataD['student_post_requirement_id'];	
									
									
									
									
									
									
									$sql_update_amount = $conn->query("SELECT * FROM student_post_requirement_amount_negotiate WHERE student_post_requirement_id = '".$Interested_Tutor_detail_DataD['student_post_requirement_id']."' and student_login_id = '".$student_loggedIn_idVal['logged_in_user_id']."' and tutor_login_id = '".$applyed['tutor_login_id']."' ");


										$sql_update_amount_data = mysqli_fetch_array($sql_update_amount);

										$student_negotiate_amount = $sql_update_amount_data['student_negotiate_amount'];

										$tutor_negotiate_amount = $sql_update_amount_data['tutor_negotiate_amount'];

										$final_accepted_amount = $sql_update_amount_data['final_accepted_amount'];

										$final_accepted_status = $sql_update_amount_data['status'];	

										$amount_negotiate_tutor_ID = $sql_update_amount_data['tutor_login_id'];	
										
									
									
									if($sql_update_amount_data['no_of_tutor_offer_amount']>1)
									{
										$Tutor_New_Offer = "New offer";
									}
									else{
										$Tutor_New_Offer = "";
									}
									
									
									
									if($applyed['post_apply_id'] != null && $applyed['post_apply_id'] != "")
									{	
								
									
									$tutor_arr[] = array(
										
													'post_apply_id' => $applyed['post_apply_id'],
													
													
													'student_post_requirements_id' => $student_post_requirement_idV,
													'add_negotiate_tag' => $Interested_Tutor_detail_DataD['add_negotiate_tag'],
													'IPT' => $Interested_Tutor_detail_DataD['IPT'],
													'Tutor_New_Offer' => $Tutor_New_Offer,
													
													'Post_Type' => $Post_Type,
													'apply_tag' => $applyed['apply_tag'],
													'tutor_login_id' => $tutor_login_idV,
													
													'flag' => $tutor_details['flag'],
													'Average_rating' => $avg_rating_val,
													'applied_date' => $applyed['applied_date'],
													'applied_time' => $applyed['applied_time'],
													'student_response' => $applyed['student_response'],
													'student_loggedIn_id' => $student_loggedIn_idVal['logged_in_user_id'],
													
													'student_negotiate_amount' => $student_negotiate_amount,
													'tutor_negotiate_amount' => $tutor_negotiate_amount,
													'final_accepted_amount' => $final_accepted_amount,
													'final_accepted_status' => $final_accepted_status,
													'amount_negotiate_tutor_ID' => $amount_negotiate_tutor_ID,
													
												
													'user_id' => $tutor_details['user_id'],
													'adminusername' => $tutor_details['adminusername'],
													'first_name' => $tutor_details['first_name'],
													'last_name' => $tutor_details['last_name'],
													'email' => $tutor_details['email'],
													
													'profile_image' => $tutor_image['profile_image'],
													'age' => $tutor_details['age'],
													'gender' => $tutor_details['gender'],
													'nationality' => $tutor_details['nationality'],
													'qualification' => $tutor_details['qualification'],
													'name_of_school' => $tutor_details['name_of_school'],
													'Course_Exam' => $tutor_details['Course_Exam'],
													'gra_year' => $tutor_details['gra_year'],
													'tutor_status' => $tutor_details['tutor_status'],
													'tuition_type' => $tutor_details['tuition_type'],
													'location' => $tutor_details['location'],
													'postal_code' => $tutor_details['postal_code'],
														
													'travel_distance' => $tutor_details['travel_distance'],
													'tutor_tutoring_experience_years' => $tutor_details['tutor_tutoring_experience_years'],
													'tutor_tutoring_experience_months' => $tutor_details['tutor_tutoring_experience_months'],
													'personal_statement' => $tutor_details['personal_statement'],
													'lettitude' => $tutor_details['lettitude'],
													'longitude' => $tutor_details['longitude'],
													'stream' => $tutor_details['stream'],
													'tutor_code' => $tutor_details['tutor_code'],
													'student_loggedIn_id' => $tutor_tution_offer_amount_type['logged_in_user_id'],
													'tutor_tution_offer_amount_type' => $tutor_tution_offer_amount_typeV,
													'tutor_tution_offer_amount' => $tutor_tution_offer_amountV,
													'tutor_tution_fees' => $tutor_tution_feesV,
													'favourite' => $favourite['favourite'],
													'history_academy_arr' => $HA,
																								//'history_academy_result' => $HAR,
													'tutoring_detail_arr' => $TD
													
													
												
												);
												
									}		
														
														
														
										//}			
														
									
									
									
								}
				  
				  ////////////////
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
					$Response[] = array(
										'student_post_requirements_id' => $tutor_result['student_post_requirements_id'],
										'student_id' => $tutor_result['logged_in_user_id'],
										'No_of_Students' => $tutor_result['No_of_Students'],
                      					'Total_days_for_expired_post' => $Total_days_for_expired_post,
										'post_expire_status' => $post_expire_status,
										'post_delist_status' => $tutor_result['post_delist_status'],
										'applicant' => $RestOfInterested_Tutor_No,
										'min_bid_amount' => $Min_bid_amount,
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
										'Total_no_of_Tutor_Applied' => $RestOfInterested_Tutor_No,
										'tutor_details' => $tutor_arr,
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
				$resultData = array('status' => false, 'message' => 'No Result found. Insert right search keyword.');
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