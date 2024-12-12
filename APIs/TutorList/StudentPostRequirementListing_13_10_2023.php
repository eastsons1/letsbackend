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
	
	
			$query = "SELECT * FROM student_post_requirements where logged_in_user_id = '".$_GET['student_id']."' ";
					
				
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
					
					
					
					
					
					
					$Response[] = array(
									 'student_post_requirements_id' => $tutor_result['student_post_requirements_id'],
									 'student_id' => $tutor_result['student_id'],
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
				$resultData = array('status' => false, 'message' => 'No Post Requirement Record Found.');
			}
				

		}
		else{
			
			$resultData = array('status' => false, 'message' => 'Student id can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>