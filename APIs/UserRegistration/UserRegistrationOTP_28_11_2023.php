<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');



		/**
		//if($_POST['OTP_EMAIL'] !="" && $_POST['OTP_MOBILE']!="")
		if($_POST['OTP_MOBILE']!="")
		{
			$check_otp = "SELECT * FROM user_info_temp WHERE OTP_mobile = '".$_POST['OTP_MOBILE']."' ";
			$check_otp_result = $conn->query($check_otp);
			$check_otp_exits = mysqli_num_rows($check_otp_result);
			
		  if($check_otp_exits == 1)	
		  {
				 $update_sql = $conn->query("update user_info_temp set OTP_Validate ='1' where OTP_mobile = '".$_POST['OTP_MOBILE']."'  ");
				 if($update_sql)
				 {
					// header('location:registration.php?step=2');
					$resultData = array('status' => true, 'message' => 'OTP is valid. Enter next details.');
							
				 }
			
		  }
		  else{
			 // $msg1 = "OTP entered is not valid. Please enter correct OTP.";
			 $resultData = array('status' => false, 'message' => 'OTP entered is not valid. Please enter correct OTP.');
							
		  }
		}	
		
		**/
		
		
		
		//if($_POST['user_type']!="")
			
		if($_POST['email']!="" && $_POST['OTP_EMAIL']!="" && $_POST['user_type']!="")
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
			 // $user_temp_record = mysqli_fetch_array($check_otp_result);
			  
				 $sql = "insert into user_info set first_name ='".$check_otp_expire['first_name']."', last_name = '".$check_otp_expire['last_name']."', adminusername ='".$check_otp_expire['adminusername']."', email = '".$check_otp_expire['email']."', password ='".$check_otp_expire['password']."', mobile ='".$check_otp_expire['mobile']."', user_type ='".$_POST['user_type']."', Term_cond ='1', user_roll	= '0', device_token = '".$check_otp_expire['device_token']."', device_type = '".$check_otp_expire['device_type']."' ";
			
				if($res=$conn->query($sql))
				{
					
			
					
					//$conn->insert_id;
					//$last_id = mysqli_insert_id($res);
					
					$del_sql = $conn->query("delete from user_info_temp WHERE OTP = '".$_POST['OTP_EMAIL']."' and email = '".$_POST['email']."' ");
				
				
					$user_id_sql = mysqli_fetch_array($conn->query("select user_id from user_info order by user_id DESC limit 1"));
					$user_last_id = $user_id_sql['user_id'];
					$user_type = $_POST['user_type'];
					
					$resultData = array('status' => true, 'message' => 'Registration success.', 'user_id' => $user_last_id, 'user_type' => $user_type);
							
				}
			
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
		
					
			echo json_encode($resultData);
			
?>