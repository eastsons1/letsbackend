<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	$Tutor_Logged_In_ID = $_GET['Tutor_Logged_In_ID'];
	
	if($Tutor_Logged_In_ID != "")
	{
		
		$check = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$Tutor_Logged_In_ID."' ");
	
	//echo mysqli_num_rows($check);
	
		if(mysqli_num_rows($check)>0)
		{ 
		
			$Rating_data_arr = array();
			
			while($Rating_data = mysqli_fetch_assoc($check))
			{
				//$Rating_data_arr[] = $Rating_data;
				
				
				$student_details = mysqli_fetch_array($conn->query("SELECT first_name,last_name,profile_image FROM user_info WHERE user_id = '".$Rating_data['student_id']."' "));
				
				$Rating_data_arr[] =  array(
				
											'rating_id' => $Rating_data['rating_id'],
											'student_id' => $Rating_data['student_id'],
											'first_name' => $student_details['first_name'],
											'last_name' => $student_details['last_name'],
											'profile_image' => $Rating_data['profile_image'],
											'tutor_id' => $Rating_data['tutor_id'],
											'rating_no' => $Rating_data['rating_no'],
											'msg' => $Rating_data['msg'],
											'created_date' => $Rating_data['created_date']
											
											
											);
			}
			
			
			if(!empty($Rating_data_arr))
			{
	
				$resultData = array('status' => true, 'Output' => $Rating_data_arr);
			
			}
			else{
			
				$Rating_data_arr = [];
				$resultData = array('status' => false, 'message' => 'No Data', 'Output' => $Rating_data_arr);
			
			}
			
			
		}
		else
		{
			
			$resultData = array('status' => false, 'message' => 'No record found.', 'Output' => []);
		
		}
	
	}
	else{
			$resultData = array('status' => false, 'message' => 'Tutor Login Id can not blank.');
	}


		echo json_encode($resultData);


?>