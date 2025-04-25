<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');



$servername = "localhost";
$username = "tutorapp";
$password = "tutorapp$%4576#*";
$dbname = "tutorapp";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 





	
			// Read the JSON file in PHP
			$data = file_get_contents("php://input");
			
			// Convert the JSON String into PHP Array
			$array = json_decode($data, true);
			
			
			
			$arrayV = array();  
			$arrayV2 = array(); 
			$arrayV3 = array();
			$arrayV4 = array();
			$arrayV5 = array();	
			$arrayV6 = array();	
			$arrayV7 = array();
			$arrayV8 = array();		
			$arrayV9 = array();	
			$arraySchedule = array();	
			
				
			
			//print_r($array);
			
			
			
			$student_post_requirements_id = $array['student_post_requirements_id'];
			$logged_in_user_id = $array['logged_in_user_id'];
			
			$student_tution_type = $array['student_tution_type'];
			$student_postal_code = $array['student_postal_code'];
			$student_postal_address = $array['student_postal_address'];
			$tutor_duration_weeks = $array['tutor_duration_weeks'];
			$tutor_duration_hours = $array['tutor_duration_hours'];
			$tutor_tution_fees = $array['tutor_tution_fees'];
			$tutor_tution_schedule_time = $array['tutor_tution_schedule_time'];
			$tutor_tution_offer_amount_type = $array['tutor_tution_offer_amount_type'];
			$tutor_tution_offer_amount = $array['tutor_tution_offer_amount'];
			$booked_date = date('d-m-Y');
			$post_updated_date = date('d-m-Y');

			
			$logged_in_user_idV2 = $array["logged_in_user_id"];
			
			if($logged_in_user_idV2 !="")
			{
				
				$check_logged_user = $conn->query("select user_id from user_info where user_id = '".$logged_in_user_idV2."' ");
				
				if(mysqli_num_rows($check_logged_user)>0)
				{
				
				
				$student_data_sql = $conn->query("select * from student_post_requirements where logged_in_user_id = '".$logged_in_user_id."' and student_post_requirements_id = '".$student_post_requirements_id."'  ");
				
				if(mysqli_num_rows($student_data_sql)>0)
				{
				
				
				$get_spr_data = mysqli_fetch_array($student_data_sql);
			
			
				$arrayV[] = "('".$array["logged_in_user_id"]."','".$array["student_tution_type"]."','".$array["student_postal_code"]."','".$array["student_postal_address"]."','".$array["tutor_duration_weeks"]."','".$array["tutor_duration_hours"]."','".$array["tutor_tution_fees"]."','".$array["tutor_tution_schedule_time"]."','".$array["tutor_tution_offer_amount_type"]."','".$array["tutor_tution_offer_amount"]."','".$booked_date."')";				
			
				$logged_in_user_idV = $array["logged_in_user_id"];
			
			
			//print_r($arrayV3);
			
			if($array["student_tution_type"]!="")
			{
				$student_tution_type = $array["student_tution_type"];
			}
			else
			{
				$student_tution_type = $get_spr_data['student_tution_type'];
			}
			if($array["student_postal_code"]!="")
			{
				$student_postal_code = $array["student_postal_code"];
			}
			else{
				$student_postal_code = $get_spr_data['student_postal_code'];
			}
			if($array["student_postal_address"]!="")
			{
				$student_postal_address = $array["student_postal_address"];
			}
			else{
				$student_postal_address = $get_spr_data['student_postal_address'];
			}
			if($array["tutor_duration_weeks"]!="")
			{
				$tutor_duration_weeks = $array["tutor_duration_weeks"];
			}
			else{
				$tutor_duration_weeks = $get_spr_data['tutor_duration_weeks'];
			}
			if($array["tutor_duration_hours"]!="")
			{
				$tutor_duration_hours = $array["tutor_duration_hours"];
			}
			else
			{
				$tutor_duration_hours = $get_spr_data['tutor_duration_hours'];
			}
			if($array["tutor_tution_fees"]!="")
			{
				$tutor_tution_fees = $array["tutor_tution_fees"];
			}
			else{
				$tutor_tution_fees = $get_spr_data['tutor_tution_fees'];
			}
			if($array["tutor_tution_schedule_time"]!="")
			{
				$tutor_tution_schedule_time = $array["tutor_tution_schedule_time"];
			}
			else{
				$tutor_tution_schedule_time = $get_spr_data['tutor_tution_schedule_time'];
			}
			if($array["tutor_tution_offer_amount_type"]!="")
			{
				$tutor_tution_offer_amount_type = $array["tutor_tution_offer_amount_type"];
			}
			else{
				$tutor_tution_offer_amount_type = $get_spr_data['tutor_tution_offer_amount_type'];
			}
			if($array["tutor_tution_offer_amount"]!="")
			{
				$tutor_tution_offer_amount = $array["tutor_tution_offer_amount"];
			}
			else{
				$tutor_tution_offer_amount = $get_spr_data['tutor_tution_offer_amount'];
			}
			
			
			$Qualifications = $array['Qualifications'];
			
			
			
			$Tutor_Schedules_Slot_Time = $array['Tutor_Schedules_Slot_Time'];
			
			$Student_Level_Grade_Subjects = $array['Student_Level_Grade_Subjects'];
			
			
			
			
			$student_grade = $array['student_grade'];
			
			$Subjects = $array['Subjects'];
			$Qualifications = $array['Qualifications'];
			$Tutor_schedules = $array['Tutor_schedules'];
			$Slots_time = $array['Slots_time'];
			
			
			
			
			/// check user_tutor_info record
			
			$chk_rec = $conn->query("select * from student_post_requirements where logged_in_user_id = '".$logged_in_user_idV."' and student_post_requirements_id = '".$student_post_requirements_id."'  ");
			//$chk_rec = $conn->query("select * from student_post_requirements where logged_in_user_id = '".$logged_in_user_idV."'  ");
			
			
				
				if(mysqli_num_rows($chk_rec)>0)
				{
					
					
					
					
					$GET_Book_ID = mysqli_fetch_array($chk_rec);
					
					
				if(!empty($Student_Level_Grade_Subjects))
				{					
					///Student levels
					//$del_tLevel = $conn->query("delete from post_requirements_student_levels where student_post_requirements_id = '".$GET_Book_ID['student_post_requirements_id']."'  ");
					
					///Student Grade
					//$del_tLevel = $conn->query("delete from post_requirements_student_grade where student_post_requirements_id = '".$GET_Book_ID['student_post_requirements_id']."'  ");
					
					
					///Student Subjects
					//$del_tinfo = $conn->query("delete from post_requirements_student_subjects where student_post_requirements_id = '".$GET_Book_ID['student_post_requirements_id']."'  ");
					
					
					////Tutor Schedule
					//$del_tinfo3 = $conn->query("delete from post_requirements_TutorSchedule where student_post_requirements_id = '".$GET_Book_ID['student_post_requirements_id']."'  ");
					
				}


				
					
					//$tqsg = $conn->query("delete from student_post_requirements where student_post_requirements_id = '".$GET_Book_ID['student_post_requirements_id']."' ");
					
					
					
					
					//$query = "INSERT INTO `student_post_requirements` (logged_in_user_id,student_tution_type,student_postal_code,student_postal_address,tutor_duration_weeks,tutor_duration_hours,tutor_tution_fees,tutor_tution_schedule_time,tutor_tution_offer_amount_type,tutor_tution_offer_amount,booked_date) VALUES " . implode(', ', $arrayV);  
				
					//$query = $conn->query("INSERT INTO student_post_requirements SET logged_in_user_id= '".$logged_in_user_idV."', student_tution_type= '".$student_tution_type."', student_postal_code= '".$student_postal_code."', student_postal_address= '".$student_postal_address."', tutor_duration_weeks= '".$tutor_duration_weeks."', tutor_duration_hours= '".$tutor_duration_hours."', tutor_tution_fees= '".$tutor_tution_fees."', tutor_tution_schedule_time= '".$tutor_tution_schedule_time."', tutor_tution_offer_amount_type= '".$tutor_tution_offer_amount_type."', tutor_tution_offer_amount= '".$tutor_tution_offer_amount."', booked_date= '".$booked_date."',negotiate_by_tutor_amount_type=0,amount_negotiate_by_student = 0, negotiate_by_student_amount_type=0,tutor_booking_status='',offer_status='',student_offer_date='',student_offer_time='',tutor_offer_date='',tutor_offer_time='',student_date_time_offer_confirmation='',tutor_accept_date_time_status='',post_updated_date='',total_days_for_expire_post='',post_expire_status='' ");
					
					$query = $conn->query("UPDATE student_post_requirements SET student_tution_type= '".$student_tution_type."', student_postal_code= '".$student_postal_code."', student_postal_address= '".$student_postal_address."', tutor_duration_weeks= '".$tutor_duration_weeks."', tutor_duration_hours= '".$tutor_duration_hours."', tutor_tution_fees= '".$tutor_tution_fees."', tutor_tution_schedule_time= '".$tutor_tution_schedule_time."', tutor_tution_offer_amount_type= '".$tutor_tution_offer_amount_type."', tutor_tution_offer_amount= '".$tutor_tution_offer_amount."', post_updated_date = '".$post_updated_date."', negotiate_by_tutor_amount_type=0,amount_negotiate_by_student = 0, negotiate_by_student_amount_type=0,tutor_booking_status='',offer_status='',student_offer_date='',student_offer_time='',tutor_offer_date='',tutor_offer_time='',student_date_time_offer_confirmation='',tutor_accept_date_time_status='',post_updated_date='',total_days_for_expire_post='',post_expire_status='' WHERE logged_in_user_id = '".$logged_in_user_idV."' and student_post_requirements_id = '".$student_post_requirements_id."'  ");
					
				$query_upD = $conn->query("UPDATE student_post_requirements SET  post_updated_date = '".$post_updated_date."' WHERE logged_in_user_id = '".$logged_in_user_idV."' and student_post_requirements_id = '".$student_post_requirements_id."'  ");
					
				
			
			
				if($query)
				{
					$getLastBooking_id = mysqli_fetch_array($conn->query("SELECT * FROM student_post_requirements ORDER BY student_post_requirements_id DESC LIMIT 0,1"));
				
					
					if(!empty($Qualifications))
					{
						$qua1 = $conn->query("delete from post_requirements_TutorQualification where student_post_requirements_id = 0 ");
					
						////Tutor Qualification
						//$del_tinfo2 = $conn->query("delete from post_requirements_TutorQualification where student_post_requirements_id = '".$GET_Book_ID['student_post_requirements_id']."'  ");
					
						
						// For Qualifications
						foreach($Qualifications as $row2 => $value2) 
						{
							//print_r($value2);
							if($value2['qualification'] !="" )
							{
								
								 $subject_val = $value2['qualification'];
								
								$arrayV3[] = "('".$value2['qualification']."')";
							}
							if($value2['qualification_id'] !="" )
							{
								//$arrayV3[] = "('".$subject_val."','".$value2['qualification_id']."')";
							}
							
						}
						
						
						/// Tutor Qualification
					
					$qua2 = $conn->query("INSERT INTO `post_requirements_TutorQualification` (Tutor_Qualification) VALUES " . implode(', ', $arrayV3));  
					$qua3 = $conn->query("UPDATE post_requirements_TutorQualification SET student_post_requirements_id = '".$student_post_requirements_id."' where student_post_requirements_id = 0 ");  
					
					}
						
							
					
					
					
					
				
				if(!empty($Student_Level_Grade_Subjects))
				{
					$level1 = $conn->query("delete from tbl_Student_Level_Grade_Subjects_Post_Requirement  where student_post_requirements_id = 0 ");
				
					/// For Add Level, Grade and Subjects		
					foreach($Student_Level_Grade_Subjects as $entry) {
						$id = $entry['ID'];
						$allSubjects = implode(',', $entry['ALL_Subjects']);
						$grade = $entry['Grade'];
						$level = $entry['Level'];
						$Admission_Level = $entry['Admission_Level'];
						
						//$level1 = $conn->query("delete from tbl_Student_Level_Grade_Subjects_Post_Requirement where Level = '".$level."' and Grade = '".$grade."' ");
					
						
						$query = $conn->query("INSERT INTO tbl_Student_Level_Grade_Subjects_Post_Requirement (ID, ALL_Subjects, Grade, Level, Admission_Level) VALUES ('$id', '$allSubjects', '$grade', '$level', '$Admission_Level')");
						
						
						
						if($level=="Secondary")
						{
						
							////////
							foreach($entry['Stream'] as $StreamsData)
							{
								$del_stream = $conn->query("delete from student_post_requirements_streams where student_post_requirements_id = 0  ");
								$add_stream = $conn->query("INSERT INTO student_post_requirements_streams  (student_post_requirements_streams, student_post_requirements_id) VALUES ('$StreamsData', '".$student_post_requirements_id."')");
							
							}
						}
						
						
						/////////
						
						
					}
					
					
					$level3 = $conn->query("UPDATE tbl_Student_Level_Grade_Subjects_Post_Requirement  SET student_post_requirements_id = '".$student_post_requirements_id."' where student_post_requirements_id = 0 "); 
					
					
					
				}
					
					
					
				if(!empty($Tutor_Schedules_Slot_Time))
				{	
					/// For Add Schedule and Times		
					foreach ($Tutor_Schedules_Slot_Time as $scheduleTime) {
						
						$slot_times = implode(',', $scheduleTime['slot_time']);
						$tutor_schedule = $scheduleTime['tutor_schedule'];
						
						
						//$scheduleTime_del = $conn->query("delete from tbl_Tutor_Schedules_Slot_Time_post_requirement where tutor_schedule = '".$tutor_schedule."' and slot_times = '".$slot_times."' ");
					
						
						$scheduleTime_insrt = $conn->query("INSERT INTO tbl_Tutor_Schedules_Slot_Time_post_requirement (tutor_schedule, slot_times) VALUES ('$tutor_schedule', '$slot_times')");
						
						
					}
					
					
					$scheduleTime_update = $conn->query("UPDATE tbl_Tutor_Schedules_Slot_Time_post_requirement SET student_post_requirements_id = '".$student_post_requirements_id."' where student_post_requirements_id = 0 ");  	
				
					
				}
					
					
					
				
				
				
				
					
					
					
					
						
					//if($qua3)
					//{
						$resultData = array('status' => true, 'message' => 'Student Post Requirement Edit Successfully.');
						
					//}
				
				
				  
					
				}
				else
				{
					$resultData = array('status' => false, 'message' => 'Error Found.');
				}
				
				
				}
				else			
				{	
					
					$resultData = array('status' => false, 'message' => 'No record found.');
					
				//echo "INSERT INTO student_post_requirements SET logged_in_user_id= '".$logged_in_user_idV."', student_tution_type= '".$student_tution_type."', student_postal_code= '".$student_postal_code."', student_postal_address= '".$student_postal_address."', tutor_duration_weeks= '".$tutor_duration_weeks."', tutor_duration_hours= '".$tutor_duration_hours."', tutor_tution_fees= '".$tutor_tution_fees."', tutor_tution_schedule_time= '".$tutor_tution_schedule_time."', tutor_tution_offer_amount_type= '".$tutor_tution_offer_amount_type."', tutor_tution_offer_amount= '".$tutor_tution_offer_amount."', booked_date= '".$booked_date."' ";
					//$query = "INSERT INTO `student_post_requirements` (logged_in_user_id,student_tution_type,student_postal_code,student_postal_address,tutor_duration_weeks,tutor_duration_hours,tutor_tution_fees,tutor_tution_schedule_time,tutor_tution_offer_amount_type,tutor_tution_offer_amount,booked_date) VALUES " . implode(', ', $arrayV);  
				
					//$query = $conn->query("INSERT INTO student_post_requirements SET logged_in_user_id= '".$logged_in_user_idV."', student_tution_type= '".$student_tution_type."', student_postal_code= '".$student_postal_code."', student_postal_address= '".$student_postal_address."', tutor_duration_weeks= '".$tutor_duration_weeks."', tutor_duration_hours= '".$tutor_duration_hours."', tutor_tution_fees= '".$tutor_tution_fees."', tutor_tution_schedule_time= '".$tutor_tution_schedule_time."', tutor_tution_offer_amount_type= '".$tutor_tution_offer_amount_type."', tutor_tution_offer_amount= '".$tutor_tution_offer_amount."', booked_date= '".$booked_date."', negotiate_by_tutor_amount_type=0,amount_negotiate_by_student = 0, negotiate_by_student_amount_type=0,tutor_booking_status='',offer_status='',student_offer_date='',student_offer_time='',tutor_offer_date='',tutor_offer_time='',student_date_time_offer_confirmation='',tutor_accept_date_time_status='',post_updated_date='',total_days_for_expire_post='',post_expire_status='' ");
				
				
				}
				
				
				}
				else
				{
					$resultData = array('status' => false, 'message' => 'Student Post Requirement ID Not Found.');
				}
			
			
				}
				else
				{
					$resultData = array('status' => false, 'message' => 'Logged In User ID Not Found.');
				}
				
			

			}
			else{
				$resultData = array('status' => false, 'message' => 'Logged in user id can\'t blank');
			}


				echo json_encode($resultData);
				
				
				
			
?>