<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
		if($_GET['student_id'] !="" && $_GET['tutor_booking_process_id'] != "" )
		{
	
	
			$query = "SELECT * FROM tutor_booking_process where student_id = '".$_GET['student_id']."' and tutor_booking_process_id = '".$_GET['tutor_booking_process_id']."' ";
					
				
			$result = $conn->query($query) or die ("table not found");
			$numrows = mysqli_num_rows($result);
			
			
			if($numrows > 0)
			{
				$Response = array();
				
				
				while($student_result = mysqli_fetch_assoc($result))
				{
					$student_booking_subjectsV   = array();
					
					$tutor_booking_process_StudentSubjects = array();
					$tutor_booking_process_qualification = array();
					$tutor_details = array();
					
					$booking_process_TutorSchedule  = array();
					$TutorSlotsTime   = array();
					
					
					/// for Tutor TutorSlotsTime
					$ssTST_query = $conn->query("select * from tutor_booking_process_TutorSlotsTime where tutor_booking_process_id = '".$student_result['tutor_booking_process_id']."' ");
					
					while($tutor_TutorSlotsTime = mysqli_fetch_array($ssTST_query))
					{
						if($tutor_TutorSlotsTime['tutor_slot_time'] != "")
						{
							$TutorSlotsTime[] = array(
																			 'tutor_booking_process_TutorSlot_time_id' => $tutor_TutorSlotsTime['tutor_booking_process_TutorSlot_time_id'],
																			 'tutor_slot_time' => $tutor_TutorSlotsTime['tutor_slot_time'],
																			 'tutor_booking_process_id' => $tutor_TutorSlotsTime['tutor_booking_process_id']
																			 
																			 );
						}
					}
					
					
					/// for Tutor TutorSchedule
					$ssTb_query = $conn->query("select * from tutor_booking_process_TutorSchedule where tutor_booking_process_id = '".$student_result['tutor_booking_process_id']."' ");
					
					while($tutor_TutorSchedule = mysqli_fetch_array($ssTb_query))
					{
						if($tutor_TutorSchedule['tutor_schedule'] != "")
						{
							$booking_process_TutorSchedule[] = array(
																			 'tutor_booking_process_TutorSchedule_id' => $tutor_TutorSchedule['tutor_booking_process_TutorSchedule_id'],
																			 'tutor_schedule' => $tutor_TutorSchedule['tutor_schedule'],
																			 'tutor_booking_process_id' => $tutor_TutorSchedule['tutor_booking_process_id']
																			 
																			 );
						}
					}
					
					/// for Tutor Qualification
					$ss_query = $conn->query("select * from tutor_booking_process_TutorQualification where tutor_booking_process_id = '".$student_result['tutor_booking_process_id']."' ");
					
					while($tutor_qualification_D = mysqli_fetch_array($ss_query))
					{
						if($tutor_qualification_D['Tutor_Qualification'] != "")
						{
							$tutor_booking_process_qualification[] = array(
																			 'tutor_booking_process_TutorQualification_id' => $tutor_qualification_D['tutor_booking_process_TutorQualification_id'],
																			 'Tutor_Qualification' => $tutor_qualification_D['Tutor_Qualification'],
																			 'Tutor_Qualification_id' => $tutor_qualification_D['Tutor_Qualification_id'],
																			 'tutor_booking_process_id' => $tutor_qualification_D['tutor_booking_process_id']
																			 );
						}
					}
					
					
					
					/// for Tutor student_booking_subjects
					$ssTST_queryw = $conn->query("select * from tutor_booking_process_StudentSubjects where tutor_booking_process_id = '".$_GET['tutor_booking_process_id']."' ");
					
					while($student_booking_subjects = mysqli_fetch_array($ssTST_queryw))
					{
						if($student_booking_subjects['Student_Subjects'] != "")
						{
							$student_booking_subjectsV[] = array(
																			 'tutor_booking_process_StudentSubjects_id' => $student_booking_subjects['tutor_booking_process_StudentSubjects_id'],
																			 'Student_Subjects' => $student_booking_subjects['Student_Subjects'],
																			 'Student_Subjects_id' => $student_booking_subjects['Student_Subjects_id'],
																			 'tutor_booking_process_id' => $student_booking_subjects['tutor_booking_process_id']
																			 
																			 );
						}
					}
					
					
					
					
					// For Student Main Details
					$Student_Main_Details = mysqli_fetch_assoc($conn->query("select * from user_info where user_id = '".$_GET['student_id']."' "));
					
										
					$Response[] = array(
									 'student_id' => $student_result['student_id'],
									 'student_level' => $student_result['student_level'],
									 'student_grade' => $student_result['student_grade'],
									 'postal_code' => $student_result['postal_code'],
									 'postal_address' => $student_result['postal_address'],
									 'student_tution_type' => $student_result['student_tution_type'],
									 'amount_negotiate_by_student' => $student_result['amount_negotiate_by_student'],
									 'negotiate_by_student_amount_type' => $student_result['negotiate_by_student_amount_type'],
									 'tutor_booking_status' => $student_result['tutor_booking_status'],
									  'offer_status' => $student_result['offer_status'],
                                      'student_offer_date' => $student_result['student_offer_date'],
                                      'student_offer_time' => $student_result['student_offer_time'],
                                       'tutor_offer_date' => $student_result['tutor_offer_date'],
                                      'tutor_offer_time' => $student_result['tutor_offer_time'],
									  'tutor_accept_date_time_status' => $student_result['tutor_accept_date_time_status'],
                                       'student_date_time_offer_confirmation' => $student_result['student_date_time_offer_confirmation'],
									 'first_name' => $Student_Main_Details['first_name'],
									 'last_name' => $Student_Main_Details['last_name'],
									 'email' => $Student_Main_Details['email'],
									 'mobile' => $Student_Main_Details['mobile'],
									 'user_type' => $Student_Main_Details['user_type'],
									 'tutor_id' => $student_result['tutor_id'],
									 'tutor_duration_weeks' => $student_result['tutor_duration_weeks'],
									 'tutor_duration_hours' => $student_result['tutor_duration_hours'],
									 'tutor_tution_fees' => $student_result['tutor_tution_fees'],
									 'tutor_tution_schedule_time' => $student_result['tutor_tution_schedule_time'],
									 'tutor_tution_offer_amount_type' => $student_result['tutor_tution_offer_amount_type'],
									 'tutor_tution_offer_amount' => $student_result['tutor_tution_offer_amount'],
									 'amount_negotiate_by_tutor' => $student_result['amount_negotiate_by_tutor'],
									 'negotiate_by_tutor_amount_type' => $student_result['negotiate_by_tutor_amount_type'],
									 'student_booking_subjects' => $student_booking_subjectsV,
									  'Tutor_booking_process_qualification' => $tutor_booking_process_qualification,
									 'Booking_process_TutorSchedule' => $booking_process_TutorSchedule,
									 'TutorSlotsTime' => $TutorSlotsTime,
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
			
			$resultData = array('status' => false, 'message' => 'Student id and Tutor booking process id can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>