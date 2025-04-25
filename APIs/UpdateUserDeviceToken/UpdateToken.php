<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
	$user_id = $_POST['user_id'];
	$new_device_token = $_POST['new_device_token'];
	//$old_device_token = $_POST['old_device_token'];
	
	$chk_user_id = $conn->query("select device_token from user_info where user_id = '".$user_id."'  ");
	
	if(mysqli_num_rows($chk_user_id)>0)
	{
	
	
		if($new_device_token !="")	
		{
	
			
			$TokenUpdate = $conn->query("UPDATE user_info SET device_token = '".$new_device_token."' WHERE user_id = '".$user_id."' ");
			
			if($TokenUpdate)
			{
				$resultData = array('status' => true, 'message' => 'User token updated successfully. ');
			}
			else
			{
				$resultData = array('status' => false, 'message' => 'User token not updated. ');
			}
			
		
	
	
		}
		else{
			$resultData = array('status' => false, 'message' => 'New Device Token can\'t blank.');
		}


	}
	else
	{
		$resultData = array('status' => false, 'message' => 'User id can\'t blank');
	}
	
	
	
	

	
		echo json_encode($resultData);
					
			
?>