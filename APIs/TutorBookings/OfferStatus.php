<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
	
	
	//// Notification start
	
			
		function base64UrlEncode($data) {
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
		}

		function createJWT($header, $payload, $privateKey) {
			$headerEncoded = base64UrlEncode(json_encode($header));
			$payloadEncoded = base64UrlEncode(json_encode($payload));

			// Combine header and payload to form the data to sign
			$signatureInput = $headerEncoded . '.' . $payloadEncoded;

			// Create the signature using the private key
			openssl_sign($signatureInput, $signature, $privateKey, 'sha256');

			// Encode signature to base64 URL-safe format
			$signatureEncoded = base64UrlEncode($signature);

			// Combine everything to form the JWT
			return $signatureInput . '.' . $signatureEncoded;
		}

		// Function to get the access token from Google OAuth 2.0 server
		function getAccessToken() {
			// Service account details
			$serviceAccountEmail = 'firebase-adminsdk-owdis@tutorapp-7522f.iam.gserviceaccount.com'; // Replace with your service account email
			$privateKey = "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCf8zAuesHZz7+h\n/Rz0DLbo6ScR4InXnhuz3R2pflzROAH2SNukxShYj+T6rLdL5TBPzOsTa0Gyfu3c\natsx9fbs/ZBEEBvq0FT4cAPJkA1HTYKRn2NhDaxslj4y+/6LWG7WnrODPZpnesqi\nyfaNM7BYp4xVLz1bjykMPZIa26DbuhzO2hb/BMqiYSkqTxX8ZJvPKXZUQkjGPNnu\nnAQwRnhBtNT2cozz+QA0TKR4E4kXHuFYX+vBTjrqIXRdRtmYgF8HSewTqBF1gzbo\n0yPa2OJq4azspQggEhFTVjkxd6rwDe/MPSTm6A4rJqSwa+m6V256BCK/+rGEr2wf\n1g7853nlAgMBAAECggEACLrkQVUv6Wx+YCAJiYR8I0A+gqpHu74Ecw+5g7vC4yR0\nbvXRDzA3oIXSEKCGrJzIw0JC/l9XSZ/F6cbnSdXL8Wlxi1V5wJo4WQr8Ge9D2kVv\nv/T8Hpr5cz/MC0pXvVFJU2t8Dsi4+bbpAnOVgmV01ZHnheq7JZktu15M8CxWnkd3\nA8eMUuKjS0G/cLN4/jZ3TDgiY5yaWeuQ07aPwbgXUK3XPpn2Tt8W7Ycf6j69n/Ol\n3EdByZXu1h9YqvmCUmHjiaaCB7/xLmo3kKvIaNcy87KW92ck0dVnl48DzcqK8PBA\n3ci3hi2ew5q9lDlPeYfT2700aT1qcd1Y8vr26OJyDQKBgQC3tlvFGeVkk1m7GHR9\nC8JoCkFDoQtDCv/sVDAf1p96NBkuuaGyOsAaLtmtXFGZ38c49Ci2DXEmfiVTq0rY\nsBp/eKDhr0P3wbUkauRXhOOYlxsaQGjqHW1+/nlA07vCnUxi1XFJnnfBkApk8xRe\ns22XCAqmXiGMJxQADRUAm2Np1wKBgQDe4zTP0wTDLTpWNJIe3evhj0V6yZ3MFNj3\nGhJTjB5wAaUaEzhG8mB9fL/w7VWW2e0bHu3Y9hWWrBjXdTXPP0RQPSQEk6DLmIJI\nZBJcpP9k9YRlcS7cdJBJjJJMZroQ3jqWMZVxTDix2+pH+PdgdIjWsGCtO0kHpQwV\nhg6SlBbaowKBgCiveC90hrr5bxviVJoE6q8D5mRF3Cqi2v7Jvkauz27O7uzMK6U/\nIaAq1AZytZewWXyhhgqbe32c3kNjYhYPGi801dxlZlYOTkGccql3QrhebqAnt5Rx\no/hF/zB+M8zr7SjOQGKfd8IkVkj5FH/MmO6j10f0/NT/KozAWPBjeWbNAoGAH5aD\nvZBidGbMhbsdmlJJQ8ZSSnyYaHvr49lGD6EkDyusgm2G5EcldaNgcHyyTJbGC7nu\na3k0xg3N13s9DQoiXFzN5fgmKbSLgkbsc0TPDTfec6H+yi+a41GQylMku49DLlYI\nn+31ev93zIt0Q69AVWzZxrNIPlUdyU8ecZebRZECgYAn6PuHDKUVkDiXGtX5EFTO\n98SK+ly3p0kIHZEJX0iE1JrSTcbAV7OYDoWsEAVOQy4SIhOCZWmdp/PbxfXPZSer\nnrOoXCMPGdjBIHcwxE55K3fH5zDABmEa3EIvJh/Hiq3Vygk/jSS5WryPZxXPbX+E\n18f40jBc5OqI3EkG3VbwPw==\n-----END PRIVATE KEY-----\n";

			// JWT Header
			$header = array(
				'alg' => 'RS256',
				'typ' => 'JWT'
			);

			// JWT Payload
			$now = time();
			$payload = array(
				'iss' => $serviceAccountEmail, // Issuer
				'sub' => $serviceAccountEmail, // Subject
				'aud' => 'https://oauth2.googleapis.com/token', // Audience
				'iat' => $now, // Issued at
				'exp' => $now + 3600, // Expires in 1 hour
				'scope' => 'https://www.googleapis.com/auth/firebase.messaging' // Scope for Firebase Cloud Messaging
			);

			// Create JWT token
			$jwt = createJWT($header, $payload, $privateKey);
			
			//print_r($jwt);

			// Prepare the token request payload
			$postData = http_build_query(array(
				'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
				'assertion' => $jwt,
			));

			// Send the request to Google's OAuth 2.0 token endpoint
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

			// Get the response and close the connection
			$response = curl_exec($ch);
			curl_close($ch);

			// Decode the response (JSON) to get the access token
			$responseDecoded = json_decode($response, true);

			if (isset($responseDecoded['access_token'])) {
				return $responseDecoded['access_token'];
				
			} else {
				throw new Exception('Failed to fetch access token: ' . $response);
			}
		}



		function sendPushNotification($accessToken, $to, $title, $screen, $SelectedTab, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id, $student_offer_time, $student_offer_date, $ProfilePic, $qualification, $TutorCode, $flag, $tutor_id, $date_time_update_by, $tutor_offer_date, $tutor_offer_time, $tutor_accept_date_time_status, $body) 
		{
			$url = 'https://fcm.googleapis.com/v1/projects/tutorapp-7522f/messages:send';
			
			// Payload for the notification
				$notificationPayload = array(
					'message' => array(
						'token' => $to, // Device token where notification will be sent
						'notification' => array(
							'title' => $title, // Title of the notification
							'body' => $body,   // Body of the notification
						),
						'data' => array( // Optional data payload for your app's handling
							'screen' => $screen, // Data field for additional screen info
							'SelectedTab' => $SelectedTab,
							'tutorBookingStatus' => $tutorBookingStatus,
							'offerStatus' => $offerStatus,
							'tutorBookingProcessId' => $tutorBookingProcessId,
							'student_id' => $student_id,
							'student_offer_time' => $student_offer_time,
							'student_offer_date' => $student_offer_date,
							'ProfilePic' => $ProfilePic,
							'qualification' => $qualification,
							'TutorCode' => $TutorCode,
							'flag' => $flag,
							'tutor_id' => $tutor_id,
							'date_time_update_by' => $date_time_update_by,
							'tutor_offer_date' => $tutor_offer_date,
							'tutor_offer_time' => $tutor_offer_time,
							'tutor_accept_date_time_status' => $tutor_accept_date_time_status,
						)
					)
				);

			// Convert payload to JSON
			$payloadJson = json_encode($notificationPayload);

			// Set up curl to send the request to Firebase FCM
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadJson);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			// Add the Authorization header with the access token and content type as JSON
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $accessToken
			));

			// Execute the request and get the response
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				throw new Exception('Curl error: ' . curl_error($ch));
			}

			// Close the connection
			curl_close($ch);

			// Return the response
			return $response;
		}


		 // Get the access token
    $accessToken = getAccessToken();

    // Device token for the user (This token is obtained from the client side - typically the user's mobile device)
    //$deviceToken = 'dPlD6vNUTHaoX3JaG5Pmgu:APA91bGxtXFGdP-AYshOjaXpn4CHX8qg5P940kKq-vQDdud3DGMCTUMT4iEZfTk1x_siDH7uRTDgJlRLr1_u3dOXFtKgK7si7SNvOf27bnMohHXyuDKZY2qq8ixXGXQ7ZewZOYc3Zbqc';  // Replace with actual device token

	
	//// Notification end



	
	
	
		if($_POST['offer_status'] !="" && $_POST['tutor_booking_process_id'] != "" && $_POST['tutor_tution_offer_amount_type'] !="" && $_POST['user_id_to_send_notification'] !="" && $_POST['acceptby'] !="" )
		{
			
			$tutor_booking_process_id = $_POST['tutor_booking_process_id'];
			$offer_status = $_POST['offer_status'];
			$user_id_to_send_notification = $_POST['user_id_to_send_notification'];
			
			
			 $query = "SELECT * FROM tutor_booking_process where tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."'  ";
					
				
			$result = $conn->query($query) or die ("table not found");
			$numrows = mysqli_num_rows($result);
			
			
			if($numrows > 0)
			{
				
				

							
								$sql = $conn->query("UPDATE tutor_booking_process SET offer_status = '".$_POST['offer_status']."', acceptby = '".$_POST['acceptby']."' WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."'  ");
								
								 //$sql = $conn->query("UPDATE tutor_booking_process SET tutor_booking_status  = '".$tutor_booking_status."' WHERE tutor_id = '".$_POST['tutor_id']."' and student_id = '".$_POST['student_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."' and tutor_tution_offer_amount = '".$_POST['tutor_tution_offer_amount']."' and amount_negotiate_by_tutor = '".$_POST['amount_negotiate_by_tutor']."' and amount_negotiate_by_student = '".$_POST['amount_negotiate_by_student']."' ");
								
								if($sql)
								{
									
									
									
								 
									   
									    $chk_notify_user = mysqli_fetch_array($conn->query("SELECT * FROM tutor_booking_process where tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."'  "));
									   
									   //echo $chk_notify_user['booking_from'];
									   //echo $chk_notify_user['tutor_tution_offer_amount_type'];
									   
									  // if($_POST['acceptby']=='tutor' && $chk_notify_user['booking_from']=='Search' && $chk_notify_user['tutor_tution_offer_amount_type']=='Negotiable')
									   if($_POST['acceptby']=='tutor' && $chk_notify_user['tutor_tution_offer_amount_type']=='Negotiable')	   
									   {
										   
										 
										  /// Send Firebase Notification start
										  
										   $aa1 = "SELECT * FROM user_info_device_token where user_id = '".$user_id_to_send_notification."'  ";

											$aa2 = $conn->query($aa1) or die ("table not found");
						
										   while($device_Token = mysqli_fetch_array($aa2))
										   {
												$to = $device_Token['device_token'];
									   
												if($offer_status=="Accept")
												{
													
													///Tutor data
													$tutor_data = mysqli_fetch_array($conn->query("SELECT profile_image,qualification,tutor_code,flag FROM user_tutor_info WHERE user_id = '".$chk_notify_user['tutor_id']."' "));
													
													
													$title = 'Offer Accepted';
													
													$screen = 'StartDT';
						
													$SelectedTab = "InProgress";
													
													
													
													$tutorBookingStatus = $chk_notify_user['tutor_booking_status'];
													$offerStatus = $chk_notify_user['offer_status'];
													$tutorBookingProcessId = $chk_notify_user['tutor_booking_process_id'];
													$student_id = $chk_notify_user['student_id'];
													$student_offer_time = $chk_notify_user['student_offer_time'];
													$student_offer_date = $chk_notify_user['student_offer_date'];
													$ProfilePic = $tutor_data['profile_image'];
													$qualification = $tutor_data['qualification'];
													$TutorCode = $tutor_data['tutor_code'];
													$flag = $tutor_data['flag'];
													$tutor_id = $chk_notify_user['tutor_id'];
													$date_time_update_by = $chk_notify_user['date_time_update_by'];
													$tutor_offer_date = $chk_notify_user['tutor_offer_date'];
													$tutor_offer_time = $chk_notify_user['tutor_offer_time'];
													$tutor_accept_date_time_status = $chk_notify_user['tutor_accept_date_time_status'];


													
													
												}
												else{
													$title = 'Offer Canceled';
												}

													
													$body = 'Congrats! Tutor has Accepted Your Fee Offer.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

													
												/// send notification	
												
												 //sendPushNotification($accessToken, $to, $title, $screen, $SelectedTab, $body);
												sendPushNotification($accessToken, $to, $title, $screen, $SelectedTab, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id, $student_offer_time, $student_offer_date, $ProfilePic, $qualification, $TutorCode, $flag, $tutor_id, $date_time_update_by, $tutor_offer_date, $tutor_offer_time, $tutor_accept_date_time_status, $body);
												
										   } 
											 
											 
											/// Send Firebase Notification end
										
										}
										
										
										
									/**	else{
											$title = 'Offer Accepted';
											$body = 'Congrats! Client has Accepted Your Fee Offer';
										
												$message = array(
										'title' => $title,
										'body' => $body);

										 sendPushNotification($to, $message);
									 
									/// Send Firebase Notification end
										
										}**/
										
										
										
									  //if($_POST['acceptby']=='student' && $chk_notify_user['booking_from']=='Search' && $chk_notify_user['tutor_tution_offer_amount_type']=='Negotiable')
									  if($_POST['acceptby']=='student' && $chk_notify_user['tutor_tution_offer_amount_type']=='Negotiable')	  
									  {
										  
										  /// student details
										$student_details = mysqli_fetch_array($conn->query("SELECT first_name,last_name FROM user_info WHERE user_id = '".$user_id_to_send_notification."' "));
										$FName = $student_details['first_name'];
										$LName = $student_details['last_name'];
										$firstCharacter = substr($FName, 0, 1);
										$secondCharacter = substr($LName, 0, 1);
										$ST_Name = $firstCharacter.$secondCharacter;
										  
										  $aa1 = "SELECT * FROM user_info_device_token where user_id = '".$user_id_to_send_notification."'  ";

											$aa2 = $conn->query($aa1) or die ("table not found");
						
										   while($device_Token = mysqli_fetch_array($aa2))
										   {
												$to = $device_Token['device_token'];
									   
									   
												if($offer_status=="Accept")
												{
													
													$title = 'Congrats! '.$ST_Name.' has accepted your Fee Offer';
													
													$screen = 'MyBookingTutor';
						
													$SelectedTab = "InProgress";
													
													
													$tutorBookingStatus = '';
													$offerStatus = '';
													$tutorBookingProcessId = '';
													$student_id = '';
													$student_offer_time = '';
													$student_offer_date = '';
													$ProfilePic = '';
													$qualification = '';
													$TutorCode = '';
													$flag = '';
													$tutor_id = '';
													$date_time_update_by = '';
													$tutor_offer_date = '';
													$tutor_offer_time = '';
													$tutor_accept_date_time_status = '';

													
													
												}
												else{
													$title = 'Offer Canceled';
												}

												$body = 'View Details in My Bookings/In Progress';   ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    
										
												//$message = array('title' => $title,'body' => $body);

												/// send notification	
												
												// sendPushNotification($accessToken, $to, $title, $screen, $SelectedTab, $body);
												
												sendPushNotification($accessToken, $to, $title, $screen, $SelectedTab, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id, $student_offer_time, $student_offer_date, $ProfilePic, $qualification, $TutorCode, $flag, $tutor_id, $date_time_update_by, $tutor_offer_date, $tutor_offer_time, $tutor_accept_date_time_status, $body);
												
												
										   }
											/// Send Firebase Notification end
										
										}
										
									/**	else{
											$title = 'Offer Accepted';
											$body = 'Congrats! Tutor has Accepted Your Fee Offer';
										
												$message = array(
										'title' => $title,
										'body' => $body);

										 sendPushNotification($to, $message);
									 
									/// Send Firebase Notification end
										
										
										}  **/
									   
									   
									   
									   
										

									
									$resultData = array('status' => true, 'message' => 'Offer Status Updated Successfully.', 'Offer_status' => $_POST['offer_status'] );
								
								}
								else			
								{
									$resultData = array('status' => false, 'message' => 'No Record Found.');
								}	


								
						
						
					
					/// Send Firebase Notification End		
				
				
			}
			else 
			{
				//$message1="Email Id Or Mobile Number not valid !";
				$resultData = array('status' => false, 'message' => 'No Record Found. Check Passing Values.');
			}
				

		}
		else{
			
			$resultData = array('status' => false, 'message' => 'Offer status, Tutor booking process id and user_id_to_send_notification can\'t be blank.');
		}	
							
			echo json_encode($resultData);
					
			
?>