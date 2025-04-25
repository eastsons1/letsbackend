<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
	
		if($_GET['tutor_booking_process_id'] !="" && $_GET['logged_in_user_id'] !="" )
		{
	
	
			 $query = "SELECT * FROM tbl_payment where tutor_booking_process_id = '".$_GET['tutor_booking_process_id']."' and logged_in_user_id = '".$_GET['logged_in_user_id']."' ORDER BY payment_id DESC ";
					
				
			$result = $conn->query($query) or die ("table not found");
			
			if(mysqli_num_rows($result)>0)
			{
				$result_data_arr = array();
				
				 while($result_data = mysqli_fetch_assoc($result))
				 {		
					$result_data_arr[] = $result_data;	 
				
				 }
				 
				 if(!empty($result_data_arr))
				 {
					 $resultData = array('status' => true, 'Output' =>  $result_data_arr);
				 }
				
					
			
			}
			else{
				$resultData = array('status' => false, 'message' => 'Record not found.');
			}
				

		}
		else{
			
			$resultData = array('status' => false, 'message' => 'Please check the passive values.');
		}	
							
			echo json_encode($resultData);
					
			
?>

