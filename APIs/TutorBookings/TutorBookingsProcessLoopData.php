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



		function sendPushNotification($accessToken, $to, $title, $screen, $bookingID, $TutorId, $studentId, $offerAmountType, $tutor_profile_image, $postal_code, $FName, $LName, $Bookdate, $body) {
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
							'bookingID' => $bookingID,
							'TutorId' => $TutorId,
							'studentId' => $studentId,
							'offerAmountType' => $offerAmountType,
							'tutor_profile_image' => $tutor_profile_image,
							'postal_code' => $postal_code,
							'FName' => $FName,
							'LName' => $LName,
							'Bookdate' => $Bookdate,
							
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














function mime2ext($mime){
    $all_mimes = '{"png":["image\/png","image\/x-png"],"bmp":["image\/bmp","image\/x-bmp",
    "image\/x-bitmap","image\/x-xbitmap","image\/x-win-bitmap","image\/x-windows-bmp",
    "image\/ms-bmp","image\/x-ms-bmp","application\/bmp","application\/x-bmp",
    "application\/x-win-bitmap"],"gif":["image\/gif"],"jpeg":["image\/jpeg",
    "image\/pjpeg"],"xspf":["application\/xspf+xml"],"vlc":["application\/videolan"],
    "wmv":["video\/x-ms-wmv","video\/x-ms-asf"],"au":["audio\/x-au"],
    "ac3":["audio\/ac3"],"flac":["audio\/x-flac"],"ogg":["audio\/ogg",
    "video\/ogg","application\/ogg"],"kmz":["application\/vnd.google-earth.kmz"],
    "kml":["application\/vnd.google-earth.kml+xml"],"rtx":["text\/richtext"],
    "rtf":["text\/rtf"],"jar":["application\/java-archive","application\/x-java-application",
    "application\/x-jar"],"zip":["application\/x-zip","application\/zip",
    "application\/x-zip-compressed","application\/s-compressed","multipart\/x-zip"],
    "7zip":["application\/x-compressed"],"xml":["application\/xml","text\/xml"],
    "svg":["image\/svg+xml"],"3g2":["video\/3gpp2"],"3gp":["video\/3gp","video\/3gpp"],
    "mp4":["video\/mp4"],"m4a":["audio\/x-m4a"],"f4v":["video\/x-f4v"],"flv":["video\/x-flv"],
    "webm":["video\/webm"],"aac":["audio\/x-acc"],"m4u":["application\/vnd.mpegurl"],
    "pdf":["application\/pdf","application\/octet-stream"],
    "pptx":["application\/vnd.openxmlformats-officedocument.presentationml.presentation"],
    "ppt":["application\/powerpoint","application\/vnd.ms-powerpoint","application\/vnd.ms-office",
    "application\/msword"],"docx":["application\/vnd.openxmlformats-officedocument.wordprocessingml.document"],
    "xlsx":["application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application\/vnd.ms-excel"],
    "xl":["application\/excel"],"xls":["application\/msexcel","application\/x-msexcel","application\/x-ms-excel",
    "application\/x-excel","application\/x-dos_ms_excel","application\/xls","application\/x-xls"],
    "xsl":["text\/xsl"],"mpeg":["video\/mpeg"],"mov":["video\/quicktime"],"avi":["video\/x-msvideo",
    "video\/msvideo","video\/avi","application\/x-troff-msvideo"],"movie":["video\/x-sgi-movie"],
    "log":["text\/x-log"],"txt":["text\/plain"],"css":["text\/css"],"html":["text\/html"],
    "wav":["audio\/x-wav","audio\/wave","audio\/wav"],"xhtml":["application\/xhtml+xml"],
    "tar":["application\/x-tar"],"tgz":["application\/x-gzip-compressed"],"psd":["application\/x-photoshop",
    "image\/vnd.adobe.photoshop"],"exe":["application\/x-msdownload"],"js":["application\/x-javascript"],
    "mp3":["audio\/mpeg","audio\/mpg","audio\/mpeg3","audio\/mp3"],"rar":["application\/x-rar","application\/rar",
    "application\/x-rar-compressed"],"gzip":["application\/x-gzip"],"hqx":["application\/mac-binhex40",
    "application\/mac-binhex","application\/x-binhex40","application\/x-mac-binhex40"],
    "cpt":["application\/mac-compactpro"],"bin":["application\/macbinary","application\/mac-binary",
    "application\/x-binary","application\/x-macbinary"],"oda":["application\/oda"],
    "ai":["application\/postscript"],"smil":["application\/smil"],"mif":["application\/vnd.mif"],
    "wbxml":["application\/wbxml"],"wmlc":["application\/wmlc"],"dcr":["application\/x-director"],
    "dvi":["application\/x-dvi"],"gtar":["application\/x-gtar"],"php":["application\/x-httpd-php",
    "application\/php","application\/x-php","text\/php","text\/x-php","application\/x-httpd-php-source"],
    "swf":["application\/x-shockwave-flash"],"sit":["application\/x-stuffit"],"z":["application\/x-compress"],
    "mid":["audio\/midi"],"aif":["audio\/x-aiff","audio\/aiff"],"ram":["audio\/x-pn-realaudio"],
    "rpm":["audio\/x-pn-realaudio-plugin"],"ra":["audio\/x-realaudio"],"rv":["video\/vnd.rn-realvideo"],
    "jp2":["image\/jp2","video\/mj2","image\/jpx","image\/jpm"],"tiff":["image\/tiff"],
    "eml":["message\/rfc822"],"pem":["application\/x-x509-user-cert","application\/x-pem-file"],
    "p10":["application\/x-pkcs10","application\/pkcs10"],"p12":["application\/x-pkcs12"],
    "p7a":["application\/x-pkcs7-signature"],"p7c":["application\/pkcs7-mime","application\/x-pkcs7-mime"],"p7r":["application\/x-pkcs7-certreqresp"],"p7s":["application\/pkcs7-signature"],"crt":["application\/x-x509-ca-cert","application\/pkix-cert"],"crl":["application\/pkix-crl","application\/pkcs-crl"],"pgp":["application\/pgp"],"gpg":["application\/gpg-keys"],"rsa":["application\/x-pkcs7"],"ics":["text\/calendar"],"zsh":["text\/x-scriptzsh"],"cdr":["application\/cdr","application\/coreldraw","application\/x-cdr","application\/x-coreldraw","image\/cdr","image\/x-cdr","zz-application\/zz-winassoc-cdr"],"wma":["audio\/x-ms-wma"],"vcf":["text\/x-vcard"],"srt":["text\/srt"],"vtt":["text\/vtt"],"ico":["image\/x-icon","image\/x-ico","image\/vnd.microsoft.icon"],"csv":["text\/x-comma-separated-values","text\/comma-separated-values","application\/vnd.msexcel"],"json":["application\/json","text\/json"]}';
    $all_mimes = json_decode($all_mimes,true);
    foreach ($all_mimes as $key => $value) {
        if(array_search($mime,$value) !== false) return $key;
    }
    return false;
}





	
			// Read the JSON file in PHP
			$data = file_get_contents("php://input");
			
			// Convert the JSON String into PHP Array
			$array = json_decode($data, true);
			
			
			// Ensure proper JSON decoding
				if ($array === null) {
					echo json_encode(['status' => false, 'message' => 'Invalid JSON data']);
					exit;
				}
			
			
			
			$arrayV = array();  
			$arrayV2 = array(); 
			$arrayV3 = array();
			$arrayV4 = array();
			$arrayV5 = array();	
			$arrayV6 = array();	
			$arraySchedule = array();			
			
			
			$student_post_requirements_id = $array['student_post_requirements_id'];
			$student_id = $array['student_id'];
			$postal_code = $array['postal_code'];
			$postal_address = $array['postal_address'];
			$tutor_id = $array['tutor_id'];
			$student_level = $array['student_level'];
			$student_grade = $array['student_grade'];
			$student_tution_type = $array['student_tution_type'];
			$tutor_duration_weeks = $array['tutor_duration_weeks'];
			$tutor_duration_hours = $array['tutor_duration_hours'];
			$tutor_tution_fees = $array['tutor_tution_fees'];
			$tutor_tution_schedule_time = $array['tutor_tution_schedule_time'];
			$tutor_tution_offer_amount_type = $array['tutor_tution_offer_amount_type'];
			$tutor_tution_offer_amount = $array['tutor_tution_offer_amount'];
			$No_of_Students = $array['No_of_Students'];
			
			$acceptby = $array['acceptby'];
			$tutor_booking_status = $array['tutor_booking_status'];
			$offer_status = $array['offer_status'];
			
			$booked_date = $array['booked_date'];
			
			
			$chk_booking = $conn->query("select * from tutor_booking_process where student_id = '".$student_id."' and tutor_id = '".$tutor_id."' ");
			
			//if(mysqli_num_rows($chk_booking)==0)
			//{	
			
			if($student_id !="" && $tutor_id !="")
			{
			
			
			$arrayV[] = "('".$array["student_post_requirements_id"]."','".$array["student_id"]."','".$array["student_tution_type"]."','".$array["postal_code"]."','".$array["postal_address"]."','".$array["tutor_id"]."','".$array["booking_from"]."','".$array["tutor_duration_weeks"]."','".$array["tutor_duration_hours"]."','".$array["tutor_tution_fees"]."','".$array["tutor_tution_schedule_time"]."','".$array["tutor_tution_offer_amount_type"]."','".$array["tutor_tution_offer_amount"]."','".$array["booked_date"]."','','','','','','0.00','','','','','','','','','','','".$array["No_of_Students"]."','".$array["acceptby"]."','".$array["tutor_booking_status"]."','".$array["offer_status"]."')";				
			
			$student_idV = $array["student_id"];
			$tutor_idV = $array["tutor_id"];
			
			$Tutor_Schedules_Slot_Time = $array['Tutor_Schedules_Slot_Time'];
			
			$Student_Level_Grade_Subjects = $array['Student_Level_Grade_Subjects'];
			
			
			$Qualifications = $array['Qualifications'];
			
			$booking_from = $array["booking_from"];
			
			
			
			/// check user_tutor_info record
			
			$chk_rec = $conn->query("select * from tutor_booking_process where student_id = '".$student_idV."' and tutor_id = '".$tutor_idV."' ");
			//$chk_rec = $conn->query("select * from tutor_booking_process where student_id = '".$student_idV."'  ");
			
			
			
			
			
			
			 $query = "INSERT INTO `tutor_booking_process` (student_post_requirements_id,student_id,student_tution_type,postal_code,postal_address,tutor_id,booking_from,tutor_duration_weeks,tutor_duration_hours,tutor_tution_fees,tutor_tution_schedule_time,tutor_tution_offer_amount_type,tutor_tution_offer_amount,booked_date,student_level,negotiate_by_tutor_amount_type,negotiate_by_student_amount_type,negotiateby,amount_negotiate_by_student,student_grade,amount_negotiate_by_tutor,student_offer_date,student_offer_time,tutor_offer_date,tutor_offer_time,student_date_time_offer_confirmation,tutor_accept_date_time_status,date_time_update_by,api_hit_date_by_confirmed_user,api_hit_time_by_confirmed_user,No_of_Students,acceptby,tutor_booking_status,offer_status) VALUES " . implode(', ', $arrayV);  
			
			

			if($conn->query($query))
			{
				
				$getLastBooking_id = mysqli_fetch_array($conn->query("SELECT * FROM tutor_booking_process ORDER BY tutor_booking_process_id DESC LIMIT 0,1"));
				
				$getLastBooking_id_val = $getLastBooking_id['tutor_booking_process_id'];
				
				/// student details
				$student_details = mysqli_fetch_array($conn->query("SELECT * FROM user_info WHERE user_id = '".$getLastBooking_id['student_id']."' "));
				/// tutor details
				$tutor_details = mysqli_fetch_array($conn->query("SELECT profile_image,postal_code FROM user_tutor_info WHERE user_id = '".$getLastBooking_id['tutor_id']."' "));
				
				
				//// send Notification 
				
				$user_main_device_token = $conn->query("SELECT device_token FROM user_info WHERE user_id = '".$tutor_idV."' ");
				
				if(mysqli_num_rows($user_main_device_token)>0)
				{
					$user_device_token = mysqli_fetch_array($user_main_device_token);
					
					$to =  $user_device_token['device_token']; //'dEdHrvwzT9iuUWJ9NZ5zOk:APA91bED869klnlM3LHvEp75KSa-GJha48otaM6iLzFjeaKN8fV4e2PccKVCw7QZgRUfNJqsflwmt40FvzGlJIVdc6BkwXeSCQoW6465dYgnqoBxa14MQmIpkDvCMnXUO2f3xx2OPmcz'; // Replace with your device token  //  $tutor_devi_token['device_token']; //
					
					$bookingID = $getLastBooking_id_val;
					$TutorId = $getLastBooking_id['tutor_id'];
					$studentId = $getLastBooking_id['student_id'];
					$offerAmountType = $getLastBooking_id['tutor_tution_offer_amount_type'];
					$tutor_profile_image = $tutor_details['profile_image'];
					$postal_code = $tutor_details['postal_code'];
					$FName = $student_details['first_name'];
					$LName = $student_details['last_name'];
					$Bookdate = $getLastBooking_id['booked_date'];
					
					

					$firstCharacter = substr($FName, 0, 1);
					$secondCharacter = substr($LName, 0, 1);
					$ST_Name = $firstCharacter.$secondCharacter;

					
					if($student_post_requirements_id == "")
					{
					
						$title = 'Congrats! '.$ST_Name.' wants to engage you as a Tutor';
						$screen = 'TutorBookingConfirmation';
						$body = 'View Details in My Bookings/New Requests';
					}
					if($student_post_requirements_id != "")
					{
					
						$title = 'Congrats! You have been Booked by '.$ST_Name.'.';
						$screen = 'TutorBookingConfirmation';
						$body = 'View details in My Bookings/In Progress.';
					}
					
					
              		//if(sendPushNotification($accessToken, $to, $title, $screen, $body))   // Output the result of sending the notification
					if(sendPushNotification($accessToken, $to, $title, $screen, $bookingID, $TutorId, $studentId, $offerAmountType, $tutor_profile_image, $postal_code, $FName, $LName, $Bookdate, $body))
					{
						$Nmsg = 1;
					}
					else
					{
						$Nmsg = 0;
					}
					
					
					if($Nmsg == 1)
					{
						$Notification_msg = 'Success';
					}	
					if($Nmsg == 0)
					{
						$Notification_msg = 'Failed';
					}	
					
					
					
				}
				else
				{
					
					
				$devSQL = $conn->query("select device_token from user_info_device_token where user_id = '".$tutor_idV."' ");	
				
				while($tutor_devi_token = mysqli_fetch_array($devSQL))
				{

					
					$to =  $tutor_devi_token['device_token']; //'dEdHrvwzT9iuUWJ9NZ5zOk:APA91bED869klnlM3LHvEp75KSa-GJha48otaM6iLzFjeaKN8fV4e2PccKVCw7QZgRUfNJqsflwmt40FvzGlJIVdc6BkwXeSCQoW6465dYgnqoBxa14MQmIpkDvCMnXUO2f3xx2OPmcz'; // Replace with your device token  //  $tutor_devi_token['device_token']; //
					
					
					
					$bookingID = $getLastBooking_id_val;
					$TutorId = $getLastBooking_id['tutor_id'];
					$studentId = $getLastBooking_id['student_id'];
					$offerAmountType = $getLastBooking_id['tutor_tution_offer_amount_type'];
					$tutor_profile_image = $tutor_details['profile_image'];
					$postal_code = $tutor_details['postal_code'];
					$FName = $student_details['first_name'];
					$LName = $student_details['last_name'];
					$Bookdate = $getLastBooking_id['booked_date'];
					
					$firstCharacter = substr($FName, 0, 1);
					$secondCharacter = substr($LName, 0, 1);
					$ST_Name = $firstCharacter.$secondCharacter;

					
					
					if($student_post_requirements_id == "")
					{
					
						$title = 'Congrats! '.$ST_Name.' wants to engage you as a Tutor';
						$screen = 'TutorBookingConfirmation';
						$body = 'View Details in My Bookings/New Requests';
					}
					if($student_post_requirements_id != "")
					{
					
						$title = 'Congrats! You have been Booked by '.$ST_Name.'.';
						$screen = 'TutorBookingConfirmation';
						$body = 'View details in My Bookings/In Progress.';
					}
					
				
              		if(sendPushNotification($accessToken, $to, $title, $screen, $bookingID, $TutorId, $studentId, $offerAmountType, $tutor_profile_image, $postal_code, $FName, $LName, $Bookdate, $body))   // Output the result of sending the notification
					{
						$Nmsg = 1;
					}
					else
					{
						$Nmsg = 0;
					}
				}	


			
					if($Nmsg == 1)
					{
						$Notification_msg = 'Success';
					}	
					if($Nmsg == 0)
					{
						$Notification_msg = 'Failed';
					}	
					
					
				}	
					
				//// end notify
				
				
				
				/// Update booking status
				
				$update_bookin_status = $conn->query("UPDATE student_post_requirements_Applied_by_tutor SET booking_status = 'booked' WHERE tutor_login_id = '".$array["tutor_id"]."' and student_post_requirements_id = '".$student_post_requirements_id."' ");
				
				
				
				$del1 = $conn->query("delete from tutor_booking_process_Level_Grade_Subjects where tutor_booking_process_id = 0 ");
				$del2 = $conn->query("delete from tutor_booking_process_Schedules_Slot_Time where tutor_booking_process_id = 0 ");
				
					
				/// For Add Level, Grade and Subjects		
				foreach($Student_Level_Grade_Subjects as $entry) 
				{
					$id = $entry['ID'];
					$allSubjects = implode(',', $entry['ALL_Subjects']);
					
					//$grade = implode(',', $entry['Grade']);
					$grade = $entry['Grade'];
					$level = $entry['Level'];
					
					if($level == "AEIS")
					{
						$Admission_level = $entry['Admission_level'];
						
					}
					else
					{
						$Admission_level = "";
					}
					
					//$level1 = $conn->query("delete from tutor_booking_process_Level_Grade_Subjects where Level = '".$level."' and Grade = '".$grade."' ");
				
					
					$query = $conn->query("INSERT INTO tutor_booking_process_Level_Grade_Subjects (ID, ALL_Subjects, Grade, Level, Admission_Level, tutor_booking_process_id) VALUES ('$id', '$allSubjects', '$grade', '$level', '$Admission_level', '$getLastBooking_id_val')");
					
					if($query)
					{
						$tag = 1;
					}
					else{
						$tag = 0;
					}
					
					
					   
					if($level=="Secondary")
					{
						//echo $booking_from;
						//die();
						
						if($booking_from == "Search")
						{
						
							$Stream1 = $conn->query("delete from tutor_booking_process_streams where tutor_booking_process_id = '".$getLastBooking_id_val."' "); 
							
							//print_r($entry['Stream']);
							
							foreach($entry['Streams'] as $streamData)
							{
								$query_stream = $conn->query("INSERT INTO tutor_booking_process_streams (streams, tutor_booking_process_id) VALUES ('$streamData', '$getLastBooking_id_val')");
						
							}
						}

						if($booking_from == "Firm" || $booking_from == "Negotiate")
						{
						
							$Stream1 = $conn->query("delete from student_post_requirements_streams where student_post_requirements_id = '".$student_post_requirements_id."' "); 
							
							//print_r($entry['Stream']);
							
							foreach($entry['Streams'] as $streamData)
							{
								$query_stream = $conn->query("INSERT INTO student_post_requirements_streams (student_post_requirements_streams, student_post_requirements_id) VALUES ('$streamData', '$student_post_requirements_id')");
						
							}
						}	
						
						
					}
				
					
					
				}
				
				
				
				///empty records
				
				//print_r($Qualifications);
				
				
					if(is_null($Qualifications) || empty($Qualifications)) 
					{
					}
					else{
			
					// For Qualifications
							foreach($Qualifications as $row2 => $value2) 
							{
								
								if($value2['qualification'] !="" )
								{
									
									$subject_val = $value2['qualification'];
									
									$arrayV3[] = "('".$value2['qualification']."','0','0')";
								}
								if($value2['qualification_id'] !="" )
								{
									//$arrayV3[] = "('".$subject_val."','".$value2['qualification_id']."')";
								}
								
							}
							
							
							
							/// Tutor Qualification
							$qua1 = $conn->query("delete from tutor_booking_process_TutorQualification where tutor_booking_process_id = 0 ");
							$qua2 = $conn->query("INSERT INTO `tutor_booking_process_TutorQualification` (Tutor_Qualification,Tutor_Qualification_id,tutor_booking_process_id) VALUES " . implode(', ', $arrayV3));  
							$qua3 = $conn->query("UPDATE tutor_booking_process_TutorQualification SET tutor_booking_process_id = '".$getLastBooking_id_val."' where tutor_booking_process_id = 0 ");  
							
			
					}
					
					
				
				//echo $getLastBooking_id_val;
				
				
					
					if($tag==1)
					{
						
						
						/// For Add Schedule and Times		
						foreach($Tutor_Schedules_Slot_Time as $scheduleTime) 
						{
							
							$slot_times = implode(',', $scheduleTime['slot_time']);
							$tutor_schedule = $scheduleTime['tutor_schedule'];
							
							
							//$scheduleTime_del = $conn->query("delete from tutor_booking_process_Schedules_Slot_Time where tutor_schedule = '".$tutor_schedule."' and slot_times = '".$slot_times."' ");
						
							
							$scheduleTime_insrt = $conn->query("INSERT INTO tutor_booking_process_Schedules_Slot_Time (tutor_schedule, slot_times, tutor_booking_process_id) VALUES ('$tutor_schedule', '$slot_times', '$getLastBooking_id_val')");
							
							
						}
						
						//$Level_Grade_Subjects = $conn->query("UPDATE tutor_booking_process_Level_Grade_Subjects  SET tutor_booking_process_id = '".$getLastBooking_id['tutor_booking_process_id']."' where tutor_booking_process_id = 0 "); 
						//$scheduleTime_update = $conn->query("UPDATE tutor_booking_process_Schedules_Slot_Time SET tutor_booking_process_id = '".$getLastBooking_id['tutor_booking_process_id']."' where tutor_booking_process_id = 0 ");  	
					
					
						
						
						
						$resultData = array('status' => true, 'message' => 'Tutor Booking Process Successful.', 'booking_id' => $getLastBooking_id['tutor_booking_process_id'], 'Notification_details' => $Notification_msg );
					}
					
				
			}
			else
				{
					$resultData = array('status' => false, 'message' => 'Error Found.');
				}
			
			}
			else			
			{
				$resultData = array('status' => false, 'message' => 'Student Id or Tutor Id can not be blank.');
			}
			

			//}
			//else{
				//$resultData = array('status' => false, 'message' => 'This Tutor has been booked already.');
			//}				
				
				echo json_encode($resultData);
			
?>