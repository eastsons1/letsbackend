<?php
error_reporting(0);
require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


//$actionName = $_POST["actionName"];

//if($actionName == "deletePost"){

		
		$email = $_POST['email'];
			$oldpassword = md5($_POST['oldpassword']);
			$newpassword = md5($_POST['newpassword']);
	
			 $query = $conn->query("select * from user_info where password='".$oldpassword."' and email= '".$email."'  ");
			 
			 if(mysqli_num_rows($query)>0)
			 {
				 
				 
				  $query2 = $conn->query("UPDATE user_info SET password = '".$newpassword."' WHERE email ='".$email."' ");
				 
				 
				if($query2)
				{
					
					
							 $subject  = "Password Update";
						 
						
					
						$message = '<table border="0" >

						<tr><td></td><td><strong>Password Update</strong></td></tr>

						<tr><td><strong>Your Password Updated successfully. </strong></td><td></td></tr>

						</table>';

					
									
						$to	=	"pushpendra@eastsons.com".",".$email;	
				
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .=  'X-Mailer: PHP/'. phpversion();
						//$headers .= 'Bcc: test@yahoo.com' . "\r\n";
						$headers .= 'From: support@gmail.com' . "\r\n";		

						

						if(@mail($to, $subject, $message, $headers))
						{

							//$msg = 'Password update successfully.';

						}
						
						
						
						
							$resultData = array('status' => true, 'Message' => "Password Change Successfully");
						

							echo json_encode($resultData);
						
						
							
					
					
					// $msg = 'Password update successfully.';
				}
				 
				 
				 
				
				
			 }
			 else{
		
		$resultDataFail = array('status' => false, 'Message' => 'Can\'t able to user Change Password...');
		
		echo json_encode($resultDataFail);
	}
		
		
		
	
	

?>