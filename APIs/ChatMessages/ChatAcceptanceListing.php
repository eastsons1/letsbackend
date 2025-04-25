<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
		$sender_id =  $_POST['loggedIn_user_id'];	
		$chat_with_user_id = $_POST['chat_userid'];
		
		
		
		if($sender_id !="" && $chat_with_user_id !="" )
		{
			
			
			$sql_m = $conn->query("SELECT * FROM tbl_chatrooms_acceptance WHERE loggedIn_user_id = '".$sender_id."' AND chat_userid = '".$chat_with_user_id."' ");
				
			if(mysqli_num_rows($sql_m)>0)
			{
				$ChatAcceptanceListing_arr = array();
				
				while($ChatAcceptanceListing = mysqli_fetch_assoc($sql_m))
				{
					$ChatAcceptanceListing_arr[] =  $ChatAcceptanceListing;
				}
				
				
				if(!empty($ChatAcceptanceListing_arr))
				{
					$resultData = array('status' => true, 'Output' => $ChatAcceptanceListing_arr );
				}
				else{
					
					$resultData = array('status' => false, 'message' => 'No Record.');
				}
				
				
			}
			else{			
			
			
			
				$ChatAcceptanceListing_arr2[] = array(
				
													'loggedIn_user_id' => $sender_id,
													'chatUserAcceptance' => "false",
													'chat_userid' => $chat_with_user_id
				
													); 
			
				$resultData = array('status' => false, 'message' => 'Record not found.', 'Output' => $ChatAcceptanceListing_arr2 );
				
			}	
			
			
		}
		else{
			$resultData = array('status' => false, 'message' => 'Please check passive values.');
		}
	
				
							
			echo json_encode($resultData);
					
			
?>