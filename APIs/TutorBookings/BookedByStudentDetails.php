<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
		if($_GET['student_id'] !="" && $_GET['tutor_id'] !="" && $_GET['tutor_tution_schedule_time'] != "" && $_GET['booked_date'] != "" )
		{
	
	
			$query = "SELECT * FROM tutor_booking_process where  student_id  = '".$_GET['student_id']."' and tutor_id = '".$_GET['tutor_id']."' and tutor_tution_schedule_time = '".$_GET['tutor_tution_schedule_time']."' and booked_date = '".$_GET['booked_date']."' ";
					
				
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
					
					
					
					
					/// For Student Profile Details.
					$student_details = mysqli_fetch_assoc($conn->query("select * from user_student_info where user_id = '".$tutor_result['student_id']."' "));
					
					if($student_details['Level']!="")
					{
						$Level = $student_details['Level'];
					}
					else{
						$Level = "";
					}
					if($student_details['Grade']!="")
					{
						$Grade = $student_details['Grade'];
					}
					else{
						$Grade = "";
					}
					if($student_details['Stream']!="")
					{
						$Stream = $student_details['Stream'];
					}
					else{
						$Stream = "";
					}
					if($student_details['passing_year']!="")
					{
						$passing_year = $student_details['passing_year'];
					}
					else{
						$passing_year = "";
					}
					if($student_details['Subject']!="")
					{
						$Subject = $student_details['Subject'];
					}
					else{
						$Subject = "";
					}
					if($student_details['country']!="")
					{
						$country = $student_details['country'];
					}
					else{
						$country = "";
					}
					if($student_details['Student_Location']!="")
					{
						$Student_Location = $student_details['Student_Location'];
					}
					else{
						$Student_Location = "";
					}
					if($student_details['Student_Postal_Code']!="")
					{
						$Student_Postal_Code = $student_details['Student_Postal_Code'];
					}
					else{
						$Student_Postal_Code = "";
					}
					if($student_details['profile_image']!="")
					{
						$profile_image = $student_details['profile_image'];
					}
					else{
						$profile_image = "";
					}
					
					
					
					// For Student Main Details
					$Student_Main_Details = mysqli_fetch_assoc($conn->query("select * from user_info where user_id = '".$tutor_result['student_id']."' "));
					
					
					
					$Response[] = array(
									 'student_id' => $tutor_result['student_id'],
									 'first_name' => $Student_Main_Details['first_name'],
									 'last_name' => $Student_Main_Details['last_name'],
									 'email' => $Student_Main_Details['email'],
									 'mobile' => $Student_Main_Details['mobile'],
									 'user_type' => $Student_Main_Details['user_type'],
									 'student_level' => $Level,
									 'student_grade' => $Grade,
									 'student_stream' => $Stream,
									 'student_passing_year' => $passing_year,
									 'student_subject' => $Subject,
									 'student_country' => $country,
									 'student_location' => $Student_Location,
									 'student_postal_code' => $Student_Postal_Code,
									 'student_profile_image' => $profile_image,
									 'student_booked_level' => $tutor_result['student_level'],
									 'student_booked_grade' => $tutor_result['student_grade'],
									 'student_booked_tution_type' => $tutor_result['student_tution_type'],
									 'student_booked_subjects' => $tutor_booking_process_StudentSubjects
									
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
			
			$resultData = array('status' => false, 'message' => 'Student id, Tutor id, and Tutor schedule time and booked date can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>