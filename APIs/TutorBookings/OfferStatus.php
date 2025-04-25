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
			$serviceAccountEmail = 'firebase-adminsdk-fbsvc@tutorapp-7522f.iam.gserviceaccount.com'; // Replace with your service account email
			$privateKey = "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCwZcOIvh9XPQD6\nqwqnA89sHaase9+3s18TR3C4CFwqN6cqTv1tsAWqEMEg0aYFm2i3/KMFAma6LgN1\n8hDt4ZNqeVSj/XzL60iWDIDHKAE2F65upKUNMxeLc5qaYk4i9nJP7FbL/0EEhak2\nrJcHx63LNb/974vb26zy7jfXiGEJrDgLZkOrZMpO25g+MHH5h97L1s+hYF77Eygh\nuourI/ls6rn50mWlPgDqe1YgpK3H7xDvavtilktttZalbgv1bABHwlzE9Uas1H5y\neXqfAPaJu2hN+8CxaG6KUUmLqRaWTFFf0EnB5MDI1yJnVlKE2mtSfNdKZZs0zxlu\nDFc26zc5AgMBAAECggEAK+YbeB2mk5GfO4LTCxb36SZk6yKF3cPyOoxKKUaNV0VT\n4QPY7pICit0SDx6VlGolcLpbAJ1lHtriKhlkrKq5guMwlQI5607B2PPCHa4fRQy2\nMJthZwxKxP3vYRHrc6iE8M52mFyNG/i+kJh5mqpPHlYhUmsp0XyVSTzPIWCzk5IB\nWB6Q0fFrRfuFOX3pwoFWkjbqs0nRNxNy9/oAxcZUnwQw8m6Iv48NLFajgE4tNx9+\n0Vz8hNJ5LPeAVTiBU6+XQ9dmvQQKIIAzrzR7ujLP8syBq39+1DpCTr2ZVnITmIpX\nhy1bNmK/8K/tnO5R0BdVu84wiYnDK20zFRzRFSTJzQKBgQD124cM+sioke7+Rg6n\nARWz/zzvuDcRfT8lQM+Dl9SVW/PP3DH/+KmhkbRa89r39PnfpAkJtq7uSRB0+xis\nCw4W62iDOTgZ37clamOe2kvh8iidHbG0LUSZOK34V4TV+SkttLqWeFW3Gdaa751k\nqjbIK9fZnPFbMC/cZdqooH8/bQKBgQC3rK1eGkzK03yaNFscdlDNyXtNyM+zhqGR\nLU3Dn8jzgv71mHP4aXJJ4E74lgISINi2fXnX3rxeRTEu8tso79GQu8zruinsZTuD\nSXsOccW0SmdyBdMfO/a+3pg5BOfLTpM+dBVaU2GVpaIv0JhOB5MtweNnt5DISfY0\n5ICtdEPbfQKBgQDwMlWzHKBF8K1pxtAx4SFvBYJnQbarY435u2QB0Khkc72z6hD/\nX9V6gHuQEIZxkek90WjzEIO/Uaq+X0Mvcm2FfuBQs+pXfPXVnCdP3z4btRZwyb3/\npepLN9Dfu8GPuym7+cIBl/dGN/wuysMewh1bW1o6xNYYnO9liC0kagln0QKBgBq3\nnnxKvRLf0ocnyH0KZNSaUzpMVJIbqlLQ0Tf8fSGW03lsFKp0xDAk1bfpMiHq7zsU\nY23YM3RPAkl/AAwjXkt8VeGQMdr2GsMNJD5EpGqGTCfU2xH3CfxXqrLYmNME+fwi\nrJx39oDrF/12jUEEbw8/3dFPbVsFDzBAcMtKVziNAoGAAYYoBfrGhZBoEBzXBM+V\nxaa2Aly0VvkF4AZQTMGdMzlAosh8BE9VnE+pna4I9qhyYrOjJgX285GXz8r5EXbZ\nbLWZmte9CC9ENrT3RcKZWmW3Bxv5VvpITWQcNrB3j9D2uc+cfscCvVvCBxkV/LmQ\nzI4R2gJYm7sNq5AlmKNSprA=\n-----END PRIVATE KEY-----\n";

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



		function sendPushNotification($accessToken, $to, $title, $screen, $SelectedTab, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id, $student_offer_time, $student_offer_date, $ProfilePic, $qualification, $TutorCode, $flag, $tutor_id, $date_time_update_by, $tutor_offer_date, $tutor_offer_time, $tutor_accept_date_time_status,$acceptby, $body) 
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
							'acceptby' => $acceptby,
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
			$create_date = date("d-m-Y h:i:s");
			
			 $query = "SELECT * FROM tutor_booking_process where tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."'  ";
					
				
			$result = $conn->query($query) or die ("table not found");
			$numrows = mysqli_num_rows($result);
			
			
			if($numrows > 0)
			{
				
				

							
								$sql = $conn->query("UPDATE tutor_booking_process SET offer_status = '".$_POST['offer_status']."', acceptby = '".$_POST['acceptby']."', update_date_time = '".$create_date."'  WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' and tutor_tution_offer_amount_type = '".$_POST['tutor_tution_offer_amount_type']."'  ");
								
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
												
												$tutor_code_sho = mysqli_fetch_array($conn->query("SELECT tutor_code FROM user_tutor_info WHERE user_id = '".$chk_notify_user['tutor_id']."' "));
												
												///Student data
												
											$stu = $conn->query("SELECT student_id FROM tutor_booking_process where tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."'  ");
					
											$student_idV = mysqli_fetch_array($stu);	
											$student_data = mysqli_fetch_array($conn->query("SELECT first_name,last_name FROM user_info WHERE user_id = '".$student_idV['student_id']."' "));

											 $first_char = strtoupper(substr($student_data['first_name'], 0, 1));

											 $last_char = strtoupper(substr($student_data['last_name'], 0, 1));

									   
												if($offer_status=="Accept")
												{
													
													///Tutor data
													$tutor_data = mysqli_fetch_array($conn->query("SELECT profile_image,qualification,tutor_code,flag FROM user_tutor_info WHERE user_id = '".$chk_notify_user['tutor_id']."' "));
													
													
													 $title = 'Congrats! '.$tutor_code_sho['tutor_code'].' has accepted your Fee Offer';
													
													$body = 'View Details in My Bookings/In Progress'; 
													
													$screen = 'StartDT';
						
													$SelectedTab = "InProgress";
													
													
													
													$tutorBookingStatus = $chk_notify_user['tutor_booking_status'];
													
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
													
													$body = 'Tutor '.$tutor_code_sho['tutor_code']. ' has cancelled you offer.'; 
												}
												
												$tutorBookingProcessId = $chk_notify_user['tutor_booking_process_id'];
												$tutor_id = $chk_notify_user['tutor_id'];	
												$offerStatus = $_POST['offer_status'];
												$acceptby = $_POST['acceptby'];	
													
													 ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

													
												/// send notification	
												
												 //sendPushNotification($accessToken, $to, $title, $screen, $SelectedTab, $body);
												sendPushNotification($accessToken, $to, $title, $screen, $SelectedTab, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id, $student_offer_time, $student_offer_date, $ProfilePic, $qualification, $TutorCode, $flag, $tutor_id, $date_time_update_by, $tutor_offer_date, $tutor_offer_time, $tutor_accept_date_time_status,$acceptby, $body);
												
										   
												/// Add Notification
												$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$user_id_to_send_notification."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - OfferStatus' ");
												if(mysqli_num_rows($chk_noti)>0)
												{
													$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$user_id_to_send_notification."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - OfferStatus' ");
												
													$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$user_id_to_send_notification."', title = '".$title."', message = '".$body."', source = 'FROM API - OfferStatus', created_date = '".$create_date."' ");
												}
												else{
													$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$user_id_to_send_notification."', title = '".$title."', message = '".$body."', source = 'FROM API - OfferStatus', created_date = '".$create_date."' ");
												
												}
										   
										   
										   
										   
										   } 
											 
											 
											/// Send Firebase Notification end
										
										}
										
										
										
										
										
									  //if($_POST['acceptby']=='student' && $chk_notify_user['booking_from']=='Search' && $chk_notify_user['tutor_tution_offer_amount_type']=='Negotiable')
									  if($_POST['acceptby']=='student' && $chk_notify_user['tutor_tution_offer_amount_type']=='Negotiable')	  
									  {
										  
										  /// student details
										  
										 if($_POST['acceptby']=='tutor')
										 {	
											$user_idv = $user_id_to_send_notification;
										 }
										 if($_POST['acceptby']=='student')
										 {	
											$result_data = mysqli_fetch_array($result);
											
											$user_idv = $result_data['student_id'];
										 }
									 
											$student_details = mysqli_fetch_array($conn->query("SELECT first_name,last_name FROM user_info WHERE user_id = '".$user_idv."' "));
											$FName = $student_details['first_name'];
											$LName = $student_details['last_name'];
											$firstCharacter = strtoupper(substr($FName, 0, 1));
											$secondCharacter = strtoupper(substr($LName, 0, 1));
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
													//$offerStatus = '';
													//$tutorBookingProcessId = '';
													$student_id = '';
													$student_offer_time = '';
													$student_offer_date = '';
													$ProfilePic = '';
													$qualification = '';
													$TutorCode = '';
													$flag = '';
													//$tutor_id = '';
													$date_time_update_by = '';
													$tutor_offer_date = '';
													$tutor_offer_time = '';
													$tutor_accept_date_time_status = '';

													
													
												}
												else{
													$title = 'Offer Canceled';
												}
												
												$tutorBookingProcessId = $chk_notify_user['tutor_booking_process_id'];
												$tutor_id = $chk_notify_user['tutor_id'];	
												$offerStatus = $_POST['offer_status'];
												$acceptby = $_POST['acceptby'];	

												$body = 'View Details in My Bookings/In Progress';   ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    
										
												//$message = array('title' => $title,'body' => $body);

												/// send notification	
												
												// sendPushNotification($accessToken, $to, $title, $screen, $SelectedTab, $body);
												
												sendPushNotification($accessToken, $to, $title, $screen, $SelectedTab, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id, $student_offer_time, $student_offer_date, $ProfilePic, $qualification, $TutorCode, $flag, $tutor_id, $date_time_update_by, $tutor_offer_date, $tutor_offer_time, $tutor_accept_date_time_status,$acceptby, $body);
												
												
												/// Add Notification
												$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$user_id_to_send_notification."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - OfferStatus' ");
												if(mysqli_num_rows($chk_noti)>0)
												{
													$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$user_id_to_send_notification."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - OfferStatus' ");
												
													$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$user_id_to_send_notification."', title = '".$title."', message = '".$body."', source = 'FROM API - OfferStatus', created_date = '".$create_date."' ");
												}
												else{
													$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$user_id_to_send_notification."', title = '".$title."', message = '".$body."', source = 'FROM API - OfferStatus', created_date = '".$create_date."' ");
												
												}
												
												
												
												
										   }
											/// Send Firebase Notification end
										
										}
										
									
									
									
									  if($_POST['acceptby']=='tutor' && $chk_notify_user['tutor_tution_offer_amount_type']=='Non Negotiable')	   
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
													
													$screen = 'MyBookings';
						
													$SelectedTab = "InProgress";
													
													
													
													$tutorBookingStatus = $chk_notify_user['tutor_booking_status'];
													//$offerStatus = $chk_notify_user['offer_status'];
													//$tutorBookingProcessId = $chk_notify_user['tutor_booking_process_id'];
													$student_id = $chk_notify_user['student_id'];
													$student_offer_time = $chk_notify_user['student_offer_time'];
													$student_offer_date = $chk_notify_user['student_offer_date'];
													$ProfilePic = $tutor_data['profile_image'];
													$qualification = $tutor_data['qualification'];
													$TutorCode = $tutor_data['tutor_code'];
													$flag = $tutor_data['flag'];
													//$tutor_id = $chk_notify_user['tutor_id'];
													$date_time_update_by = $chk_notify_user['date_time_update_by'];
													$tutor_offer_date = $chk_notify_user['tutor_offer_date'];
													$tutor_offer_time = $chk_notify_user['tutor_offer_time'];
													$tutor_accept_date_time_status = $chk_notify_user['tutor_accept_date_time_status'];


													
													
												}
												else{
													$title = 'Offer Canceled';
												}
												
												$offerStatus = $_POST['offer_status'];
												$tutorBookingProcessId = $chk_notify_user['tutor_booking_process_id'];
												$tutor_id = $chk_notify_user['tutor_id'];
												$acceptby = $_POST['acceptby'];	
													
													$body = 'Congrats! Tutor has Accepted Your Fee Offer.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

													
												/// send notification	
												
												 //sendPushNotification($accessToken, $to, $title, $screen, $SelectedTab, $body);
												sendPushNotification($accessToken, $to, $title, $screen, $SelectedTab, $tutorBookingStatus, $offerStatus, $tutorBookingProcessId, $student_id, $student_offer_time, $student_offer_date, $ProfilePic, $qualification, $TutorCode, $flag, $tutor_id, $date_time_update_by, $tutor_offer_date, $tutor_offer_time, $tutor_accept_date_time_status,$acceptby, $body);
												
										   
												/// Add Notification
												$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$user_id_to_send_notification."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - OfferStatus' ");
												if(mysqli_num_rows($chk_noti)>0)
												{
													$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$user_id_to_send_notification."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - OfferStatus' ");
												
													$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$user_id_to_send_notification."', title = '".$title."', message = '".$body."', source = 'FROM API - OfferStatus', created_date = '".$create_date."' ");
												}
												else{
													$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$user_id_to_send_notification."', title = '".$title."', message = '".$body."', source = 'FROM API - OfferStatus', created_date = '".$create_date."' ");
												
												}
										   
										   
										   
										   
										   } 
											 
											 
											/// Send Firebase Notification end
										
										}
									
									
									
									   
									   
									   
									   
										

									
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