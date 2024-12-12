<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
		
		$sql = $conn->query("SELECT user_type,user_id from user_info where user_type = 'Admin' ");
		
		$Admin_data = mysqli_fetch_array($sql);
		
		$Admin_data_array = array(
									'user_id' => $Admin_data['user_id'],
									'user_type' => $Admin_data['user_type']
			
								  );
		
		
		if(!empty($Admin_data_array))
		{
			$resultData = array('status' => true, 'Output' => $Admin_data_array);
		}
		else{
			
			$resultData = array('status' => false, 'message' => 'Can\'t display data. ');
		}	
							
			echo json_encode($resultData);
					
			
?>