<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
		if($_GET['tutor_id'] !="")
		{
	
	
			$query = "SELECT * FROM tutor_booking_process where tutor_id = '".$_GET['tutor_id']."' ";
					
				
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
					$student_details = array();
					
					/// for Student_Subjects
					$ss_query = $conn->query("select * from tutor_booking_process_StudentSubjects where tutor_booking_process_id = '".$tutor_result['tutor_booking_process_id']."' ");
					
					while($student_subject_res = mysqli_fetch_array($ss_query))
					{
						if($student_subject_res['Student_Subjects'] != "")
						{
							$tutor_booking_process_StudentSubjects[] = array(
																			 'tutor_booking_process_StudentSubjects_id' => $student_subject_res['tutor_booking_process_StudentSubjects_id'],
																			 'Student_Subjects' => $student_subject_res['Student_Subjects']
																			 );
						}
					}
					
					
					
					
					/// for Student Name etc.
					$student_details[] = mysqli_fetch_assoc($conn->query("select * from user_student_info where user_id = '".$tutor_result['student_id']."' "));
					
					
					
					
					$Response[] = array(
									 'tutor_booking_process_id' => $tutor_result['tutor_booking_process_id'],
									 'student_id' => $tutor_result['student_id'],
									 'student_booked_level' => $tutor_result['student_level'],
									 'student_booked_grade' => $tutor_result['student_grade'],
									 'student_booked_tution_type' => $tutor_result['student_tution_type'],
									 'tution_offer_amount_type' => $tutor_result['tutor_tution_offer_amount_type'],
									 'tutor_tution_offer_amount' => $tutor_result['tutor_tution_offer_amount'],
									 'student_booked_subjects' => $tutor_booking_process_StudentSubjects,
									 'tutor_booking_status' => $tutor_result['tutor_booking_status'],
                                      'offer_status' => $tutor_result['offer_status'],
                                       'student_offer_date' => $tutor_result['student_offer_date'],
                                      'student_offer_time' => $tutor_result['student_offer_time'],
                                       'tutor_offer_date' => $tutor_result['tutor_offer_date'],
                                      'tutor_offer_time' => $tutor_result['tutor_offer_time'],
									  'tutor_accept_date_time_status' => $tutor_result['tutor_accept_date_time_status'],
                                       'student_date_time_offer_confirmation' => $tutor_result['student_date_time_offer_confirmation'],
									 'student_profile_details' => $student_details
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
			
			$resultData = array('status' => false, 'message' => 'Tutor id can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>