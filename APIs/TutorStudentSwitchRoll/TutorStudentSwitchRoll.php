<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
		$user_id    = 	$_GET['user_id'];
		$rollswitch = 	$_GET['RollSwitch'];
		$user_type  = 	$_GET['user_type'];
		
		if($user_id != "" && $rollswitch != "" && $user_type != "")
		{	
		
			if($user_type == 'tutor')
			{
				$Utype = 'I am an Educator';
				$SetUserTypeSession = 'student';
				
				$sql = $conn->query("UPDATE user_info SET user_type = '".$Utype."' WHERE user_id = '".$user_id."' ");
				
				if($sql)
				{
					$resultData = array('Status' => true, 'Message' => 'Student Roll Changed To Tutor.' );
				}
				else{
					$resultData = array('Status' => false, 'Message' => 'Roll Changed Error.');
				}
			}
			
			
			if($user_type == 'student')
			{
				$Utype = 'I am looking for a Tutor';
				$SetUserTypeSession = 'tutor';
				
				$sql = $conn->query("UPDATE user_info SET user_type = '".$Utype."' WHERE user_id = '".$user_id."' ");
				
				if($sql)
				{
					$resultData = array('Status' => true, 'Message' => 'Tutor Roll Changed To Student.');
				}
				else{
					$resultData = array('Status' => false, 'Message' => 'Roll Changed Error.');
				}
				
			}				
						
			echo json_encode($resultData);
					
		}	
?>