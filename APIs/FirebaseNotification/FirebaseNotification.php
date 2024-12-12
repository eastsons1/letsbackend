<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
 
 function sendPushNotification($to = '', $data = array()){
    
        $api_key = 'AAAAf0sjSUk:APA91bEZkNVyHVbEVqpwegNX0QnJnh-ncfn3Lhq21NZVXyQmFcD3eApAnOoaVAlfxFJnUX2p1co4d5kTgLh_rVVmTnGIx8XG2cNXEzBtQDcfOGhNpkG3FoQhaLEm5XZNLIVWDPsnH249';
        $fields = array('to' => $to, 'notification' => $data);
    
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
        );
        $url = 'https://fcm.googleapis.com/fcm/send';
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
    
    
    
    
    $to = 'eVYV3gdPTciJA835wuv9HC:APA91bF2IGKxtyfrp5b6PSScec5OCvWr3kWzd20LrXmW92-F6Lbf3Zl4lM5NKlZtdd7lcbDkT5H6U_IJxoRATVdi826Y7iPIOYrdIHFzVOrqyQwlXiwAShIh3o1z2CIWclHetLN-7yPU'; //Device token 
    // You can get it from FirebaseInstanceId.getInstance().getToken();
   
	
	/// Fetch Data from Database
	
		$offer_status_sql = $conn->query("select tutor_booking_process_id,student_id,tutor_id,offer_status from tutor_booking_process order by tutor_booking_process_id DESC");
		
		if(mysqli_num_rows($offer_status_sql)>0)
		{
		
			$push_notify_array = array();
			while($offer_status = mysqli_fetch_assoc($offer_status_sql))
			{
				$push_notify_array[] = $offer_status;
			}


			/**
			   $message = array(
				'title' => 'Hi',
				'body' => 'I am pushpendra');
				
				echo sendPushNotification($to, $message);
				**/
			

			if(!empty($push_notify_array))
			{
				 sendPushNotification($to, $push_notify_array);
				
				$resultData = array('status' => true, 'message' => 'Notification Send Successfully.');
			}
			else			
			{
				$resultData = array('status' => false, 'message' => 'No Record Found.');
			}	
	
		}
		else			
		{
			$resultData = array('status' => false, 'message' => 'No Record Found.');
		}
		
		
		echo json_encode($resultData);
	
	?>