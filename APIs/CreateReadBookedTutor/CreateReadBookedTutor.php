<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


$tutor_booking_process_id  = $_POST['tutor_booking_process_id'];
//$readUnreadTag = $_POST['readUnreadTag'];

 if($tutor_booking_process_id != "" )
 {
	$chk = $conn->query("SELECT * FROM tutor_booking_process WHERE tutor_booking_process_id = '".$tutor_booking_process_id."'   ");
 
	if(mysqli_num_rows($chk)>0)
	{
		
		$chk_data = mysqli_fetch_array($chk);
		
		if($chk_data['readUnreadTag']=='unread' || $chk_data['readUnreadTag']=='')
		{
			$add_read = $conn->query("UPDATE tutor_booking_process SET readUnreadTag = 'read' WHERE tutor_booking_process_id = '".$tutor_booking_process_id."'  ");
		
			if($add_read)
			{
				$resultData = array('status' => true, 'message' => 'Booking marked read successfully.');
			}
			else{
				$resultData = array('status' => false, 'message' => 'Booking not marked.');
			}
		}
		else{
			$resultData = array('status' => false, 'message' => 'Booking already read marked.');
		}
		
	}
	else
	{
		$resultData = array('status' => false, 'message' => 'No record found.');
	}
	
 
 }
 else
 {
	$resultData = array('status' => false, 'message' => 'Please check the passive values.' );
 }

	echo json_encode($resultData);

?>