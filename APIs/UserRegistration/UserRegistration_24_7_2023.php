<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


		
//////

function Send_OTP_Mobile($CountryCode,$Mobile,$OTP)
{
	///"https://api.authkey.io/request?authkey=597a19768e9f3ec6&mobile=7991846193&country_code=91&sid=5319&otp=1234&time=10min";
	
//$url_otp = "https://api.authkey.io/request?authkey=597a19768e9f3ec6&mobile=$Mobile&country_code=$CountryCode&sid=5319&otp=$OTP&time=10min";

$url_otp = "https://api.authkey.io/request?authkey=a00bc3228c699037&mobile=$Mobile&country_code=$CountryCode&sid=9334&otp=$OTP&time=10min";

	$payload = json_encode("");
    //sending requests
    $ch = curl_init($url_otp);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'       
    ));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);

    // catching the response
    $response = json_decode($result, true);
	
	 $response;
	
}


///////
		
		$first_name	=	$_POST['first_name'];
		$last_name	=	$_POST['last_name'];
		$email	=	$_POST['email'];
		$password	=	$_POST['password'];
		$mobile	=	$_POST['mobile'];
		$country_phone_code	=	$_POST['country_phone_code'];
		
		///check mobile no valid
			
			

			if(!empty($mobile)) // phone number is not empty
			{
				//if(preg_match('/^\d{8}$/',$mobile)) // phone number is valid  (Min 8 digit)
				//{

                    
				 // $mobile = '0' . $mobile;

				  // your other code here
				  
				  
				  
				 ////check email id valid
				 
				 function test_input($data) {
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data);
					return $data;
					}

					$email = test_input($_POST["email"]);
					
					if(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
					{
						
						$resultData = array('status' => true, 'message' => 'Please type a valid email address');	
						echo json_encode($resultData);	
					}
					else					
					{	
				  
				  
				
					
					
					if( $first_name!="" && $last_name!="" && $email!="" && $mobile!="" && $country_phone_code !="")
					{
						
						
						
						//$check_email = "SELECT * FROM user_info_temp WHERE email = '".$email."' or mobile ='".$mobile."' ";    /// Check mobile or email exists
						
						$check_email = "SELECT * FROM user_info WHERE email = '".$email."' ";    /// Check mobile or email exists
						$check_email_result = $conn->query($check_email);
						$email_already_exits = mysqli_num_rows($check_email_result);
						if($email_already_exits>0)
						{
							$resultData = array('status' => false, 'message' => 'This Email id already exists. Please use another email id.');
							 
							$email_chk = 0;
							
						}
						else			
						{
							$email_chk = 1;
						}
						
						
						$check_mobile = "SELECT * FROM user_info WHERE mobile ='".$mobile."' ";    /// Check mobile or email exists
						$check_mobile_result = $conn->query($check_mobile);
						$mobile_already_exits = mysqli_num_rows($check_mobile_result);
						if($mobile_already_exits>0)
						{
							$resultData = array('status' => false, 'message' => 'This Mobile No. already exists. Please use another Mobile No.');
							 
							$mobile_chk = 0;
						}
						else			
						{
							$mobile_chk = 1;
						}
						
						
						
						////check mobile & email start
						if($email_chk == 0)	
						{
							echo json_encode($resultData);
						}
						elseif($mobile_chk == 0){
							echo json_encode($resultData);
						}
						elseif($email_chk == 0 && $mobile_chk == 0){
							echo json_encode($resultData);
						}
						////check mobile & email end
						
						
					  if($email_chk == 1 && $mobile_chk == 1)	
					  {
						  
						  ///Generate 4 digit otp number start function 
							function generateKey($keyLength) {
							// Set a blank variable to store the key in
							$key = "";
							for ($x = 1; $x <= $keyLength; $x++) {
							// Set each digit
							$key .= random_int(0, 9);
							}
							return $key;
							}
						   ///Generate 4 digit otp number end function 
						  
						  
							$_SESSION['OTP'] = '';
						  
							$randomNumber_otp = generateKey(4); //rand(10,10000);
							$randomNumber_otp_mobile = generateKey(4); ///rand(10,10000);
							
							$check_email = $conn->query("SELECT * FROM user_info WHERE email = '".$email."' ");
						
						  if(mysqli_num_rows($check_email) == 0)	
						  {	
						
						
						 $sql = "insert into user_info_temp set first_name ='".$first_name."', last_name ='".$last_name."', adminusername ='".$email."', email = '".$email."', password ='".md5($password)."', mobile ='".$mobile."', user_roll	= '0', OTP = '".$randomNumber_otp."', OTP_mobile = '".$randomNumber_otp_mobile."'  ";
						
						
						
						if($res=$conn->query($sql))
						{
							
							$subject  = "OTP For User Registration";
						
							$message = '<table border="0" >

							<tr><td></td><td><strong>OTP For Registration</strong></td></tr>

							<tr><td><strong>OTP: </strong></td><td>'.$randomNumber_otp.'</td></tr>

							</table>';

						
										
							$to	=	"pushpendra@eastsons.com".",".$email;	
					
						/**	$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .=  'X-Mailer: PHP/'. phpversion();
							//$headers .= 'Bcc: test@yahoo.com' . "\r\n";
							$headers .= 'From: support@gmail.com' . "\r\n";		
							
						**/	
							
							$headers = "From: support@gmail.com \r\n";
							$headers .= "Reply-To: ".$email."\r\n";
							$headers .= "Return-Path: ".$email."\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
							$headers .= "X-Priority: 3\r\n";
							$headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;

							

							if(@mail($to, $subject, $message, $headers))
							{

								//$msg1 = '<span style="color:red;">Message sent successfully.</span>';
								
								Send_OTP_Mobile($country_phone_code,$mobile,$randomNumber_otp_mobile);
								
								$_SESSION['OTP'] = $randomNumber_otp;
								
								//header('location:registration.php?step=1');
								$resultData = array('status' => true, 'message' => 'OTP sent in your mobile no. and email. Please go for next step.', 'Mobile_OTP' => $randomNumber_otp_mobile, 'Email_OTP' => $randomNumber_otp);	
								 echo json_encode($resultData);	
							}
				
						

				
				
							}
							else
							{
								//$msg1 = "Error while trying to inserting the record.";
								$resultData = array('status' => false, 'message' => 'Error while trying to inserting the record.');
										
							}
							
						 }
						 else{
							 //$msg1 = "This Email id already exists. Please use another email id.";
							 $resultData = array('status' => false, 'message' => 'This Email id already exists. Please use another email id.');
											
						 }
							
							
						}
						else{
							
							//$msg1 = "This Email or Mobile Already Exists. Please go for login.";
							//$resultData = array('status' => false, 'message' => 'This Email or Mobile Already Exists. Please go for login.');
										
						}
						
						
						 //echo json_encode($resultData);
						
							
						}
					
					}		
		
		/**
				}
				else // phone number is not valid
				{
				  //echo 'Phone number invalid !';
				   $resultData = array('status' => false, 'message' => 'Phone number invalid !');
				   echo json_encode($resultData);
				}  
                
                **/
			}
			else // phone number is empty
			{
			 // echo 'You must provid a phone number !';
			   $resultData = array('status' => false, 'message' => 'You must provid a phone number !');
				 echo json_encode($resultData);
			  
			}
		
		
		
		
		
		
		if($_POST['OTP_EMAIL'] !="" && $_POST['OTP_MOBILE']!="")
		{
			$check_otp = "SELECT * FROM user_info_temp WHERE OTP = '".$_POST['OTP_EMAIL']."' and OTP_mobile = '".$_POST['OTP_MOBILE']."' ";
			$check_otp_result = $conn->query($check_otp);
			$check_otp_exits = mysqli_num_rows($check_otp_result);
			
		  if($check_otp_exits == 1)	
		  {
				 $update_sql = $conn->query("update user_info_temp set OTP_Validate ='1' where OTP = '".$_POST['OTP_EMAIL']."'  ");
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
		  
		   // echo json_encode($resultData);
		  
		}	
		
		
		
		if($_POST['OTP_EMAIL']!="" && $_POST['user_type']!="")
		{
			$check_otp = "SELECT * FROM user_info_temp WHERE OTP = '".$_POST['OTP_EMAIL']."' and OTP_Validate ='1' ";
			$check_otp_result = $conn->query($check_otp);
			$check_otp_exits = mysqli_num_rows($check_otp_result);
			
		  if($check_otp_exits == 1)	
		  {
			  $user_temp_record = mysqli_fetch_array($check_otp_result);
			  
				$sql = "insert into user_info set first_name ='".$user_temp_record['first_name']."', last_name = '".$user_temp_record['last_name']."', adminusername ='".$user_temp_record['adminusername']."', email = '".$user_temp_record['email']."', password ='".md5($_POST['password'])."', mobile ='".$user_temp_record['mobile']."', user_type ='".$_POST['user_type']."', Term_cond ='1', user_roll	= '0' ";
			
				if($res=$conn->query($sql))
				{
					
					//$conn->insert_id;
					$last_id = mysqli_insert_id($conn);
					
					$del_sql = $conn->query("delete from user_info_temp WHERE OTP_Validate ='1' and OTP = '".$_POST['OTP_EMAIL']."' ");
				
					$_SESSION['adminusername'] = $user_temp_record['email'];
					$_SESSION['user_name'] = $user_temp_record['first_name']." ".$user_temp_record['last_name'];
					$_SESSION['username'] = $user_temp_record['email'];
					$_SESSION['loggedIn_user_id'] = $last_id; 
					///header("location:admin/welcome.php");
					
					 $resultData = array('status' => true, 'message' => 'Registration success.');
							
				}
			
		  }
		  else{
			  ///$msg1 = "OTP entered is not valid. Please enter correct OTP.";
			   $resultData = array('status' => false, 'message' => 'OTP entered is not valid. Please enter correct OTP.');
							
		  }
		  
		 // echo json_encode($resultData);
		  
		  
		}
		
					
			
			
?>