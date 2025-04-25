<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
		if($_GET['tutor_id'] !="" && $_GET['tutor_booking_process_id'] != "" )
		{
	
	
			$query = "SELECT * FROM tutor_booking_process where tutor_id = '".$_GET['tutor_id']."' and tutor_booking_process_id = '".$_GET['tutor_booking_process_id']."' order by readUnreadTag ASC ";
					
				
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
					
					
					/// for Student Level, Grade and Subjects List
					$ss_query2 = $conn->query("select * from tutor_booking_process_Level_Grade_Subjects where tutor_booking_process_id = '".$tutor_result['tutor_booking_process_id']."' ");
					
					while($student_subject_res = mysqli_fetch_array($ss_query2))
					{
						if($student_subject_res['Level'] != "" && $student_subject_res['ALL_Subjects'] != "")
						{
							
							if($student_subject_res['Level'] == "Secondary" )
							{
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
									$streams_sql = $conn->query("SELECT * FROM student_post_requirements_streams WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
											
										while($streams_Data = mysqli_fetch_array($streams_sql))
										{
											
											
											$Stream_Data_array[] = $streams_Data['student_post_requirements_streams'];
										}
								}
							
							}
							else{
								$Stream_Data_array = "";
							}
							
							
							$post_requirements_student_subjects[] = array(
																			 'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
																			  'ID' => $student_subject_res['ID'],
																			  'Level' => $student_subject_res['Level'],
																			  'Grade' => $student_subject_res['Grade'],
																			  'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
																			  'tutor_booking_process_id' => $student_subject_res['tutor_booking_process_id'],
																			  'streams' => $Stream_Data_array
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
					
					
					
					
					
					// For Student Main Details
					$Tutor_Main_Details = mysqli_fetch_assoc($conn->query("select * from user_info where user_id = '".$tutor_result['tutor_id']."' "));
					
					
					
					$Response[] = array(
										'student_id' => $tutor_result['student_id'],
										'student_level' => $tutor_result['student_level'],
										'No_of_Students' => $tutor_result['No_of_Students'],
										'Cancelled_By' => $tutor_result['Cancelled_By'],
										'student_grade' => $tutor_result['student_grade'],
										'student_tution_type' => $tutor_result['student_tution_type'],
										'tutor_id' => $tutor_result['tutor_id'],
										'readUnreadTag' => $tutor_result['readUnreadTag'],
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
										'tutor_booking_status' => $tutor_result['tutor_booking_status'],
										'offer_status' => $tutor_result['offer_status'],
										'student_offer_date' => $tutor_result['student_offer_date'],
										'student_offer_time' => $tutor_result['student_offer_time'],
										'tutor_offer_date' => $tutor_result['tutor_offer_date'],
										'tutor_offer_time' => $tutor_result['tutor_offer_time'],
										'tutor_accept_date_time_status' => $tutor_result['tutor_accept_date_time_status'],
										'student_date_time_offer_confirmation' => $tutor_result['student_date_time_offer_confirmation'],
										'first_name' => $Tutor_Main_Details['first_name'],
										'last_name' => $Tutor_Main_Details['last_name'],
										'email' => $Tutor_Main_Details['email'],
										'mobile' => $Tutor_Main_Details['mobile'],
										'user_type' => $Tutor_Main_Details['user_type'],
										'student_level_grade_subjects' => $post_requirements_student_subjects,
										'tutor_qualification' => $Tutor_Qualification,
										'tutor_schedule_and_slot_times' => $Tutor_Schedule
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
			
			$resultData = array('status' => false, 'message' => 'Tutor id and Tutor booking process id can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>