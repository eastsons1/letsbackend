<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');
   


  $user_login_id = $_POST['user_login_id'];
  
  $user_type = $_POST['user_type'];
 
  
  
  if($user_login_id != "" && $user_type !="" && $user_type == "I am an Educator")
  {
	  $check = $conn->query("SELECT * FROM tbl_user_suspended WHERE user_id = '".$user_login_id."' and user_type = '".$user_type."' ");
  
	  if(mysqli_num_rows($check)>0)
	  {
		  
		  $del = $conn->query("DELETE FROM `tbl_user_suspended` WHERE user_id = '".$user_login_id."' and user_type = '".$user_type."' " );
		  
		  
		  
		  
		  $update_details = mysqli_fetch_array($conn->query("SELECT * FROM user_info WHERE user_id = '".$user_login_id."' and user_type = '".$user_type."' "));
					
			  $T_sql = $conn->query("SELECT * FROM user_tutor_info WHERE user_id = '".$user_login_id."'  "); 		
			 
				if(mysqli_num_rows($T_sql)>0)
				{
					$tutor_details = mysqli_fetch_array($T_sql);
					
					$complete_profile = 'Yes';
				}
				else{
					
					$complete_profile = 'No';
				}	
					
					
			  
				///check suspended accound
		
				$check_sus = $conn->query("SELECT * FROM tbl_user_suspended WHERE user_id = '".$user_login_id."' and user_type = '".$user_type."' and account_suspended = 'suspended' ");
			
				if(mysqli_num_rows($check_sus) > 0)
				{
					$AccountType = 'suspended';
				}
				else{
					$AccountType = 'active';	
				}
				
				
				
				//// Average Rating of student_date_time_offer_confirmation
					
					
					$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$user_login_id."' ");
					
					
					
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
		  
		  
		  
		 
		  if($del)
		  {
			  $resultData = array('Status' => true, 'Message' => 'Account Activated Successfully.' , 'Access_Token' => $update_details['accessToken'], 'Device_Token' => $update_details['device_token'], 'user_id' => $update_details['user_id'], 'first_name' => $update_details['first_name'], 'last_name' => $update_details['last_name'], 'user_type' => $update_details['user_type'], 'postal_code' => $tutor_details['postal_code'], 'profile_image' => $update_details['profile_image'], 'complete_profile' => $complete_profile, 'Mobile' => $update_details['mobile'], 'Average_rating' => $update_details['mobile'], 'AccountType' => $AccountType);
		  }
		  else
		  {
			  $resultData = array('Status' => false, 'Message' => 'Execution Error' );
		  }
	  
	  }
	else
	{
		$resultData = array('Status' => false, 'Message' => 'Record Not Found.');
	}	
  
  }
  else
  {
	  $resultData = array('Status' => false, 'Message' => 'User Login Id, User Type Can Not Blank And User Type Must Be Tutor.');
  }
  
  
  echo json_encode($resultData);
  

?>