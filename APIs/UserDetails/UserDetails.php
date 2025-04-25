<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');



		
		
		if($_POST['user_id']!="")
		{
			$check = "SELECT * FROM user_info WHERE user_id = '".$_POST['user_id']."' ";
			$check_res = $conn->query($check);
			$check_res_num = mysqli_num_rows($check_res);
			
		  if($check_res_num == 1)	
		  {
				 
				 $user_list_arr = array();
				$user = $conn->query("SELECT * FROM user_info WHERE user_id = '".$_POST['user_id']."' ");
				while($user_list = mysqli_fetch_assoc($user))
				{
					if($user_list['user_type']=="I am looking for a Tutor")
					{
						$sql = "SELECT * FROM user_student_info  WHERE user_id = '".$_POST['user_id']."' " ;
						
						$user_type = "Student";
					}
					if($user_list['user_type']=="I am an Educator")
					{
						$sql = "SELECT * FROM  user_tutor_info WHERE user_id = '".$_POST['user_id']."' " ;
						
						$user_type = "Tutor";
					}
					
					$user_extra_info = mysqli_fetch_assoc($conn->query($sql));
					
					if(!empty($user_extra_info))
					{
						$user_list_arr[] = array_merge($user_list,$user_extra_info);
					}
					else{
						$user_list_arr[] = $user_list;
					}
					
				}
				
				
				/// get user additional details
				if($user_type=="Tutor")
				{	
					//////////
					
					$query = "SELECT * FROM tutor_booking_process where tutor_id = '".$_POST['user_id']."' ";
					
				
				$result = $conn->query($query) or die ("table not found");
				
			
			
				$Response = array();
				
				while($tutor_result = mysqli_fetch_assoc($result))
				{
					$tutor_booking_process_StudentSubjects = array();
					$post_requirements_student_subjects = array();
					$complete_user_profile_tutoring_detail = array();
					$Tutor_Qualification  = array();
					$Tutor_Schedule   = array();
					$Tutor_slot_time = array();
					
					
					/// for Complete user profile tutoring details
					$query_cuptd = $conn->query("select * from complete_user_profile_tutoring_detail where user_id = '".$_POST['user_id']."' ");
					
					while($user_profile_details = mysqli_fetch_array($query_cuptd))
					{
						if($user_profile_details['TutoringLevel'] != "" && $user_profile_details['Tutoring_Grade'] != "" && $user_profile_details['Tutoring_ALL_Subjects'] != "")
						{
							$complete_user_profile_tutoring_detail[] = array(
																			 'tutoring_detail_id' => $user_profile_details['tutoring_detail_id'],
																			  'TutoringLevel' => $user_profile_details['TutoringLevel'],
																			  'AdmissionLevel' => $user_profile_details['AdmissionLevel'],
																			  'Tutoring_Grade' => $user_profile_details['Tutoring_Grade'],
																			  'Tutoring_ALL_Subjects' => $user_profile_details['Tutoring_ALL_Subjects'],
																			  'Tutoring_Year' => $user_profile_details['Tutoring_Year'],
																			  'Tutoring_Month' => $user_profile_details['Tutoring_Month'],
																			  'user_id' => $user_profile_details['user_id']
																			  
																			 );
						}
					}
					
					
					
					/// for Student Level, Grade and Subjects List
					$ss_query2 = $conn->query("select * from tutor_booking_process_Level_Grade_Subjects where tutor_booking_process_id = '".$tutor_result['tutor_booking_process_id']."' ");
					
					while($student_subject_res = mysqli_fetch_array($ss_query2))
					{
						if($student_subject_res['Level'] != "" && $student_subject_res['Grade'] != "" && $student_subject_res['ALL_Subjects'] != "")
						{
							$post_requirements_student_subjects[] = array(
																			 'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
																			  'ID' => $student_subject_res['ID'],
																			  'Level' => $student_subject_res['Level'],
																			  'Grade' => $student_subject_res['Grade'],
																			  'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
																			  'tutor_booking_process_id' => $student_subject_res['tutor_booking_process_id']
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
					
					
					
					
					
					
					
					$Response[] = array(
										'tutor_booking_process_id' => $tutor_result['tutor_booking_process_id'],
										'tutor_id' => $tutor_result['tutor_id'],
										'student_id' => $tutor_result['student_id'],
										'student_level' => $tutor_result['student_level'],
										'student_grade' => $tutor_result['student_grade'],
										'student_tution_type' => $tutor_result['student_tution_type'],
										'tutor_id' => $tutor_result['tutor_id'],
										'postal_code' => $tutor_result['postal_code'],
										'postal_address' => $tutor_result['postal_address'],
										'tutor_duration_weeks' => $tutor_result['tutor_duration_weeks'],
										'tutor_duration_hours' => $tutor_result['tutor_duration_hours'],
										'tutor_tution_fees' => $tutor_result['tutor_tution_fees'],
										'tutor_tution_schedule_time' => $tutor_result['tutor_tution_schedule_time'],
										'tutor_tution_offer_amount_type' => $tutor_result['tutor_tution_offer_amount_type'],
										'tutor_tution_offer_amount' => $tutor_result['tutor_tution_offer_amount'],
										'amount_negotiate_by_tutor' => $tutor_result['amount_negotiate_by_tutor'],
										'amount_negotiate_by_student' => $tutor_result['amount_negotiate_by_student'],
										'booked_date' => $tutor_result['booked_date'],
										'tutor_booking_status' => $tutor_result['tutor_booking_status'],
										'offer_status' => $tutor_result['offer_status'],
										'student_offer_date' => $tutor_result['student_offer_date'],
										'student_offer_time' => $tutor_result['student_offer_time'],
										'tutor_offer_date' => $tutor_result['tutor_offer_date'],
										'tutor_offer_time' => $tutor_result['tutor_offer_time'],
										'tutor_accept_date_time_status' => $tutor_result['tutor_accept_date_time_status'],
										'student_date_time_offer_confirmation' => $tutor_result['student_date_time_offer_confirmation'],
										'student_level_grade_subjects' => $post_requirements_student_subjects,
										'tutor_qualification' => $Tutor_Qualification,
										'tutor_schedule_and_slot_times' => $Tutor_Schedule,
										'complete_user_profile_tutoring_detail' => $complete_user_profile_tutoring_detail
									 
									 );
					
					
				}	
				
							
				
				
			
					
					//////////
					
					
					
					
				}
				
				
				$user_list_arrF = array_merge($user_list_arr,$Response);
				
				
				
				if(!empty($user_list_arrF))
				{
					$resultData = array('status' => true, 'Single_User_details' => $user_list_arrF);
				}
				else{
					$resultData = array('status' => false, 'message' => 'No Records Found.');
				}
				
			
		  }
		  else{
			
			 $resultData = array('status' => false, 'message' => 'User id not exists.');
							
		  }
		}
		else
		{
			  $resultData = array('status' => false, 'message' => 'User id can not blank.');		
		}			
		

					
			echo json_encode($resultData);
			
?>