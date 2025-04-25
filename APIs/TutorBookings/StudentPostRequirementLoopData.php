<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');



$servername = "localhost";
$username = "mytutors_tutorapp_ver3";
$password = "^%&^*&TYY6567*(&uyur$7";
$dbname = "mytutors_tutorapp_ver3";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 


      





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








	
			// Read the JSON file in PHP
			$data = file_get_contents("php://input");
			
			// Convert the JSON String into PHP Array
			$array = json_decode($data, true);
			
			
			
			$arrayV = array();  
			$arrayV2 = array(); 
			$arrayV3 = array();
			$arrayV4 = array();
			$arrayV5 = array();	
			$arrayV6 = array();	
			$arrayV7 = array();
			$arrayV8 = array();		
			$arrayV9 = array();	
			$arraySchedule = array();	
			
				
			
			//print_r($array);
			
			
			
			
			$logged_in_user_id = $array['logged_in_user_id'];
			
			$student_tution_type = $array['student_tution_type'];
			$student_postal_code = $array['student_postal_code'];
			$student_lat = $array['student_lat'];
			$student_long = $array['student_long'];
			$student_postal_address = $array['student_postal_address'];
			$tutor_duration_weeks = $array['tutor_duration_weeks'];
			$tutor_duration_hours = $array['tutor_duration_hours'];
			$tutor_tution_fees = $array['tutor_tution_fees'];
			$tutor_tution_schedule_time = $array['tutor_tution_schedule_time'];
			$tutor_tution_offer_amount_type = $array['tutor_tution_offer_amount_type'];
			$tutor_tution_offer_amount = $array['tutor_tution_offer_amount'];
			$booked_date = date('d-m-Y');
			
			
			$logged_in_user_idV2 = $array["logged_in_user_id"];
			
		
			if($logged_in_user_idV2 !="")
			{	
				$check_logged_user = $conn->query("select user_id from user_info where user_id = '".$logged_in_user_idV2."' ");
				
				if(mysqli_num_rows($check_logged_user)>0)
				{
				
				
				
			//$chk_booking = $conn->query("select * from student_post_requirements where logged_in_user_id = '".$logged_in_user_id."'  ");
			
			
			$arrayV[] = "('".$array["logged_in_user_id"]."','".$array["student_tution_type"]."','".$array["student_postal_code"]."','".$array["student_postal_address"]."','".$array["tutor_duration_weeks"]."','".$array["tutor_duration_hours"]."','".$array["tutor_tution_fees"]."','".$array["tutor_tution_schedule_time"]."','".$array["tutor_tution_offer_amount_type"]."','".$array["tutor_tution_offer_amount"]."','".$booked_date."')";				
			
			 $logged_in_user_idV = $array["logged_in_user_id"];
			
			
			//print_r($arrayV3);
			
			if($array["student_tution_type"]!="")
			{
				$student_tution_type = $array["student_tution_type"];
			
			}
			if($array["student_postal_code"]!="")
			{
				$student_postal_code = $array["student_postal_code"];
			}
			if($array["student_postal_address"]!="")
			{
				$student_postal_address = $array["student_postal_address"];
			}
			if($array["tutor_duration_weeks"]!="")
			{
				$tutor_duration_weeks = $array["tutor_duration_weeks"];
			}
			if($array["tutor_duration_hours"]!="")
			{
				$tutor_duration_hours = $array["tutor_duration_hours"];
			}
			if($array["tutor_tution_fees"]!="")
			{
				$tutor_tution_fees = $array["tutor_tution_fees"];
			}
			if($array["tutor_tution_schedule_time"]!="")
			{
				$tutor_tution_schedule_time = $array["tutor_tution_schedule_time"];
			}
			if($array["tutor_tution_offer_amount_type"]!="")
			{
				$tutor_tution_offer_amount_type = $array["tutor_tution_offer_amount_type"];
			}
			if($array["tutor_tution_offer_amount"]!="")
			{
				$tutor_tution_offer_amount = $array["tutor_tution_offer_amount"];
			}
			if($array["No_of_Students"]!="")
			{
				$No_of_Students = $array["No_of_Students"];
			}
			
			$Qualifications = $array['Qualifications'];
			
			
			
			$Tutor_Schedules_Slot_Time = $array['Tutor_Schedules_Slot_Time'];
			
			$Student_Level_Grade_Subjects = $array['Student_Level_Grade_Subjects'];
			
			
			
			$student_grade = $array['student_grade'];
			
			$Subjects = $array['Subjects'];
			$Qualifications = $array['Qualifications'];
			$Tutor_schedules = $array['Tutor_schedules'];
			$Slots_time = $array['Slots_time'];
			
			
			
			
			/// check user_tutor_info record
			
			$chk_rec = $conn->query("select * from student_post_requirements where logged_in_user_id = '".$logged_in_user_idV."' and student_tution_type = '".$student_tution_type."' and student_postal_code = '".$student_postal_code."' and student_postal_address = '".$student_postal_address."' and tutor_duration_weeks = '".$tutor_duration_weeks."' and tutor_duration_hours = '".$tutor_duration_hours."' and tutor_tution_fees = '".$tutor_tution_fees."' and tutor_tution_schedule_time = '".$tutor_tution_schedule_time."' and tutor_tution_offer_amount_type = '".$tutor_tution_offer_amount_type."' and tutor_tution_offer_amount = '".$tutor_tution_offer_amount."' and booked_date = '".$booked_date."' ");
			//$chk_rec = $conn->query("select * from student_post_requirements where logged_in_user_id = '".$logged_in_user_idV."'  ");
			
			
				
				if(mysqli_num_rows($chk_rec)>0)
				{
					
					
					
					
					$GET_Book_ID = mysqli_fetch_array($chk_rec);
					
					
					///Student levels
					$del_tLevel = $conn->query("delete from post_requirements_student_levels where student_post_requirements_id = '".$GET_Book_ID['student_post_requirements_id']."'  ");
					
					///Student Grade
					$del_tLevel = $conn->query("delete from post_requirements_student_grade where student_post_requirements_id = '".$GET_Book_ID['student_post_requirements_id']."'  ");
					
					
					///Student Subjects
					$del_tinfo = $conn->query("delete from post_requirements_student_subjects where student_post_requirements_id = '".$GET_Book_ID['student_post_requirements_id']."'  ");
					
					////Tutor Qualification
					$del_tinfo2 = $conn->query("delete from post_requirements_TutorQualification where student_post_requirements_id = '".$GET_Book_ID['student_post_requirements_id']."'  ");
					
					////Tutor Schedule
					$del_tinfo3 = $conn->query("delete from post_requirements_TutorSchedule where student_post_requirements_id = '".$GET_Book_ID['student_post_requirements_id']."'  ");
					
					
					
					//$tqsg = $conn->query("delete from student_post_requirements where student_post_requirements_id = '".$GET_Book_ID['student_post_requirements_id']."' ");
					
					//$query = "INSERT INTO `student_post_requirements` (logged_in_user_id,student_tution_type,student_postal_code,student_postal_address,tutor_duration_weeks,tutor_duration_hours,tutor_tution_fees,tutor_tution_schedule_time,tutor_tution_offer_amount_type,tutor_tution_offer_amount,booked_date) VALUES " . implode(', ', $arrayV);  
				
					//$query = $conn->query("INSERT INTO student_post_requirements SET logged_in_user_id= '".$logged_in_user_idV."', student_tution_type= '".$student_tution_type."', student_postal_code= '".$student_postal_code."', student_postal_address= '".$student_postal_address."', tutor_duration_weeks= '".$tutor_duration_weeks."', tutor_duration_hours= '".$tutor_duration_hours."', tutor_tution_fees= '".$tutor_tution_fees."', tutor_tution_schedule_time= '".$tutor_tution_schedule_time."', tutor_tution_offer_amount_type= '".$tutor_tution_offer_amount_type."', tutor_tution_offer_amount= '".$tutor_tution_offer_amount."', booked_date= '".$booked_date."',negotiate_by_tutor_amount_type=0,amount_negotiate_by_student = 0, negotiate_by_student_amount_type=0,tutor_booking_status='',offer_status='',student_offer_date='',student_offer_time='',tutor_offer_date='',tutor_offer_time='',student_date_time_offer_confirmation='',tutor_accept_date_time_status='',post_updated_date='',total_days_for_expire_post='',post_expire_status='',post_delist_status='', No_of_Students = '".$No_of_Students."' ");
					
				
				
				}
				else			
				{	
					
				//echo "INSERT INTO student_post_requirements SET logged_in_user_id= '".$logged_in_user_idV."', student_tution_type= '".$student_tution_type."', student_postal_code= '".$student_postal_code."', student_postal_address= '".$student_postal_address."', tutor_duration_weeks= '".$tutor_duration_weeks."', tutor_duration_hours= '".$tutor_duration_hours."', tutor_tution_fees= '".$tutor_tution_fees."', tutor_tution_schedule_time= '".$tutor_tution_schedule_time."', tutor_tution_offer_amount_type= '".$tutor_tution_offer_amount_type."', tutor_tution_offer_amount= '".$tutor_tution_offer_amount."', booked_date= '".$booked_date."' ";
					//$query = "INSERT INTO `student_post_requirements` (logged_in_user_id,student_tution_type,student_postal_code,student_postal_address,tutor_duration_weeks,tutor_duration_hours,tutor_tution_fees,tutor_tution_schedule_time,tutor_tution_offer_amount_type,tutor_tution_offer_amount,booked_date) VALUES " . implode(', ', $arrayV);  
				
					//$query = $conn->query("INSERT INTO student_post_requirements SET logged_in_user_id= '".$logged_in_user_idV."', student_tution_type= '".$student_tution_type."', student_postal_code= '".$student_postal_code."', student_postal_address= '".$student_postal_address."', tutor_duration_weeks= '".$tutor_duration_weeks."', tutor_duration_hours= '".$tutor_duration_hours."', tutor_tution_fees= '".$tutor_tution_fees."', tutor_tution_schedule_time= '".$tutor_tution_schedule_time."', tutor_tution_offer_amount_type= '".$tutor_tution_offer_amount_type."', tutor_tution_offer_amount= '".$tutor_tution_offer_amount."', booked_date= '".$booked_date."', negotiate_by_tutor_amount_type=0,amount_negotiate_by_student = 0, negotiate_by_student_amount_type=0,tutor_booking_status='',offer_status='',student_offer_date='',student_offer_time='',tutor_offer_date='',tutor_offer_time='',student_date_time_offer_confirmation='',tutor_accept_date_time_status='',post_updated_date='',total_days_for_expire_post='',post_expire_status='',post_delist_status='', No_of_Students = '".$No_of_Students."' ");
				
				
				}
				
				
				 $update_date_time = date('d-m-Y H:i:s');
				
				
				$query = $conn->query("INSERT INTO student_post_requirements SET logged_in_user_id= '".$logged_in_user_idV."', student_tution_type= '".$student_tution_type."', student_postal_code= '".$student_postal_code."', student_postal_address= '".$student_postal_address."', tutor_duration_weeks= '".$tutor_duration_weeks."', tutor_duration_hours= '".$tutor_duration_hours."', tutor_tution_fees= '".$tutor_tution_fees."', tutor_tution_schedule_time= '".$tutor_tution_schedule_time."', tutor_tution_offer_amount_type= '".$tutor_tution_offer_amount_type."', tutor_tution_offer_amount= '".$tutor_tution_offer_amount."', booked_date= '".$booked_date."', negotiate_by_tutor_amount_type=0,amount_negotiate_by_student = 0, negotiate_by_student_amount_type=0,tutor_booking_status='',offer_status='',student_offer_date='',student_offer_time='',tutor_offer_date='',tutor_offer_time='',student_date_time_offer_confirmation='',tutor_accept_date_time_status='',post_updated_date='',total_days_for_expire_post='',post_expire_status='',post_delist_status='', No_of_Students = '".$No_of_Students."', student_lat = '".$student_lat."', student_long = '".$student_long."' , update_date_time = '".$update_date_time."' ");
				
				
				
				
				// For Qualifications
				foreach($Qualifications as $row2 => $value2) 
				{
					//print_r($value2);
					if($value2['qualification'] !="" )
					{
						
						 $subject_val = $value2['qualification'];
						
						$arrayV3[] = "('".$value2['qualification']."')";
					}
					if($value2['qualification_id'] !="" )
					{
						//$arrayV3[] = "('".$subject_val."','".$value2['qualification_id']."')";
					}
					
				}
				
				
				
				// For Subjects
				foreach($Student_Level_Grade_Subjects as $row3 => $value3) 
				{
					
					foreach($value3 as $row4 => $value4) 
					{
						//print_r($row4);
						if($row4 == 'ALL_Subjects')
						{
							foreach($value4 as $row5 => $value5) 
							{
								//echo $row4;
								//print_r($value5);
								// $subject_val = $value3['ALL_Subjects'];
								
								$arrayV4[] = "('".$value5."')";
							}
						}
					
					}
				}
				
				
			
			
				if($query)
				{
					
					
					
					/// Send Firebase Notification start
										  
						   $aa1 = "SELECT device_token FROM user_info_device_token where user_id = '".$_POST['tutor_id']."'  ";

							$aa2 = $conn->query($aa1) or die ("table not found");
		
						   while($device_Token = mysqli_fetch_array($aa2))
						   {
								$to = $device_Token['device_token'];
					   
								
									$title = 'New Post';
									
									$body = 'New post created by student.';  

									
								/// send notification	
								sendPushNotification($accessToken, $to, $title, $body);	
								
								
								/// Add Notification
								$create_date = date("d-m-Y h:i:s");
								$chk_noti  = $conn->query("SELECT * FROM add_notifcations WHERE user_id_to_notification = '".$_POST['tutor_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostRequirementLoopData' ");
								if(mysqli_num_rows($chk_noti)>0)
								{
									$del_No  = $conn->query("DELETE FROM add_notifcations WHERE user_id_to_notification = '".$_POST['tutor_id']."' and title = '".$title."' and message = '".$body."' and source = 'FROM API - StudentPostRequirementLoopData' ");
								
									$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['tutor_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostRequirementLoopData', created_date = '".$create_date."' ");
								}
								else{
									$addN  = $conn->query("INSERT INTO add_notifcations SET user_id_to_notification = '".$_POST['tutor_id']."', title = '".$title."', message = '".$body."', source = 'FROM API - StudentPostRequirementLoopData', created_date = '".$create_date."' ");
								
								}
								
								
								
						   } 
							 
							 
							/// Send Firebase Notification end
					
					
					
					
					
					$getLastBooking_id = mysqli_fetch_array($conn->query("SELECT * FROM student_post_requirements ORDER BY student_post_requirements_id DESC LIMIT 0,1"));
				
					$level1 = $conn->query("delete from tbl_Student_Level_Grade_Subjects_Post_Requirement  where student_post_requirements_id = 0 ");
				
				
				
				
					/// For Add Level, Grade and Subjects		
					foreach($Student_Level_Grade_Subjects as $entry) {
						$id = $entry['ID'];
						$allSubjects = implode(',', $entry['ALL_Subjects']);
						
						$grade = $entry['Grade'];
						$level = $entry['Level'];
						$Admission_Level = $entry['Admission_Level'];
						
						//$level1 = $conn->query("delete from tbl_Student_Level_Grade_Subjects_Post_Requirement where Level = '".$level."' and Grade = '".$grade."' ");
					
						
						$query = $conn->query("INSERT INTO tbl_Student_Level_Grade_Subjects_Post_Requirement (ID, ALL_Subjects, Grade, Level, Admission_Level) VALUES ('$id', '$allSubjects', '$grade', '$level', '$Admission_Level')");
						
						
						
						if($level=="Secondary")
						{
						
							////////
							foreach($entry['Stream'] as $StreamsData)
							{
								$del_stream = $conn->query("delete from student_post_requirements_streams where student_post_requirements_id = 0  ");
								$add_stream = $conn->query("INSERT INTO student_post_requirements_streams  (student_post_requirements_streams, student_post_requirements_id) VALUES ('$StreamsData', '".$getLastBooking_id['student_post_requirements_id']."')");
							
							}
						}
						
						
						/////////
						
						
					}
					
					/// For Add Schedule and Times		
					foreach ($Tutor_Schedules_Slot_Time as $scheduleTime) {
						
						$slot_times = implode(',', $scheduleTime['slot_time']);
						$tutor_schedule = $scheduleTime['tutor_schedule'];
						
						
						//$scheduleTime_del = $conn->query("delete from tbl_Tutor_Schedules_Slot_Time_post_requirement where tutor_schedule = '".$tutor_schedule."' and slot_times = '".$slot_times."' ");
					
						
						$scheduleTime_insrt = $conn->query("INSERT INTO tbl_Tutor_Schedules_Slot_Time_post_requirement (tutor_schedule, slot_times) VALUES ('$tutor_schedule', '$slot_times')");
						
						
					}
					
					
					
					$level3 = $conn->query("UPDATE tbl_Student_Level_Grade_Subjects_Post_Requirement  SET student_post_requirements_id = '".$getLastBooking_id['student_post_requirements_id']."' where student_post_requirements_id = 0 "); 
					$scheduleTime_update = $conn->query("UPDATE tbl_Tutor_Schedules_Slot_Time_post_requirement SET student_post_requirements_id = '".$getLastBooking_id['student_post_requirements_id']."' where student_post_requirements_id = 0 ");  	
				
				
				
				//print_r($arrayV4);
					
					
					/// All Subjects
					$qua11 = $conn->query("delete from tbl_Student_Subjects_Post_Requirement where student_post_requirements_id = 0 ");
					$qua22 = $conn->query("INSERT INTO `tbl_Student_Subjects_Post_Requirement` (ALL_Subjects) VALUES " . implode(', ', $arrayV4));  
					$qua33 = $conn->query("UPDATE tbl_Student_Subjects_Post_Requirement SET student_post_requirements_id = '".$getLastBooking_id['student_post_requirements_id']."' where student_post_requirements_id = 0 ");  
					
					
					/// Tutor Qualification
					$qua1 = $conn->query("delete from post_requirements_TutorQualification where student_post_requirements_id = 0 ");
					$qua2 = $conn->query("INSERT INTO `post_requirements_TutorQualification` (Tutor_Qualification) VALUES " . implode(', ', $arrayV3));  
					$qua3 = $conn->query("UPDATE post_requirements_TutorQualification SET student_post_requirements_id = '".$getLastBooking_id['student_post_requirements_id']."' where student_post_requirements_id = 0 ");  
					
					
					
					
					
						
					if($qua3)
					{
						$resultData = array('status' => true, 'message' => 'Student Post Requirement Add Successfully.');
						
					}
				
				
				  
					
				}
				else
				{
					$resultData = array('status' => false, 'message' => 'Error Found.');
				}
			
			
				}
				else
				{
					$resultData = array('status' => false, 'message' => 'Logged In User ID Not Found.');
				}
				
			

			}
			else{
				$resultData = array('status' => false, 'message' => 'Logged in user id can\'t blank');
			}


				echo json_encode($resultData);
				
				
				
			
?>