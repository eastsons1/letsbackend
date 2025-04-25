<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
 $user_id = $_POST['user_id'];

if($user_id != "")
{
	$sql = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$user_id."' ");
	
	if(mysqli_num_rows($sql)>0)
	{
		$add_notifcations = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$user_id."'  order by id desc ");
		
		$add_notifcations_List_arr = array();
		while($add_notifcations_List = mysqli_fetch_assoc($add_notifcations))
		{
			$add_notifcations_List_arr[] = $add_notifcations_List;
		}
	
	
		if(!empty($add_notifcations_List_arr))
		{
			$resultSet = array('status' => true, 'Output' => $add_notifcations_List_arr );
		}
	
	}
	else{
		$resultSet = array('status' => false, 'message' => 'Record not found.');
	}
}
else
{
	$resultSet = array('status' => false, 'message' => 'User id can not blank.');
} 

  echo json_encode($resultSet);
	
	
	
?>