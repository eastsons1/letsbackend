<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
		$user_id_to_send_notification = $_POST['user_id_to_send_notification'];
		
	
		if($user_id_to_send_notification !="" && $_POST['tutor_tution_offer_amount_type'] !="" && $_POST['tutor_booking_process_id'] !="" && $_POST['negotiateby'] !="")
		{
			
			/// For Student update amount
			if($_POST['student_id'] !="" && $_POST['amount_negotiate_by_student'] !="" && $_POST['negotiate_by_student_amount_type'] !="" && $_POST['negotiateby'] !="")
			{
		
		
				 $query = "SELECT * FROM tutor_booking_process where student_id = '".$_POST['student_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."' and tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' ";
						
					
				$result = $conn->query($query) or die ("table not found");
				$numrows = mysqli_num_rows($result);
				
				
				
				 $tutor_idVSql = mysqli_fetch_array($result);
						
				 $tutor_idV = $tutor_idVSql['tutor_id'];
				 
				 
				 $sql_token = $conn->query("SELECT device_token FROM user_info WHERE user_id = '".$user_id_to_send_notification."' ");
				 
				 $device_token = mysqli_fetch_array($sql_token);
					
				 $to = $device_token['device_token']; //'fGHmYdK5RumJLGfPQnPjdK:APA91bFMB09skbnDNFqTJ5IKX97jBTLvLETIwtXDYSVGsaHnsPyRHCmNYzta_ePnN-RGYnT5FlEMBpo9aEOM9DspoFGYVXVGvm5T7qkprexS2yVnz83RwQgDR9rOW1AL425aIlJiWVc7'; // Replace with your device token
	
				
				if($numrows > 0)
				{
					

					/// Record updated
					
					 $sql = $conn->query($aa="UPDATE tutor_booking_process SET amount_negotiate_by_student = '".$_POST['amount_negotiate_by_student']."', negotiate_by_student_amount_type = '".$_POST['negotiate_by_student_amount_type']."', negotiateby = '".$_POST['negotiateby']."'  WHERE student_id = '".$_POST['student_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."' and tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."'  ");
					
					//echo $aa;
					
					if($sql)
					{
						
						//######### SEND notification start
						
						function sendPushNotification($to = '', $data = array()) {
						$api_key = 'AAAAf0sjSUk:APA91bFcxtNxUFAm-5o_52jNXqoFjlqimXQanGi0zyaEDiSfSiYW7iT1cm0s0Bm5Qx8lur1jRZSi_qfbUa3OvSo51cu0_hvgMj_efnbjlFikJDRsFreSIymliWgIdPUz323oMSKvUMST'; // Replace with your FCM server key
						$fields = array('to' => $to, 'notification' => $data);
						$headers = array(
							'Content-Type: application/json',
							'Authorization: key=' . $api_key
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

					//$to = 'fGHmYdK5RumJLGfPQnPjdK:APA91bFMB09skbnDNFqTJ5IKX97jBTLvLETIwtXDYSVGsaHnsPyRHCmNYzta_ePnN-RGYnT5FlEMBpo9aEOM9DspoFGYVXVGvm5T7qkprexS2yVnz83RwQgDR9rOW1AL425aIlJiWVc7'; // Replace with your device token

					$message = array(
						'title' => 'Payment offer',
						'body' => 'Client has made you a fee offer'
					);
					
					if(sendPushNotification($to, $message))  // Output the result of sending the notification
					{
						$notify = 'Notification sent successfully.';
					}
					else{
						
						$notify = 'Notification did not send';
					}
	
						/**
						//############ SEND notification end
						**/
						
						
						
						$resultData = array('status' => true, 'message' => 'Record Updated Successfully.', 'amount_negotiate_by_student' => $_POST['amount_negotiate_by_student'], 'notify' => $notify );
					
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
					
					
				$state = 1;	

			}
			else{
				
				if($state !=2)
				{
				
					$resultData = array('status' => false, 'message' => 'Student id, Amount negotiate by student and Negotiate by can\'t be blank.');
				}
			}
			
			
			
			
			/// For tutor update amount
			if($_POST['tutor_id'] !="" && $_POST['amount_negotiate_by_tutor'] !="" && $_POST['negotiate_by_tutor_amount_type'] !="" && $_POST['negotiateby'] !="" )
			{
		
		
				 $query = "SELECT * FROM tutor_booking_process where tutor_id = '".$_POST['tutor_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."' and tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' ";
						
					
				$result = $conn->query($query) or die ("table not found");
				$numrows = mysqli_num_rows($result);
				
				
				if($numrows > 0)
				{
					

					/// Record updated
					
					 $sql = $conn->query("UPDATE tutor_booking_process SET amount_negotiate_by_tutor = '".$_POST['amount_negotiate_by_tutor']."', negotiate_by_tutor_amount_type = '".$_POST['negotiate_by_tutor_amount_type']."' , negotiateby = '".$_POST['negotiateby']."' WHERE tutor_id = '".$_POST['tutor_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."' and tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."'  ");
					
					
					if($sql)
					{
						$resultData = array('status' => true, 'message' => 'Record Updated Successfully.', 'amount_negotiate_by_tutor' => $_POST['amount_negotiate_by_tutor'] );
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
					
					
					$state = 2;	

			}
			else{
				
				if($state !=1)
				{
				
					$resultData = array('status' => false, 'message' => 'Tutor id, Amount negotiate by tutor Negotiate by can\'t be blank.');
				}
			}


			
		
		
		}
		else{
			
			
			
			$resultData = array('status' => false, 'message' => 'user_id_to_send_notification, Tutor Tution Offer Amount Type, Tutor booking process id and Negotiate by can\'t be blank.');
		}
		
		
		
		
			
					
			
							
				echo json_encode($resultData);
				
					
			
?>