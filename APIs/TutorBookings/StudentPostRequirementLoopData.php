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