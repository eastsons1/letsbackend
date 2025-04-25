<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


		$emailId = $_POST['emailId'];
		$userpassword = $_POST['userpass'];
		$device_token = $_POST['device_token'];
		$device_type = $_POST['device_type'];
		
		
		
		
		
		if($_POST['login_option']=="Mobile Number")
		{
			$mobile_num = $_POST['mobile'];
			$country_phone_code = $_POST['country_phone_code'];
			$query = "SELECT * FROM user_info WHERE mobile	='".$mobile_num."' and country_phone_code = '".$country_phone_code."'  ";
			$idt = 1;
		}
		if($_POST['login_option']=="Email")
		{
			$emailId = $_POST['emailId'];
			 $query = "SELECT * FROM user_info WHERE email	='".$emailId."'  ";
			$idt = 2;
		}
		
		//echo $query;
		
		$result = $conn->query($query) or die ("table not found");
		
		$numrows = mysqli_num_rows($result);
		
		
		
		
		
		if($numrows > 0)
		{
			
			if($idt==1)
			{
				$queryPass = $conn->query("SELECT * FROM user_info WHERE country_phone_code = '".$country_phone_code."' and mobile	='".$_POST['mobile']."' and password ='".md5($userpassword)."' ");
			}
			if($idt==2)
			{
				$queryPass = $conn->query("SELECT * FROM user_info WHERE email	='".$_POST['emailId']."' and password ='".md5($userpassword)."' ");
			}
			
			$checkPass = mysqli_num_rows($queryPass);
		
		 if($checkPass > 0)
		 {
			
			
			
		  
		  $results = mysqli_fetch_array($queryPass);
		  
		  
		  
		  
			$results['email'];
			$results['password'];
			
			
			
			
			//if( ($emailId==$results['email'] || $mobile_num==$results['mobile'] ) && md5($userpassword) == $results['password'] )
			//{
				
				
				
				
				//// Average Rating of student_date_time_offer_confirmation
					
					
					$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$results['user_id']."' ");
					
					
					
					$nn = 0;
					$sn = 0;
					while($avg_rating = mysqli_fetch_array($avg_rating_sql))
					{
						$sn = $sn+1;
						$nn = $nn+$avg_rating['rating_no'];
					}
					
					
					if($nn !=0 && $sn !=0)
					{
						
						 $avg_rating = round($nn/$sn); 
					}
					else
					{
						 $avg_rating = 'No rating.';
					}
					
					
				
				
				
				///Token Create start
				
					//$userID = $results['user_id'];
					//$userRole = $results['user_type'];
					

					define('SECRET_KEY', "fakesecretkey");

						function createToken($data)
						{
							/* Create a part of token using secretKey and other stuff */
							$tokenGeneric = SECRET_KEY.$_SERVER["SERVER_NAME"]; // It can be 'stronger' of course

							/* Encoding token */
							$token = hash('sha256', $tokenGeneric.$data);
							
							return array('token' => $token, 'userData' => $data);
						}





						function auth($login, $password)
						{
							// we check user. For instance, it's ok, and we get his ID and his role.
							//$userID = 1;
							//$userRole = "admin";
							
							$userID = $login;
							$userRole = md5($password);

							// Concatenating data with TIME
							$data = time()."_".$userID."-".$userRole;
							$token = createToken($data);
							
							return $token;
							//echo json_encode($token);
						}

					
					
						
						define('VALIDITY_TIME', 3600);

						function checkToken($receivedToken, $receivedData)
						{
							/* Recreate the generic part of token using secretKey and other stuff */
							$tokenGeneric = SECRET_KEY.$_SERVER["SERVER_NAME"];

							// We create a token which should match
							$token = hash('sha256', $tokenGeneric.$receivedData);   

							// We check if token is ok !
							if ($receivedToken != $token)
							{
								echo 'wrong Token !';
								return false;
							}

							list($tokenDate, $userData) = explode("_", $receivedData);
							// here we compare tokenDate with current time using VALIDITY_TIME to check if the token is expired
							// if token expired we return false

							// otherwise it's ok and we return a new token
							
							
							return createToken(time()."#".$userData);   
						}
					
						
				
						
				
				
				/// Insert token into database start
				
				
		
				
						$tokenV = auth($emailId,$userpassword);
						foreach($tokenV as $key => $value) {
						
						
							if($key=='token')
							{
								$tokenD = $value;
							}
							
							if($key=='userData')
							{
								$userData = $value;
							}
						
						}
						
						
						
						
					   $_SESSION['token'] = $tokenD;
					
					   $_SESSION['timeout'] = time();
					
						$expiry = 1;
							
						// Set expiry_timestamp..
						$expiry_timestamp = $_SESSION['timeout'] + 1 * 60; //time() + $expiry;	
						
					
					
					$update_sql = $conn->query("UPDATE user_info SET accessToken ='".$tokenD."', expiry_timestamp = '".$expiry_timestamp."' WHERE email	= '".$emailId."' and password = '".md5($userpassword)."'  ");
					
					$chk_user_data = mysqli_fetch_array($conn->query("SELECT * FROM user_info WHERE email ='".$emailId."' and password ='".md5($userpassword)."' "));
					
					
				
				if( $chk_user_data['accessToken'] != $_SESSION['token'] && $_SESSION['timeout'] + 1 * 60 < time())
				{
					$resultData = array('status' => false, 'message' => 'Invalid Access Token!');
					echo json_encode($resultData);
					
				}
				else
				{
					
				
				
					if($_POST['emailId'] !="")
					{
						$user_session_value = $_POST['emailId'];
					}
					if($_POST['mobile'] !="")
					{
						$user_session_value = $_POST['mobile'];
					}
					
					$_SESSION['adminusername'] = $user_session_value;
					
					$_SESSION['username'] = $user_session_value;
					
					$_SESSION['loggedIn_user_id'] = $results['user_id']; 
					
					
					$user_id = $results['user_id'];
					$user_type = $results['user_type'];
					$first_name = $results['first_name'];
					$last_name = $results['last_name'];
					
					$mobilesql = mysqli_fetch_array($conn->query("select mobile from user_info where user_id = '".$user_id."' "));
						
					$mobileNo = $mobilesql['mobile'];
					
					///Get Postal code and profile_image
					$ssqql = $conn->query("Select user_id,postal_code,profile_image From user_tutor_info WHERE user_id = '".$user_id."' ");
					
					
					if(mysqli_num_rows($ssqql)>0)
					{
						$postal_code_query = mysqli_fetch_array($ssqql);
						$postal_code = $postal_code_query['postal_code'];
						$profile_image = $postal_code_query['profile_image'];
						
						$complete_profile = 'Yes';
					}
					else{
							$postal_code = "";
							$profile_image = "";
							$complete_profile = 'No';
					}
					
					if($_POST['remember'])
					{
						setcookie("cookusername", $_SESSION['adminusername'], time()+3600 , "/");
						setcookie("cookpass", $_SESSION['adminusername'], time()+60*60*24*30 , "/");
					}
					else
					{
						setcookie("cookusername", $_SESSION['adminusername'], time()+(-3600) , "/");
					}
				
				
				
				
				
				//$update_Token_type = $conn->query("UPDATE user_info SET device_token ='".$device_token."', device_type ='".$device_type."' WHERE email	= '".$emailId."' and password = '".md5($userpassword)."'  ");
					
				
				$chkT = $conn->query("select * from user_info_device_token where user_id = '".$user_id."' and device_token ='".$device_token."' and device_type ='".$device_type."' ");
				if(mysqli_num_rows($chkT)>0)
				{
					//$update_Token_type = $conn->query("UPDATE user_info_device_token SET device_token = '".$device_token."' WHERE user_id ='".$user_id."' and device_type ='".$device_type."' ");
				
				}
				else{
					
					$Add_Token_type = $conn->query("INSERT INTO user_info_device_token SET device_token ='".$device_token."', device_type ='".$device_type."' , user_id ='".$user_id."' ");
				
				}
				
				
				
				
				 ///check suspended accound
		
				$check_sus = $conn->query("SELECT * FROM tbl_user_suspended WHERE user_id = '".$results['user_id']."' and user_type = '".$results['user_type']."' and account_suspended = 'suspended' ");
			
				if(mysqli_num_rows($check_sus) > 0)
				{
					$AccountType = 'suspended';
				}
				else{
					$AccountType = 'active';
				}
				
				
				
				
				//header("location:admin/welcome.php");
				 $resultData = array('Status' => true, 'Message' => 'User Login Successfully.', 'Access_Token' => $tokenD, 'Device_Token' => $device_token, 'user_id' => $user_id, 'first_name' => $first_name, 'last_name' => $last_name, 'user_type' => $user_type, 'postal_code' => $postal_code, 'profile_image' => $profile_image, 'complete_profile' => $complete_profile, 'Mobile' => $mobileNo, 'Average_rating' => $avg_rating, 'AccountType' => $AccountType );
				 
				
				}
				
				
			///}
			//else{ ///$message1="Password not valid !";
				//$resultData = array('status' => false, 'message' => 'Password not valid !');
			//}
			
			
			
			}
			else 
			{
				$resultData = array('status' => false, 'message' => 'Incorrect password. Please enter again.');
			}
			
			
			
		}
		else 
		{
			//$message1="Email Id Or Mobile Number not valid !";
			$resultData = array('status' => false, 'message' => 'Email Id Or Mobile Number not valid !');
		}
				
							
			echo json_encode($resultData);
					
			
?>