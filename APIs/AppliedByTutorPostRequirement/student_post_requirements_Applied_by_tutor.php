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



function sendPushNotification($accessToken, $deviceToken, $title, $body) {
    $url = 'https://fcm.googleapis.com/v1/projects/tutorapp-7522f/messages:send';
    
    // Payload for the notification
    $notificationPayload = array(
        'message' => array(
            'token' => $deviceToken, // Device token where notification will be sent
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
		
		
		
		
		$logged_in_tutor_id = $_POST['logged_in_tutor_id'];
		$student_post_requirements_id = $_POST['student_post_requirements_id'];
		$apply_tag = $_POST['apply_tag'];
		$date = date('d-m-Y');   //date('m-d-Y');
		
		date_default_timezone_set("Asia/Calcutta");  ///America/New_York
		$time =  date("h:i:sa");
		
		if($logged_in_tutor_id != "" && $student_post_requirements_id != "" && $apply_tag != "")
		{
			
          
          
          
			$check = $conn->query("select * from student_post_requirements where student_post_requirements_id = '".$student_post_requirements_id."' and post_expire_status <> 'Expired' ");
		
			if(mysqli_num_rows($check)>0)
			{
				
				
				 $tutorCodeSQL = mysqli_fetch_array($conn->query("SELECT tutor_code FROM user_tutor_info where user_id = '".$_POST['logged_in_tutor_id']."'  "));

				 $tutorCode = $tutorCodeSQL['tutor_code'];
				
				
				$check_apply = $conn->query("select * from student_post_requirements_Applied_by_tutor where tutor_login_id = '".$logged_in_tutor_id."' and student_post_requirements_id = '".$student_post_requirements_id."' ");
				
				$student_id = mysqli_fetch_array($check);
				
				if(mysqli_num_rows($check_apply)>0)
				{
					$update_apply_rec = $conn->query("UPDATE student_post_requirements_Applied_by_tutor SET apply_tag = '".$apply_tag."', applied_date = '".$date."', applied_time = '".$time."' WHERE tutor_login_id = '".$logged_in_tutor_id."' and student_post_requirements_id = '".$student_post_requirements_id."'  ");
					
					
					if($update_apply_rec)
					{
					    
					    
					    
					    //// Update student_post_requirements post_expire_status
						
							$apply_post = mysqli_fetch_array($conn->query("SELECT applied_date FROM student_post_requirements_Applied_by_tutor WHERE student_post_requirements_id = '".$student_post_requirements_id."' "));
						
						
							$str2 = $apply_post['applied_date'];
							$str2 = strtotime(date("M d Y ")) - (strtotime($str2));
							$total_days_for_expire_by_apply_post =  round($str2/3600/24);
							
							$expiredValue = round(45);
							
							if($total_days_for_expire_by_apply_post !="")
							{
								 $total_days_expire_by_apply_post = $total_days_for_expire_by_apply_post;
							}
							
							if($total_days_expire_by_apply_post !="" && $total_days_expire_by_apply_post > $expiredValue )
							{
								  $post_expire_status = 'Expired';
									 $Applied_status = 0; 	
										
							}
							else{
								 $post_expire_status = '';
								 $Applied_status = 1; 
								
									$sql = $conn->query("UPDATE student_post_requirements SET booked_date = '".$date."' ");
							}
							
							
							
                      
                     
							
							
						
						////
					    
					    
					    
						if($apply_tag=='true')
						{
							$msg = 'You have applied successfully.';
							
							$PostApply = 1;
						}
						if($apply_tag=='false')
						{
							$PostApply = 0;
							
							$msg = 'You have withdraw successfully.';
							
							$update_amount_negotiateSQL = $conn->query("UPDATE student_post_requirement_amount_negotiate SET tutor_negotiate_amount = '0.00' WHERE student_post_requirement_id = '".$student_post_requirements_id."' and tutor_login_id = '".$logged_in_tutor_id."' ");
						
							
							$student_token = $conn->query("select device_token from user_info_device_token where user_id = '".$student_id['logged_in_user_id']."' ");
						
								 while($device_Token = mysqli_fetch_array($student_token))
								 {
										 $to = $device_Token['device_token'];
										 
										 
										 $title = 'Application Withdrawn';
										 $body = $tutorCode.' has withdrawn application.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    
										
								
										/// send notification	
										sendPushNotification($accessToken, $to, $title, $body);	
								
										

								}
						
						
						}
						
						$resultData = array('status' => true, 'message' => $msg, 'student_post_requirements_id' => $student_post_requirements_id );
					}
					else{
						$resultData = array('status' => false, 'message' => 'error!');
					}
				}
				else{
					$insert_Tag = $conn->query("INSERT INTO student_post_requirements_Applied_by_tutor SET apply_tag = '".$apply_tag."', tutor_login_id = '".$logged_in_tutor_id."', student_post_requirements_id = '".$student_post_requirements_id."', applied_date = '".$date."', applied_time = '".$time."', student_response='',student_loggedIn_id= 0  ");	
					
					
					
					if($insert_Tag)
					{
						
						
						if($apply_tag == 'true')
						{
							
								$msg = 'You have applied successfully.';
							
						}
						
						
						if($apply_tag=='false')
						{
							
							$msg = 'You have withdraw successfully.';
							
							$update_amount_negotiateSQL = $conn->query("UPDATE student_post_requirement_amount_negotiate SET tutor_negotiate_amount = '0.00' WHERE student_post_requirement_id = '".$student_post_requirements_id."' and tutor_login_id = '".$logged_in_tutor_id."' ");
						
							
							//$student_id = mysqli_fetch_array($check);
						
							
							
								$student_token = $conn->query("select device_token from user_info_device_token where user_id = '".$student_id['logged_in_user_id']."' ");
						
								 while($device_Token = mysqli_fetch_array($student_token))
								 {
										 $to = $device_Token['device_token'];
										 
										 
										 $title = 'Application Withdrawn';
										 $body = $tutorCode.' has withdrawn application.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    
										
								
										/// send notification	
										sendPushNotification($accessToken, $to, $title, $body);	
								
										

								}
						
						
						}
						
						$resultData = array('status' => true, 'message' => $msg);
					}
					else{
						$resultData = array('status' => false, 'message' => 'error!');
					}
				}
				
				
				
				
				/// if post applied yes
				if($PostApply==1)
				{
					
					
						//echo $student_id['logged_in_user_id'];
						
						//echo "SELECT tutor_code FROM user_tutor_info where user_id = '".$_POST['logged_in_tutor_id']."'  ";
						
					
						//// if Non negotiable
							
							$nnsql = mysqli_fetch_array($conn->query("select tutor_tution_offer_amount_type, tutor_tution_offer_amount from student_post_requirements where student_post_requirements_id = '".$_POST['student_post_requirements_id']."' "));
							
							if($nnsql['tutor_tution_offer_amount_type']=="Non Negotiable")
							{
								$Amount = $nnsql['tutor_tution_offer_amount'];
							}
							
							//// if Negotiable
							
							$nnsql2 = mysqli_fetch_array($conn->query("select amount_type, final_accepted_amount from student_post_requirement_amount_negotiate where student_post_requirement_id = '".$_POST['student_post_requirements_id']."' "));
							
							if($nnsql2['amount_type']=="Negotiable")
							{
								 $Amount = $nnsql2['final_accepted_amount'];
							}
							
							
							
							
							$user_main_device_token = $conn->query("SELECT device_token FROM user_info WHERE user_id = '".$student_id['logged_in_user_id']."' ");
				
						if(mysqli_num_rows($user_main_device_token)>0)
						{
							
							 $user_device_token = mysqli_fetch_array($user_main_device_token);
							
							$to =  $user_device_token['device_token']; 
									 
								 $title = 'You have a New Applicant';
								 
								 $body = $tutorCode.' has accepted the fee of SGD'.$Amount.' per hour.';  
								

								 /// send notification	
								$response = sendPushNotification($accessToken, $to, $title, $body);	
							
						}
						else{
							
							
								$student_token = $conn->query("select device_token from user_info_device_token where user_id = '".$student_id['logged_in_user_id']."' ");
						
								 while($device_Token = mysqli_fetch_array($student_token))
								 {
									 
									 
									 $to = $device_Token['device_token'];
									 
									 $title = 'You have a New Applicant';
									 
									 $body = $tutorCode.' has accepted the fee of SGD'.$Amount.' per hour.';  
									

									 /// send notification	
									$response = sendPushNotification($accessToken, $to, $title, $body);	
									 
									// echo $response;
									 
								 }
							
						}

				}
				
				
				
				
				
			}
			else{
				$resultData = array('status' => false, 'message' => 'Student post has been expired.');
			}
		
		
		}
		else
		{
			$resultData = array('status' => false, 'message' => 'Logged in tutor id, post id and apply tag can\'t blank.');
		}			
		
		
					
			echo json_encode($resultData);
			
?>