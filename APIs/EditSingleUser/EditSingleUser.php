<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

require '../../phpmailer-master/class.phpmailer.php';	


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
    foreach ($all_mimes as $key => $array) {
        if(array_search($mime,$array) !== false) return $key;
    }
    return false;
}





$logged_in_user_id = $_POST['logged_in_user_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$countryflag = strtolower($_POST['countryflag']);
$country_phone_code = $_POST['country_phone_code'];
$mobile = $_POST['mobile'];
$address1 = $_POST['address1'];
$OTP_EMAIL = $_POST['OTP_EMAIL'];

if(trim($_POST['password']) !="")
{
	$password = md5($_POST['password']);
}
else{
	$password = "";
	
}

$profile_image = $_POST['profile_image'];



if($logged_in_user_id != "" && $OTP_EMAIL == "")
{

	$sql = $conn->query("SELECT * FROM user_info WHERE user_id = '".$logged_in_user_id."' ");

	if(mysqli_num_rows($sql)>0)
	{
		
		
		
		$OrgUsr = mysqli_fetch_array($sql);
		
		
		$full_name = ucfirst($OrgUsr['first_name'])." ".ucfirst($OrgUsr['last_name']);
		
		//if($OrgUsr['email'] == $email && $OrgUsr['mobile'] == $mobile)
		//{
		
			$stmt = $conn->prepare("SELECT email, mobile, country_phone_code FROM user_info WHERE user_id <> ?");
			$stmt->bind_param("i", $logged_in_user_id); // Assuming user_id is an integer
			$stmt->execute();
			$result = $stmt->get_result();

			// Initialize flags for email and mobile existence
			$emailExists = false;
			$mobileExists = false;

			while ($UData = $result->fetch_assoc()) {
				// Check if the email exists
				if ($UData['email'] === $email) {
					$emailExists = true;
				}

				// Check if the mobile number with country code exists
				if (
					$UData['mobile'] === $mobile &&
					$UData['country_phone_code'] === $country_phone_code
				) {
					$mobileExists = true;
				}

				// If both email and mobile exist, break the loop early
				if ($emailExists && $mobileExists) {
					break;
				}
			}

			// Respond based on whether the email or mobile exists or not
			if ($emailExists && $mobileExists) {
				$resultData = array('status' => false, 'message' => 'Email id and Mobile number already exist.');
			} elseif ($emailExists) {
				$resultData = array('status' => false, 'message' => 'Email id already exists.');
			} elseif ($mobileExists) {
				$resultData = array('status' => false, 'message' => 'Mobile number already exists.');
			} else {
					// Both email and mobile are available
					//$resultData = array('status' => true, 'message' => 'Email id and Mobile number are available.');
						
			
			
		
		
		$del = $conn->query("delete from user_info_temp where USERID = '".$logged_in_user_id."' ");
		
		
	  if($del)
	  {
		  
		  //$otp = rand(1000,10000);
		  
		  
		  ///Generate 4 digit otp number start function 
			function generateKey($keyLength) {
			// Set a blank variable to store the key in
			$key = "";
			for ($x = 1; $x <= $keyLength; $x++) {
			// Set each digit
			$key .= random_int(0, 9);
			}
				return $key;
			}
		  
		  
			$otp = generateKey(4);
		  
		  
			
			
			/////////////////////
							
							$mail = new PHPMailer(true); //New instance, with exceptions enabled

									
									
									try {
									  
									  $body = '
									<table border="0" style="font-size: 15px; font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
										<tr>
											<td colspan="2" >Hi ' . $full_name . ',</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0;">
												Here is the OTP you have been waiting for:
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0; text-align: center; font-size: 24px; font-weight: bold; color: #2f5497;">
												' . implode(' ', str_split($otp)) . '
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0; font-size: 12px; color:#777777;">
												This OTP is only valid for 90 seconds. Use it promptly.
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0;">
												If you face any issue, you can contact us via Help & Support.
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding: 10px 0; font-size: 14px; color: #666;">
												Thanks & Regards,<br>
												<strong>MyTutors </strong>
											</td>
										</tr>
									</table>';
									

									// Configure PHPMailer to use SMTP
									$mail->IsSMTP();
									$mail->SMTPAuth = true;
									$mail->SMTPSecure = 'ssl';
									$mail->Port = 465;  // SMTP server port
									$mail->Host = 'eastsons.mytutors.moe';  // SMTP server
									$mail->Username = 'info@mytutors.moe';  // SMTP username
									$mail->Password = 'PVzn08KRAzDhV';      // SMTP password

									// From address and name
									$mail->From = 'noreply@mytutors.moe';
									$mail->FromName = 'MyTutors.Moe';

									// Recipient address
									 $to	=	$email;	
									$mail->AddAddress($to);

									// Email subject
									$mail->Subject = 'OTP authentication code';

									// Optional: Plain text version for non-HTML email clients
									$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
									
									// Word wrap setting
									$mail->WordWrap = 80;

									// HTML body content
									$mail->MsgHTML($body);

									// Set the mail format to HTML
									$mail->IsHTML(true);

									// Send email
									$mail->Send();
									
									//echo 'Success';
									
								
								$currentTimestamp = date('Y-m-d H:i:s'); //time();

								$add_otp_in_user_temp = $conn->query("insert into user_info_temp set USERID = '".$logged_in_user_id."', email = '".$email."', OTP = '".$otp."', otp_timestamp = '".$currentTimestamp."' ");


								$resultData = array('status' => true, 'message' => 'OTP sent in your email id.' );



								

								} catch (Exception $e) {
									echo 'Mailer Error: ' . $mail->ErrorInfo; // Provide error message in case of failure
								}
									
									////////////////////
			
			
			
			
			
			
			
			
			
			
			
	  }
	  else{
	  
		//$resultData = array('status' => false, 'message' => 'No record found.');
	  }
	  
	  
	  
		}
		
		 
	  
	  
	  
	}
	else
	{
		$resultData = array('status' => false, 'message' => 'No record found.');
	}
	
}
else
{
	//$resultData = array('status' => false, 'message' => 'User id can not blank.');




	////// Check verify OTP and update record///////
	if($OTP_EMAIL != "" )
	{

		
			
				if(!empty($_POST['email']) && !empty($_POST['OTP_EMAIL'])) 
				{
					date_default_timezone_set('Your/Timezone'); // Set the timezone
					$email = $conn->real_escape_string($_POST['email']);
					$otp = $conn->real_escape_string($_POST['OTP_EMAIL']);
					
					$check_otp = "SELECT * FROM user_info_temp WHERE OTP = '".$_POST['OTP_EMAIL']."' AND OTP_Validate = '0' AND email = '$email'";
					$check_otp_result = $conn->query($check_otp);

					if (mysqli_num_rows($check_otp_result) > 0) {
						$check_otp_expire = mysqli_fetch_array($check_otp_result);
						
					  
							$otp_unix_timestamp = strtotime($check_otp_expire['otp_timestamp']);
							$current_time = time(); //time();
							
							//echo  $otp_unix_timestamp.'===';
							
							 //echo ($current_time - $otp_unix_timestamp);
							
							
							if(($current_time - $otp_unix_timestamp) > 0 && ($current_time - $otp_unix_timestamp) <= 90) 
							{
								
								
								
								//$resultData = array('status' => true, 'message' => 'OTP Verified Successfully.');
								
								if($profile_image !="" )
								{
									
											
											// Define the Base64 value you need to save as an image
																		
											$b64 = $profile_image;

											// Obtain the original content (usually binary data)
											$bin = base64_decode($b64);

											// Gather information about the image using the GD library
											$size = getImageSizeFromString($bin);

											// Check the MIME type to be sure that the binary data is an image
											if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
											  die('Base64 value is not a valid image');
											}

											// Mime types are represented as image/gif, image/png, image/jpeg, and so on
											// Therefore, to extract the image extension, we subtract everything after the “image/” prefix
											$ext = substr($size['mime'], 6);

											// Make sure that you save only the desired file extensions
											if(!in_array($ext, ['png', 'gif', 'jpeg'])) {
											  die('Unsupported image type');
											}

											// Specify the location where you want to save the image
											$img_file = "../../UPLOAD_file/profile_image".time().".{$ext}";

											// Save binary data as raw data (that is, it will not remove metadata or invalid contents)
											// In this case, the PHP backdoor will be stored on the server
											file_put_contents($img_file, $bin);
																		
											$img_name =  "profile_image".time().".{$ext}";


										$profile_image_name = $img_name;
									
									//$arrayV2[] = "('".$img_name."')";
								}
								else{
									$profile_image_name = "";
								}
								
								
								//echo '=='.$password.'==';
								
								if($password !="")
								{
									if($profile_image_name != "")
									{
										
										$update = $conn->query("UPDATE user_info SET adminusername = '".$email."', first_name = '".$first_name."' , last_name = '".$last_name."', email = '".$email."', countryflag = '".$countryflag."', country_phone_code = '".$country_phone_code."', mobile = '".$mobile."', password = '".$password."', address1 = '".$address1."', profile_image = '".$profile_image_name."' WHERE user_id = '".$logged_in_user_id."' ");
										
									}
									else{
										$update = $conn->query("UPDATE user_info SET adminusername = '".$email."', first_name = '".$first_name."' , last_name = '".$last_name."', email = '".$email."', countryflag = '".$countryflag."', country_phone_code = '".$country_phone_code."', mobile = '".$mobile."', password = '".$password."', address1 = '".$address1."' WHERE user_id = '".$logged_in_user_id."' ");
									}
									
								}
								else{
									
									if($profile_image_name != "")
									{
										$update = $conn->query("UPDATE user_info SET adminusername = '".$email."', first_name = '".$first_name."' , last_name = '".$last_name."', email = '".$email."', countryflag = '".$countryflag."', country_phone_code = '".$country_phone_code."', mobile = '".$mobile."', address1 = '".$address1."', profile_image = '".$profile_image_name."' WHERE user_id = '".$logged_in_user_id."' ");
										
										$updateProfile = $conn->query("UPDATE user_tutor_info SET profile_image = '".$profile_image_name."' WHERE user_id = '".$logged_in_user_id."' ");
										
									}
									else{
										
										$update = $conn->query("UPDATE user_info SET adminusername = '".$email."', first_name = '".$first_name."' , last_name = '".$last_name."', email = '".$email."', countryflag = '".$countryflag."', country_phone_code = '".$country_phone_code."', mobile = '".$mobile."', address1 = '".$address1."' WHERE user_id = '".$logged_in_user_id."' ");
									
									}
									
									
								}
								
								
								
								  if($update)
								  {
									$resultData = array('status' => true, 'message' => 'Record updated successfully.' );
								  }
								  else{
								  
									$resultData = array('status' => false, 'message' => 'No record found.');
								  }
								
								
								
							
							
							
							} else if (($current_time - $otp_unix_timestamp) <= 0) {
								$resultData = array('status' => false, 'message' => 'OTP has Expired.');
							} else {
								$resultData = array('status' => false, 'message' => 'OTP has Expired.');
							}
						
					} else {
						$resultData = array('status' => false, 'message' => 'OTP is Incorrect.');
					}
				} else {
					$resultData = array('status' => false, 'message' => 'Email and OTP cannot be blank.');
				}
			
			
			
		
	
	
	}
	else
	{
		$resultData = array('status' => false, 'message' => 'OTP can not blank.');
	}


		///////////
		
}		
		
		


 echo json_encode($resultData);

?>