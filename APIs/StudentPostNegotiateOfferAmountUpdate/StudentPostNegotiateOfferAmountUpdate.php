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



		function sendPushNotification($accessToken, $to, $title, $body) {
			$url = 'https://fcm.googleapis.com/v1/projects/tutorapp-7522f/messages:send';
			
			// Payload for the notification
			$notificationPayload = array(
				'message' => array(
					'token' => $to, // Device token where notification will be sent
					'notification' => array(
						'title' => $title, // Title of the notification
						'body' => $body,   // Body of the notification
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






	
		$student_post_requirement_id = $_POST['student_post_requirement_id'];
		$amount_type = $_POST['amount_type'];
		$student_login_id = $_POST['student_login_id'];
		$tutor_login_id = $_POST['tutor_login_id'];
		$student_negotiate_amount = $_POST['student_negotiate_amount'];
		$tutor_negotiate_amount = $_POST['tutor_negotiate_amount'];
		$final_accepted_amount = $_POST['final_accepted_amount'];
		$status = $_POST['status'];
		$negotiate_by = $_POST['negotiate_by'];
		
		
		//$d=mktime(11, 14, 54, 8, 12, 2014);

		
		
		$date_time = date("Y-m-d h:i:sa");
		
		
		$tutorCodeSQL = mysqli_fetch_array($conn->query("SELECT tutor_code FROM user_tutor_info where user_id = '".$_POST['tutor_login_id']."'  "));

		$tutorCode = $tutorCodeSQL['tutor_code'];
		
	
		
		if($student_post_requirement_id !="" && $amount_type == "Negotiable" )
		{
			
          
			/// For Student update amount
			if($student_login_id !="" && $tutor_login_id !="" && $student_negotiate_amount !="" )
			{
			
				$chk = $conn->query("SELECT * FROM student_post_requirement_amount_negotiate WHERE student_login_id = '".$student_login_id."' and tutor_login_id = '".$tutor_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."' ");
			
				if(mysqli_num_rows($chk)>0)
				{
					
					
					
					
					if($final_accepted_amount=='')
					{
						$final_accepted_amount = 0.00;
					}
					
					
				//////////////	
					if($final_accepted_amount != 0 && $final_accepted_amount != "")
					{
						$nVal = mysqli_fetch_array($chk);
						$arrV = array($nVal['student_negotiate_amount'],$nVal['tutor_negotiate_amount']);

						//print_r($arrV);
                      
                      

						$final_accepted_amount_val = number_format((float)$final_accepted_amount, 2, '.', '');  
						//echo $final_accepted_amount_val;
						
						if(in_array($final_accepted_amount_val,$arrV, TRUE))
						{
							$mValS = 'Yes';
							
							
						}
						else{
							$mValS = 'No';
							
							
						}
						
						
					}
					else{
						$mValS = 1;
					}
					
				//////////////
				
				
				if($negotiate_by !="")
				{
					$negotiate_by_val = $negotiate_by;
				}
				else{
					$negotiate_by_val = "";
				}
				
				
				if($mValS==1 || $mValS == 'Yes')
				{
					$sql = $conn->query("UPDATE student_post_requirement_amount_negotiate SET student_negotiate_amount = '".$student_negotiate_amount."', final_accepted_amount = '".$final_accepted_amount."', status = '".$status."', negotiate_by = '".$negotiate_by_val."', date_time = '".$date_time."' WHERE student_login_id = '".$student_login_id."' and tutor_login_id = '".$tutor_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."' ");
					
					if($sql)
					{
						
						
						$nnsql = mysqli_fetch_array($conn->query("select tutor_tution_offer_amount_type, tutor_tution_offer_amount from student_post_requirements where student_post_requirements_id = '".$student_post_requirement_id."' "));
						
						if($nnsql['tutor_tution_offer_amount_type']=="Negotiable")
						{
							$Amount = $nnsql['tutor_tution_offer_amount'];
						}
						
						
						
						/// send Notification start
						
						if($negotiate_by_val == "Tutor")
						{
							
							
							$CHK_tutor_negotiate_amount = mysqli_fetch_array($conn->query("select tutor_negotiate_amount from student_post_requirement_amount_negotiate where student_login_id = '".$_POST['student_login_id']."' and tutor_login_id = '".$_POST['tutor_login_id']."' and student_post_requirement_id = '".$_POST['student_post_requirement_id']."' "));
							
							//echo $CHK_tutor_negotiate_amount['tutor_negotiate_amount'];
							
							if($CHK_tutor_negotiate_amount['tutor_negotiate_amount'] == "0.00" )
							{
								$title = 'You have a Fee Offer';
							}
							else{
								$title = 'You have an Updated Fee Offer';
							}
							
							
							$Sdevice_tokenS = $conn->query("select device_token from user_info where user_id = '".$_POST['student_login_id']."' ");
							
							if(mysqli_num_rows($Sdevice_tokenS)>0)
							{
								$device_Tokens = mysqli_fetch_array($Sdevice_tokenS);
								 $to = $device_Tokens['device_token'];
								
								
											
											
								$body = $tutorCode.' has offered SGD'.$_POST['tutor_negotiate_amount'].' per hour';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

									
								/// send notification	
								 sendPushNotification($accessToken, $to, $title, $body);	
								
							}
							else
							{								
							
							
							
							
							
							$aa1 = "SELECT device_token FROM user_info_device_token where user_id = '".$_POST['student_login_id']."'  ";

							$aa2 = $conn->query($aa1) or die ("table not found");
							
								   while($device_Token = mysqli_fetch_array($aa2))
								   {
									   
									   
									   
											$to = $device_Token['device_token'];
							   
											
											$body = $tutorCode.' has offered SGD'.$_POST['tutor_negotiate_amount'].' per hour';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

											
										/// send notification	
										sendPushNotification($accessToken, $to, $title, $body);	
										
								   } 
								   
							}	   
							
						}
						
						
						
						
					
						
						if($negotiate_by_val == "Student" && $final_accepted_amount == "0.00")    /// final_accepted_amount is blank
						{
							
							 
							
							$nnsql2 = mysqli_fetch_array($conn->query("select amount_type, final_accepted_amount from student_post_requirement_amount_negotiate where student_post_requirement_id = '".$student_post_requirement_id."' "));
							
							if($nnsql2['amount_type']=="Negotiable")
							{
								 $Amount = $nnsql2['final_accepted_amount'];
							}
							
							
							
							$studentFnameLnameSQL = mysqli_fetch_array($conn->query("select first_name, last_name from user_info where user_id = '".$_POST['student_login_id']."' "));
							
							
							$firstCharacter1 = substr($studentFnameLnameSQL['first_name'], 0, 1);
							$firstCharacter2 = substr($studentFnameLnameSQL['last_name'], 0, 1);
							
							$studentFnameLname = $firstCharacter1.' '.$firstCharacter2;
							
							
							
							$Sdevice_tokenS = $conn->query("select device_token from user_info where user_id = '".$_POST['tutor_login_id']."' ");
							
							if(mysqli_num_rows($Sdevice_tokenS)>0)
							{
								$device_Tokens = mysqli_fetch_array($Sdevice_tokenS);
								 $to = $device_Tokens['device_token'];
								 
								 $title = 'You have a Fee Offer';
											//TUAC3432 has offered  SGD35.00 per hour
											
											$body = $studentFnameLname.' has offered SGD'.$_POST['student_negotiate_amount'].' per hour.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

											
										/// send notification	
										sendPushNotification($accessToken, $to, $title, $body);	
							}
							else
							{
							
							$aa3 = "SELECT device_token FROM user_info_device_token where user_id = '".$_POST['tutor_login_id']."'  ";

							$aa4 = $conn->query($aa3) or die ("table not found");
						
							 while($device_Token2 = mysqli_fetch_array($aa4))
							 {
											
											$to = $device_Token2['device_token'];
							   
										
											$title = 'You have a Fee Offer';
											//TUAC3432 has offered  SGD35.00 per hour
											
											$body = $studentFnameLname.' has offered SGD'.$_POST['student_negotiate_amount'].' per hour.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

											
										/// send notification	
										sendPushNotification($accessToken, $to, $title, $body);	
							   } 
							   
							   
							}   
							   
						}
						
						
						
						
						if($negotiate_by_val == "Student" && $final_accepted_amount != "0.00")
						{
							
							 
							
							$nnsql2 = mysqli_fetch_array($conn->query("select amount_type, final_accepted_amount from student_post_requirement_amount_negotiate where student_post_requirement_id = '".$student_post_requirement_id."' "));
							
							if($nnsql2['amount_type']=="Negotiable")
							{
								 $Amount = $nnsql2['final_accepted_amount'];
							}
							
							
							
							$studentFnameLnameSQL = mysqli_fetch_array($conn->query("select first_name, last_name from user_info where user_id = '".$_POST['student_login_id']."' "));
							
							
							$firstCharacter1 = substr($studentFnameLnameSQL['first_name'], 0, 1);
							$firstCharacter2 = substr($studentFnameLnameSQL['last_name'], 0, 1);
							
							$studentFnameLname = $firstCharacter1.' '.$firstCharacter2;
							
							
							
							$Sdevice_tokenS = $conn->query("select device_token from user_info where user_id = '".$_POST['student_login_id']."' ");
							
							if(mysqli_num_rows($Sdevice_tokenS)>0)
							{
								$device_Tokens = mysqli_fetch_array($Sdevice_tokenS);
								 $to = $device_Tokens['device_token'];
								 
								 $title = 'You have a Fee Offer';
											//TUAC3432 has offered  SGD35.00 per hour
											
											$body = $studentFnameLname.' has offered SGD'.$_POST['student_negotiate_amount'].' per hour.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

											
										/// send notification	
										sendPushNotification($accessToken, $to, $title, $body);	
							}
							else
							{
							
							$aa3 = "SELECT device_token FROM user_info_device_token where user_id = '".$_POST['student_login_id']."'  ";

							$aa4 = $conn->query($aa3) or die ("table not found");
						
							 while($device_Token2 = mysqli_fetch_array($aa4))
							 {
											
											$to = $device_Token2['device_token'];
							   
										
											$title = 'You have a Fee Offer';
											//TUAC3432 has offered  SGD35.00 per hour
											
											$body = $studentFnameLname.' has offered SGD'.$_POST['student_negotiate_amount'].' per hour.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

											
										/// send notification	
										sendPushNotification($accessToken, $to, $title, $body);	
							   } 
							   
							   
							}   
							   
						}
						
						
						
						
						
						//// send to tutor if Client(student) Negotiates amount
						
						$query_stu_amt = mysqli_fetch_array($conn->query("SELECT student_negotiate_amount FROM student_post_requirement_amount_negotiate where tutor_login_id = '".$tutor_login_id."' and student_login_id = '".$student_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."' "));
						
						if($negotiate_by_val == "Student" && $query_stu_amt['student_negotiate_amount'] != "0.00")
						{
							
							$studentFnameLnameSQL = mysqli_fetch_array($conn->query("select first_name, last_name from user_info where user_id = '".$_POST['student_login_id']."' "));
							
							$firstCharacter1 = substr($studentFnameLnameSQL['first_name'], 0, 1);
							$firstCharacter2 = substr($studentFnameLnameSQL['last_name'], 0, 1);
							
							$studentFnameLname = $firstCharacter1.' '.$firstCharacter2;
							
							
							$Sdevice_tokenS = $conn->query("select device_token from user_info where user_id = '".$_POST['tutor_login_id']."' ");
							
							if(mysqli_num_rows($Sdevice_tokenS)>0)
							{
								$device_Tokens = mysqli_fetch_array($Sdevice_tokenS);
								 $to = $device_Tokens['device_token'];
								 
								 $title = 'You have an Updated Offer';
								 $body = $studentFnameLname.' has offered SGD'.$_POST['student_negotiate_amount'].' per hour.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    
								
											
										/// send notification	
										sendPushNotification($accessToken, $to, $title, $body);	
							}
							else
							{
							
							$aa3 = "SELECT device_token FROM user_info_device_token where user_id = '".$_POST['tutor_login_id']."'  ";

							$aa4 = $conn->query($aa3) or die ("table not found");
						
							 while($device_Token2 = mysqli_fetch_array($aa4))
							 {
											
									$to = $device_Token2['device_token'];
					   
								
									$title = 'You have an Updated Offer';
									$body = $studentFnameLname.' has offered SGD'.$_POST['student_negotiate_amount'].' per hour.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    
						
											
										/// send notification	
										sendPushNotification($accessToken, $to, $title, $body);	
							   } 
							   
							   
							}   
							   
						}
						
						/// send Notification end
						
						
						
						
						
						
						
						$resultData = array('status' => true, 'message' => 'Negotiate Amount Updated Successfully.', 'offer_amount_status' => $status, 'final_accepted_amount' => $final_accepted_amount );
					}
					else			
					{
						$resultData = array('status' => false, 'message' => 'Not updated.');
					}	

				}
				
				if($mValS=='No')
				{
					$resultData = array('status' => false, 'message' => 'Not match final accepted amount with student and tutor negotiate amount.');
				}

					
					
				}
									
					
							
					
				
				
					
				$state = 1;	

			}
			else{
				
				if($state !=2)
				{
				
					$resultData = array('status' => false, 'message' => 'Student id and Amount negotiate by student can\'t be blank.');
				}
			}
			
			
			
			
			/// For tutor update amount
			if($tutor_login_id !="" && $student_login_id !="" && $tutor_negotiate_amount !="" )
			{
				
		
		
				$query = "SELECT * FROM student_post_requirement_amount_negotiate where tutor_login_id = '".$tutor_login_id."' and student_login_id = '".$student_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."' ";
						
					
				$result = $conn->query($query) or die ("table not found");
				$numrows = mysqli_num_rows($result);
				
				
				if($numrows > 0)
				{
				
					if($final_accepted_amount=='')
					{
						$final_accepted_amount = 0.00;
					}
					
					
					
					//////////////	
					if($final_accepted_amount != 0 && $final_accepted_amount != "")
					{
						$nVal = mysqli_fetch_array($result);
						$arrV = array($nVal['student_negotiate_amount'],$nVal['tutor_negotiate_amount']);

						//print_r($arrV);

						$final_accepted_amount_val = number_format((float)$final_accepted_amount, 2, '.', '');  
						//echo $final_accepted_amount_val;
						
						if(in_array($final_accepted_amount_val,$arrV, TRUE))
						{
							$mValS = 'Yes';
							
							
						}
						else{
							$mValS = 'No';
							
							
						}
						
						
					}
					else{
						$mValS = 1;
					}
					
				//////////////
					
					
					
					if($mValS==1 || $mValS == 'Yes')
					{
					/// Record updated
						$nVal2 = mysqli_fetch_array($result);
						//$nVal2['no_of_tutor_offer_amount'];
					
						 $notoa = $nVal2['no_of_tutor_offer_amount'] + 1;
					
						$sql = $conn->query("UPDATE student_post_requirement_amount_negotiate SET tutor_negotiate_amount = '".$tutor_negotiate_amount."', no_of_tutor_offer_amount = '".$notoa."', final_accepted_amount = '".$final_accepted_amount."', status = '".$status."', date_time = '".$date_time."' WHERE tutor_login_id = '".$tutor_login_id."' and student_login_id = '".$student_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."'  ");
						
						if($sql)
						{
							$resultData = array('status' => true, 'message' => 'Negotiate Amount Updated Successfully.', 'offer_amount_status' => $status, 'final_accepted_amount' => $final_accepted_amount );
						}
						else			
						{
							$resultData = array('status' => false, 'message' => 'Not updated.');
						}				
						
					
					}
					
					if($mValS=='No')
					{
						$resultData = array('status' => false, 'message' => 'Not match final accepted amount with student and tutor negotiate amount.');
					}
					
					
				}
				else 
				{
					
					$add_negotiate_tag  = date('Y-m-d H:i:s');
					
					$sql = $conn->query("INSERT INTO student_post_requirement_amount_negotiate SET tutor_negotiate_amount = '".$tutor_negotiate_amount."', no_of_tutor_offer_amount = '1', date_time = '".$date_time."', add_negotiate_tag = '".$add_negotiate_tag."', IPT = 'New', tutor_login_id = '".$tutor_login_id."',student_login_id = '".$student_login_id."', student_post_requirement_id = '".$student_post_requirement_id."', amount_type='Negotiable', student_negotiate_amount=0.00, final_accepted_amount=0.00, status='' ");
					
					if($sql)
					{
						$resultData = array('status' => true, 'message' => 'Negotiate Amount Updated Successfully.', 'offer_amount_status' => $status, 'final_accepted_amount' => $final_accepted_amount );
					}
					else			
					{
						$resultData = array('status' => false, 'message' => 'Not updated.');
					}				
					
				}	
					
					
					
				
					
					
					$state = 2;	

			}
			else{
				
				if($state !=1)
				{
				
					$resultData = array('status' => false, 'message' => 'Tutor id and Amount negotiate by tutor can\'t be blank.');
				}
			}


			
		
		
		}
		else{
			
			$resultData = array('status' => false, 'message' => 'Please check the passive values.');
		}
		
		
		
		
					/// Accepted Amount
						
						
						
						//if($_POST['student_post_requirement_id'] !="" && $_POST['student_login_id'] !="" && $_POST['tutor_login_id'] !="" && $_POST['tutor_negotiate_amount'] != "0.00" && $final_accepted_amount != "0.00" && $final_accepted_amount != "" && $_POST['status'] != ""  )
							
						
						if($final_accepted_amount != "" && $_POST['status'] != ""  )
						{
							
							
							$nnsql2 = mysqli_fetch_array($conn->query("select amount_type, final_accepted_amount from student_post_requirement_amount_negotiate where student_post_requirement_id = '".$student_post_requirement_id."' "));
							
							if($nnsql2['amount_type']=="Negotiable")
							{
								 $Amount = $nnsql2['final_accepted_amount'];
							}
							
							
							
							$studentFnameLnameSQL = mysqli_fetch_array($conn->query("select first_name, last_name from user_info where user_id = '".$_POST['student_login_id']."' "));
							
							
							$firstCharacter1 = substr($studentFnameLnameSQL['first_name'], 0, 1);
							$firstCharacter2 = substr($studentFnameLnameSQL['last_name'], 0, 1);
							
							$studentFnameLname = $firstCharacter1.' '.$firstCharacter2;
							
							
							
							$Sdevice_tokenS = $conn->query("select device_token from user_info where user_id = '".$_POST['student_login_id']."' ");
							
							if(mysqli_num_rows($Sdevice_tokenS)>0)
							{
								$device_Tokens = mysqli_fetch_array($Sdevice_tokenS);
								 $to = $device_Tokens['device_token'];
								 
								 $title = 'You have a New Applicant';
											//TUAC3432 has offered  SGD35.00 per hour
								
								$body = $tutorCode.' has accepted the fee of SGD'.$_POST['final_accepted_amount'].' per hour';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

											
										/// send notification	
								sendPushNotification($accessToken, $to, $title, $body);	
								
								
							}
							else
							{
							
							$aa3 = "SELECT device_token FROM user_info_device_token where user_id = '".$_POST['student_login_id']."'  ";

							$aa4 = $conn->query($aa3) or die ("table not found");
						
							 while($device_Token2 = mysqli_fetch_array($aa4))
							 {
											
									$to = $device_Token2['device_token'];
					   
								
									 $title = 'You have a New Applicant';
									//TUAC3432 has offered  SGD35.00 per hour
						
									$body = $tutorCode.' has accepted the fee of SGD'.$_POST['final_accepted_amount'].' per hour';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

											
										/// send notification	
									sendPushNotification($accessToken, $to, $title, $body);	
							   
							   
							   } 
							   
							   
							}   
							   
						}
		
		
		
			
							
				echo json_encode($resultData);
				
					
			
?>