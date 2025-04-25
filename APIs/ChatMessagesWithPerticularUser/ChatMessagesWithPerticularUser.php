<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");

header('content-type:application/json');

$sender_id =  $_POST['logged_in_user_id'];   

if($sender_id) {
    $user_array = array();
    $added_user_ids = array(); // Array to track added user IDs
	
	
	
	// Fetch logged-in user's role
	$logged_in_user_roll = mysqli_fetch_array($conn->query("SELECT user_type FROM user_info WHERE user_id = '".$sender_id."'"));

	// Ensure role is correctly retrieved
	$user_role = $logged_in_user_roll['user_type'];

	$sql_m = $conn->query("SELECT DISTINCT loggedIn_user_id, loggedIn_user_id_roll, chat_userid, chat_userid_roll, created_on, msg, readUnreadMessageTag 
							FROM chatrooms 
							WHERE ( (loggedIn_user_id = '".$sender_id."' AND loggedIn_user_id_roll = '".$user_role."' ) 
							OR (chat_userid = '".$sender_id."' AND chat_userid_roll = '".$user_role."')) 
							AND loggedIn_user_id_roll <> chat_userid_roll
							ORDER BY created_on DESC");

	
	
	
	
    while($send_receive_messages = mysqli_fetch_array($sql_m)) 
	{
		
		
		
        // Fetch user type
        $sql_cchk = mysqli_fetch_array($conn->query("SELECT user_type FROM user_info WHERE user_id = '".$send_receive_messages['loggedIn_user_id']."' OR user_id = '".$send_receive_messages['chat_userid']."'"));

        // Determine the type of user
        if($sql_cchk['user_type'] == "I am an Educator") {
            $logged_in_sender_user = 'Tutor';
        } elseif($sql_cchk['user_type'] == "I am looking for a Tutor") {
            $logged_in_sender_user = 'Student';
        }

        // Fetch user details
        $user_details_sql = $conn->query("SELECT * FROM user_info");

        while($user_details_Data = mysqli_fetch_array($user_details_sql)) {
            // Check if user ID is already added
            if(!in_array($user_details_Data['user_id'], $added_user_ids)) {
                if($user_details_Data['user_id'] == $send_receive_messages['chat_userid'] || $user_details_Data['user_id'] == $send_receive_messages['loggedIn_user_id']) {
                    if($sender_id != $user_details_Data['user_id']) {
                        $avatar = mysqli_fetch_array($conn->query("SELECT profile_image,tutor_code,flag,qualification FROM user_tutor_info WHERE user_id = '".$user_details_Data['user_id']."'"));

						$UserCode = $avatar['tutor_code'];
						$Flag = $avatar['flag']; 	
						
						//$Time =  date('h:i A', strtotime($send_receive_messages['created_on']));
						
						
						
						$timestamp = strtotime($send_receive_messages['created_on']); // Example input date string
						$Time = date("d-m-Y H:i", $timestamp);




						
						
						$unread_message = mysqli_fetch_array($conn->query("SELECT count(readUnreadMessageTag) FROM chatrooms WHERE loggedIn_user_id = '".$user_details_Data['user_id']."' "));
						
						 $unread_message['count(readUnreadMessageTag)'];
						

                        if($user_details_Data['user_type']=='Admin')
						{
							$first_name = 'Support'; 
							$last_name = '';
							$Qualification = '';
						}
						else{						
							$first_name = $user_details_Data['first_name'];
							
							$last_name = $user_details_Data['last_name'];
							
							$Qualification = $avatar['qualification'];
						}					
						
						
						/// total count Message
						
						$count_message = mysqli_fetch_array($conn->query("SELECT count(loggedIn_user_id) FROM chatrooms WHERE loggedIn_user_id = '".$user_details_Data['user_id']."' and readUnreadMessageTag = 'unread' "));
						
						$LoggedInUserUnreadCount =  $count_message['count(loggedIn_user_id)'];
						
						$count_message2 = mysqli_fetch_array($conn->query("SELECT count(loggedIn_user_id) FROM chatrooms WHERE loggedIn_user_id = '".$user_details_Data['user_id']."' and readUnreadMessageTag = 'unread' "));
						
						$LoggedInUserUnreadCount22 =  $count_message2['count(loggedIn_user_id)'];
						
                        $user_array[] = array(
                            '_id' => $user_details_Data['user_id'],
							'first_name' => $first_name,
							'last_name' => $last_name,
							'Qualification' => $Qualification,
                            'avatar' => $avatar['profile_image'],
							'UserCode' => $UserCode,
							'Flag' => $Flag,
							'Time' => $Time,
							'message' => $send_receive_messages['msg'],
							'readUnreadMessageTag' => $send_receive_messages['readUnreadMessageTag'],
                            'Total_unread_message' => $unread_message['count(readUnreadMessageTag)'],
							'LoggedInUserUnreadCount' => $LoggedInUserUnreadCount
							
                        );
                        // Add user ID to the tracking array
                        $added_user_ids[] = $user_details_Data['user_id'];
                    }
                }
            }
        }
    }

    if(!empty($user_array)) {
        $resultData = array('status' => true , 'message' => 'Chat Message List', 'Output' => $user_array );
    } else {
        $resultData = array('status' => false, 'message' => 'No record found.');
    }
} else {
    $resultData = array('status' => false, 'message' => 'Please check the passive values.');
}

echo json_encode($resultData);


?>