<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	 

	$tutor_id = $_GET['tutor_id'];

	if($tutor_id != "")
	{
		$sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$tutor_id."' ");
		
		if(mysqli_num_rows($sql)>0)
		{
			$Data_arr = array();
			
			while($Data = mysqli_fetch_assoc($sql))
			{
				$Data_arr[] =  $Data;
			}
			
			
			if(!empty($Data_arr))
			{
				$resultData = array('status' => true, 'Output' => $Data_arr);
			}
			else{
				$resultData = array('status' => false, 'message' => 'No record found.');
			}
			
		}
		else
		{
			$resultData = array('status' => true, 'message' => 'No record found.');
		}
	}
	else
	{
		$resultData = array('status'=> false, 'message' => 'Tutor id can not blank.');
	}


	echo json_encode($resultData);

?>