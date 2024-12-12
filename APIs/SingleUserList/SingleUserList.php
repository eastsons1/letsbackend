<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


$logged_in_user_id = $_POST['logged_in_user_id'];

if($logged_in_user_id != "")
{
	$sql = $conn->query("SELECT * FROM user_info WHERE user_id = '".$logged_in_user_id."' ");

	if(mysqli_num_rows($sql)>0)
	{
	
		$data_arr = array();
		
	  while($data = mysqli_fetch_assoc($sql))
	  {
		$data_arr[] = $data;
	  }
	  
	  if(!empty($data_arr))
	  {
			$resultData = array('status' => true, 'Output' => $data_arr );
	  }
	  else{
	  
		$resultData = array('status' => false, 'message' => 'No record found.');
	  }
	  
	  
	}
	else
	{
		$resultData = array('status' => false, 'message' => 'No record found.');
	}
	
}
else
{
	$resultData = array('status' => false, 'message' => 'User id can not blank.');
}

 echo json_encode($resultData);

?>