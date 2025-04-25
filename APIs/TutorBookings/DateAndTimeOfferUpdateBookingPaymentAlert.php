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

		
		
		
		
		
		
		

		function sendPushNotification($accessToken, $to, $title, $body, $screen) 
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
	
	
	
	
	
				$query = "SELECT * FROM tutor_booking_process ";
							
						
					$result = $conn->query($query) or die ("table not found");
					$numrows = mysqli_num_rows($result);
					
					
					if($numrows > 0)
					{

						
						while($data = mysqli_fetch_array($result))
						{
						
						
							//date_default_timezone_set('Asia/Kolkata');
							date_default_timezone_set('Asia/Singapore');
							 $api_hit_date = $data['api_hit_date_by_confirmed_user'];											//date("d-m-Y");
							 $api_hit_time = $data['api_hit_time_by_confirmed_user'];               //date("H:i:s");

							
							
							//////######
							$student_token = mysqli_fetch_array($conn->query("SELECT device_token FROM user_info WHERE user_id = '".$data['student_id']."' "));
							
							
							
							
							
							$check_user_payment = mysqli_fetch_array($conn->query("SELECT * FROM tbl_payment as payment INNER JOIN  tutor_booking_process as book ON payment.tutor_booking_process_id = book.tutor_booking_process_id WHERE payment.tutor_booking_process_id = '".$data['tutor_booking_process_id']."' and payment.logged_in_user_id = '".$data['student_id']."' "));
							
							
							
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
										
										 $screen = '';
								
										 $to = $student_token['device_token'];
										 $body = "Make Payment in My Bookings/In Progress";
										 
										 
										 $notificationSent = sendPushNotification($accessToken, $to, $title, $body, $screen);

										
										
										/// Add Notification
										$create_date = date("d-m-Y h:i:s");
										
										$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$data['student_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdateBookingPaymentAlert' ");
										if(mysqli_num_rows($chk_noti)>0)
										{
											$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$data['student_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdateBookingPaymentAlert' ");
										
											$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$data['student_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdateBookingPaymentAlert', created_date = '".$create_date."' ");
										}
										else{
											$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$data['student_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdateBookingPaymentAlert', created_date = '".$create_date."' ");
										
										}
										
										
										
										
									} 
									elseif($timeDiff2 > (24 * 3600)) 
									{
										//echo "More than 24 hours remaining.";
										//$title = "Payment Due in within 23 hours";
									} 
									else 
									{
										//echo "The time has already passed.";
										//$title = "Payment Overdue. Booking is now cancelled.";
									}
								
								
								
								
								
							
							
							}
							
							
							//////####
							
							
						}	
							
							
					}		
					
					
					
							
		
		?>