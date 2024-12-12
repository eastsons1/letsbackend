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
		//$message = $_POST['message'];
		$dateTime = date('Y-m-d H:i:sP');
		
		if($sender_id !="" && $chat_with_user_id !="" )
		{
		
		
		///check user start
			$sql_cchk = mysqli_fetch_array($conn->query("SELECT user_type FROM user_info WHERE user_id = '".$sender_id."'  "));
			
			if($sql_cchk['user_type']=="I am an Educator")
			{
				$logged_in_sender_user = 'Tutor';
			}
			
			if($sql_cchk['user_type']=="I am looking for a Tutor")
			{
				$logged_in_sender_user = 'Student';
			}
			
			
			/// check user end
			
			
		
			
				///Sender and receiver All Chat Messages
				$send_receiver_message_array = array();
				
				
				$sql_m = $conn->query("SELECT * FROM chatrooms WHERE loggedIn_user_id = '".$sender_id."' and chat_userid = '".$chat_with_user_id."'  order by created_on DESC ");
				
				while($send_receive_messages = mysqli_fetch_array($sql_m))
				{
					
					/// user details start
					$user_array = array();
					
					if($logged_in_sender_user == 'Tutor')
					{
					
						$user_details_sql = $conn->query("SELECT info.first_name,info.last_name,Tinfo.user_id,Tinfo.profile_image FROM user_tutor_info as Tinfo INNER JOIN user_info as info ON Tinfo.user_id = info.user_id  ");
					}
					
					if($logged_in_sender_user == 'Student')
					{
						$chk_student = $conn->query("SELECT user_id FROM user_student_info WHERE user_id = '".$sender_id."' ");
						
						if(mysqli_num_rows($chk_student)>0)
						{
							$user_details_sql = $conn->query("SELECT info.first_name,info.last_name,Sinfo.user_id,Sinfo.profile_image FROM user_student_info as Sinfo INNER JOIN user_info as info ON Sinfo.user_id = info.user_id  ");
						
						}
						else{
							$user_details_sql = $conn->query("SELECT * FROM user_info ");
													
						}
						
						
						
					}
					
					
					
					while($user_details_Data = mysqli_fetch_array($user_details_sql))
					{
						if($user_details_Data['user_id'] == $send_receive_messages['loggedIn_user_id'])
						{
							$name = $user_details_Data['first_name'].' '.$user_details_Data['last_name'];
							$user_array = array(
													'_id' => $user_details_Data['user_id'],
													'name' => $name,
													'avatar' => $user_details_Data['profile_image']
												  );
						}
					}
					/// user details end
					
					
					
					$send_receiver_message_array[] = array(
													'_id' => $send_receive_messages['id'],
													'text' => $send_receive_messages['msg'],
													'createdAt' => $send_receive_messages['created_on'],
													'user' => $user_array
													
												/**	'sender_user_id' => $send_receive_messages['loggedIn_user_id'],
													'receiver_user_id' => $send_receive_messages['chat_userid'],
													
													'status' => $send_receive_messages['status']  **/
													
					
												  );
				}
				
				
				
				
				
			
				if(!empty($send_receiver_message_array))
				{
					$resultData = array('status' => true , 'message' => 'Chat Messages List', 'Output' => $send_receiver_message_array );
			
				}
			
			
			
			
			
		}
		else
		{
			$resultData = array('status' => false, 'message' => 'Please check the passive values.');
		}		
	
	
	
				
							
			echo json_encode($resultData);
					
			
?>