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
			
			$create_date = date("d-m-Y h:i:s");
			
			
	
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
						$firstCharacter = strtoupper(substr($FName, 0, 1));
						$secondCharacter = strtoupper(substr($LName, 0, 1));
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
							
							
							$count_update_date_time_val = mysqli_fetch_array($conn->query("SELECT count_update_date_time FROM tutor_booking_process  WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' "));
							
							$count_update_date_time = $count_update_date_time_val['count_update_date_time']+1;;
							
							
							$devT = $conn->query("select device_token from user_info_device_token where user_id = '".$_POST['tutor_id']."' ");
							
							while($device_token = mysqli_fetch_array($devT))
							{

								if($student_date_time_offer_confirmation_Sql['student_offer_date'] == "" && $student_date_time_offer_confirmation_Sql['student_offer_time'] == "" )
								{
									if($count_update_date_time == 1)
									{
										$title = $ST_Name.' has proposed a Start Date/Time';
									}
									else{
										$title = $ST_Name.' has updated a Start Date/Time';
									}
									
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
								$date_time_update_by = $_POST['date_time_update_by']; ///$student_date_time_offer_confirmation_Sql['date_time_update_by'];
								
								
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
								$tutorBookingProcessId = $student_date_time_offer_confirmation_Sql['tutor_booking_process_id'];
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
								
								
								
								/// Add Notification
								$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$_POST['tutor_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
								if(mysqli_num_rows($chk_noti)>0)
								{
									$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$_POST['tutor_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
								
									$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['tutor_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
								}
								else{
									$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['tutor_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
								
								}
								

								
							}
							
							
							 
							
							 $sql = $conn->query("UPDATE tutor_booking_process SET student_offer_date = '".$_POST['student_offer_date']."', student_offer_time = '".$_POST['student_offer_time']."', date_time_update_by = '".$_POST['date_time_update_by']."', update_date_time = '".$create_date."', count_update_date_time = '".$count_update_date_time."'  WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' ");
						
								
							
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
						
									$title = 'Tutor '.$tutor_data['tutor_code'].' has proposed a Start Date/Time.';
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
								
								
								 $tutor_booking_process_id = $student_date_time_offer_confirmation_Sql['tutor_booking_process_id'];
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
								$tutorBookingProcessId = $student_date_time_offer_confirmation_Sql['tutor_booking_process_id'];
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
								
								
								
								/// Add Notification
								$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
								if(mysqli_num_rows($chk_noti)>0)
								{
									$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
								
									$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
								}
								else{
									$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
								
								}
								
								
								
								
							}
							else{
							
							
							
								$Tok = $conn->query("select device_token from user_info_device_token where user_id = '".$_POST['student_id']."' ");
							
								while($device_token = mysqli_fetch_array($Tok))
								{

									$to =  $device_token['device_token']; 
						
									$title = 'Tutor '.$tutor_data['tutor_code'].' has proposed a Start Date/Time.';
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
								
								
								/// Add Notification
								$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
								if(mysqli_num_rows($chk_noti)>0)
								{
									$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
								
									$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
								}
								else{
									$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
								
								}
									
									
								}
								
								
							}
								
								
								
							$sql = $conn->query("UPDATE tutor_booking_process SET tutor_offer_date = '".$_POST['tutor_offer_date']."', tutor_offer_time = '".$_POST['tutor_offer_time']."', date_time_update_by = '".$_POST['date_time_update_by']."', update_date_time = '".$create_date."' WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' ");
						
									
								
							
						}	
						
						
						
						
						
					
						if($_POST['student_date_time_offer_confirmation'] == 'Confirmed' && $_POST['tutor_booking_process_id'] != "" && $_POST['student_id'] != "" && $_POST['student_offer_date'] !="" && $_POST['student_offer_time'] !="" && $_POST['date_time_update_by'] !="")
						{
						
							$sql = $conn->query("UPDATE tutor_booking_process SET student_date_time_offer_confirmation = '".$_POST['student_date_time_offer_confirmation']."',  student_offer_date = '".$_POST['student_offer_date']."', student_offer_time = '".$_POST['student_offer_time']."', date_time_update_by = '".$_POST['date_time_update_by']."', api_hit_date_by_confirmed_user = '".$api_hit_date_by_confirmed_user."', api_hit_time_by_confirmed_user = '".$api_hit_time_by_confirmed_user."', update_date_time = '".$create_date."' WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' and student_id = '".$_POST['student_id']."'  ");
						
						}
						else			
						{
							$resultData = array('status' => false, 'message' => 'tutor_booking_process_id,student_id,student_offer_date and student_offer_time can not be blank.');
						}
						
						
						if($_POST['student_date_time_offer_confirmation'] == 'Confirmed' && $_POST['tutor_booking_process_id'] != "" && $_POST['student_id'] != "" && $_POST['student_date_time_offer_confirmation'] !="" && $_POST['date_time_update_by'] !="" )
						{
						
							$sql3 = $conn->query("UPDATE tutor_booking_process SET student_date_time_offer_confirmation = '".$_POST['student_date_time_offer_confirmation']."', student_date_time_offer_confirmation = '".$_POST['student_date_time_offer_confirmation']."' , date_time_update_by = '".$_POST['date_time_update_by']."', api_hit_date_by_confirmed_user = '".$api_hit_date_by_confirmed_user."', api_hit_time_by_confirmed_user = '".$api_hit_time_by_confirmed_user."' , update_date_time = '".$create_date."' WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' and student_id = '".$_POST['student_id']."'  ");
						
						}
						else			
						{
							$resultData = array('status' => false, 'message' => 'tutor_booking_process_id,student_id and student_date_time_offer_confirmation can not be blank.');
						}
						
						
						if($_POST['student_date_time_offer_confirmation'] == 'Confirmed' && $_POST['tutor_booking_process_id'] != "" && $_POST['tutor_id'] != "" && $_POST['tutor_offer_date'] !="" && $_POST['tutor_offer_time'] !="" && $_POST['date_time_update_by'] !="")
						{
						
						
							$sql = $conn->query("UPDATE tutor_booking_process SET student_date_time_offer_confirmation = '".$_POST['student_date_time_offer_confirmation']."', tutor_accept_date_time_status = '".$tutor_accept_date_time_status."', tutor_offer_date = '".$_POST['tutor_offer_date']."', tutor_offer_time = '".$_POST['tutor_offer_time']."' , date_time_update_by = '".$_POST['date_time_update_by']."', api_hit_date_by_confirmed_user = '".$api_hit_date_by_confirmed_user."', api_hit_time_by_confirmed_user = '".$api_hit_time_by_confirmed_user."', update_date_time = '".$create_date."' WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' and tutor_id = '".$_POST['tutor_id']."'  ");
							
							
						}
						else			
						{
							$resultData = array('status' => false, 'message' => 'tutor_booking_process_id,tutor_id,tutor_offer_date and tutor_offer_time can not be blank.');
						}
						
						
						if($_POST['student_date_time_offer_confirmation'] == 'Confirmed' && $_POST['tutor_booking_process_id'] != "" && $_POST['tutor_id'] != "" && $_POST['tutor_accept_date_time_status'] !="" && $_POST['date_time_update_by'] !="")
						{
						
						
							$sql2 = $conn->query("UPDATE tutor_booking_process SET student_date_time_offer_confirmation = '".$_POST['student_date_time_offer_confirmation']."', tutor_accept_date_time_status = '".$tutor_accept_date_time_status."', tutor_accept_date_time_status = '".$_POST['tutor_accept_date_time_status']."' , date_time_update_by = '".$_POST['date_time_update_by']."', api_hit_date_by_confirmed_user = '".$api_hit_date_by_confirmed_user."', api_hit_time_by_confirmed_user = '".$api_hit_time_by_confirmed_user."', update_date_time = '".$create_date."' WHERE tutor_booking_process_id = '".$_POST['tutor_booking_process_id']."' and tutor_id = '".$_POST['tutor_id']."'  ");
							
							
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
								
								
								
								/// Add Notification
								$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
								if(mysqli_num_rows($chk_noti)>0)
								{
									$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
								
									$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
								}
								else{
									$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
								
								}
								
							
							
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
							$firstCharacter = strtoupper(substr($FName, 0, 1));
							$secondCharacter = strtoupper(substr($LName, 0, 1));
							$ST_Name = $firstCharacter.$secondCharacter;	
							
							//###################
									
									
									//echo $_POST['student_date_time_offer_confirmation'];
									
									
									$result_notify_data2 = mysqli_fetch_array($result);	
										
										
										////// If confirmation Confirmed condition start
										
										if($_POST['date_time_update_by'] == "student" && $_POST['student_date_time_offer_confirmation'] == "Confirmed" &&  $_POST['tutor_id'] !="" && $_POST['student_id'] !="" && $_POST['tutor_booking_process_id'] !="" && $_POST['current_app_date'] !="" && $_POST['current_app_time'] !="" && $result_notify_data2['tutor_accept_date_time_status'] == "")
										{
											
											$date_time_update_by = $_POST['date_time_update_by'];
											$student_date_time_offer_confirmation = $_POST['student_date_time_offer_confirmation'];
											$tutor_id = $_POST['tutor_id'];
											$tutor_booking_process_id = $_POST['tutor_booking_process_id'];
											
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
																	
																	
												
													/// Add Notification
													$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$_POST['tutor_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
													if(mysqli_num_rows($chk_noti)>0)
													{
														$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$_POST['tutor_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
													
														$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['tutor_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
													}
													else{
														$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['tutor_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
													
													}	
																	
																	
												
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
																	
																	
																	
													/// Add Notification
													$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$_POST['tutor_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
													if(mysqli_num_rows($chk_noti)>0)
													{
														$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$_POST['tutor_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
													
														$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['tutor_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
													}
													else{
														$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['tutor_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
													
													}					
																	
													
													
												}
												
											}
											
											
											
										}
										
										
										if($_POST['date_time_update_by'] == "tutor" && $_POST['student_date_time_offer_confirmation'] == "Confirmed" &&  $_POST['tutor_accept_date_time_status'] == "Accept" &&  $_POST['tutor_id'] !="" && $_POST['student_id'] !="" && $_POST['tutor_booking_process_id'] !="" && $_POST['current_app_date'] !="" && $_POST['current_app_time'] !="" )
										{
											
											
											$TutorCodeSQL = mysqli_fetch_array($conn->query("SELECT tutor_code FROM user_tutor_info WHERE user_id = '".$_POST['tutor_id']."' ")); 
											
											$TutorCodeV = $TutorCodeSQL['tutor_code'];
											
											
											$title = 'Tutor '.$TutorCodeV.' has Accepted your Start Date/Time';
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
																	
																	
													/// Add Notification
													$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
													if(mysqli_num_rows($chk_noti)>0)
													{
														$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
													
														$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
													}
													else{
														$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
													
													}				
														
																	
												
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
																	
													
												/// Add Notification
													$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
													if(mysqli_num_rows($chk_noti)>0)
													{
														$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$_POST['student_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - DateAndTimeOfferUpdate' ");
													
														$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
													}
													else{
														$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['student_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - DateAndTimeOfferUpdate', created_date = '".$create_date."' ");
													
													}													
																	
													
													
												}
												
											}
											
											
											
										}
										
										
										
										
						////// If confirmation confirmed condition end
										
										
										
										
						////////////	Discount Amount added for first time start ///////////////			
										
						
						$chk22 = $conn->query("
							SELECT * 
							FROM tutor_booking_process as process INNER JOIN tutor_booking_process_discount as chk_discont ON
							process.student_id = chk_discont.student_id
							WHERE process.acceptby <> '' 
								AND process.booked_date <> '' 
								AND process.tutor_booking_status = 'Accept' 
								AND process.offer_status = 'Accept' 
								AND process.student_date_time_offer_confirmation = 'Confirmed' 
								AND process.date_time_update_by <> '' 
								
								AND process.api_hit_date_by_confirmed_user <> '' 
								AND process.api_hit_time_by_confirmed_user <> '' 
								
								AND process.student_id = '".$_POST['student_id']."'
						");
						

					//echo mysqli_num_rows($chk);

					   
							
						
						 $countR = mysqli_num_rows($chk22);	
							
							if($countR == 0)
							{
								
							 $chk2 = $conn->query("
							SELECT * 
							FROM tutor_booking_process 
							WHERE  acceptby <> '' 
								AND booked_date <> '' 
								AND tutor_booking_status = 'Accept' 
								AND offer_status = 'Accept' 
								AND student_date_time_offer_confirmation = 'Confirmed' 
								AND date_time_update_by <> '' 
								
								AND api_hit_date_by_confirmed_user <> '' 
								AND api_hit_time_by_confirmed_user <> '' 
								
								AND student_id = '".$_POST['student_id']."'
						");	
						
						
								
							$booking_data = mysqli_fetch_array($chk2);
							
							if($booking_data['acceptby'] == 'tutor')
							{
								 $Final_Fee = $booking_data['amount_negotiate_by_student'];
							}
							if($booking_data['acceptby'] == 'student')
							{
								 $Final_Fee = $booking_data['amount_negotiate_by_tutor'];
							}
							 
							// echo $Final_Fee;
							 
							 
							$tutor_duration_weeks = explode('lessons a week', $booking_data['tutor_duration_weeks']);
							$tutor_duration_hours = explode('hours a lesson', $booking_data['tutor_duration_hours']);

							$one_week_hours = (float)$tutor_duration_weeks[0] * (float)$tutor_duration_hours[0];
							$one_month_hours = $one_week_hours * 4;

							 $Total_Fee_Of_Hours = $one_month_hours * $Final_Fee;
							 $Amount_to_Company_without_discount = $Total_Fee_Of_Hours / 2;

							 $record_no = mysqli_num_rows($chk2);

							// First-time discount 10%
							
						  
								$discount = 10; // Discount in %
								 $Save = $Amount_to_Company_without_discount * ($discount / 100); // 10% savings
								$Amount_to_Company_with_discount = $Amount_to_Company_without_discount - $Save;

								$Discount_Data[] = array(
									'discount_type' => 'First discount',
									'discount' => $discount,
									'Save' => $Save,
									'Amount_to_Company_without_discount' => $Amount_to_Company_without_discount,
									'Amount_to_Company_with_discount' => $Amount_to_Company_with_discount
								);
						   
							
							
							if($Amount_to_Company_with_discount != "" )
							{
								

									//$update_discount = $conn->query("INSERT INTO tutor_booking_process_discount SET student_id = '".$_POST['student_id']."', count_of_discount = 1	");	student_post_requirements_id
									$update_discount = $conn->query("INSERT INTO tutor_booking_process_discount SET student_id = '".$_POST['student_id']."', tutor_booking_process_id = '".$booking_data['tutor_booking_process_id']."',student_post_requirements_id = '".$booking_data['student_post_requirements_id']."',final_accepted_amount = '".$Final_Fee."',tutor_duration_weeks = '".$booking_data['tutor_duration_weeks']."',tutor_duration_hours = '".$booking_data['tutor_duration_hours']."',discount = '".$discount."',savings = '".$Save."',Amount_to_Company_with_discount = '".$Amount_to_Company_with_discount."', count_of_discount = 1	");	
													
								
								
								if($update_discount)
								{
									
									$tutor_booking_process_discount_GET = mysqli_fetch_array($conn->query("SELECT count_of_discount FROM tutor_booking_process_discount WHERE student_id = '".$_POST['student_id']."' and tutor_booking_process_id = '".$booking_data['tutor_booking_process_id']."' and student_post_requirements_id = '".$booking_data['student_post_requirements_id']."' " ));	
									
									$update_booking_No = $conn->query("UPDATE tutor_booking_process SET promocode = '".$tutor_booking_process_discount_GET['count_of_discount']."', update_date_time = '".$create_date."' WHERE student_id = '".$_POST['student_id']."' and tutor_id = '".$_POST['tutor_id']."' and tutor_booking_process_id = '".$booking_data['tutor_booking_process_id']."' and student_post_requirements_id = '".$booking_data['student_post_requirements_id']."' ");	
									
									$resultSet = array('status' => true, 'message' => 'Success', 'Discount_Data' => $Discount_Data);
								}
							}
							else{
								$resultSet = array('status' => true, 'message' => 'No record for discount.');
							}

						} 
						else 
						{
							//$resultSet = array('status' => false, 'message' => 'Record not found.');
							
							$Discount_Data = [];
							
						}

   
   
   
				////////////	Discount Amount added for first time end ///////////////	
						// Fetch the total count of bookings for the current month and only consider entries where Invoice_code is blank
						// Fetch the total count of bookings for the current month that have an empty Invoice_code
						$total_count_query = "
							SELECT COUNT(tutor_booking_process_id) AS booking_count
							FROM tutor_booking_process 
							WHERE 
								student_date_time_offer_confirmation = 'Confirmed'
								AND api_hit_date_by_confirmed_user <> '' 
								AND acceptby <> '' 
								AND booked_date <> '' 
								AND tutor_booking_status = 'Accept' 
								AND offer_status = 'Accept' 
								AND Invoice_code <> '' 
								AND DATE_FORMAT(STR_TO_DATE(api_hit_date_by_confirmed_user, '%d-%m-%Y'), '%Y-%m') = 
									DATE_FORMAT(NOW(), '%Y-%m')
						";

						$total_count_result = $conn->query($total_count_query);

						if (!$total_count_result) {
							die("Error fetching total count: " . $conn->error);
						}

						// Get the count of bookings with a valid Invoice_code
						$total_count_row = $total_count_result->fetch_assoc();
						$BookingCount = $total_count_row['booking_count'] ?? 0;

						// Increment the count for the new booking
						$BookingCount += 1;

						// Fetch the `created_date` for the given tutor_booking_process_id
						$tutor_booking_process_idVal = $conn->real_escape_string($_POST['tutor_booking_process_id']);
						$get_create_date_query = "
							SELECT api_hit_date_by_confirmed_user 
							FROM tutor_booking_process 
							WHERE tutor_booking_process_id = '$tutor_booking_process_idVal'
						";

						$get_create_date_result = $conn->query($get_create_date_query);

						if (!$get_create_date_result) {
							die("Error fetching creation date: " . $conn->error);
						}

						$get_create_date_row = $get_create_date_result->fetch_assoc();
						$created_date = $get_create_date_row['api_hit_date_by_confirmed_user'] ?? null;

						if (!$created_date) {
							die("Error: Creation date not found for the given `tutor_booking_process_id`.");
						}

						// Process the `created_date` to generate the `Invoice_code`
						$date_parts = explode('-', $created_date);

						if (count($date_parts) === 3) {
							$year = substr($date_parts[2], -2);
							$month = $date_parts[1];

							// Generate the invoice code
							$Invoice_code = $month . $year . '-038-' . str_pad($BookingCount, 1, '0', STR_PAD_LEFT);

							//echo "Generated Invoice Code: " . $Invoice_code;
						} else {
							die("Error: Invalid `created_date` format.");
						}

						// Update the `Invoice_code` in the database
						$update_query = "
							UPDATE tutor_booking_process 
							SET Invoice_code = '$Invoice_code' 
							WHERE 
								student_id = '".$conn->real_escape_string($_POST['student_id'])."' 
								AND tutor_id = '".$conn->real_escape_string($_POST['tutor_id'])."' 
								AND tutor_booking_process_id = '$tutor_booking_process_idVal' 
								AND Invoice_code = ''
						";

						$update_result = $conn->query($update_query);

						if (!$update_result) {
							die("Error updating Invoice_code: " . $conn->error);
						}
						
						
						//////////
   
   
   
							
							
							$resultData = array('status' => true, 'message' => 'Date and time Offer Acceptance Confirmed.', 'Discount_Data' => $Discount_Data);
						
						
						}
						
						
						
					}
					else 
					{
						//$message1="Email Id Or Mobile Number not valid !";
						$resultData = array('status' => false, 'message' => 'No Record Found. Check Passing Values.');
					
					}
			
			
	
		
							
					echo json_encode($resultData);
					
			
?>