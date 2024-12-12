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

						

						if(@mail($to, $subject, $message, $headers, '-f info@mytutors.moe'))
						{

							$resultSet = array('status' => true, 'message' => 'OTP sent in email id.', 'OTP' => $randomNumber_otp);
						
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
			
			
			
			
			
			echo json_encode($resultSet);
			
		
		
		
?>