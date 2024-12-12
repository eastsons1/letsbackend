<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
		$sender_id =  $_POST['logged_in_user_id'];	
		$chat_with_user_id = $_POST['chat_with_user_id'];
		$message = $_POST['message'];
		$dateTime = date('Y-m-d H:i:sP');
		
		if($sender_id !="" && $chat_with_user_id !="" && $message !="")
		{
		
			$sql_add = $conn->query("INSERT INTO chatrooms SET loggedIn_user_id = '".$sender_id."' , chat_userid = '".$chat_with_user_id."', msg = '".$message."' , status = 'Send' , created_on = '".$dateTime."' ");
			
			if($sql_add)
			{
				
			
				///Sender and receiver All Chat Messages
				$send_receiver_message_array = array();
				
				
				$sql_m = $conn->query("SELECT * FROM chatrooms WHERE loggedIn_user_id = '".$sender_id."' or chat_userid = '".$sender_id."' order by created_on ASC ");
				
				while($send_receive_messages = mysqli_fetch_array($sql_m))
				{
					$send_receiver_message_array[] = array(
													'id' => $send_receive_messages['id'],
													'sender_user_id' => $send_receive_messages['loggedIn_user_id'],
													'receiver_user_id' => $send_receive_messages['chat_userid'],
													'send_message' => $send_receive_messages['msg'],
													'status' => $send_receive_messages['status'],
													'created_on' => $send_receive_messages['created_on']
					
												  );
				}
				
				
				
				
				
			
				if(!empty($send_receiver_message_array))
				{
					$resultData = array('status' => true , 'message' => 'Message sent successfully.', 'Output' => $send_receiver_message_array );
			
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