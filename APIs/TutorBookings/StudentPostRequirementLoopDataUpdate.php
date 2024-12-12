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
			
			
		
			
			$logged_in_user_idV2 = $array["logged_in_user_id"];
			
			
			
			$booked_date = mysqli_fetch_array($conn->query("SELECT * FROM student_post_requirements WHERE student_post_requirements_id = '".$student_post_requirements_id."' "));
			
			$str = $booked_date['booked_date'];
			$str = strtotime(date("M d Y ")) - (strtotime($str));
			$total_days_for_expire_post =  round($str/3600/24);
			
			
			$expiredValue = round(45);
			
			
			
			
			
			if($student_post_requirements_id !="" && $logged_in_user_idV2 !="")
			{
			
			
			$chk_expire_sql = mysqli_fetch_array($conn->query("SELECT post_expire_status,student_post_requirements_id FROM student_post_requirements WHERE student_post_requirements_id = '".$student_post_requirements_id."' "));
			
			if($chk_expire_sql['student_post_requirements_id'] != "")
			{
			
				
				
		//	echo $chk_expire_sql['post_expire_status'];
		
			if($chk_expire_sql['post_expire_status']=="")
			{
				
				/////////////////
						
						
					$arrayV[] = "('".$array["logged_in_user_id"]."','".$array["student_tution_type"]."','".$array["student_postal_code"]."','".$array["student_postal_address"]."','".$array["tutor_duration_weeks"]."','".$array["tutor_duration_hours"]."','".$array["tutor_tution_fees"]."','".$array["tutor_tution_schedule_time"]."','".$array["tutor_tution_offer_amount_type"]."','".$array["tutor_tution_offer_amount"]."','".$booked_date."')";				
					
					 $logged_in_user_idV = $array["logged_in_user_id"];
					
					
					//print_r($arrayV3);
					
					if($array["student_tution_type"]!="")
					{
						$student_tution_type = $array["student_tution_type"];
					}
					if($array["student_postal_code"]!="")
					{
						$student_postal_code = $array["student_postal_code"];
					}
					if($array["student_postal_address"]!="")
					{
						$student_postal_address = $array["student_postal_address"];
					}
					if($array["tutor_duration_weeks"]!="")
					{
						$tutor_duration_weeks = $array["tutor_duration_weeks"];
					}
					if($array["tutor_duration_hours"]!="")
					{
						$tutor_duration_hours = $array["tutor_duration_hours"];
					}
					if($array["tutor_tution_fees"]!="")
					{
						$tutor_tution_fees = $array["tutor_tution_fees"];
					}
					if($array["tutor_tution_schedule_time"]!="")
					{
						$tutor_tution_schedule_time = $array["tutor_tution_schedule_time"];
					}
					if($array["tutor_tution_offer_amount_type"]!="")
					{
						$tutor_tution_offer_amount_type = $array["tutor_tution_offer_amount_type"];
					}
					if($array["tutor_tution_offer_amount"]!="")
					{
						$tutor_tution_offer_amount = $array["tutor_tution_offer_amount"];
					}
					
					$Qualifications = $array['Qualifications'];
					
					
					
					$Tutor_Schedules_Slot_Time = $array['Tutor_Schedules_Slot_Time'];
					
					$Student_Level_Grade_Subjects = $array['Student_Level_Grade_Subjects'];
					
					
					
					$student_grade = $array['student_grade'];
					
					$Subjects = $array['Subjects'];
					$Qualifications = $array['Qualifications'];
					$Tutor_schedules = $array['Tutor_schedules'];
					$Slots_time = $array['Slots_time'];
					
					
					
					
					if($total_days_for_expire_post !="" && $total_days_for_expire_post > $expiredValue )
					{
					    
					    
					    $str = date('d-m-Y');
						$str = strtotime(date("M d Y ")) - (strtotime($str));
						$total_days_for_expire_post =  round($str/3600/24);
					    
					    $post_updated_date = date('d-m-Y');
					    
						$post_expire_status = 'Expired';
						$query = $conn->query("UPDATE student_post_requirements SET logged_in_user_id= '".$logged_in_user_idV."', post_updated_date = '".$post_updated_date."', total_days_for_expire_post = '".$total_days_for_expire_post."', post_expire_status = '".$post_expire_status."', student_tution_type= '".$student_tution_type."', student_postal_code= '".$student_postal_code."', student_postal_address= '".$student_postal_address."', tutor_duration_weeks= '".$tutor_duration_weeks."', tutor_duration_hours= '".$tutor_duration_hours."', tutor_tution_fees= '".$tutor_tution_fees."', tutor_tution_schedule_time= '".$tutor_tution_schedule_time."', tutor_tution_offer_amount_type= '".$tutor_tution_offer_amount_type."', tutor_tution_offer_amount= '".$tutor_tution_offer_amount."', negotiate_by_tutor_amount_type=0,amount_negotiate_by_student = 0, negotiate_by_student_amount_type=0,tutor_booking_status='',offer_status='',student_offer_date='',student_offer_time='',tutor_offer_date='',tutor_offer_time='',student_date_time_offer_confirmation='',tutor_accept_date_time_status='' WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
				
					}
					else					
					{
					    $str = date('d-m-Y');
						$str = strtotime(date("M d Y ")) - (strtotime($str));
						$total_days_for_expire_post =  round($str/3600/24);
						
					    $post_updated_date = date('d-m-Y');
					    
						$post_expire_status = '';
						$query = $conn->query("UPDATE student_post_requirements SET logged_in_user_id= '".$logged_in_user_idV."', booked_date = '".$post_updated_date."' , post_updated_date = '".$post_updated_date."', total_days_for_expire_post = '".$total_days_for_expire_post."', post_expire_status = '".$post_expire_status."', student_tution_type= '".$student_tution_type."', student_postal_code= '".$student_postal_code."', student_postal_address= '".$student_postal_address."', tutor_duration_weeks= '".$tutor_duration_weeks."', tutor_duration_hours= '".$tutor_duration_hours."', tutor_tution_fees= '".$tutor_tution_fees."', tutor_tution_schedule_time= '".$tutor_tution_schedule_time."', tutor_tution_offer_amount_type= '".$tutor_tution_offer_amount_type."', tutor_tution_offer_amount= '".$tutor_tution_offer_amount."', negotiate_by_tutor_amount_type=0,amount_negotiate_by_student = 0, negotiate_by_student_amount_type=0,tutor_booking_status='',offer_status='',student_offer_date='',student_offer_time='',tutor_offer_date='',tutor_offer_time='',student_date_time_offer_confirmation='',tutor_accept_date_time_status='' WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
				
				
			
				
					}
				   
				
						
						
						
						/**
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
						
						**/
						
						
					
					
						if($query)
						{
							
							$getLastBooking_id = mysqli_fetch_array($conn->query("SELECT * FROM student_post_requirements ORDER BY student_post_requirements_id DESC LIMIT 0,1"));
						
							$level1 = $conn->query("delete from tbl_Student_Level_Grade_Subjects_Post_Requirement  where student_post_requirements_id = 0 ");
							
							foreach($Student_Level_Grade_Subjects as $entry) 
							{
								if(!empty($entry['ALL_Subjects']))
								{
									$level_del_sub = $conn->query("delete from tbl_Student_Level_Grade_Subjects_Post_Requirement where student_post_requirements_id = '".$student_post_requirements_id."' ");
							
								}
							}
						
							/// For Add Level, Grade and Subjects		
							foreach($Student_Level_Grade_Subjects as $entry) {
								$id = $entry['ID'];
								$allSubjects = implode(',', $entry['ALL_Subjects']);
								$grade = $entry['Grade'];
								$level = $entry['Level'];
								$Admission_Level = $entry['Admission_Level'];
								
							//	$level1 = $conn->query("delete from tbl_Student_Level_Grade_Subjects_Post_Requirement where Level = '".$level."' and Grade = '".$grade."' ");
								
								
								
								$query = $conn->query("INSERT INTO tbl_Student_Level_Grade_Subjects_Post_Requirement (ID, ALL_Subjects, Grade, Level, Admission_Level,student_post_requirements_id) VALUES ('$id', '$allSubjects', '$grade', '$level', '$Admission_Level', '$student_post_requirements_id')");
								
								if(!empty($entry['Streams']))
								{
									$del_stream_str = $conn->query("delete from student_post_requirements_streams where student_post_requirements_id = '".$student_post_requirements_id."'  ");
								}
								
								////////
								foreach($entry['Streams'] as $StreamsData)
								{
									$del_stream = $conn->query("delete from student_post_requirements_streams where student_post_requirements_id = 0  ");
									
									$add_stream = $conn->query("INSERT INTO student_post_requirements_streams  (student_post_requirements_streams, student_post_requirements_id) VALUES ('$StreamsData', '".$student_post_requirements_id."')");
								
								}
								
								
								/////////
								
								
							}
							
							/// For Add Schedule and Times	
							foreach ($Tutor_Schedules_Slot_Time as $scheduleTime) 
							{
								if(!empty($scheduleTime['slot_time']))
								{
									$scheduleTime_del = $conn->query("delete from tbl_Tutor_Schedules_Slot_Time_post_requirement where student_post_requirements_id = '".$student_post_requirements_id."' ");
							}	}
							
							foreach ($Tutor_Schedules_Slot_Time as $scheduleTime) {
								
								$slot_times = implode(',', $scheduleTime['slot_time']);
								$tutor_schedule = $scheduleTime['tutor_schedule'];
								
								
								$scheduleTime_insrt = $conn->query("INSERT INTO tbl_Tutor_Schedules_Slot_Time_post_requirement (tutor_schedule, slot_times, student_post_requirements_id) VALUES ('$tutor_schedule', '$slot_times', '$student_post_requirements_id')");
								
								
							}
							
							
							
							$level3 = $conn->query("UPDATE tbl_Student_Level_Grade_Subjects_Post_Requirement SET student_post_requirements_id = '".$getLastBooking_id['student_post_requirements_id']."' where student_post_requirements_id = 0 "); 
							$scheduleTime_update = $conn->query("UPDATE tbl_Tutor_Schedules_Slot_Time_post_requirement SET student_post_requirements_id = '".$getLastBooking_id['student_post_requirements_id']."' where student_post_requirements_id = 0 ");  	
						
						
						
						
						
							
							/// Tutor Qualification
							//$qua1 = $conn->query("delete from post_requirements_TutorQualification where student_post_requirements_id = 0 ");
							//$qua2 = $conn->query("INSERT INTO `post_requirements_TutorQualification` (Tutor_Qualification) VALUES " . implode(', ', $arrayV3));  
							//$qua3 = $conn->query("UPDATE post_requirements_TutorQualification SET student_post_requirements_id = '".$getLastBooking_id['student_post_requirements_id']."' where student_post_requirements_id = 0 ");  
							
							
							
								
							if($scheduleTime_update)
							{
								$resultData = array('status' => true, 'message' => 'Student Post Requirement Update Successfully.');
								
							}
						
						
						  
							
						}
						else
						{
							$resultData = array('status' => false, 'message' => 'Error Found.');
						}
				
				
				///////////////
				
		    	}
				else{
						$resultData = array('status' => false, 'message' => 'This post already expired.');
				}	
				
				
			    }
				else{
						$resultData = array('status' => false, 'message' => 'Student Post Requirement id does not exists.');
				}	
				

			}
			else{
				    $resultData = array('status' => false, 'message' => 'Logged in user id and Post Requirement id can\'t blank');
			}


				echo json_encode($resultData);
				
				
				
			
?>