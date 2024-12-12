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
			
		if($_POST['email']!="" && $_POST['user_type']!="")
		{
			
			 $check_otp = "SELECT * FROM user_info_temp WHERE OTP_Validate ='0' and email = '".$_POST['email']."'  ";
			$check_otp_result = $conn->query($check_otp);
			
			
			if(mysqli_num_rows($check_otp_result)>0)
			{
			
			
				$check_otp_expire = mysqli_fetch_array($check_otp_result);
			
				$profile_imageV = $check_otp_expire['profile_image'];
			
			
				 $sql = "update user_info_temp set user_type ='".$_POST['user_type']."' where email = '".$_POST['email']."' ";
			
				if($res=$conn->query($sql))
				{
					
					$user_id_sql = mysqli_fetch_array($conn->query("select * from user_info_temp where email = '".$_POST['email']."' "));
					$user_last_id = $user_id_sql['user_id'];
					$user_type = $_POST['user_type'];
					
					
					
					//////
					// $user_temp_record = mysqli_fetch_array($check_otp_result);
			  
						 $sql = "insert into user_info set first_name ='".$check_otp_expire['first_name']."', last_name = '".$check_otp_expire['last_name']."', adminusername ='".$check_otp_expire['adminusername']."', email = '".$check_otp_expire['email']."', password ='".$check_otp_expire['password']."', mobile ='".$check_otp_expire['mobile']."', profile_image = '".$profile_imageV."', user_type ='".$_POST['user_type']."', Term_cond ='1', user_roll	= '0', device_token = '".$check_otp_expire['device_token']."',  device_type = 'Android' ,accessToken='',expiry_timestamp='',otp_timestamp='' ";
					
						if($res=$conn->query($sql))
						{
						
							//$conn->insert_id;
							//$last_id = mysqli_insert_id($res);
							
							$del_sql = $conn->query("delete from user_info_temp WHERE email = '".$_POST['email']."' ");
						
						
							$user_id_sql = mysqli_fetch_array($conn->query("select user_id,user_type from user_info order by user_id DESC limit 1"));
							$user_last_id = $user_id_sql['user_id'];
							$user_type = $user_id_sql['user_type'];
							
							
							///////////
							
							$aaaa = "SELECT * FROM user_info WHERE email = '".$_POST['email']."'  ";
							$UserData = mysqli_fetch_array($conn->query($aaaa));
							
							
							
							///Get Postal code and profile_image
							$ssqql = $conn->query("Select user_id,postal_code,profile_image From user_tutor_info WHERE user_id = '".$_POST['email']."' ");
					
					
						if(mysqli_num_rows($ssqql)>0)
						{
							$postal_code_query = mysqli_fetch_array($ssqql);
							$postal_code = $postal_code_query['postal_code'];
							$profile_image = $postal_code_query['profile_image'];
							
							$complete_profile = 'Yes';
						}
						else{
								$postal_code = "";
								$profile_image = $UserData['profile_image'];
								$complete_profile = 'No';
						}
						
						
						
						//// Average Rating of student_date_time_offer_confirmation
					
					
						$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$UserData['user_id']."' ");
						
						
						
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
					
					
					
					
							
							//print_r($UserData);
							
							////////////
							
							
							
							
							$resultData = array('status' => true, 'message' => 'Registration success.' , 'Access_Token' => $UserData['accessToken'], 'Device_Token' => $UserData['device_token'], 'user_id' => $UserData['user_id'], 'first_name' => $UserData['first_name'], 'last_name' => $UserData['last_name'], 'user_type' => $UserData['user_type'], 'postal_code' => $postal_code, 'profile_image' => $profile_image, 'complete_profile' => $complete_profile, 'Mobile' => $UserData['mobile'], 'Average_rating' => $avg_rating );
									
						}
					
					/////
					
					
							
				}
				
				
			}
			else{
				
				$resultData = array('status' => false, 'message' => 'Check passive values.');
		
			}				
			
		  
		  
		}
		else{
			
			$resultData = array('status' => false, 'message' => 'Email id and User type can not blank', 'user_id' => $user_last_id, 'user_type' => $_POST['user_type'] );
		}
		
					
			echo json_encode($resultData);
			
?>