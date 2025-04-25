<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


	$sql = $conn->query("SELECT * FROM tbl_rating order by rating_id DESC");

	if(mysqli_num_rows($sql)>0)
	{
		while($rating_list = mysqli_fetch_assoc($sql))
		{
			$rating_list_array[] = $rating_list;
		}
		
		
		if(!empty($rating_list_array))
		{
			$resultData = array('status' => true, 'Output' => $rating_list_array);
		}
		
		
	}
	else
	{
		$resultData = array('status' => false, 'message' => 'No record found.');
	}
	
	echo json_encode($resultData);

?>