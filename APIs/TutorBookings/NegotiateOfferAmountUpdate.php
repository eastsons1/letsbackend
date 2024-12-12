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



							


		function sendPushNotification(
    $accessToken, $to, $title, $screen, $SelectedTab, $amount_negotiate_by_tutor, $ProfilePic, 
    $qualification, $TutorCode, $flag, $amount_negotiate_by_student, $tutor_tution_offer_amount, 
    $tutor_booking_process_id, $tutor_tution_offer_amount_type, $tutor_id, $student_id, 
    $negotiate_by_tutor_amount_type, $body, $student_offer_date, $tutor_accept_date_time_status, 
    $student_date_time_offer_confirmation, $offer_status, $tutor_offer_date, $tutor_offer_time, 
    $student_first_name, $student_last_name) 
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
						'data' => array( // Data payload for your app's handling
									'screen' => $screen,
									'SelectedTab' => $SelectedTab,
									'amount_negotiate_by_tutor' => $amount_negotiate_by_tutor,
									'ProfilePic' => $ProfilePic,
									'qualification' => $qualification,
									'TutorCode' => $TutorCode,
									'flag' => $flag,
									'amount_negotiate_by_student' => $amount_negotiate_by_student,
									'tutor_tution_offer_amount' => $tutor_tution_offer_amount,
									'tutor_booking_process_id' => $tutor_booking_process_id,
									'tutor_tution_offer_amount_type' => $tutor_tution_offer_amount_type,
									'tutor_id' => $tutor_id,
									'student_id' => $student_id,
									'negotiate_by_tutor_amount_type' => $negotiate_by_tutor_amount_type,
									'student_offer_date' => $student_offer_date,
									'tutor_accept_date_time_status' => $tutor_accept_date_time_status,
									'student_date_time_offer_confirmation' => $student_date_time_offer_confirmation,
									'offer_status' => $offer_status,
									'tutor_offer_date' => $tutor_offer_date,
									'tutor_offer_time' => $tutor_offer_time,
									'student_first_name' => $student_first_name,
									'student_last_name' => $student_last_name,
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
				 
				 
				 
				
				if($numrows > 0)
				{
					

					/// Record updated
					
					 $sql = $conn->query($aa="UPDATE tutor_booking_process SET amount_negotiate_by_student = '".$_POST['amount_negotiate_by_student']."', negotiate_by_student_amount_type = '".$_POST['negotiate_by_student_amount_type']."', negotiateby = '".$_POST['negotiateby']."'  WHERE student_id = '".$_POST['student_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."' and tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."'  ");
					
					//echo $aa;
					
					if($sql)
					{
						
						if($_POST['negotiateby']=='student')
						{
						
						
						if($_POST['negotiate_by_tutor_amount_type'] == "Negotiable")
						{
							
							
							$screen = 'TutorAcceptNegotiate';
							
							///Tutor data
							$tutor_data = mysqli_fetch_array($conn->query("SELECT profile_image,qualification,tutor_code,flag FROM user_tutor_info WHERE user_id = '".$tutor_idVSql['tutor_id']."' "));
								
							///Student data
							$student_data = mysqli_fetch_array($conn->query("SELECT first_name,last_name FROM user_info WHERE user_id = '".$tutor_idVSql['student_id']."' "));
									
							
							$amount_negotiate_by_tutor = '';
							$ProfilePic = '';
							$qualification = '';
							$TutorCode = '';
							$flag = '';
							$amount_negotiate_by_student =  '';
							$tutor_tution_offer_amount = '';
							$tutor_booking_process_id = '';
							$tutor_tution_offer_amount_type = '';
							$tutor_id = '';
							$student_id = '';
							$negotiate_by_tutor_amount_type = '';
							
							
							$student_offer_date = $tutor_idVSql['student_offer_date'];
							$tutor_accept_date_time_status = $tutor_idVSql['tutor_accept_date_time_status'];
							$student_date_time_offer_confirmation = $tutor_idVSql['student_date_time_offer_confirmation'];
							$offer_status = $tutor_idVSql['offer_status']; 
							$tutor_offer_date = $tutor_idVSql['tutor_offer_date']; 
							$tutor_offer_time = $tutor_idVSql['tutor_offer_time'];
							$student_first_name = $student_data['first_name'];
							$student_last_name = $student_data['last_name'];
							
							
						}
						else{
							$screen = 'MyBookingTutor';
						}
						
					
						$title = 'Payment offer';
						$body = 'Client has made you a fee offer';
					
						$SelectedTab = "InProgress";
					
					
						$sql_token = $conn->query("SELECT device_token FROM user_info WHERE user_id = '".$user_id_to_send_notification."' ");

						if(mysqli_num_rows($sql_token)>0)
						{

						$device_token = mysqli_fetch_array($sql_token);

						$to = $device_token['device_token']; //'fGHmYdK5RumJLGfPQnPjdK:APA91bFMB09skbnDNFqTJ5IKX97jBTLvLETIwtXDYSVGsaHnsPyRHCmNYzta_ePnN-RGYnT5FlEMBpo9aEOM9DspoFGYVXVGvm5T7qkprexS2yVnz83RwQgDR9rOW1AL425aIlJiWVc7'; // Replace with your device token

					
					
					//print_r(sendPushNotification($accessToken, $to, $title, $screen, $body));
					
							if(sendPushNotification(
								$accessToken, $to, $title, $screen, $SelectedTab, $amount_negotiate_by_tutor, $ProfilePic, 
								$qualification, $TutorCode, $flag, $amount_negotiate_by_student, $tutor_tution_offer_amount, 
								$tutor_booking_process_id, $tutor_tution_offer_amount_type, $tutor_id, $student_id, 
								$negotiate_by_tutor_amount_type, $body, $student_offer_date, $tutor_accept_date_time_status, 
								$student_date_time_offer_confirmation, $offer_status, $tutor_offer_date, $tutor_offer_time, 
								$student_first_name, $student_last_name) )   // Output the result of sending the notification
							{
								$notify = 'Notification sent successfully.';
							}
							else{
								
								$notify = 'Notification did not send';
							}
							
						}
						else
						{
							
							
						$devSQL = $conn->query("select device_token from user_info_device_token where user_id = '".$user_id_to_send_notification."' ");	
						
						while($tutor_devi_token = mysqli_fetch_array($devSQL))
						{

							
							$to =  $tutor_devi_token['device_token']; //'dEdHrvwzT9iuUWJ9NZ5zOk:APA91bED869klnlM3LHvEp75KSa-GJha48otaM6iLzFjeaKN8fV4e2PccKVCw7QZgRUfNJqsflwmt40FvzGlJIVdc6BkwXeSCQoW6465dYgnqoBxa14MQmIpkDvCMnXUO2f3xx2OPmcz'; // Replace with your device token  //  $tutor_devi_token['device_token']; //
							
							
						
							if(sendPushNotification(
								$accessToken, $to, $title, $screen, $SelectedTab, $amount_negotiate_by_tutor, $ProfilePic, 
								$qualification, $TutorCode, $flag, $amount_negotiate_by_student, $tutor_tution_offer_amount, 
								$tutor_booking_process_id, $tutor_tution_offer_amount_type, $tutor_id, $student_id, 
								$negotiate_by_tutor_amount_type, $body, $student_offer_date, $tutor_accept_date_time_status, 
								$student_date_time_offer_confirmation, $offer_status, $tutor_offer_date, $tutor_offer_time, 
								$student_first_name, $student_last_name) )   // Output the result of sending the notification
							{
								$notify = 'Notification sent successfully.';
							}
							else
							{
								$notify = 'Notification did not send';
							}
						}	


					
							
							
						}
						
						
						

						
							
					
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
						
						
						if($_POST['negotiateby']=='tutor')
						{
							
							$tutor_idVSql = mysqli_fetch_array($result);
							
						//######### SEND notification start
						
						///Tutor data
							$tutor_data = mysqli_fetch_array($conn->query("SELECT profile_image,qualification,tutor_code,flag FROM user_tutor_info WHERE user_id = '".$tutor_idVSql['tutor_id']."' "));
								
							///Student data
							//$student_data = mysqli_fetch_array($conn->query("SELECT first_name,last_name FROM user_info WHERE user_id = '".$tutor_idVSql['student_id']."' "));
									
					
					
						//$title = 'Payment offer';
						//$body = 'Tutor has made you a fee offer';
						///Tutor data
								
						$title = $tutor_data['tutor_code'].' has Offered you a Fee';
						$body = 'View Details in My Bookings/In Progress.';
						
						$screen = 'AcceptNegotiate';
						$SelectedTab = "InProgress";
						
						
							$amount_negotiate_by_tutor = $tutor_idVSql['amount_negotiate_by_tutor'];
							$ProfilePic = $tutor_data['profile_image'];
							$qualification = $tutor_data['qualification'];
							$TutorCode = $tutor_data['tutor_code'];
							$flag = $tutor_data['flag'];
							$amount_negotiate_by_student =  $tutor_idVSql['amount_negotiate_by_student'];
							$tutor_tution_offer_amount = $tutor_idVSql['tutor_tution_offer_amount'];
							$tutor_booking_process_id = $tutor_idVSql['tutor_booking_process_id'];
							$tutor_tution_offer_amount_type = $tutor_idVSql['tutor_tution_offer_amount_type'];
							$tutor_id = $tutor_idVSql['tutor_id'];
							$student_id = $tutor_idVSql['student_id'];
							$negotiate_by_tutor_amount_type = $tutor_idVSql['negotiate_by_tutor_amount_type'];
							
							
							$student_offer_date = '';
							$tutor_accept_date_time_status = '';
							$student_date_time_offer_confirmation = '';
							$offer_status = ''; 
							$tutor_offer_date = ''; 
							$tutor_offer_time = '';
							$student_first_name = '';
							$student_last_name = '';
							
						
							
						$user_main_device_token = $conn->query("SELECT device_token FROM user_info WHERE user_id = '".$user_id_to_send_notification."' ");
				
						if(mysqli_num_rows($user_main_device_token)>0)
						{
							$user_device_token = mysqli_fetch_array($user_main_device_token);
							
							$to =  $user_device_token['device_token']; //'dEdHrvwzT9iuUWJ9NZ5zOk:APA91bED869klnlM3LHvEp75KSa-GJha48otaM6iLzFjeaKN8fV4e2PccKVCw7QZgRUfNJqsflwmt40FvzGlJIVdc6BkwXeSCQoW6465dYgnqoBxa14MQmIpkDvCMnXUO2f3xx2OPmcz'; // Replace with your device token  //  $tutor_devi_token['device_token']; //
							
							
							//print_r(sendPushNotification($accessToken, $to, $title, $screen, $body));
							
							/// send notification	
							if(sendPushNotification(
								$accessToken, $to, $title, $screen, $SelectedTab, $amount_negotiate_by_tutor, $ProfilePic, 
								$qualification, $TutorCode, $flag, $amount_negotiate_by_student, $tutor_tution_offer_amount, 
								$tutor_booking_process_id, $tutor_tution_offer_amount_type, $tutor_id, $student_id, 
								$negotiate_by_tutor_amount_type, $body, $student_offer_date, $tutor_accept_date_time_status, 
								$student_date_time_offer_confirmation, $offer_status, $tutor_offer_date, $tutor_offer_time, 
								$student_first_name, $student_last_name) )   // Output the result of sending the notification
							{
								$notify = 'Notification sent successfully.';
							}
							else{
								
								$notify = 'Notification did not send';
							}
							
							
						}
						else
						{


							$devSQL = $conn->query("select device_token from user_info_device_token where user_id = '".$user_id_to_send_notification."' ");	
				
							while($tutor_devi_token = mysqli_fetch_array($devSQL))
							{

								
								$to =  $tutor_devi_token['device_token']; //'dEdHrvwzT9iuUWJ9NZ5zOk:APA91bED869klnlM3LHvEp75KSa-GJha48otaM6iLzFjeaKN8fV4e2PccKVCw7QZgRUfNJqsflwmt40FvzGlJIVdc6BkwXeSCQoW6465dYgnqoBxa14MQmIpkDvCMnXUO2f3xx2OPmcz'; // Replace with your device token  //  $tutor_devi_token['device_token']; //
								
								
							
							
					
							if(sendPushNotification(
								$accessToken, $to, $title, $screen, $SelectedTab, $amount_negotiate_by_tutor, $ProfilePic, 
								$qualification, $TutorCode, $flag, $amount_negotiate_by_student, $tutor_tution_offer_amount, 
								$tutor_booking_process_id, $tutor_tution_offer_amount_type, $tutor_id, $student_id, 
								$negotiate_by_tutor_amount_type, $body, $student_offer_date, $tutor_accept_date_time_status, 
								$student_date_time_offer_confirmation, $offer_status, $tutor_offer_date, $tutor_offer_time, 
								$student_first_name, $student_last_name) )   // Output the result of sending the notification
							{
								$notify = 'Notification sent successfully.';
							}
							else{
								
								$notify = 'Notification did not send';
							}
							
							}
							
							
						}
							
							
							
							
						
						}	
						
						
						$resultData = array('status' => true, 'message' => 'Record Updated Successfully.', 'amount_negotiate_by_tutor' => $_POST['amount_negotiate_by_tutor'], 'notify' => $notify );
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