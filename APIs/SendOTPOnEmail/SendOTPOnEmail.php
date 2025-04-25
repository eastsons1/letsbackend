<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

require '../../phpmailer-master/class.phpmailer.php';

		
		
		$email = $_POST['email'];
			
			if($email != "")
			{
			
			 $query = $conn->query("select * from user_info where email= '".$email."'  ");
			 
			 if(mysqli_num_rows($query)>0)
			 {
				 
				 ///Generate 4 digit otp number start function 
					function generateKey($keyLength) 
					{
						// Set a blank variable to store the key in
						$key = "";
						for ($x = 1; $x <= $keyLength; $x++) {
						// Set each digit
						$key .= random_int(0, 9);
						}
						return $key;
					}
				   ///Generate 4 digit otp number end function 
				 
				 
				 $full_namevv =  mysqli_fetch_array($query);
				 
				 $full_name = $full_namevv['first_name'].' '.$full_namevv['last_name'];
				 
				 

				 $randomNumber_otp = generateKey(4); //rand(10,10000);
				 
				 $currentTimestamp = date('Y-m-d H:i:s');
				
				  $query2 = $conn->query("UPDATE user_info SET otp = '".$randomNumber_otp."', otp_timestamp = '".$currentTimestamp."' WHERE email ='".$email."' ");
				  
				 
				if($query2)
				{
					
					
					/**
						$subject  = "OTP For Password Change";
						 
						
						
						$message = '
									<table border="0" style="font-size: 15px; font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
										<tr>
											<td colspan="2" >Hi ' . $full_name . ',</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0;">
												Here is the OTP you have been waiting for:
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0; text-align: center; font-size: 24px; font-weight: bold; color: #2f5497;">
												' . implode(' ', str_split($randomNumber_otp)) . '
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0; font-size: 12px; color:#777777;">
												This OTP is only valid for 90 seconds. Use it promptly.
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0;">
												If you face any issue, you can contact us via Help & Support.
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0; font-size: 14px; color: #666;">
												Thanks & Regards,<br>
												<strong>MyTutors Admin</strong>
											</td>
										</tr>
									</table>';

					
									
						$to	=	"pushpendra@eastsons.com".",".$email;	
				
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .=  'X-Mailer: PHP/'. phpversion();
						//$headers .= 'Bcc: test@yahoo.com' . "\r\n";
						$headers .= 'From: support@gmail.com' . "\r\n";	

						**/



						
						
						
						//////////////////
						
						$mail = new PHPMailer(true); // New instance, with exceptions enabled
								
								
								try {
									  $body = '
									<table border="0" style="font-size: 15px; font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
										<tr>
											<td colspan="2" >Hi ' . $full_name . ',</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0;">
												Here is the OTP you have been waiting for:
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0; text-align: center; font-size: 24px; font-weight: bold; color: #2f5497;">
												' . implode(' ', str_split($randomNumber_otp)) . '
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0; font-size: 12px; color:#777777;">
												This OTP is only valid for 90 seconds. Use it promptly.
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0;">
												If you face any issue, you can contact us via Help & Support.
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0; font-size: 14px; color: #666;">
												Thanks & Regards,<br>
												<strong>MyTutors Admin</strong>
											</td>
										</tr>
									</table>';

									// Configure PHPMailer to use SMTP
									$mail->IsSMTP();
									$mail->SMTPAuth = true;
									$mail->SMTPSecure = 'ssl';
									$mail->Port = 465;  // SMTP server port
									$mail->Host = 'eastsons.mytutors.moe';  // SMTP server
									$mail->Username = 'info@mytutors.moe';  // SMTP username
									$mail->Password = 'PVzn08KRAzDhV';      // SMTP password

									// From address and name
									$mail->From = 'noreply@mytutors.moe';
									$mail->FromName = 'MyTutors.Moe';

									// Recipient address
									 $to	=	$email;	
									$mail->AddAddress($to);

									// Email subject
									$mail->Subject = 'OTP For Password Change';

									// Optional: Plain text version for non-HTML email clients
									$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
									
									// Word wrap setting
									$mail->WordWrap = 80;

									// HTML body content
									$mail->MsgHTML($body);

									// Set the mail format to HTML
									$mail->IsHTML(true);

									// Send email
									$mail->Send();
									
									//echo 'Success';
									
								$resultSet = array('status' => true, 'message' => 'OTP sent in email id.', 'OTP' => $randomNumber_otp);
						
									
									

								} catch (Exception $e) {
									echo 'Mailer Error: ' . $mail->ErrorInfo; // Provide error message in case of failure
								}
								
						
						
						/////////////
						
						
						
						
						
						
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