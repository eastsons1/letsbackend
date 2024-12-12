<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
		
		
		
		
		if($_POST['loggedIn_user_id'] != "" && $_POST['booked_to_user_id'] != "")
		{
			$booked_date = date('d-m-Y');
			
			
			$check_user_type_student   =  mysqli_fetch_array($conn->query(" SELECT user_type FROM user_info WHERE user_id ='".$_POST['loggedIn_user_id']."'  "));
			
			$check_user_type_tutor   =  mysqli_fetch_array($conn->query(" SELECT user_type FROM user_info WHERE user_id ='".$_POST['booked_to_user_id']."'  "));
			
			if($check_user_type_student['user_type'] == "I am looking for a Tutor" && $check_user_type_tutor['user_type']== "I am an Educator" )
			{
			
			
			$chk     =  $conn->query(" SELECT * FROM booked_tutor WHERE booked_by_user_id ='".$_POST['loggedIn_user_id']."' and booked_to_user_id = '".$_POST['booked_to_user_id']."' ");
		    
			if(mysqli_num_rows($chk)>0)
			{
				
				$resultData = array('status' => false, 'Message' => 'This Tutor is already booked by you. Please book another one.');
			}
			else{
			
				$sql_insert     =  "INSERT INTO booked_tutor SET booked_by_user_id ='".$_POST['loggedIn_user_id']."', booked_to_user_id = '".$_POST['booked_to_user_id']."', booked_date = '".$booked_date."' ";
				$sql_insert_run =  $conn->query($sql_insert);
		
				if($sql_insert_run)
				{
					$resultData = array('status' => true, 'Message' => 'Tutor Booked Successfully.');
				}
				else{
					$resultData = array('status' => false, 'Message' => 'Booking Error.');
				}
			
			}
			
			}
			else{
				$resultData = array('status' => false, 'Message' => 'Check User Type student and tutor for booking.');
			}
			
		}
	else{
			$resultData = array('status' => false, 'Message' => 'Logged In User_Id and Booked To User Id Can Not Be Blank.');
		}
		
				
							
			echo json_encode($resultData);
					
			
?>