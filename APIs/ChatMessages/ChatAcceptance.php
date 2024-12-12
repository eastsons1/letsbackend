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
		
		$chatUserAcceptance = $_POST['chatUserAcceptance'];
		
		
		$dateTime = date('Y-m-d H:i:sP');
		
		//date_default_timezone_set('Asia/Kolkata');
		//$dateTime = date('Y-m-d H:i:sP', time());
		
		if($sender_id !="" && $chat_with_user_id !="" && $chatUserAcceptance !="" )
		{
			
			
			$sql_m = $conn->query("SELECT * FROM tbl_chatrooms_acceptance WHERE loggedIn_user_id = '".$sender_id."' AND chat_userid = '".$chat_with_user_id."' ");
				
			if(mysqli_num_rows($sql_m)>0)
			{
				$sql_add = $conn->query("UPDATE tbl_chatrooms_acceptance SET chatUserAcceptance = '".$chatUserAcceptance."' WHERE loggedIn_user_id = '".$sender_id."'  AND chat_userid = '".$chat_with_user_id."' ");
			}
			else{			
			
				$sql_add = $conn->query("INSERT INTO tbl_chatrooms_acceptance SET loggedIn_user_id = '".$sender_id."' , chat_userid = '".$chat_with_user_id."', chatUserAcceptance = '".$chatUserAcceptance."',  created_on = '".$dateTime."' ");
			}	
			
			if($sql_add)
			{
				
				
				
				///Sender and receiver All Chat Messages
				$send_receiver_message_array = array();
				
				$sql_m2 = $conn->query("SELECT * FROM tbl_chatrooms_acceptance WHERE loggedIn_user_id = '".$sender_id."' AND chat_userid = '".$chat_with_user_id."' ");
			
				
				while($send_receive_messages = mysqli_fetch_array($sql_m2))
				{
					
					
					$send_receiver_message_array[] = array(
													'chatrooms_acceptance_id' => $send_receive_messages['chatrooms_acceptance_id'],
													'loggedIn_user_id' => $send_receive_messages['loggedIn_user_id'],
													'chatUserAcceptance' => $send_receive_messages['chatUserAcceptance'],
													'chat_userid' => $send_receive_messages['chat_userid'],
													'created_on' => $send_receive_messages['created_on']
													
													
												
												  );
				}
				
				
				
				
				
			
				if(!empty($send_receiver_message_array))
				{
					$resultData = array('status' => true , 'Output' => $send_receiver_message_array );
			
				}
				                                                                                                                                                                                                     
			
			
			}
			else
			{ 
				$resultData = array('status' => false, 'message' => 'Execution Error.' ); 
			}
			
		}
		else
		{
			$resultData = array('status' => false, 'message' => 'Please check the passive values.');
		}		
	
	
	
				
							
			echo json_encode($resultData);
					
			
?>