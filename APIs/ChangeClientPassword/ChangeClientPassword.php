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

		$sql = $conn->query("SELECT * FROM user_info WHERE email = '".$email."' and otp = '".$OTP."' ");

		if(mysqli_num_rows($sql)>0)
		{
			
			$user_details = mysqli_fetch_array($sql);
			
			$otp_timestamp = $user_details['otp_timestamp'];
			
			$currectTimeStamp = time();
			$OneMinuteAgoTimestamp = $currectTimeStamp - 60;
				 
			
			if($otp_timestamp >= $OneMinuteAgoTimestamp && $otp_timestamp <= $currectTimeStamp)
			{	
			
				$update_new_password = $conn->query("UPDATE user_info SET password = '".$newPassword."' WHERE email = '".$email."' and otp = '".$OTP."' ");
			
				if($update_new_password)
				{
					$resultSet = array('status' => true, 'message' => 'Password updated successfully.');
				}
				else{
					$resultSet = array('status' => false, 'message' => 'Password not updated.');
				}
			
			
			}
			else{
				
				$resultSet = array('status' => false, 'message' => 'OTP has expired.');
			}
			
		
		}
		else
		{
			$resultSet = array('status' => false, 'message' => 'No record found.');
		}

	}
	else{
		
		$resultSet = array('status' => false, 'message' => 'Please check the passive values.');
	}
	
	echo json_encode($resultSet);
	
?>