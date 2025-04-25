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



		function sendPushNotification($accessToken, $to, $title, $body, $screen, $student_login_id, $tutor_login_id ) {
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
									'student_login_id' => $student_login_id,
									'tutor_login_id' => $tutor_login_id,
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
		$user_id_to_send_notification = $_POST['user_id_to_send_notification'];
		
		
		
		$ssqql = $conn->query("select * from student_post_requirement_amount_negotiate where student_login_id = '".$_POST['student_login_id']."' and tutor_login_id = '".$_POST['tutor_login_id']."' and student_post_requirement_id = '".$_POST['student_post_requirement_id']."' ");
							
		//echo mysqli_num_rows($ssqql);
		
		//$d=mktime(11, 14, 54, 8, 12, 2014);

		
		
		$date_time = date("Y-m-d h:i:sa");
		
		$create_date = date("d-m-Y h:i:s");
		
		
		$tutorCodeSQL = mysqli_fetch_array($conn->query("SELECT tutor_code FROM user_tutor_info where user_id = '".$_POST['tutor_login_id']."'  "));

		$tutorCode = $tutorCodeSQL['tutor_code'];
		
		
		$student_negotiate_amountV = mysqli_fetch_array($conn->query("SELECT student_negotiate_amount FROM student_post_requirement_amount_negotiate where tutor_login_id = '".$tutor_login_id."' and student_login_id = '".$student_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."' "));
						
		//echo $student_negotiate_amountV['student_negotiate_amount'];
						
		
		
		
	
		
		if($student_post_requirement_id !="" && $amount_type == "Negotiable" )
		{
			
          
			/// For Student update amount
			if($negotiate_by == "Student" && $student_login_id !="" && $tutor_login_id !="" && $student_negotiate_amount !="" )
			{
				
				
				$chk = $conn->query("SELECT * FROM student_post_requirement_amount_negotiate WHERE student_login_id = '".$student_login_id."' and tutor_login_id = '".$tutor_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."' ");
			
				if(mysqli_num_rows($chk)>0)
				{
					
					
					
					
					if($final_accepted_amount=='')
					{
						$final_accepted_amount = 0.00;
					}
					
					//echo $final_accepted_amount;
					
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
						
						if($negotiate_by_val == "Tutor" )  ///&& $_POST['student_negotiate_amount'] == ""
						{
							
							
							
							//echo mysqli_num_rows($ssqql).'=='.$_POST['tutor_negotiate_amount'];
							
							//echo $_POST['tutor_negotiate_amount'];	
							if(mysqli_num_rows($ssqql)>0 && $_POST['tutor_negotiate_amount'] != "" )
							{
								 $title = 'You have an Updated Fee Offer';
							}
							
							
							 $screen = 'MyPosts';
							 
							
							
							
							$aa1 = "SELECT device_token FROM user_info_device_token where user_id = '".$user_id_to_send_notification."'  ";

							$aa2 = $conn->query($aa1) or die ("table not found");
							
							   while($device_Token = mysqli_fetch_array($aa2))
							   {
								   
								   
								   $tutorCodeSQL = mysqli_fetch_array($conn->query("SELECT tutor_code FROM user_tutor_info where user_id = '".$_POST['tutor_login_id']."'  "));

									$tutorCode = $tutorCodeSQL['tutor_code'];
								   
									$to = $device_Token['device_token'];
					   
									$body = 'Tutor '.$tutorCode.' has offered SGD'.$_POST['tutor_negotiate_amount'].' per hour';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

										
									/// send notification	
									 sendPushNotification($accessToken, $to, $title, $body, $screen, $student_login_id, $tutor_login_id);	
									 
									 /// Add Notification
									$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_login_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
									if(mysqli_num_rows($chk_noti)>0)
									{
										$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_login_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
									
										$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_login_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
									}
									else{
										$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_login_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
									
									}
									
							   } 
								   
								   
							
						}
						
						
						
						
						
						if($negotiate_by_val == "Student" && $final_accepted_amount == 0 && $_POST['tutor_negotiate_amount']=="")    /// final_accepted_amount is blank
						{
							
							
							//$query_stu_amt = mysqli_fetch_array($conn->query("SELECT student_negotiate_amount FROM student_post_requirement_amount_negotiate where tutor_login_id = '".$tutor_login_id."' and student_login_id = '".$student_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."' "));

							if($student_negotiate_amountV['student_negotiate_amount'] == "0.00" && $_POST['tutor_negotiate_amount']=="" )
							{
							
							 
							
							$nnsql2 = mysqli_fetch_array($conn->query("select amount_type, final_accepted_amount from student_post_requirement_amount_negotiate where student_post_requirement_id = '".$student_post_requirement_id."' "));
							
							if($nnsql2['amount_type']=="Negotiable")
							{
								 $Amount = $nnsql2['final_accepted_amount'];
							}
							
							
							
							
							
							
							
							
							$aa3 = "SELECT device_token FROM user_info_device_token where user_id = '".$user_id_to_send_notification."'  ";

							$aa4 = $conn->query($aa3) or die ("table not found");
						
							 while($device_Token2 = mysqli_fetch_array($aa4))
							 {
											
											$studentFnameLnameSQL = mysqli_fetch_array($conn->query("select first_name, last_name from user_info where user_id = '".$_POST['student_login_id']."' "));
							
							
											$firstCharacter1 = strtoupper(substr($studentFnameLnameSQL['first_name'], 0, 1));
											$firstCharacter2 = strtoupper(substr($studentFnameLnameSQL['last_name'], 0, 1));
											
											$studentFnameLname = $firstCharacter1.' '.$firstCharacter2;
											
											
											$to = $device_Token2['device_token'];
											
											$screen = 'MyApplied';
										
											 $title = 'You have a Fee Offer';
											//TUAC3432 has offered  SGD35.00 per hour
											
											$body = $studentFnameLname.' has offered SGD'.$_POST['student_negotiate_amount'].' per hour.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

											
										/// send notification	
										sendPushNotification($accessToken, $to, $title, $body, $screen, $student_login_id, $tutor_login_id);	
										
										/// Add Notification
										$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$user_id_to_send_notification."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
										if(mysqli_num_rows($chk_noti)>0)
										{
											$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$user_id_to_send_notification."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
										
											$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$user_id_to_send_notification."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
										}
										else{
											$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$user_id_to_send_notification."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
										
										}
									 
							   } 
							   
							   
						 }
							   
						}
						
						
						//echo $final_accepted_amount;
						
						if($negotiate_by_val == "Student" && $final_accepted_amount != 0 && $_POST['tutor_negotiate_amount']=="")
						{
							
							 
							
							$nnsql2 = mysqli_fetch_array($conn->query("select amount_type, final_accepted_amount from student_post_requirement_amount_negotiate where student_post_requirement_id = '".$student_post_requirement_id."' "));
							
							if($nnsql2['amount_type']=="Negotiable")
							{
								 $Amount = $nnsql2['final_accepted_amount'];
							}
							
							
							
							
							
							
							$aa3 = "SELECT device_token FROM user_info_device_token where user_id = '".$user_id_to_send_notification."'  ";

							$aa4 = $conn->query($aa3) or die ("table not found");
						
							 while($device_Token2 = mysqli_fetch_array($aa4))
							 {
											
											$studentFnameLnameSQL = mysqli_fetch_array($conn->query("select first_name, last_name from user_info where user_id = '".$_POST['student_login_id']."' "));
							
							
											$firstCharacter1 = strtoupper(substr($studentFnameLnameSQL['first_name'], 0, 1));
											$firstCharacter2 = strtoupper(substr($studentFnameLnameSQL['last_name'], 0, 1));
											
											$studentFnameLname = $firstCharacter1.' '.$firstCharacter2;
							
							
											
											$to = $device_Token2['device_token'];
											$screen = 'MyApplied';
										
											 $title = 'You have a Fee Offer';
											//TUAC3432 has offered  SGD35.00 per hour
											
											$body = $studentFnameLname.' has offered SGD'.$_POST['student_negotiate_amount'].' per hour.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    

											
										/// send notification	
										 sendPushNotification($accessToken, $to, $title, $body, $screen, $student_login_id, $tutor_login_id);	
										
										/// Add Notification
										$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$tutor_login_id."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
										if(mysqli_num_rows($chk_noti)>0)
										{
											$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$tutor_login_id."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
										
											$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$tutor_login_id."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
										}
										else{
											$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$tutor_login_id."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
										
										}
										
							   } 
							   
							   
							   
							   
						}
						
						
						
						
						
						//// send to tutor if Client(student) Negotiates amount
						
						
							  
						
						//echo $student_negotiate_amount['student_negotiate_amount'];
						if($negotiate_by_val == "Student" && $student_negotiate_amountV['student_negotiate_amount'] != "0.00" && $_POST['tutor_negotiate_amount']=="")
						{
							
							
							
							
							$aa3 = "SELECT device_token FROM user_info_device_token where user_id = '".$user_id_to_send_notification."'  ";

							$aa4 = $conn->query($aa3) or die ("table not found");
						
							 while($device_Token2 = mysqli_fetch_array($aa4))
							 {
										
									$studentFnameLnameSQL = mysqli_fetch_array($conn->query("select first_name, last_name from user_info where user_id = '".$_POST['student_login_id']."' "));
							
									$firstCharacter1 = strtoupper(substr($studentFnameLnameSQL['first_name'], 0, 1));
									$firstCharacter2 = strtoupper(substr($studentFnameLnameSQL['last_name'], 0, 1));
									
									$studentFnameLname = $firstCharacter1.''.$firstCharacter2;
							
							
										
									$to = $device_Token2['device_token'];
									$screen = 'MyApplied';
								
									$title = 'You have an Updated Offer';
									$body = $studentFnameLname.' has offered SGD '.$_POST['student_negotiate_amount'].' per hour.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    
						
											
									/// send notification	
									 sendPushNotification($accessToken, $to, $title, $body, $screen, $student_login_id, $tutor_login_id);	
									
									/// Add Notification
									$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$tutor_login_id."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
									if(mysqli_num_rows($chk_noti)>0)
									{
										$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$tutor_login_id."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
									
										$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$tutor_login_id."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
									}
									else{
										$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$tutor_login_id."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
									
									}
									
							   } 
							   
							   
							   $sql = $conn->query("UPDATE student_post_requirement_amount_negotiate SET student_negotiate_amount = '".$_POST['student_negotiate_amount']."', final_accepted_amount = '".$final_accepted_amount."', status = '".$status."', negotiate_by = '".$negotiate_by_val."', date_time = '".$date_time."' WHERE student_login_id = '".$student_login_id."' and tutor_login_id = '".$tutor_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."' ");
					 
							  
							   
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
				else{
					
					
					
					
					
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
			if($negotiate_by == "Tutor" && $tutor_login_id !="" && $student_login_id !="" && $tutor_negotiate_amount !="" )
			{
				
		
		
				$query = "SELECT * FROM student_post_requirement_amount_negotiate where tutor_login_id = '".$tutor_login_id."' and student_login_id = '".$student_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."' ";
						
					
				$result = $conn->query($query) or die ("table not found");
				$numrows = mysqli_num_rows($result);
				
				
				if($numrows > 0)
				{
					
					
					
					
					//echo $student_negotiate_amount['student_negotiate_amount'];
						if($negotiate_by == "Tutor" && $_POST['student_negotiate_amount'] == "" && $_POST['tutor_negotiate_amount'] != "0.00" && $final_accepted_amount == "")
						{
							
							
							
							$aa3 = "SELECT device_token FROM user_info_device_token where user_id = '".$user_id_to_send_notification."'  ";

							$aa4 = $conn->query($aa3) or die ("table not found");
						
							 while($device_Token2 = mysqli_fetch_array($aa4))
							 {
										
									 $tutorCodeSQL = mysqli_fetch_array($conn->query("SELECT tutor_code FROM user_tutor_info where user_id = '".$_POST['tutor_login_id']."'  "));

									 $tutorCode = $tutorCodeSQL['tutor_code'];
									 
										
									 $to = $device_Token2['device_token'];
									 $screen = 'MyPosts';
								
									 $title = 'You have a Fee Offer';
									 $body = 'Tutor '.$tutorCode.' has offered SGD '.$_POST['tutor_negotiate_amount'].' per hour.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    
						
						
											
									/// send notification	
									  sendPushNotification($accessToken, $to, $title, $body, $screen, $student_login_id, $tutor_login_id);
									
									/// Add Notification
									$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_login_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
									if(mysqli_num_rows($chk_noti)>0)
									{
										$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_login_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
									
										$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_login_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
									}
									else{
										$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_login_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
									
									}
									
							   } 
							   
							   
							  // $sql = $conn->query("UPDATE student_post_requirement_amount_negotiate SET tutor_negotiate_amount = '".$_POST['tutor_negotiate_amount']."', final_accepted_amount = '".$final_accepted_amount."', status = '".$status."', negotiate_by = '".$negotiate_by_val."', date_time = '".$date_time."' WHERE student_login_id = '".$student_login_id."' and tutor_login_id = '".$tutor_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."' ");
					 
							  
							   
						}
						
						/// send Notification end
					
					
					
					
					
				
					if($final_accepted_amount=='')
					{
						$final_accepted_amount = 0.00;
					}
					
					
					//echo $final_accepted_amount;
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
					
						$sql = $conn->query("UPDATE student_post_requirement_amount_negotiate SET tutor_negotiate_amount = '".$tutor_negotiate_amount."', no_of_tutor_offer_amount = '".$notoa."', negotiate_by = '".$negotiate_by."', final_accepted_amount = '".$final_accepted_amount."', status = '".$status."', date_time = '".$date_time."' WHERE tutor_login_id = '".$tutor_login_id."' and student_login_id = '".$student_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."'  ");
						
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
					
					
					
					/// send Notification start
						
						if($negotiate_by == "Tutor" )    ///&& $_POST['student_negotiate_amount'] == ""
						{
							
							
							
							//echo mysqli_num_rows($ssqql).'=='.$_POST['tutor_negotiate_amount'];
							
							if(mysqli_num_rows($ssqql)==0 && $_POST['tutor_negotiate_amount'] != "" )
							{
								$title = 'You have a Fee Offer';
							}
							
							
							
							
							
							
							$aa1 = "SELECT device_token FROM user_info_device_token where user_id = '".$user_id_to_send_notification."'  ";

							$aa2 = $conn->query($aa1) or die ("table not found");
							
							   while($device_Token = mysqli_fetch_array($aa2))
							   {
								   
								   $tutorCodeSQL = mysqli_fetch_array($conn->query("SELECT tutor_code FROM user_tutor_info where user_id = '".$_POST['tutor_login_id']."'  "));

									$tutorCode = $tutorCodeSQL['tutor_code'];
								   
									$to = $device_Token['device_token'];
					   
									$body = 'Tutor '.$tutorCode.' has offered SGD'.$_POST['tutor_negotiate_amount'].' per hour';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    
									$screen = 'MyPosts';
										
									/// send notification	
									 sendPushNotification($accessToken, $to, $title, $body, $screen, $student_login_id, $tutor_login_id);

									 /// Add Notification
									$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_login_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
									if(mysqli_num_rows($chk_noti)>0)
									{
										$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_login_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
									
										$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_login_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
									}
									else{
										$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_login_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
									
									}	
									
							   } 
								   
								   
							
						}
					
					
					
					
					
					
					
					
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
							
							
							$firstCharacter1 = strtoupper(substr($studentFnameLnameSQL['first_name'], 0, 1));
							$firstCharacter2 = strtoupper(substr($studentFnameLnameSQL['last_name'], 0, 1));
							
							$studentFnameLname = $firstCharacter1.' '.$firstCharacter2;
							
							
							
							
							
							$aa3 = "SELECT device_token FROM user_info_device_token where user_id = '".$user_id_to_send_notification."'  ";

							$aa4 = $conn->query($aa3) or die ("table not found");
						
							 while($device_Token2 = mysqli_fetch_array($aa4))
							 {
											
									$to = $device_Token2['device_token'];
					   
								
									 $title = 'You have a New Applicant';
									//TUAC3432 has offered  SGD35.00 per hour
						
									$body = 'Tutor '.$tutorCode.' has accepted the fee of SGD'.$_POST['final_accepted_amount'].' per hour';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    
									$screen = 'MyPosts';
											
										/// send notification	
									sendPushNotification($accessToken, $to, $title, $body, $screen, $student_login_id, $tutor_login_id);	
									
									/// Add Notification
									$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_login_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
									if(mysqli_num_rows($chk_noti)>0)
									{
										$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_login_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostNegotiateOfferAmountUpdate' ");
									
										$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_login_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
									}
									else{
										$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_login_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostNegotiateOfferAmountUpdate', created_date = '".$create_date."' ");
									
									}
							   
							   
							   } 
							   
							   
							  
							   
						}
		
		
		
			
							
				echo json_encode($resultData);
				
					
			
?>