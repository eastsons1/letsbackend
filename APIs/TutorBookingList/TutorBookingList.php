<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
		
		
		if($_POST['booked_tutor_id'] != "" || $_POST['student_id'] != "")
		{
			
			if($_POST['booked_tutor_id'] != "" )
			{
				$sql = $conn->query("SELECT * FROM tbl_book_tutor_by_student WHERE tutor_id ='".$_POST['booked_tutor_id']."'  ");
			}
			
			if($_POST['student_id'] != "" )
			{
				$sql = $conn->query("SELECT * FROM tbl_book_tutor_by_student WHERE student_id ='".$_POST['student_id']."'  ");
			}
			
			
			
			if(mysqli_num_rows($sql)>0)
			{
			
			$Response = array();
			
			while($booked_tutor_data  =  mysqli_fetch_assoc($sql))
			{
				$Student_subjects_data_array = array();
				
				$Student_Profile_array = array();
				
				$Tutor_Profile_array = array();
				
				
				$Tutor_profile_sql = $conn->query("SELECT * FROM user_info WHERE user_id = '".$booked_tutor_data['tutor_id']."' ");
				
				while($Tutor_profile_Data = mysqli_fetch_assoc($Tutor_profile_sql))
				{
					$Tutor_Profile_array = $Tutor_profile_Data;
				}
				
				
				$Student_Profile_sql =  $conn->query("SELECT * FROM user_info WHERE user_id = '".$booked_tutor_data['student_id']."'  ");
				
				while($Student_Profile_Data = mysqli_fetch_assoc($Student_Profile_sql))
				{
					$Student_Profile_array[] =  $Student_Profile_Data;
				}
				
				
				$Student_subjects =  $conn->query("SELECT * FROM tbl_book_tutor_by_student_subjects WHERE booking_id = '".$booked_tutor_data['book_id']."'  ");
				
				while($Student_subjects_data = mysqli_fetch_assoc($Student_subjects))
				{
					$Student_subjects_data_array[] =  $Student_subjects_data;
				}
				
				
				
				
				$Response[] = array(
									'book_id' => $booked_tutor_data['book_id'],
									'student_id' => $booked_tutor_data['student_id'],
									'tutor_id' => $booked_tutor_data['tutor_id'],
									'tution_type' => $booked_tutor_data['tution_type'],
									'postal_code' => $booked_tutor_data['postal_code'],
									'level' => $booked_tutor_data['level'],
									'grade' => $booked_tutor_data['grade'],
									'negotiable_amount' => $booked_tutor_data['negotiable_amount'],
									'counter_amount' => $booked_tutor_data['counter_amount'],
									'fixed_amount' => $booked_tutor_data['fixed_amount'],
									'booking_status' => $booked_tutor_data['booking_status'],
									'booking_date' => $booked_tutor_data['booking_date'],
									'update_date' => $booked_tutor_data['update_date'],
									'Student_Subjects' => $Student_subjects_data_array,
									'Student_Profile' => $Student_Profile_array,
									'Tutor_Profile' => $Tutor_Profile_array
									
									
									);
				
			}
			
			
			
				if($Response)
				{
					$resultData = array('Status' => true, 'Tutor_Booking_list' => $Response);
				}
				else{
					
					$resultData = array('Status' => false, 'Tutor_Booking_list' => $Response);
				}
			
			
			
			
			}
			else{
				
				$resultData = array('Status' => false, 'Message' => 'No Record Found For This Tutor Id.');
			}
			
			
			
			
		}
		else{
			$resultData = array('Status' => false, 'Message' => 'User id can\'t blank.');
		}
		
				
							
			echo json_encode($resultData);
					
			
?>