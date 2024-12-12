<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


 $logged_in_user_id = $_POST['logged_in_user_id'];
 $user_type = $_POST['user_type'];
 
 if($logged_in_user_id != "" && $user_type != "")
 {
 
	$sql = $conn->query("SELECT * FROM user_info WHERE user_id = '".$logged_in_user_id."' ");
	
	if(mysqli_num_rows($sql)>0)
	{
 
		$switch_user = $conn->query("UPDATE user_info SET user_type = '".$user_type."' WHERE user_id = '".$logged_in_user_id."' ");	
		
		if($switch_user)
		{
			
			///Get Postal code and profile_image
					$ssqql = $conn->query("Select user_id,postal_code,profile_image From user_tutor_info WHERE user_id = '".$logged_in_user_id."' ");
					
					
					if(mysqli_num_rows($ssqql)>0)
					{
						$postal_code_query = mysqli_fetch_array($ssqql);
						$postal_code = $postal_code_query['postal_code'];
						$profile_image = $postal_code_query['profile_image'];
						
						$complete_profile = 'Yes';
						
						//// Average Rating of student_date_time_offer_confirmation
					
					
							$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$postal_code_query['user_id']."' ");
							
							
							
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
						
						
						
					}
					else{
							$postal_code = "";
							$profile_image = "";
							$complete_profile = 'No';
					}
					
					
					
					
					
					/// user details
					
					$User_Detail = mysqli_fetch_array($sql);
					
					$profile_imageSTU = $User_Detail['profile_image'];
					
					
					
					
					if($User_Detail['user_type']=="I am an Educator")
					{
						
						
						$postal_codeV =  $postal_code;
						$profile_imageV = $profile_image;
					}
					if($User_Detail['user_type']=="I am looking for a Tutor")
					{
						$postal_codeV = "";
						$profile_imageV = $profile_imageSTU;
					}
					
					
					
					
					
					
			
			
			$resultData = array('status' => true, 'message' => 'User roll has been switched successfully.', 'user_id' => $logged_in_user_id, 'complete_profile' => $complete_profile , 'Access_Token' => $User_Detail['accessToken'], 'Device_Token' => $User_Detail['device_token'], 'user_id' => $User_Detail['user_id'], 'first_name' => $User_Detail['first_name'], 'last_name' => $User_Detail['last_name'], 'user_type' => $User_Detail['user_type'], 'postal_code' => $postal_codeV, 'profile_image' => $profile_imageV, 'complete_profile' => $complete_profile, 'Mobile' => $User_Detail['mobile'], 'Average_rating' => $avg_rating);
		}
		else
		{
			$resultData = array('status' => false, 'message' => 'User roll switching issue.');
		}
		
	}
	else{
		$resultData = array('status' => false, 'message' => 'No record found.');
	}		
 }
 else{
	 $resultData = array('status' => false, 'message' => 'Please check passive values. ');
 }
 
  echo json_encode($resultData);

?>