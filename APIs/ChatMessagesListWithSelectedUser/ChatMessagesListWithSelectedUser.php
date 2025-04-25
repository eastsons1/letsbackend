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
		
		 $added_user_ids = array();
		
		
		if($sender_id !="" && $chat_with_user_id !="" )
		{
		
		
		///check user start
			$sql_cchk = mysqli_fetch_array($conn->query("SELECT user_type,user_id FROM user_info WHERE user_id = '".$sender_id."' or user_id = '".$chat_with_user_id."'  "));
			
			if($sql_cchk['user_type']=="I am an Educator")
			{
				$logged_in_sender_user = 'Tutor';
				$identity_user = $sql_cchk['user_id'];
			}
			
			if($sql_cchk['user_type']=="I am looking for a Tutor")
			{
				$logged_in_sender_user = 'Student';
				$identity_user = $sql_cchk['user_id'];
			}
			
			
			if($sql_cchk['user_type']=="Admin")
			{
				$logged_in_sender_user = 'Admin';
				$identity_user = $sql_cchk['user_id'];
			}
			
			//echo $logged_in_sender_user;
			//echo $identity_user;
			
			/// check user end
			
			
		
			
				///Sender and receiver All Chat Messages
				$send_receiver_message_array = array();
				
				
				/**
				$sql_m = $conn->query("SELECT * FROM chatrooms WHERE 
    
											(
												loggedIn_user_id LIKE '%".$sender_id."%' 
												OR loggedIn_user_id LIKE '%".$chat_with_user_id."%' 
											)
											AND (
												chat_userid LIKE '%".$chat_with_user_id."%' 
												OR chat_userid LIKE '%".$sender_id."%' 
											)
										ORDER BY created_on DESC");     
										
										**/
										
										
				$sql_m = $conn->query("SELECT * FROM chatrooms WHERE 
    
											(
												loggedIn_user_id = '".$sender_id."' 
												OR loggedIn_user_id = '".$chat_with_user_id."' 
											)
											AND (
												chat_userid = '".$chat_with_user_id."' 
												OR chat_userid = '".$sender_id."' 
											)
										ORDER BY created_on DESC");						
				
				
				if(mysqli_num_rows($sql_m)>0)
				{
				
				
				while($send_receive_messages = mysqli_fetch_array($sql_m))
				{
					
					
					
					if($logged_in_sender_user != 'Admin')
					{
					
					
					/// user details start
					$user_array = array();
					
					if($logged_in_sender_user == 'Tutor')
					{
					
						$user_details_sql = $conn->query("SELECT info.first_name,info.last_name,Tinfo.user_id,Tinfo.profile_image FROM user_tutor_info as Tinfo INNER JOIN user_info as info ON Tinfo.user_id = info.user_id  ");
						
						$nameD = mysqli_fetch_array($conn->query("SELECT * FROM user_tutor_info as Tinfo INNER JOIN user_info as info ON Tinfo.user_id = info.user_id WHERE info.user_id = '".$send_receive_messages['loggedIn_user_id']."' "));
						$user_D = $nameD['first_name'].' '.$nameD['last_name'];
						$logged_in_sender_userT = 'Tutor';
						
					
					}
					
					if($logged_in_sender_user == 'Student')
					{
						
						/**
						$chk_student = $conn->query("SELECT user_id FROM user_student_info WHERE user_id = '".$send_receive_messages['loggedIn_user_id']."' ");
						
						if(mysqli_num_rows($chk_student)>0)
						{
							$user_details_sql = $conn->query("SELECT info.first_name,info.last_name,Sinfo.user_id,Sinfo.profile_image FROM user_student_info as Sinfo INNER JOIN user_info as info ON Sinfo.user_id = info.user_id  ");
						
							$nameD = mysqli_fetch_array($conn->query("SELECT info.first_name,info.last_name,Sinfo.user_id,Sinfo.profile_image FROM user_student_info as Sinfo INNER JOIN user_info as info ON Sinfo.user_id = info.user_id WHERE info.user_id = '".$send_receive_messages['loggedIn_user_id']."' "));
							$user_D = $nameD['first_name'].' '.$nameD['last_name'];
							$logged_in_sender_userT = 'Student';
						
						
						}
						else{
							**/
							
							$user_details_sql = $conn->query("SELECT * FROM user_info ");
							
							$nameD = mysqli_fetch_array($conn->query("SELECT first_name,last_name,profile_image FROM user_info WHERE user_id = '".$send_receive_messages['loggedIn_user_id']."' "));
							
							
							$user_D = $nameD['first_name'].' '.$nameD['last_name'];
							$logged_in_sender_userT = 'Student';
													
						//}
						
						
						
					}
					
					
					
					
					
					//echo $logged_in_sender_user.'==';
					
					
					while($user_details_Data = mysqli_fetch_array($user_details_sql))
					{
						
						$pro_img = mysqli_fetch_array($conn->query("SELECT DISTINCT Tinfo.profile_image,Tinfo.tutor_code,Tinfo.flag FROM user_tutor_info as Tinfo INNER JOIN user_info as info ON Tinfo.user_id = info.user_id WHERE info.user_id = '".$send_receive_messages['loggedIn_user_id']."' "));
						
						$profile_img = $pro_img['profile_image'];
						
						
						
							
							$user_array = array(
													'_id' => $send_receive_messages['loggedIn_user_id'],
													'name' => $user_D,
													'avatar' => $profile_img
													
											   );
						
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
				else{
					$resultData = array('status' => false , 'message' => 'No record found.' );
			
					
				}
				
				
				
				
				
				
				
				
				
				///////////// For admin start //////////////
				
				
				if($logged_in_sender_user == 'Admin')
				{
					//print_r($added_user_ids);
					
					
					//$added_user_ids[] = array($sender_id,$chat_with_user_id);	
					
					 //if($sender_id == $send_receive_messages['loggedIn_user_id'] || $chat_with_user_id == $send_receive_messages['loggedIn_user_id']) 
					 if(in_array($send_receive_messages['loggedIn_user_id'], array($sender_id, $chat_with_user_id)))
					 {
					
					
					
					/// user details start
					$user_array = array();
					
					
					
					
					
					if($logged_in_sender_user == 'Admin')
					{
							
							$user_details_sql = $conn->query("SELECT * FROM user_info ");
							
							$nameD = mysqli_fetch_array($conn->query("SELECT first_name,last_name,profile_image FROM user_info WHERE user_id = '".$send_receive_messages['loggedIn_user_id']."' "));
							
							
							$user_D = $nameD['first_name'].' '.$nameD['last_name'];
							$logged_in_sender_userT = 'Admin';
							
						
					}
					
					
					//echo $logged_in_sender_user.'==';
					
					
					while($user_details_Data = mysqli_fetch_array($user_details_sql))
					{
						
						$pro_img = mysqli_fetch_array($conn->query("SELECT DISTINCT Tinfo.profile_image,Tinfo.tutor_code,Tinfo.flag FROM user_tutor_info as Tinfo INNER JOIN user_info as info ON Tinfo.user_id = info.user_id WHERE info.user_id = '".$send_receive_messages['loggedIn_user_id']."' "));
						
						$profile_img = $pro_img['profile_image']; 
						
						
							
						$user_array = array(
												'_id' => $send_receive_messages['loggedIn_user_id'],
												'name' => $user_D,
												'avatar' => $profile_img
												
										   );
						
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
				else{
					$resultData = array('status' => false , 'message' => 'No record found.' );
			
					
				}
												  
												  
				}
				else{
					$resultData = array('status' => false , 'message' => 'No record found.' );
			
					
				}
				
				
				////////////for admin end




				
												  
				}
				
				
				}
				else{
					$resultData = array('status' => false , 'message' => 'No record found.' );
			
					
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