<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
		
		$chat_id = $_POST['chat_id'];
		
		if($chat_id !="")
		{
          
          $check_chatId = $conn->query("SELECT id FROM chatrooms WHERE id = '".$chat_id."' ");
          
          if(mysqli_num_rows($check_chatId)>0)
		  {
          
          
			$sql = $conn->query("SELECT * FROM chatrooms WHERE id = '".$chat_id."' and readUnreadMessageTag ='unread' ");
			
			if(mysqli_num_rows($sql)>0)
			{
				$update_user_chat = $conn->query("UPDATE chatrooms SET readUnreadMessageTag = 'read' WHERE id = '".$chat_id."'  ");
			
				if($update_user_chat)
				{
					$resultData = array('status' => true, 'message' => 'Record updated successfully.' ); 
				}
				else{
					$resultData = array('status' => false, 'message' => 'Error in record update.');
				}
			
			}
			else
			{
				$resultData = array('status' => false, 'message' => 'This chat is already read.');
			}
			
			
          
          
        }
		else
        {
          $resultData = array('status' => false, 'message' => 'Chat id does not exist.');
        }
          
		}
		else{
			$resultData = array('status' => false, 'message' => 'Chat id can\'t blank.');
		}
		
						
			echo json_encode($resultData);
					
			
?>