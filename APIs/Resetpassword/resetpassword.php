<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


require '../../phpmailer-master/class.phpmailer.php';


		
		
		$user_email = $_POST['user_email'];
		$old_password = md5($_POST['old_password']);
		$new_password = md5($_POST['new_password']);
		
		if($user_email !="" && $old_password !="" && $new_password != "")
		{
		
		
		$check_exist = $conn->query("SELECT * FROM user_info WHERE email = '".$user_email."' and password = '".$old_password."' ");
	
		if(mysqli_num_rows($check_exist)>0)
		{
			$update = $conn->query("UPDATE user_info SET password = '".$new_password."' WHERE email = '".$user_email."' ");
		
			if($update)
			{
				
				
				/**
				$subject  = "Password Update";
						 
						
					
						$message = '<table border="0" >

						<tr><td></td><td><strong>Password Update</strong></td></tr>

						<tr><td><strong>Your Password Updated successfully. </strong></td><td></td></tr>
						
						<tr><td></td><td></td></tr>						
						<tr><td><strong>Your New Password is: '.$_POST['new_password'].' </strong></td><td></td></tr>
						<tr><td></td><td></td></tr>	
						<tr><td></td><td></td></tr>
						<tr><td><strong>Thanks</strong></td><td></td></tr>							
						</table>';

					
									
						$to	=	"pushpendra@eastsons.com".",".$user_email;	
				
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .=  'X-Mailer: PHP/'. phpversion();
						//$headers .= 'Bcc: test@yahoo.com' . "\r\n";
						$headers .= 'From: support@gmail.com' . "\r\n";		
						
						
						**/
						
						
						

							
							/////////////////////
							
							$mail = new PHPMailer(true); //New instance, with exceptions enabled

									
									
									try {
									  
									    $body = '<table border="0" >

											<tr><td></td><td><strong>Password Update</strong></td></tr>

											<tr><td><strong>Your Password Updated successfully. </strong></td><td></td></tr>
											
											<tr><td></td><td></td></tr>						
											<tr><td><strong>Your New Password is: '.$_POST['new_password'].' </strong></td><td></td></tr>
											<tr><td></td><td></td></tr>	
											<tr><td></td><td></td></tr>
											<tr><td><strong>Thanks</strong></td><td></td></tr>							
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
									$to	=	$user_email;  //$email;	
									
									$mail->AddAddress($to);

									// Email subject
									$mail->Subject = 'Password Update';

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
									
								
								$resultData = array('status' => true, 'Message' => 'Password Updated Successfully.');

								

								} catch (Exception $e) {
									echo 'Mailer Error: ' . $mail->ErrorInfo; // Provide error message in case of failure
								}
									
									////////////////////



						
						
			}
		
		}
		else
		{
			$resultData = array('status' => false, 'Message' => 'Provide Credentail Not Found.');
		}
		
		
		
		}
		else{
			$resultData = array('status' => false, 'Message' => 'Email, Old Password and New Password Can\'t Blank. ');
		}
	
		
		echo json_encode($resultData);		
			
?>