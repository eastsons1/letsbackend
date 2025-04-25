<?php
	error_reporting(0);
	header('Content-Type: application/json; charset=utf-8');
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: PUT, GET, POST");

	require_once("config.php");
	
	header('content-type:application/json');



	$user_id = $_POST['user_id'];

 
	$sql = $conn->query("SELECT * FROM chatrooms WHERE loggedIn_user_id = '".$user_id."' ");

	if(mysqli_num_rows($sql)>0)
	{
		$update_rec = $conn->query("UPDATE chatrooms SET readUnreadMessageTag = 'read' WHERE loggedIn_user_id = '".$user_id."' ");
	
		if($update_rec)
		{
			$resultSet = array('status' => true, 'message' => 'Chat has been marked as read.');
		}
		else{
			$resultSet = array('status' => false, 'message' => 'Update Error.');
		}
	}
	else
	{
		$resultSet = array('status' => false, 'message' => 'No record found.');
	}
	
	
	echo json_encode($resultSet);

?>