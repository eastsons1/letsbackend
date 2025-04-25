<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	

		if($_GET['tutor_booking_process_id'] != "" && $_GET['tutor_id'] !="" && $_GET['student_id'] !=""  && $_GET['offer_status'] !="" )
		{

			
	
	
			$query = "SELECT * FROM tutor_booking_process where tutor_booking_process_id = '".$_GET['tutor_booking_process_id']."' and tutor_id = '".$_GET['tutor_id']."' and student_id = '".$_GET['student_id']."'   ";
					
				
			$result = $conn->query($query) or die ("table not found");
			$numrows = mysqli_num_rows($result);
			
			
			if($numrows > 0)
			{
				
				/// Record deleted
				
				if($_GET['offer_status']=="Accept")
				{
					$tutor_booking_status = 1;
				}
				if($_GET['offer_status']=="Reject")
				{
					$tutor_booking_status = 0;
				}
				
				
				 $sql = $conn->query("UPDATE tutor_booking_process SET tutor_booking_status  = '".$tutor_booking_status."' WHERE tutor_booking_process_id = '".$_GET['tutor_booking_process_id']."' and tutor_id = '".$_GET['tutor_id']."' and student_id = '".$_GET['student_id']."'  ");
				
				if($sql)
				{
					$resultData = array('status' => true, 'message' => 'Offer Updated Successfully.', 'offer_status' => $_GET['offer_status'] );
				}
				else			
				{
					$resultData = array('status' => false, 'message' => 'No Record Found.');
				}				
				
				
			}
			else 
			{
				//$message1="Email Id Or Mobile Number not valid !";
				$resultData = array('status' => false, 'message' => 'No Record Found. Check Passing Values.');
			}


			
				

		}
		else{
			
			$resultData = array('status' => false, 'message' => 'Tutor id, Student id, Tutor booking process id, Offer Status(Accept/Reject) can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>