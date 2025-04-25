<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

		
		
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

						

						if(@mail($to, $subject, $message, $headers))
						{

							$resultData = array('status' => true, 'Message' => 'Password Updated Successfully.');

						}
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