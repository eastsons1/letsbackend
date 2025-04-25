<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
	
	//// Notification start
	
			
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

		
		
		
		
		
		
		

		function sendPushNotification($accessToken, $to, $title, $ProfilePic, $body, $screen,) 
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
						'data' => array( 
									'ProfilePic' => $ProfilePic,
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




	
		$sender_id =  $_POST['logged_in_user_id'];	
		$chat_with_user_id = $_POST['chat_with_user_id'];
		$message = $_POST['message'];
		
		
		$dateTime = date('Y-m-d H:i:sP');
		
		//date_default_timezone_set('Asia/Kolkata');
		//$dateTime = date('Y-m-d H:i:sP', time());
		
		if($sender_id !="" && $chat_with_user_id !="" && $message !="" )
		{
			
			
			/// logged_in_user roll
			$logged_in_user_roll = mysqli_fetch_array($conn->query("SELECT user_type,user_id,profile_image,first_name,last_name FROM user_info WHERE user_id = '".$sender_id."'  "));
			
			/// chat_with_user_id roll
			$chat_with_user_id_roll = mysqli_fetch_array($conn->query("SELECT user_type,user_id,profile_image,first_name,last_name,device_token FROM user_info WHERE user_id = '".$chat_with_user_id."'  "));
			
			
			
			///check user start
			$sql_cchk = mysqli_fetch_array($conn->query("SELECT user_type,user_id FROM user_info WHERE user_id = '".$sender_id."' or user_id = '".$chat_with_user_id."'  "));
			
			if($sql_cchk['user_type']=="I am an Educator")
			{
				$logged_in_sender_user = 'Tutor';
				$identity_user = $sql_cchk['user_id'];
			}
			
			if($sql_cchk['user_type']=="I am looking for a Tutor")
			{
				$logged_in_sender_user = 'Student';
				$identity_user = $sql_cchk['user_id'];
			}
			
			if($sql_cchk['user_type']=="Admin")
			{
				$logged_in_sender_user = 'Admin';
				$identity_user = $sql_cchk['user_id'];
			}
			
			
			/// check user end
					
			
			$sql_add = $conn->query("INSERT INTO chatrooms SET loggedIn_user_id = '".$sender_id."', loggedIn_user_id_roll = '".$logged_in_user_roll['user_type']."',  chat_userid = '".$chat_with_user_id."', chat_userid_roll = '".$chat_with_user_id_roll['user_type']."', msg = '".$message."' , status = 'Send' , readUnreadMessageTag = 'unread' , created_on = '".$dateTime."' ");
			
			if($sql_add)
			{
				
				//// Sent Notification start ////
				
				if($chat_with_user_id_roll['user_type'] == "I am an Educator")
				{
					
					$to = $chat_with_user_id_roll['device_token'];   //// tutor id
					
					$title = ucfirst($logged_in_user_roll['first_name'])." ".$logged_in_user_roll['last_name'];  //// student name
					
					if($logged_in_user_roll['profile_image'] != "")
					{
						$ProfilePic = $logged_in_user_roll['profile_image'];  //// student image
					}
					else{
						$ProfilePic = '';
					}
					
					$body = $message;  ///// message
					$screen = 'ChatStacknavigation';
					
				}
				
				if($chat_with_user_id_roll['user_type'] == "I am looking for a Tutor")
				{
					
					$tutor_data = mysqli_fetch_array($conn->query("SELECT tutor_code,profile_image FROM user_tutor_info WHERE user_id = '".$sender_id."'  "));
			
					$to = $chat_with_user_id_roll['device_token'];  //// student id
					
					$title = $tutor_data['tutor_code'];  //// tutor name
					$ProfilePic = $tutor_data['profile_image'];  //// tutor image
					$body = $message;  ///// message
					$screen = 'ChatStacknavigation';
					
				}
				
				
					//echo $to.'=='.$title.'=='.$ProfilePic.'=='.$body;
					
				
				 sendPushNotification($accessToken, $to, $title, $ProfilePic, $body, $screen);
												
				//// send notification end ////
				
				
				
				///Sender and receiver All Chat Messages
				$send_receiver_message_array = array();
				
				
				
				$sql_m = $conn->query("SELECT * FROM chatrooms WHERE 
    
											(
												loggedIn_user_id LIKE '%".$sender_id."%' 
												OR loggedIn_user_id LIKE '%".$chat_with_user_id."%' 
											)
											AND (
												chat_userid LIKE '%".$chat_with_user_id."%' 
												OR chat_userid LIKE '%".$sender_id."%' 
											)
										ORDER BY created_on DESC");
				
				
				
				while($send_receive_messages = mysqli_fetch_array($sql_m))
				{
					
					
					
					
					/// user details start
					$user_array = array();
					
					if($logged_in_sender_user == 'Tutor')
					{
					
						$user_details_sql = $conn->query("SELECT info.first_name,info.last_name,Tinfo.user_id,Tinfo.profile_image FROM user_tutor_info as Tinfo INNER JOIN user_info as info ON Tinfo.user_id = info.user_id  ");
						
						$nameD = mysqli_fetch_array($conn->query("SELECT * FROM user_tutor_info as Tinfo INNER JOIN user_info as info ON Tinfo.user_id = info.user_id WHERE info.user_id = '".$send_receive_messages['loggedIn_user_id']."' "));
						$user_D = $nameD['first_name'].' '.$nameD['last_name'];
						$logged_in_sender_userT = 'Tutor';
						
					
					}
					
					if($logged_in_sender_user == 'Student')
					{
						
						/**
						$chk_student = $conn->query("SELECT user_id FROM user_student_info WHERE user_id = '".$send_receive_messages['loggedIn_user_id']."' ");
						
						if(mysqli_num_rows($chk_student)>0)
						{
							$user_details_sql = $conn->query("SELECT info.first_name,info.last_name,Sinfo.user_id,Sinfo.profile_image FROM user_student_info as Sinfo INNER JOIN user_info as info ON Sinfo.user_id = info.user_id  ");
						
							$nameD = mysqli_fetch_array($conn->query("SELECT info.first_name,info.last_name,Sinfo.user_id,Sinfo.profile_image FROM user_student_info as Sinfo INNER JOIN user_info as info ON Sinfo.user_id = info.user_id WHERE info.user_id = '".$send_receive_messages['loggedIn_user_id']."' "));
							$user_D = $nameD['first_name'].' '.$nameD['last_name'];
							$logged_in_sender_userT = 'Student';
						
						
						}
						else{
							**/
							
							$user_details_sql = $conn->query("SELECT * FROM user_info ");
							
							$nameD = mysqli_fetch_array($conn->query("SELECT first_name,last_name,profile_image FROM user_info WHERE user_id = '".$send_receive_messages['loggedIn_user_id']."' "));
							
							
							$user_D = $nameD['first_name'].' '.$nameD['last_name'];
							$logged_in_sender_userT = 'Student';
													
						//}
						
						
						
					}
					
					
					if($logged_in_sender_user == 'Admin')
					{
							
							$user_details_sql = $conn->query("SELECT * FROM user_info ");
							
							$nameD = mysqli_fetch_array($conn->query("SELECT first_name,last_name,profile_image FROM user_info WHERE user_id = '".$send_receive_messages['loggedIn_user_id']."' "));
							
							
							$user_D = $nameD['first_name'].' '.$nameD['last_name'];
							$logged_in_sender_userT = 'Admin';
													
						
					}
					
					
					
					while($user_details_Data = mysqli_fetch_array($user_details_sql))
					{
						
						$pro_img = mysqli_fetch_array($conn->query("SELECT DISTINCT Tinfo.profile_image FROM user_tutor_info as Tinfo INNER JOIN user_info as info ON Tinfo.user_id = info.user_id WHERE info.user_id = '".$send_receive_messages['loggedIn_user_id']."' "));
						
						$profile_img = $pro_img['profile_image']; 
						
							
							$user_array = array(
													'_id' => $send_receive_messages['loggedIn_user_id'],
													'name' => $user_D,
													'avatar' => $profile_img
											   );
						
					}
					/// user details end
					
					
					
					$send_receiver_message_array[] = array(
													'_id' => $send_receive_messages['id'],
													'text' => $send_receive_messages['msg'],
													
													'createdAt' => $send_receive_messages['created_on'],
													'user' => $user_array
													
												/**	'sender_user_id' => $send_receive_messages['loggedIn_user_id'],
													'receiver_user_id' => $send_receive_messages['chat_userid'],
													
													'status' => $send_receive_messages['status']  **/
													
					
												  );
				}
				
				
				
				
				
			
				if(!empty($send_receiver_message_array))
				{
					$resultData = array('status' => true , 'message' => 'Chat Messages List', 'Output' => $send_receiver_message_array );
			
				}
				
			
			
			}
			else
			{ 
				$resultData = array('status' => false, 'message' => 'Execution Error.' ); 
			}
			
		}
		else
		{
			$resultData = array('status' => false, 'message' => 'Please check the passive values.');
		}		
	
	
	
				
							
			echo json_encode($resultData);
					
			
?>