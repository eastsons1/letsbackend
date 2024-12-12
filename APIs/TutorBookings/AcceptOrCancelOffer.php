<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
		if($_POST['tutor_id'] !="" && $_POST['student_id'] !="" && $_POST['tutor_tution_offer_amount_type'] !="" && $_POST['tutor_tution_offer_amount'] !="" && $_POST['amount_negotiate_by_tutor'] !="" && $_POST['amount_negotiate_by_student'] !="" && $_POST['offer_status'] !="")
		{
	
	
			$query = "SELECT * FROM tutor_booking_process where tutor_id = '".$_POST['tutor_id']."' and student_id = '".$_POST['student_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."' and tutor_tution_offer_amount = '".$_POST['tutor_tution_offer_amount']."' and amount_negotiate_by_tutor = '".$_POST['amount_negotiate_by_tutor']."' and amount_negotiate_by_student = '".$_POST['amount_negotiate_by_student']."'  ";
					
				
			$result = $conn->query($query) or die ("table not found");
			$numrows = mysqli_num_rows($result);
			
			
			if($numrows > 0)
			{
				
				/// Record deleted
				
				if($_POST['offer_status']=="Accept")
				{
					$tutor_booking_status = 1;
				}
				if($_POST['offer_status']=="Reject")
				{
					$tutor_booking_status = 0;
				}
				
				
				 $sql = $conn->query("UPDATE tutor_booking_process SET tutor_booking_status  = '".$tutor_booking_status."' WHERE tutor_id = '".$_POST['tutor_id']."' and student_id = '".$_POST['student_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."' and tutor_tution_offer_amount = '".$_POST['tutor_tution_offer_amount']."' and amount_negotiate_by_tutor = '".$_POST['amount_negotiate_by_tutor']."' and amount_negotiate_by_student = '".$_POST['amount_negotiate_by_student']."' ");
				
				if($sql)
				{
					$resultData = array('status' => true, 'message' => 'Offer Updated Successfully.', 'offer_status' => $_POST['offer_status'] , 'tutor_tution_offer_amount_type' => $_POST['tutor_tution_offer_amount_type'], 'offer_amount' => $_POST['tutor_tution_offer_amount'], 'amount_negotiate_by_tutor' => $_POST['amount_negotiate_by_tutor'], 'amount_negotiate_by_student' => $_POST['amount_negotiate_by_student'] );
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
			
			$resultData = array('status' => false, 'message' => 'Tutor id, Student id, Tutor Tution Offer Amount Type, Tutor Tution Offer Amount, Amount Negotiate By Tutor and Amount Negotiate By Student  can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>