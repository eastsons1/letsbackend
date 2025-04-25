<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
		if($_POST['tutor_id'] !="" && $_POST['student_id'] !="" && $_POST['tutor_tution_offer_amount_type'] !="" && $_POST['tutor_tution_offer_amount'] !="" && $_POST['amount_negotiate_by_student'] !="")
		{
	
	
			$query = "SELECT * FROM tutor_booking_process where tutor_id = '".$_POST['tutor_id']."' and student_id = '".$_POST['student_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."' and tutor_tution_offer_amount = '".$_POST['tutor_tution_offer_amount']."'  ";
					
				
			$result = $conn->query($query) or die ("table not found");
			$numrows = mysqli_num_rows($result);
			
			
			if($numrows > 0)
			{
				

				/// Record deleted
				
				 $sql = $conn->query("UPDATE tutor_booking_process SET amount_negotiate_by_student = '".$_POST['amount_negotiate_by_student']."' WHERE tutor_id = '".$_POST['tutor_id']."' and student_id = '".$_POST['student_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."' and tutor_tution_offer_amount = '".$_POST['tutor_tution_offer_amount']."'  ");
				
				
				
				if($sql)
				{
					$resultData = array('status' => true, 'message' => 'Record Updated Successfully.', 'amount_negotiate_by_student' => $_POST['amount_negotiate_by_student'] );
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
			
			$resultData = array('status' => false, 'message' => 'Tutor id, Student id, Tutor Tution Offer Amount Type, Tutor Tution Offer Amount and Amount Negotiate By Student can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>