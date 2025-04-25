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
		
		
		$create_date = date("d-m-Y h:i:s");
		
		
		
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
						
							
							/**
							$student_token = $conn->query("select device_token from user_info_device_token where user_id = '".$student_id['logged_in_user_id']."' ");
						
								 while($device_Token = mysqli_fetch_array($student_token))
								 {
										 $to = $device_Token['device_token'];
										 
										 
										 $title = 'Application Withdrawn';
										 $body = $tutorCode.' has withdrawn application.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    
										
								
										/// send notification	
										sendPushNotification($accessToken, $to, $title, $body);	
								
										

								}
								
							**/	
						
						
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
							
							$update_interested = $conn->query("UPDATE student_post_requirements SET New_Interested = 1, update_date_time = '".$create_date."' WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");	
					
							
								$msg = 'You have applied successfully.';
							
						}
						
						
						if($apply_tag=='false')
						{
							
							$msg = 'You have withdraw successfully.';
							
							$update_amount_negotiateSQL = $conn->query("UPDATE student_post_requirement_amount_negotiate SET tutor_negotiate_amount = '0.00' WHERE student_post_requirement_id = '".$student_post_requirements_id."' and tutor_login_id = '".$logged_in_tutor_id."' ");
						
							
							//$student_id = mysqli_fetch_array($check);
						
							
							
							/**
								$student_token = $conn->query("select device_token from user_info_device_token where user_id = '".$student_id['logged_in_user_id']."' ");
						
								 while($device_Token = mysqli_fetch_array($student_token))
								 {
										 $to = $device_Token['device_token'];
										 
										 
										 $title = 'Application Withdrawn';
										 $body = $tutorCode.' has withdrawn application.';  ///Your Offer has been '.$offer_status.' for the booking ID '.$tutor_booking_process_id;    
										
								
										/// send notification	
										sendPushNotification($accessToken, $to, $title, $body);	
								
										

								}
								
							**/	
						
						
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
							
							
							
							/**
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
						
						**/
						

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