<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

		
		
		
		
		
		$email = $_POST['email'];
			
			if($email != "")
			{
			
			//$newpassword = md5($_POST['newpassword']);
			
			
			 $query = $conn->query("select * from user_info where email= '".$email."'  ");
			 
			 if(mysqli_num_rows($query)>0)
			 {
				 
				 $randomNumber_otp = rand(10,10000);
				 
				 $currentTimestamp = time();
				 
				  $query2 = $conn->query("UPDATE user_info SET otp = '".$randomNumber_otp."', otp_timestamp = '".$currentTimestamp."' WHERE email ='".$email."' ");
				 
				 
				if($query2)
				{
					
					
						$subject  = "OTP For Password Change";
						 
						$message = '<table border="0" >

						<tr><td></td><td><strong>OTP For Password:  '.$randomNumber_otp.'</strong></td></tr>

						
						</table>';

					
									
						$to	=	"pushpendra@eastsons.com".",".$email;	
				
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .=  'X-Mailer: PHP/'. phpversion();
						//$headers .= 'Bcc: test@yahoo.com' . "\r\n";
						$headers .= 'From: support@gmail.com' . "\r\n";		

						

						if(@mail($to, $subject, $message, $headers))
						{

							$resultSet = array('status' => true, 'message' => 'OTP sent in email id.');
						
						}
						
				}
				 
				 
				
			 }
			 else{
				$resultSet = array('status' => false, 'message' => 'Record not found.');
			}
			
		
			}
			else{
				$resultSet = array('status' => false, 'message' => 'Email id can not blank.');
			}
			
			
			
			////  Second step to add otp and password
			
			
			if($email=="")
			{	
			
			if($_POST['otp'] !="" && $_POST['newpassword'] !="" )
			{	
		
				$newpassword = md5($_POST['newpassword']);
			
				$query = $conn->query("select * from user_info where otp = '".$_POST['otp']."'  ");
					 
					 if(mysqli_num_rows($query)>0)
					 {
						 
						 $check_otp_expire = mysqli_fetch_array($query);
						 
						 $timestampToCheck = $check_otp_expire['otp_timestamp'];
						 
						$currentTimestamp = time();
						$oneMinuteAgoTimestamp = $currentTimestamp - 60;

						if ($timestampToCheck >= $oneMinuteAgoTimestamp && $timestampToCheck <= $currentTimestamp) 
						{
							//echo 'The timestamp is within the last 1 minute.';
						
						 
						 
						 $update_pass = $conn->query("UPDATE user_info SET password = '".$newpassword."' WHERE otp = '".$_POST['otp']."'  ");
						
						if($update_pass)
						{
							
							$resultSet = array('status' => true, 'message' => 'Password updated successfully.');
							$pus = 1;
						}
						else{
							$pus = 0;
						}
						
						
						
						} else {
							//$msg2 =  'OTP Has expired.';  ///The timestamp is not within the last 1 minute.
							$resultSet = array('status' => false, 'message' => 'OTP Has expired.');
						}
						
						
					 
					 }
					 else{
						 //$msg2 = 'OTP did not match.';
						 $resultSet = array('status' => false, 'message' => 'OTP did not match.');
					 }
					 
					 
			}
		 else{
			 //$msg2 = 'OTP and password can not blank.';
			 $resultSet = array('status' => false, 'message' => 'OTP and password can not blank.');
		 }
			
			}
			
			
			echo json_encode($resultSet);
			
		
		
		
?>