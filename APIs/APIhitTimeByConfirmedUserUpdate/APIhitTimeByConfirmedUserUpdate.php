<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
		if($_POST['tutor_booking_process_id'] !="")
		{
	
			$Query_Chk = $conn->query("SELECT * FROM tutor_booking_process WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' ");
			
		if(mysqli_num_rows($query_chk)>0)
		{	
				
	
			$query = $conn->query("UPDATE tutor_booking_process SET api_hit_date_by_confirmed_user = '' WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' ");
					
																				
			if($query)
			{
				$resultData = array('status' => true, 'message' => 'Time has been updated.');
			}
			else
			{
				$resultData = array('status' => false, 'message' => 'Execution error.');
			}
		}	
		else
		{
			$resultData = array('status' => false, 'message' => 'No record found.');
		}		

		}
		else{
			
			$resultData = array('status' => false, 'message' => 'Tutor booking process id can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>