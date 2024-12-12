<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
		
		
	
		//if($_POST['tutor_booking_process_id'] != "" && $_POST['student_id'] && $_POST['tutor_id'] && $_POST['tutor_offer_date'] !="" && $_POST['tutor_offer_time'] !="" && $_POST['student_date_time_offer_confirmation'] !="" && $_POST['tutor_accept_date_time_status'] !="")
		//{
			
			
			
			
			
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
									$accessToken, $to, $title, $screen, $SelectedTab, $body,
									$tutor_id, $tutor_booking_process_id, $student_offer_date, $tutor_accept_date_time_status,
									$tutor_tution_offer_amount_type, $student_date_time_offer_confirmation, $offer_status,
									$tutor_offer_date, $tutor_offer_time, $student_first_name, $student_last_name,
									$date_time_update_by, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id,
									$student_offer_time, $ProfilePic, $qualification, $TutorCode, $flag
								) 
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
									'tutor_id' => $tutor_id,
									'tutor_booking_process_id' => $tutor_booking_process_id,
									'student_offer_date' => $student_offer_date,
									'tutor_accept_date_time_status' => $tutor_accept_date_time_status,
									'tutor_tution_offer_amount_type' => $tutor_tution_offer_amount_type,
									'student_date_time_offer_confirmation' => $student_date_time_offer_confirmation,
									'offer_status' => $offer_status,
									'tutor_offer_date' => $tutor_offer_date,
									'tutor_offer_time' => $tutor_offer_time,
									'student_first_name' => $student_first_name,
									'student_last_name' => $student_last_name,
									'date_time_update_by' => $date_time_update_by,
									'tutorBookingStatus' => $tutorBookingStatus,
									'offerStatus' => $offerStatus,
									'tutorBookingProcessId' => $tutorBookingProcessId,
									'student_id' => $student_id,
									'student_offer_time' => $student_offer_time,
									'ProfilePic' => $ProfilePic,
									'qualification' => $qualification,
									'TutorCode' => $TutorCode,
									'flag' => $flag,
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
			
			
			
			
	
					$query = "SELECT * FROM tutor_booking_process where tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."'  ";
							
						
					$result = $conn->query($query) or die ("table not found");
					$numrows = mysqli_num_rows($result);
					
					
					if($numrows > 0)
					{


						// Get the default timezone set in the configuration
						// $default_timezone = date_default_timezone_get();
						
						
						
						
						

						// After loop, you can check the default timezone again if needed
							//$default_timezone = date_default_timezone_get();
							
							//date_default_timezone_set($default_timezone);
							
							//date_default_timezone_set('Asia/Kolkata');
							date_default_timezone_set('Asia/Singapore');
							 $api_hit_date = $_POST['current_app_date'];											//date("d-m-Y");
							 $api_hit_time = $_POST['current_app_time'];               //date("H:i:s");

							$api_hit_date_by_confirmed_user = $api_hit_date;
							$api_hit_time_by_confirmed_user = $api_hit_time; 
							
							
						


					

						


						//$api_hit_date_time = date("Y-m-d h:i:sa");
						
						
						//date_default_timezone_set('Asia/Singapore');
						//echo date("d-m-Y H:i:s");

						
							
						$student_date_time_offer_confirmation_Sql = mysqli_fetch_array($result);
						$student_date_time_offer_confirmation = $student_date_time_offer_confirmation_Sql['student_date_time_offer_confirmation'];
						$date_time_update_by = $student_date_time_offer_confirmation_Sql['date_time_update_by'];
						
						//if($_POST['student_date_time_offer_confirmation'] == 'Confirmed' && $_POST['date_time_update_by'] == 'student')
						
					/**
						/// student image
						$student_picQ = $conn->query("SELECT profile_image FROM user_info WHERE user_id = '".$_POST['student_id']."' ");	
						
						if(mysqli_fetch_array($student_picQ)>0)
						{
							$student_picFetch = mysqli_fetch_array($student_picQ);
							$student_pic = $student_picFetch['profile_image'];
						}
						else{
							
							$student_picFetch = mysqli_fetch_array($conn->query("SELECT profile_image FROM user_tutor_info WHERE user_id = '".$_POST['student_id']."' "));	
							$student_pic = $student_picFetch['profile_image'];
						}
					**/	
						
						
						/// tutor image
						$tutor_picQ = $conn->query("SELECT profile_image FROM user_info WHERE user_id = '".$_POST['tutor_id']."' ");	
						
						if(mysqli_fetch_array($tutor_picQ)>0)
						{
							$tutor_picFetch = mysqli_fetch_array($tutor_picQ);
							$tutor_pic = $tutor_picFetch['profile_image'];
						}
						else{
							
							$tutor_picFetch = mysqli_fetch_array($conn->query("SELECT profile_image FROM user_tutor_info WHERE user_id = '".$_POST['tutor_id']."' "));	
							$tutor_pic = $tutor_picFetch['profile_image'];
						}
					
					
					
					if($_POST['date_time_update_by'] == 'student' && $_POST['student_date_time_offer_confirmation'] != 'Confirmed' && $_POST['tutor_booking_process_id'] !="" && $_POST['tutor_id'] !="" && $_POST['student_offer_date'] !="" && $_POST['student_offer_time'] !="" && $_POST['tutor_offer_date'] =="" && $_POST['tutor_offer_time'] =="")	
					{
						
						$user_name = mysqli_fetch_array($conn->query("SELECT first_name,last_name FROM user_info WHERE user_id = '".$_POST['student_id']."' "));
						
						$FName = $user_name['first_name'];
						$LName = $user_name['last_name'];
						$firstCharacter = substr($FName, 0, 1);
						$secondCharacter = substr($LName, 0, 1);
						$ST_Name = $firstCharacter.$secondCharacter;
						
						
						
							$api_hit_date_by_confirmed_user = $api_hit_date;
							$api_hit_time_by_confirmed_user = $api_hit_time;    ///api_hit_date_time_by_student
							
							if($_POST['student_date_time_offer_confirmation'] == 'Confirmed')
							{
								$Confirmed = 'Confirmed';
							}
							else{
								$Confirmed = '';
							}
							
							$devT = $conn->query("select device_token from user_info_device_token where user_id = '".$_POST['tutor_id']."' ");
							
							while($device_token = mysqli_fetch_array($devT))
							{

								if($student_date_time_offer_confirmation_Sql['student_offer_date'] == "" && $student_date_time_offer_confirmation_Sql['student_offer_time'] == "" )
								{
									
									$title = $ST_Name.' has proposed a Start Date/Time';
									$body = 'View Details in My Bookings/In Progress.';
								}
								else{
									
									$title = $ST_Name.' has requested to change the Start Date/Time';
									$body = 'View Details in My Bookings/In Progress.';
								}


								$to =  $device_token['device_token']; 
					
								
								$screen = 'TutorStartDT';
								$SelectedTab = '';
								
								
								
								
							///Student data
							$student_data = mysqli_fetch_array($conn->query("SELECT first_name,last_name FROM user_info WHERE user_id = '".$student_date_time_offer_confirmation_Sql['student_id']."' "));
									
								
								$tutor_id = $student_date_time_offer_confirmation_Sql['tutor_id'];
								$tutor_booking_process_id = $student_date_time_offer_confirmation_Sql['tutor_booking_process_id'];
								$student_offer_date = $student_date_time_offer_confirmation_Sql['student_offer_date'];
								$student_offer_time = $student_date_time_offer_confirmation_Sql['student_offer_time'];
								$tutor_accept_date_time_status = $student_date_time_offer_confirmation_Sql['tutor_accept_date_time_status'];
								$tutor_tution_offer_amount_type = $student_date_time_offer_confirmation_Sql['tutor_tution_offer_amount_type'];
								$student_date_time_offer_confirmation = $student_date_time_offer_confirmation_Sql['student_date_time_offer_confirmation'];
								$offer_status = $student_date_time_offer_confirmation_Sql['offer_status'];
								$tutor_offer_date = $_POST['tutor_offer_date'];
								$tutor_offer_time = $_POST['tutor_offer_time'];
								$student_first_name = $student_data['first_name'];
								$student_last_name = $student_data['last_name'];
								$date_time_update_by = $student_date_time_offer_confirmation_Sql['date_time_update_by'];
								
								
								$amount_negotiate_by_tutor = '';
								$ProfilePic = '';
								$qualification = '';
								$TutorCode = '';
								$flag = '';
								$amount_negotiate_by_student =  '';
								$tutor_tution_offer_amount = '';
								$student_id = '';
								$negotiate_by_tutor_amount_type = '';
								$tutorBookingStatus = '';
								$offerStatus = '';
								$tutorBookingProcessId = '';
								//$student_offer_time = '';
									
								
								
								


								/// send notification	
								//sendPushNotification($accessToken, $to, $title, $body);
								
								sendPushNotification(
									$accessToken, $to, $title, $screen, $SelectedTab, $body,
									$tutor_id, $tutor_booking_process_id, $student_offer_date, $tutor_accept_date_time_status,
									$tutor_tution_offer_amount_type, $student_date_time_offer_confirmation, $offer_status,
									$tutor_offer_date, $tutor_offer_time, $student_first_name, $student_last_name,
									$date_time_update_by, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id,
									$student_offer_time, $ProfilePic, $qualification, $TutorCode, $flag
								);

								
							}
							
							
							 $sql = $conn->query("UPDATE tutor_booking_process SET student_offer_date = '".$_POST['student_offer_date']."', student_offer_time = '".$_POST['student_offer_time']."', date_time_update_by = '".$_POST['date_time_update_by']."' WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' ");
						
								
							
						}							
						
						//if($_POST['student_date_time_offer_confirmation'] == 'Confirmed' && $_POST['date_time_update_by'] == 'tutor')
							
						if($_POST['date_time_update_by'] == 'tutor' && $_POST['student_date_time_offer_confirmation'] != 'Confirmed' && $_POST['tutor_booking_process_id'] !="" && $_POST['student_id'] !="" && $_POST['student_offer_date'] =="" && $_POST['student_offer_time'] =="" && $_POST['tutor_offer_date'] !="" && $_POST['tutor_offer_time'] !="")
						{
							
							
							//$api_hit_date_time_by_tutor = $api_hit_date_time;      ///api_hit_date_time_by_tutor
							
							$api_hit_date_by_confirmed_user = $api_hit_date;
							$api_hit_time_by_confirmed_user = $api_hit_time;    ///api_hit_date_time_by_student
							
							if($_POST['student_date_time_offer_confirmation'] == 'Confirmed')
							{
								$Confirmed = 'Confirmed';
							}
							else{
								$Confirmed = '';
							}
							
							$tutor_accept_date_time_status = 'Accept';
							
							
							///Tutor data
							$tutor_data = mysqli_fetch_array($conn->query("SELECT profile_image,qualification,tutor_code,flag FROM user_tutor_info WHERE user_id = '".$_POST['tutor_id']."' "));
								
							
							$studentFL_name = mysqli_fetch_array($conn->query("SELECT first_name, last_name FROM user_info WHERE user_id = '".$_POST['student_id']."' "));
							
							$user_main_device_token = $conn->query("SELECT device_token, first_name, last_name FROM user_info WHERE user_id = '".$_POST['student_id']."' ");
							
							if(mysqli_num_rows($user_main_device_token)>0)
							{
								
								 $device_token_M = mysqli_fetch_array($user_main_device_token);
								
									$to =  $device_token_M['device_token']; 
						
									$title = $tutor_data['tutor_code'].' has proposed a Start Date/Time.';
									$body = 'View Details in My Bookings/In Progress';
									$screen = 'StartDT';
									$SelectedTab = '';
									
									
									
								//$tutor_id = '';
								//$tutor_booking_process_id = '';
								//$student_offer_date = '';
								$tutor_accept_date_time_status = '';
								//$tutor_tution_offer_amount_type = '';
								$student_date_time_offer_confirmation = '';
								//$offer_status = '';
								//$tutor_offer_date = '';
								//$tutor_offer_time = '';
								//$student_first_name = '';
								//$student_last_name = '';
								//$date_time_update_by = '';
								
								
								$tutor_booking_process_id = $_POST['tutor_booking_process_id'];
								$tutor_id = $_POST['tutor_id'];
								$amount_negotiate_by_tutor = $student_date_time_offer_confirmation_Sql['amount_negotiate_by_tutor'];
								$ProfilePic = $tutor_data['profile_image'];
								$qualification = $tutor_data['qualification'];
								$TutorCode = $tutor_data['tutor_code'];
								$flag = $tutor_data['flag'];
								$amount_negotiate_by_student =  $student_date_time_offer_confirmation_Sql['amount_negotiate_by_student'];
								$tutor_tution_offer_amount = $student_date_time_offer_confirmation_Sql['tutor_tution_offer_amount'];
								$student_id = $student_date_time_offer_confirmation_Sql['student_id'];
								$negotiate_by_tutor_amount_type = $student_date_time_offer_confirmation_Sql['negotiate_by_tutor_amount_type'];
								$tutorBookingStatus = $student_date_time_offer_confirmation_Sql['tutorBookingStatus'];
								$offerStatus = $student_date_time_offer_confirmation_Sql['offerStatus'];
								$tutorBookingProcessId = $student_date_time_offer_confirmation_Sql['tutorBookingProcessId'];
								$student_offer_date = $student_date_time_offer_confirmation_Sql['student_offer_date'];
								$student_offer_time = $student_date_time_offer_confirmation_Sql['student_offer_time'];
								$date_time_update_by = 	$student_date_time_offer_confirmation_Sql['date_time_update_by'];
								$tutor_offer_date = $_POST['tutor_offer_date'];
								$tutor_offer_time = $_POST['tutor_offer_time'];
								$tutor_tution_offer_amount_type = $student_date_time_offer_confirmation_Sql['tutor_tution_offer_amount_type'];
								$offer_status = $student_date_time_offer_confirmation_Sql['offer_status'];	
								$student_first_name = $studentFL_name['first_name'];
								$student_last_name = $studentFL_name['last_name'];	
									

								 /// send notification	
									//sendPushNotification($accessToken, $to, $title, $body);
									sendPushNotification(
									$accessToken, $to, $title, $screen, $SelectedTab, $body,
									$tutor_id, $tutor_booking_process_id, $student_offer_date, $tutor_accept_date_time_status,
									$tutor_tution_offer_amount_type, $student_date_time_offer_confirmation, $offer_status,
									$tutor_offer_date, $tutor_offer_time, $student_first_name, $student_last_name,
									$date_time_update_by, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id,
									$student_offer_time, $ProfilePic, $qualification, $TutorCode, $flag
								);
								
							}
							else{
							
							
							
								$Tok = $conn->query("select device_token from user_info_device_token where user_id = '".$_POST['student_id']."' ");
							
								while($device_token = mysqli_fetch_array($Tok))
								{

									$to =  $device_token['device_token']; 
						
									$title = $tutor_data['tutor_code'].' has proposed a Start Date/Time.';
									$body = 'View Details in My Bookings/In Progress';
									$screen = 'StartDT';
									$SelectedTab = '';
									
									
									
								//$tutor_id = '';
								//$tutor_booking_process_id = '';
								//$student_offer_date = '';
								$tutor_accept_date_time_status = '';
								//$tutor_tution_offer_amount_type = '';
								$student_date_time_offer_confirmation = '';
								//$offer_status = '';
								//$tutor_offer_date = '';
								//$tutor_offer_time = '';
								//$student_first_name = '';
								//$student_last_name = '';
								//$date_time_update_by = '';
								
								
								$tutor_booking_process_id = $_POST['tutor_booking_process_id'];
								$tutor_id = $_POST['tutor_id'];
								$amount_negotiate_by_tutor = $student_date_time_offer_confirmation_Sql['amount_negotiate_by_tutor'];
								$ProfilePic = $tutor_pic; ///$tutor_data['profile_image'];
								$qualification = $tutor_data['qualification'];
								$TutorCode = $tutor_data['tutor_code'];
								$flag = $tutor_data['flag'];
								$amount_negotiate_by_student =  $student_date_time_offer_confirmation_Sql['amount_negotiate_by_student'];
								$tutor_tution_offer_amount = $student_date_time_offer_confirmation_Sql['tutor_tution_offer_amount'];
								$student_id = $student_date_time_offer_confirmation_Sql['student_id'];
								$negotiate_by_tutor_amount_type = $student_date_time_offer_confirmation_Sql['negotiate_by_tutor_amount_type'];
								$tutorBookingStatus = $student_date_time_offer_confirmation_Sql['tutorBookingStatus'];
								$offerStatus = $student_date_time_offer_confirmation_Sql['offerStatus'];
								$tutorBookingProcessId = $student_date_time_offer_confirmation_Sql['tutorBookingProcessId'];
								$student_offer_date = $student_date_time_offer_confirmation_Sql['student_offer_date'];
								$student_offer_time = $student_date_time_offer_confirmation_Sql['student_offer_time'];
								$date_time_update_by = 	$student_date_time_offer_confirmation_Sql['date_time_update_by'];
								$tutor_offer_date = $_POST['tutor_offer_date'];
								$tutor_offer_time = $_POST['tutor_offer_time'];
								$tutor_tution_offer_amount_type = $student_date_time_offer_confirmation_Sql['tutor_tution_offer_amount_type'];
								$offer_status = $student_date_time_offer_confirmation_Sql['offer_status'];	
								$student_first_name = $studentFL_name['first_name'];
								$student_last_name = $studentFL_name['last_name'];	

									

								 /// send notification	
									//sendPushNotification($accessToken, $to, $title, $body);
									sendPushNotification(
									$accessToken, $to, $title, $screen, $SelectedTab, $body,
									$tutor_id, $tutor_booking_process_id, $student_offer_date, $tutor_accept_date_time_status,
									$tutor_tution_offer_amount_type, $student_date_time_offer_confirmation, $offer_status,
									$tutor_offer_date, $tutor_offer_time, $student_first_name, $student_last_name,
									$date_time_update_by, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id,
									$student_offer_time, $ProfilePic, $qualification, $TutorCode, $flag
								);
									
									
								}
								
								
							}
								
								
								
							$sql = $conn->query("UPDATE tutor_booking_process SET tutor_offer_date = '".$_POST['tutor_offer_date']."', tutor_offer_time = '".$_POST['tutor_offer_time']."', date_time_update_by = '".$_POST['date_time_update_by']."' WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' ");
						
									
								
							
						}	
						
						
						
						
						
					
						if($_POST['student_date_time_offer_confirmation'] == 'Confirmed' && $_POST['tutor_booking_process_id'] != "" && $_POST['student_id'] != "" && $_POST['student_offer_date'] !="" && $_POST['student_offer_time'] !="" && $_POST['date_time_update_by'] !="")
						{
						
							$sql = $conn->query("UPDATE tutor_booking_process SET student_date_time_offer_confirmation = '".$Confirmed."',  student_offer_date = '".$_POST['student_offer_date']."', student_offer_time = '".$_POST['student_offer_time']."', date_time_update_by = '".$_POST['date_time_update_by']."', api_hit_date_by_confirmed_user = '".$api_hit_date_by_confirmed_user."', api_hit_time_by_confirmed_user = '".$api_hit_time_by_confirmed_user."' WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' and student_id = '".$_POST['student_id']."'  ");
						
						}
						else			
						{
							$resultData = array('status' => false, 'message' => 'tutor_booking_process_id,student_id,student_offer_date and student_offer_time can not be blank.');
						}
						
						
						if($_POST['student_date_time_offer_confirmation'] == 'Confirmed' && $_POST['tutor_booking_process_id'] != "" && $_POST['student_id'] != "" && $_POST['student_date_time_offer_confirmation'] !="" && $_POST['date_time_update_by'] !="" )
						{
						
							$sql3 = $conn->query("UPDATE tutor_booking_process SET student_date_time_offer_confirmation = '".$Confirmed."', student_date_time_offer_confirmation = '".$_POST['student_date_time_offer_confirmation']."' , date_time_update_by = '".$_POST['date_time_update_by']."', api_hit_date_by_confirmed_user = '".$api_hit_date_by_confirmed_user."', api_hit_time_by_confirmed_user = '".$api_hit_time_by_confirmed_user."' WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' and student_id = '".$_POST['student_id']."'  ");
						
						}
						else			
						{
							$resultData = array('status' => false, 'message' => 'tutor_booking_process_id,student_id and student_date_time_offer_confirmation can not be blank.');
						}
						
						
						if($_POST['student_date_time_offer_confirmation'] == 'Confirmed' && $_POST['tutor_booking_process_id'] != "" && $_POST['tutor_id'] != "" && $_POST['tutor_offer_date'] !="" && $_POST['tutor_offer_time'] !="" && $_POST['date_time_update_by'] !="")
						{
						
						
							$sql = $conn->query("UPDATE tutor_booking_process SET student_date_time_offer_confirmation = '".$Confirmed."', tutor_accept_date_time_status = '".$tutor_accept_date_time_status."', tutor_offer_date = '".$_POST['tutor_offer_date']."', tutor_offer_time = '".$_POST['tutor_offer_time']."' , date_time_update_by = '".$_POST['date_time_update_by']."', api_hit_date_by_confirmed_user = '".$api_hit_date_by_confirmed_user."', api_hit_time_by_confirmed_user = '".$api_hit_time_by_confirmed_user."' WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' and tutor_id = '".$_POST['tutor_id']."'  ");
							
							
						}
						else			
						{
							$resultData = array('status' => false, 'message' => 'tutor_booking_process_id,tutor_id,tutor_offer_date and tutor_offer_time can not be blank.');
						}
						
						
						if($_POST['student_date_time_offer_confirmation'] == 'Confirmed' && $_POST['tutor_booking_process_id'] != "" && $_POST['tutor_id'] != "" && $_POST['tutor_accept_date_time_status'] !="" && $_POST['date_time_update_by'] !="")
						{
						
						
							$sql2 = $conn->query("UPDATE tutor_booking_process SET student_date_time_offer_confirmation = '".$Confirmed."', tutor_accept_date_time_status = '".$tutor_accept_date_time_status."', tutor_accept_date_time_status = '".$_POST['tutor_accept_date_time_status']."' , date_time_update_by = '".$_POST['date_time_update_by']."', api_hit_date_by_confirmed_user = '".$api_hit_date_by_confirmed_user."', api_hit_time_by_confirmed_user = '".$api_hit_time_by_confirmed_user."' WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' and tutor_id = '".$_POST['tutor_id']."'  ");
							
							
							//////######
							$student_token = mysqli_fetch_array($conn->query("SELECT device_token FROM user_info WHERE user_id = '".$_POST['student_id']."' "));
							
							$check_user_payment = mysqli_fetch_array($conn->query("SELECT * FROM tbl_payment as payment INNER JOIN  tutor_booking_process as book ON payment.tutor_booking_process_id = book.tutor_booking_process_id WHERE payment.tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' and payment.logged_in_user_id = '".$_POST['tutor_id']."' "));
							
							if($check_user_payment['amount'] == "0.00")
							{
								
								///echo $api_hit_date.' '.$api_hit_time;
								
								 $date3 = strtotime($api_hit_date.' '.$api_hit_time); // Target date and time
								 $date4 = strtotime(date('Y-m-d H:i:s')); // Current date and time

								// Calculate the difference in seconds
									$timeDiff2 = $date3 - $date4;

									// Check if the difference is less than or equal to 24 hours
									if($timeDiff2 > 0 && $timeDiff2 <= (24 * 3600)) 
									{
										// Convert seconds to hours
										$hoursLeft = floor($timeDiff2 / 3600);
										$minutesLeft = floor(($timeDiff2 % 3600) / 60);
										//echo "Time remaining: $hoursLeft hours and $minutesLeft minutes";
										$title = "Payment Due in within 23 hours";
									} 
									elseif($timeDiff2 > (24 * 3600)) 
									{
										//echo "More than 24 hours remaining.";
										//$title = "Payment Due in within 23 hours";
									} 
									else 
									{
										//echo "The time has already passed.";
										$title = "Payment Overdue. Booking is now cancelled.";
									}
								
								
								
								
								 $to = $student_token['device_token'];
								 $body = "Make Payment in My Bookings/In Progress";
								 
								 sendPushNotification(
														$accessToken, $to, $title, $screen, $SelectedTab, $body,
														$tutor_id, $tutor_booking_process_id, $student_offer_date, $tutor_accept_date_time_status,
														$tutor_tution_offer_amount_type, $student_date_time_offer_confirmation, $offer_status,
														$tutor_offer_date, $tutor_offer_time, $student_first_name, $student_last_name,
														$date_time_update_by, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id,
														$student_offer_time, $ProfilePic, $qualification, $TutorCode, $flag
													);
								
								
							
							
							}
							
							
							//////####
							
							
							
						}
						else			
						{
							$resultData = array('status' => false, 'message' => 'tutor_booking_process_id,tutor_id,tutor_accept_date_time_status can not be blank.');
						}
						
						
						
						
						if($sql)
						{
							
							 $result_notify_data = mysqli_fetch_array($result);
							
							 $resultData = array('status' => true, 'message' => 'Offer date and time Updated Successfully.');
						}
						

						if($sql2)
						{
							$resultData = array('status' => true, 'message' => 'Date and time Offer Accepted Successfully.');
						}
						

						if($sql3)
						{
							
							
							$user_name = mysqli_fetch_array($conn->query("SELECT first_name,last_name FROM user_info WHERE user_id = '".$_POST['student_id']."' "));
						
							$FName = $user_name['first_name'];
							$LName = $user_name['last_name'];
							$firstCharacter = substr($FName, 0, 1);
							$secondCharacter = substr($LName, 0, 1);
							$ST_Name = $firstCharacter.$secondCharacter;	
							
							//###################
									
									
									//echo $_POST['student_date_time_offer_confirmation'];
									
									
									$result_notify_data2 = mysqli_fetch_array($result);	
										
										
										////// If confirmation Confirmed condition start
										
										if($_POST['date_time_update_by'] == "student" && $_POST['student_date_time_offer_confirmation'] == "Confirmed" &&  $_POST['tutor_id'] !="" && $_POST['student_id'] !="" && $_POST['tutor_booking_process_id'] !="" && $_POST['current_app_date'] !="" && $_POST['current_app_time'] !="" && $result_notify_data2['tutor_accept_date_time_status'] == "")
										{
											
											$title = $ST_Name.' has Accepted your Start Date/Time';					
											//$body = 'Client has agreed to your Start Date/Time';
											$body = 'Booking is Confirmed. Pending Client’s payment';
											$screen = 'MyBookingTutor';                                                                                             
											$SelectedTab = "InProgress";
											
											
										    $device_token1 = $conn->query("SELECT device_token FROM user_info WHERE user_id = '".$_POST['tutor_id']."' ");
			
											if(mysqli_num_rows($device_token1)>0)
											{
												$userDT = mysqli_fetch_array($device_token1);
												$to  = $userDT['device_token'];
												
												sendPushNotification(
																		$accessToken, $to, $title, $screen, $SelectedTab, $body,
																		$tutor_id, $tutor_booking_process_id, $student_offer_date, $tutor_accept_date_time_status,
																		$tutor_tution_offer_amount_type, $student_date_time_offer_confirmation, $offer_status,
																		$tutor_offer_date, $tutor_offer_time, $student_first_name, $student_last_name,
																		$date_time_update_by, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id,
																		$student_offer_time, $ProfilePic, $qualification, $TutorCode, $flag
																	);
												
											}
											else{
												
												$Tok1 = $conn->query("select device_token from user_info_device_token where user_id = '".$_POST['tutor_id']."' ");
							
												while($device_token2 = mysqli_fetch_array($Tok1))
												{
													
													$to  = $device_token2['device_token'];
													
													sendPushNotification(
																		$accessToken, $to, $title, $screen, $SelectedTab, $body,
																		$tutor_id, $tutor_booking_process_id, $student_offer_date, $tutor_accept_date_time_status,
																		$tutor_tution_offer_amount_type, $student_date_time_offer_confirmation, $offer_status,
																		$tutor_offer_date, $tutor_offer_time, $student_first_name, $student_last_name,
																		$date_time_update_by, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id,
																		$student_offer_time, $ProfilePic, $qualification, $TutorCode, $flag
																	);
													
													
												}
												
											}
											
											
											
										}
										
										
										if($_POST['date_time_update_by'] == "tutor" && $_POST['student_date_time_offer_confirmation'] == "Confirmed" &&  $_POST['tutor_accept_date_time_status'] == "Accept" &&  $_POST['tutor_id'] !="" && $_POST['student_id'] !="" && $_POST['tutor_booking_process_id'] !="" && $_POST['current_app_date'] !="" && $_POST['current_app_time'] !="" )
										{
											
											
											$TutorCodeSQL = mysqli_fetch_array($conn->query("SELECT tutor_code FROM user_tutor_info WHERE user_id = '".$_POST['tutor_id']."' ")); 
											
											$TutorCodeV = $TutorCodeSQL['tutor_code'];
											
											
											$title = $TutorCodeV.' has Accepted your Start Date/Time';
											$body = 'Proceed to Make Payment in My Bookings/In Progress';
											$screen = 'MyBookings';
											$SelectedTab = "InProgress";
											
											
											$device_token1 = $conn->query("SELECT device_token FROM user_info WHERE user_id = '".$_POST['student_id']."' ");
			
											if(mysqli_num_rows($device_token1)>0)
											{
												
												$userDT = mysqli_fetch_array($device_token1);
												$to  = $userDT['device_token'];
												
												sendPushNotification(
																		$accessToken, $to, $title, $screen, $SelectedTab, $body,
																		$tutor_id, $tutor_booking_process_id, $student_offer_date, $tutor_accept_date_time_status,
																		$tutor_tution_offer_amount_type, $student_date_time_offer_confirmation, $offer_status,
																		$tutor_offer_date, $tutor_offer_time, $student_first_name, $student_last_name,
																		$date_time_update_by, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id,
																		$student_offer_time, $ProfilePic, $qualification, $TutorCode, $flag
																	);
												
											}
											else{
												
												$Tok1 = $conn->query("select device_token from user_info_device_token where user_id = '".$_POST['student_id']."' ");
							
												while($device_token2 = mysqli_fetch_array($Tok1))
												{
													
													$to  = $device_token2['device_token'];
													
													sendPushNotification(
																		$accessToken, $to, $title, $screen, $SelectedTab, $body,
																		$tutor_id, $tutor_booking_process_id, $student_offer_date, $tutor_accept_date_time_status,
																		$tutor_tution_offer_amount_type, $student_date_time_offer_confirmation, $offer_status,
																		$tutor_offer_date, $tutor_offer_time, $student_first_name, $student_last_name,
																		$date_time_update_by, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id,
																		$student_offer_time, $ProfilePic, $qualification, $TutorCode, $flag
																	);
													
													
												}
												
											}
											
											
											
										}
										
										
										
										
										////// If confirmation confirmed condition end

										
							
							
							$resultData = array('status' => true, 'message' => 'Date and time Offer Acceptance Confirmed.');
						}
						
						
						
					}
					else 
					{
						//$message1="Email Id Or Mobile Number not valid !";
						$resultData = array('status' => false, 'message' => 'No Record Found. Check Passing Values.');
					
					}
			
			
	
		
							
					echo json_encode($resultData);
					
			
?>