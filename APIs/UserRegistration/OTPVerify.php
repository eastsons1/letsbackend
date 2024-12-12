<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');



		
		
			
		if($_POST['email']!="" && $_POST['OTP_EMAIL']!="" )
		{
			$check_otp = "SELECT * FROM user_info_temp WHERE OTP = '".$_POST['OTP_EMAIL']."' and OTP_Validate ='0' and email = '".$_POST['email']."' ";
			$check_otp_result = $conn->query($check_otp);

			$check_otp_expire = mysqli_fetch_array($check_otp_result);

			$timestampToCheck = $check_otp_expire['otp_timestamp'];

			$currentTimestamp = time();
			$oneMinuteAgoTimestamp = $currentTimestamp - 60;
			

			if($timestampToCheck >= $oneMinuteAgoTimestamp && $timestampToCheck <= $currentTimestamp) 
			{
				//echo 'The timestamp is within the last 1 minute.';
						
				
			$check_otp_exits = mysqli_num_rows($check_otp_result);
			
			
		  if($check_otp_exits == 1)	
		  {
					
			 $resultData = array('status' => true, 'message' => 'OTP Verified Successfully.');
			
		  }
		  else{
			  ///$msg1 = "OTP entered is not valid. Please enter correct OTP.";
			   $resultData = array('status' => false, 'message' => 'OTP entered is not valid. Please enter correct OTP.');
							
		  }
		  
		  
		} else {
				//$msg2 =  'OTP Has expired.';  ///The timestamp is not within the last 1 minute.
				$resultData = array('status' => false, 'message' => 'OTP Has expired.');
			  }
		  
		  
		  
		}
		else{
			$resultData = array('status' => false, 'message' => 'Email and OTP can Not Blank.' );
		}
		
					
			echo json_encode($resultData);
			
?>