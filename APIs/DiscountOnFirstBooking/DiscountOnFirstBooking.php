<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	

/**
Discount calculation:-


Fee $50/hr
Frequency 4 times a week
Duration 3hrs each lesson

1 week = 4x3hrs = 12hrs
1 month = 4 weeks = (12x4)= 48hrs
1 month/4 weeks = 48 x $50 = $2400

Amount to Company without discount = $2400/2 = $1200

Discount = 10%

Save = 10% of $1200 = $120

Amount to Company with discount = $1200-$120 = $270



**/



$student_id = $_POST['student_id'];
$tutor_id = $_POST['tutor_id'];

if (!empty($student_id)) {
    $chk = $conn->query("
        SELECT * 
        FROM tutor_booking_process as process INNER JOIN tutor_booking_process_discount as chk_discont ON
		process.student_id = chk_discont.student_id
        WHERE 
            process.tutor_tution_offer_amount <> '' 
            AND process.acceptby <> '' 
            AND process.booked_date <> '' 
            AND process.tutor_booking_status = 'Accept' 
            AND process.offer_status = 'Accept' 
            AND process.student_date_time_offer_confirmation = 'Confirmed' 
            AND process.date_time_update_by <> '' 
            AND process.tutor_accept_date_time_status = 'Accept' 
            AND process.api_hit_date_by_confirmed_user <> '' 
            AND process.api_hit_time_by_confirmed_user <> '' 
			
            AND process.student_id = '".$conn->real_escape_string($student_id)."'
    ");

//echo mysqli_num_rows($chk);

   
		
        
		
		
		if(mysqli_num_rows($chk)==0)
		{
			
		 $chk2 = $conn->query("
        SELECT * 
        FROM tutor_booking_process 
        WHERE 
            tutor_tution_offer_amount <> '' 
            AND acceptby <> '' 
            AND booked_date <> '' 
            AND tutor_booking_status = 'Accept' 
            AND offer_status = 'Accept' 
            AND student_date_time_offer_confirmation = 'Confirmed' 
            AND date_time_update_by <> '' 
            AND tutor_accept_date_time_status = 'Accept' 
            AND api_hit_date_by_confirmed_user <> '' 
            AND api_hit_time_by_confirmed_user <> '' 
			
            AND student_id = '".$conn->real_escape_string($student_id)."'
    ");	
			
		$booking_data = mysqli_fetch_assoc($chk2);

        $Final_Fee = $booking_data['tutor_tution_offer_amount'];
        $tutor_duration_weeks = explode('lessons a week', $booking_data['tutor_duration_weeks']);
        $tutor_duration_hours = explode('hours a lesson', $booking_data['tutor_duration_hours']);

        $one_week_hours = (float)$tutor_duration_weeks[0] * (float)$tutor_duration_hours[0];
        $one_month_hours = $one_week_hours * 4;

         $Total_Fee_Of_Hours = $one_month_hours * $Final_Fee;
         $Amount_to_Company_without_discount = $Total_Fee_Of_Hours / 2;

         $record_no = mysqli_num_rows($chk);

        // First-time discount 10%
		
      
            $discount = 10; // Discount in %
            $Save = $Amount_to_Company_without_discount * ($discount / 100); // 10% savings
            $Amount_to_Company_with_discount = $Amount_to_Company_without_discount - $Save;

            $Discount_Data = array(
				'discount_type' => 'First discount',
                'discount' => $discount,
                'Save' => $Save,
                'Amount_to_Company_without_discount' => $Amount_to_Company_without_discount,
                'Amount_to_Company_with_discount' => $Amount_to_Company_with_discount
            );
       
		
		
		if($Amount_to_Company_with_discount != "" )
		{
			/**
			$update_discount = $conn->query($aa="UPDATE tutor_booking_process SET booking_discount = '10' 
								WHERE 
								tutor_tution_offer_amount <> '' 
								AND acceptby <> '' 
								AND booked_date <> '' 
								AND tutor_booking_status = 'Accept' 
								AND offer_status = 'Accept' 
								AND student_date_time_offer_confirmation = 'Confirmed' 
								AND date_time_update_by <> '' 
								AND tutor_accept_date_time_status = 'Accept' 
								AND api_hit_date_by_confirmed_user <> '' 
								AND api_hit_time_by_confirmed_user <> '' 
								AND booking_discount = 0
								AND student_id = '".$conn->real_escape_string($student_id)."'
								");
								
				**/

				$update_discount = $conn->query("INSERT INTO tutor_booking_process_discount SET student_id = '".$conn->real_escape_string($student_id)."', count_of_discount = 1	");	
								
			
			
			if($update_discount)
			{
				$resultSet = array('status' => true, 'message' => 'Success', 'Discount_Data' => $Discount_Data);
			}
		}
		else{
			$resultSet = array('status' => true, 'message' => 'No record for discount.');
		}

	} else {
        $resultSet = array('status' => false, 'message' => 'Record not found.');
    }

   
} else {
    $resultSet = array('status' => false, 'message' => 'Please check input values.');
}

echo json_encode($resultSet);
?>
