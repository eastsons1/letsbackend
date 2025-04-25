<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


	$email = $_POST['email'];
	$OTP = $_POST['OTP'];
	$newPassword = md5($_POST['newPassword']);


	if($email !="" && $OTP !="" && $newPassword !="" )
	{

		$check_pass = $conn->query("select * from user_password where email = '".$email."' and password = '".$newPassword."'  ");
					 
		 if(mysqli_num_rows($check_pass)>0)
		 {
			 $resultSet = array('status' => false, 'message' => 'This password has been used. Please try another.');
		 }
		 else{
		

		$sql = $conn->query("SELECT * FROM user_info WHERE email = '".$email."' and otp = '".$OTP."' ");

		if(mysqli_num_rows($sql)>0)
		{
			
			
			
			$user_details = mysqli_fetch_array($sql);
			
			$otp_timestamp = strtotime($user_details['otp_timestamp']);
			
			$currectTimeStamp = time();
			//$OneMinuteAgoTimestamp = $currectTimeStamp - 90;
				 
				 
				 
			if(($currectTimeStamp - $otp_timestamp) > 0 && ($currectTimeStamp - $otp_timestamp) <= 90) 
			{
                $update_new_password = $conn->query("UPDATE user_info SET password = '".$newPassword."' WHERE email = '".$email."' and otp = '".$OTP."' ");
			
				if($update_new_password)
				{
					$resultSet = array('status' => true, 'message' => 'Password updated successfully.');
				}
				else{
					$resultSet = array('status' => false, 'message' => 'Password not updated.');
				}
				
            } else if (($currectTimeStamp - $otp_timestamp) <= 0) {
                $resultSet = array('status' => false, 'message' => 'OTP has Expired.');
            } else {
                $resultSet = array('status' => false, 'message' => 'OTP has Expired.');
            }	 
				 
			
			
			
			
			
		
		}
		else
		{
			$resultSet = array('status' => false, 'message' => 'OTP is Incorrect.');
		}
		
		
		
		 }
		

	}
	else{
		
		$resultSet = array('status' => false, 'message' => 'Please check the passive values.');
	}
	
	echo json_encode($resultSet);
	
?>