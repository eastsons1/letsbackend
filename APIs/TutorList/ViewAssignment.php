<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
			$tutor_login_id = $_GET['tutor_login_id'];
	
			$query = "SELECT * FROM student_post_requirements order by student_post_requirements_id DESC ";
					
				
			$result = $conn->query($query) or die ("table not found");
			
			$numrows = mysqli_num_rows($result);
			
			
			if($numrows > 0)
			{
				$Response = array();
				
				while($tutor_result = mysqli_fetch_assoc($result))
				{
					
					$applied_sql = mysqli_fetch_array($conn->query("SELECT apply_tag FROM student_post_requirements_Applied_by_tutor WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' and tutor_login_id = '".$tutor_login_id."'  "));
					
					if($applied_sql['apply_tag'] != 'true')
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
					
					
					//echo $_GET['tutor_login_id'];
					//echo $tutor_result['student_post_requirements_id'];
					
					if($_GET['tutor_login_id'] !="")
					{
						$favS = $conn->query("SELECT * from student_post_requirements_Favourite_Assigned  WHERE tutor_login_id = '".$_GET['tutor_login_id']."' and student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
						
						if(mysqli_num_rows($favS)>0)
						{
						
						$check = mysqli_fetch_array($favS);
						
							if($check['favourite']=="" )
							{
								$Favourite = 'false';
								$tutor_id = "";
							}
							else
							{
								if($check['favourite']=="false")
								{
									$Favourite = 'false';
									$tutor_id = $check['tutor_login_id'];
								}
								else
								{
									$Favourite = 'true';
									$tutor_id = $check['tutor_login_id'];
								}
							}	
						
					}
					else
					{
						$Favourite = 'false';
					}						
						
					}
					else{
							$Favourite = 'false';
							$tutor_id = "";
					}
					
					
					
					
					/////////////
					
					$booked_date = mysqli_fetch_array($conn->query("SELECT * FROM student_post_requirements WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' "));
			
					$str = $booked_date['booked_date'];
					$str = strtotime(date("M d Y ")) - (strtotime($str));
					$total_days_for_expire_post =  round($str/3600/24);
					
					
					$expiredValue = round(45);
					
					
					if($total_days_for_expire_post !="" && $total_days_for_expire_post > $expiredValue )
					{
						$str = date('d-m-Y');
						$str = strtotime(date("M d Y ")) - (strtotime($str));
						$total_days_for_expire_post =  round($str/3600/24);
						
						$post_updated_date = date('d-m-Y');
						
						$post_expire_status = 'Expired';
						//$query = $conn->query("UPDATE student_post_requirements SET  post_updated_date = '".$post_updated_date."', total_days_for_expire_post = '".$total_days_for_expire_post."', post_expire_status = '".$post_expire_status."', student_tution_type= '".$student_tution_type."', student_postal_code= '".$student_postal_code."', student_postal_address= '".$student_postal_address."', tutor_duration_weeks= '".$tutor_duration_weeks."', tutor_duration_hours= '".$tutor_duration_hours."', tutor_tution_fees= '".$tutor_tution_fees."', tutor_tution_schedule_time= '".$tutor_tution_schedule_time."', tutor_tution_offer_amount_type= '".$tutor_tution_offer_amount_type."', tutor_tution_offer_amount= '".$tutor_tution_offer_amount."', negotiate_by_tutor_amount_type=0,amount_negotiate_by_student = 0, negotiate_by_student_amount_type=0,tutor_booking_status='',offer_status='',student_offer_date='',student_offer_time='',tutor_offer_date='',tutor_offer_time='',student_date_time_offer_confirmation='',tutor_accept_date_time_status='' WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
				
					}
					else					
					{
						$str = date('d-m-Y');
						$str = strtotime(date("M d Y ")) - (strtotime($str));
						$total_days_for_expire_post =  round($str/3600/24);
						
						$post_updated_date = date('d-m-Y');
						
						$post_expire_status = '';
						//$query = $conn->query("UPDATE student_post_requirements SET  booked_date = '".$post_updated_date."' , post_updated_date = '".$post_updated_date."', total_days_for_expire_post = '".$total_days_for_expire_post."', post_expire_status = '".$post_expire_status."', student_tution_type= '".$student_tution_type."', student_postal_code= '".$student_postal_code."', student_postal_address = '".$student_postal_address."', tutor_duration_weeks= '".$tutor_duration_weeks."', tutor_duration_hours = '".$tutor_duration_hours."', tutor_tution_fees= '".$tutor_tution_fees."', tutor_tution_schedule_time= '".$tutor_tution_schedule_time."', tutor_tution_offer_amount_type= '".$tutor_tution_offer_amount_type."', tutor_tution_offer_amount= '".$tutor_tution_offer_amount."', negotiate_by_tutor_amount_type=0,amount_negotiate_by_student = 0, negotiate_by_student_amount_type=0,tutor_booking_status='',offer_status='',student_offer_date='',student_offer_time='',tutor_offer_date='',tutor_offer_time='',student_date_time_offer_confirmation='',tutor_accept_date_time_status='' WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
				
					
					
					
					$No_of_applicant_sql = $conn->query("SELECT student_post_requirements_id FROM student_post_requirements_Applied_by_tutor WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' and apply_tag = 'true' ");
					
					$No_of_applicants = mysqli_num_rows($No_of_applicant_sql);
					
					
					
					/////
					
					$sql_minbid = mysqli_fetch_array($conn->query("SELECT min(tutor_negotiate_amount) FROM student_post_requirement_amount_negotiate as nego INNER JOIN student_post_requirements_Applied_by_tutor as apply ON nego.student_post_requirement_id = apply.student_post_requirements_id WHERE nego.tutor_negotiate_amount <> 0.00 and apply.student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."'  "));
					$min_bid_on_post = $sql_minbid['min(tutor_negotiate_amount)'];
					
					
					
					/////
					
					
					
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
					
					
					 $student_name_sql = mysqli_fetch_array($conn->query("SELECT first_name,last_name FROM user_info WHERE user_id = '".$tutor_result['logged_in_user_id']."' "));
					
						$student_first_name = $student_name_sql['first_name'];
						$student_last_name = $student_name_sql['last_name'];
					
					
					////////
					//$tutorLoginId =  mysqli_fetch_array($conn->query("SELECT apply.tutor_login_id FROM student_post_requirements as assig INNER JOIN student_post_requirements_Applied_by_tutor as apply ON assig.student_post_requirements_id = apply.student_post_requirements_id WHERE assig.student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' "));
					
					
					$query_chk_DList_Sql = $conn->query("SELECT * FROM student_post_requirements where post_delist_status='Delist' and student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
					
					//echo mysqli_num_rows($query_chk_DList_Sql);
					
					if(mysqli_num_rows($query_chk_DList_Sql)<1)
					{
					
						$Response[] = array(
										'student_post_requirements_id' => $tutor_result['student_post_requirements_id'],
										'student_id' => $tutor_result['logged_in_user_id'],
										'No_of_Students' => $tutor_result['No_of_Students'],
										'tutor_login_id' => $_GET['tutor_login_id'],
                          				'student_first_name' => $student_name_sql['first_name'],
										'student_last_name' => $student_name_sql['last_name'],
										'student_level' => $tutor_result['student_level'],
										'student_grade' => $tutor_result['student_grade'],
										'student_tution_type' => $tutor_result['student_tution_type'],
										'student_postal_code' => $tutor_result['student_postal_code'],
										'student_lat' => $tutor_result['student_lat'],
										'student_long' => $tutor_result['student_long'],
										'student_postal_address' => $tutor_result['student_postal_address'],
										'applicant' => $No_of_applicants,
										'min_bid_on_post' => $min_bid_on_post,
										'total_days_left_for_expired_post' => $total_days_expired_post,
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
										'tutor_id' => $tutor_id,
										'Favourite' => $Favourite,
										'student_level_grade_subjects' => $post_requirements_student_subjects,
										'tutor_qualification' => $Tutor_Qualification,
										'tutor_schedule_and_slot_times' => $Tutor_Schedule
									 	
									 );
									 
						}	 
									 
								}
					
					////////////////	 
									 
									 
									 
									 
					
					}	
					
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
				
				$resultData = array('status' => false, 'message' => 'No Post Requirement Record Found.');
			}
				

		
							
			echo json_encode($resultData);
					
			
?>