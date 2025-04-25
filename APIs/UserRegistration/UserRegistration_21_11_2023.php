<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");

require '../../phpmailer-master/class.phpmailer.php';

//require_once("dbcontroller.php");
header('content-type:application/json');






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


		
//////

/**
function Send_OTP_Mobile($CountryCode,$Mobile,$OTP)
{
	///"https://api.authkey.io/request?authkey=597a19768e9f3ec6&mobile=7991846193&country_code=91&sid=5319&otp=1234&time=10min";
	
//$url_otp = "https://api.authkey.io/request?authkey=597a19768e9f3ec6&mobile=$Mobile&country_code=$CountryCode&sid=5319&otp=$OTP&time=10min";

$url_otp = "https://api.authkey.io/request?authkey=a00bc3228c699037&mobile=$Mobile&country_code=$CountryCode&sid=9334&otp=$OTP&time=10min";

	$payload = json_encode("");
    //sending requests
    $ch = curl_init($url_otp);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'       
    ));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);

    // catching the response
    $response = json_decode($result, true);
	
	 $response;
	
}
**/

///////
		
		$first_name	=	$_POST['first_name'];
		$last_name	=	$_POST['last_name'];
		$email	=	$_POST['email'];
		$password	=	$_POST['password'];
		$mobile	=	$_POST['mobile'];
		$country_phone_code	=	$_POST['country_phone_code'];
		
		$full_name = $first_name." ".$last_name;
		
		$device_token	=	$_POST['device_token'];
		$device_type	=	$_POST['device_type'];
		
		$profile_image	=	$_POST['profile_image'];
		
		
		
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


						$profile_image = $img_name;
					
					$arrayV2[] = "('".$img_name."')";
				}
		
		
		///check mobile no valid
			
			

			if(!empty($mobile)) // phone number is not empty
			{
				//if(preg_match('/^\d{8}$/',$mobile)) // phone number is valid  (Min 8 digit)
				//{

                    
				 // $mobile = '0' . $mobile;

				  // your other code here
				  
				  
				  
				 ////check email id valid
				 
				 function test_input($data) {
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data);
					return $data;
					}

					$email = test_input($_POST["email"]);
					
					if(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
					{
						$resultData = array('status' => true, 'message' => 'Please type a valid email address');	
						echo json_encode($resultData);	
					}
					else					
					{	
				  
				  
				
					
					
					if( $first_name!="" && $last_name!="" && $email!="" && $mobile!="" && $country_phone_code !="" && $device_token != "" && $device_type != "" )
					{
						
						
						
						//$check_email = "SELECT * FROM user_info_temp WHERE email = '".$email."' or mobile ='".$mobile."' ";    /// Check mobile or email exists
						
						$check_email = "SELECT * FROM user_info WHERE email = '".$email."' ";    /// Check mobile or email exists
						$check_email_result = $conn->query($check_email);
						$email_already_exits = mysqli_num_rows($check_email_result);
						if($email_already_exits>0)
						{
							$resultData = array('status' => false, 'message' => 'This Email id already exists. Please use another email id.');
							 
							$email_chk = 0;
							
						}
						else			
						{
							$email_chk = 1;
						}
						
						
						$check_mobile = "SELECT * FROM user_info WHERE mobile ='".$mobile."' ";    /// Check mobile or email exists
						$check_mobile_result = $conn->query($check_mobile);
						$mobile_already_exits = mysqli_num_rows($check_mobile_result);
						if($mobile_already_exits>0)
						{
							$resultData = array('status' => false, 'message' => 'This Mobile No. already exists. Please use another Mobile No.');
							 
							$mobile_chk = 0;
						}
						else			
						{
							$mobile_chk = 1;
						}
						
						
						
						////check mobile & email start
						if($email_chk == 0)	
						{
							echo json_encode($resultData);
						}
						elseif($mobile_chk == 0){
							echo json_encode($resultData);
						}
						elseif($email_chk == 0 && $mobile_chk == 0){
							echo json_encode($resultData);
						}
						////check mobile & email end
						
						
					  if($email_chk == 1 && $mobile_chk == 1)	
					  {
						  
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
						   ///Generate 4 digit otp number end function 
						  
						  
							$_SESSION['OTP'] = '';
						  
							$randomNumber_otp = generateKey(4); //rand(10,10000);
							$randomNumber_otp_mobile = generateKey(4); ///rand(10,10000);
							
							$check_email = $conn->query("SELECT * FROM user_info WHERE email = '".$email."' ");
						
						  if(mysqli_num_rows($check_email) == 0)	
						  {	
						
						
						 $sql = "insert into user_info_temp set first_name ='".$first_name."', last_name ='".$last_name."', adminusername ='".$email."', email = '".$email."', password ='".md5($password)."', mobile ='".$mobile."', user_roll	= '0', OTP = '".$randomNumber_otp."', OTP_mobile = '".$randomNumber_otp_mobile."', device_token = '".$device_token."', device_type = '".$device_type."'  ";
						
						
						
						if($res=$conn->query($sql))
						{
							
							
							/**
							$subject  = "OTP For User Registration";
						
							$message = '<table border="0" >

							<tr><td></td><td><strong>OTP For Registration</strong></td></tr>
							<tr><td></td><td><strong></strong></td></tr>
							<tr><td><strong>Hi '.$full_name.',</strong></td><td></td></tr>
							<tr><td></td><td><strong></strong></td></tr>
							<tr><td>Please find below the OTP for user registration.</td><td></td></tr>
							<tr><td></td><td><strong></strong></td></tr>
							<tr><td><strong>OTP: '.$randomNumber_otp.'</strong></td><td></td></tr>
							<tr><td></td><td><strong></strong></td></tr>
							<tr><td></td><td><strong></strong></td></tr>
							<tr><td></td><td><strong></strong></td></tr>
							<tr><td><strong>Thanks & regards,</strong></td><td></td></tr>
							<tr><td>Tutorapp Admin</td><td></td></tr>

							</table>';

						
										
							$to	=	"pushpendra@eastsons.com".",".$email;	
					
						
							
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .=  'X-Mailer: PHP/'. phpversion();
							//$headers .= 'Bcc: test@yahoo.com' . "\r\n";
							$headers .= 'From: projects@eastsons.com' . "\r\n";		

							

							if(@mail($to, $subject, $message, $headers))
							{
								**/
								
								
								
								//// SMTP mail start


                               // try {
                                    $mail = new PHPMailer(true); //New instance, with exceptions enabled

                                   // $body             = file_get_contents('../../phpmailer-master/contents.html');
                                    //$body             = preg_replace('/\\\\/','', $body); //Strip backslashes

                                    $body = '<table border="0" >

                                                <tr><td></td><td><strong>OTP For Registration</strong></td></tr>
                                                <tr><td></td><td><strong></strong></td></tr>
                                                <tr><td><strong>Hi '.$full_name.',</strong></td><td></td></tr>
                                                <tr><td></td><td><strong></strong></td></tr>
                                                <tr><td>Please find below the OTP for user registration.</td><td></td></tr>
                                                <tr><td></td><td><strong></strong></td></tr>
                                                <tr><td><strong>OTP: '.$randomNumber_otp.'</strong></td><td></td></tr>
                                                <tr><td></td><td><strong></strong></td></tr>
                                                <tr><td></td><td><strong></strong></td></tr>
                                                <tr><td></td><td><strong></strong></td></tr>
                                                <tr><td><strong>Thanks & regards,</strong></td><td></td></tr>
                                                <tr><td>Tutorapp Admin</td><td></td></tr>

                                                </table>';


                                    $mail->IsSMTP();                           // tell the class to use SMTP
                                    $mail->SMTPAuth   = true;                  // enable SMTP authentication
                                    $mail->Port       = 465;                    // set the SMTP server port
                                    $mail->Host       = "cloud-da17fb.managed-vps.net"; // SMTP server
                                    $mail->Username   = "info@refuel.site";     // SMTP server username
                                    $mail->Password   = "India@123";            // SMTP server password

                                    $mail->IsSendmail();  // tell the class to use Sendmail

                                    $mail->AddReplyTo("name@domain.com","First Last");

                                    $mail->From       = "info@refuel.site";
                                    $mail->FromName   = "Tutor App";

                                    
                                    $to	=	$email;	

                                    $mail->AddAddress($to);

                                    $mail->Subject  = "OTP For User Registration";

                                    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                                    $mail->WordWrap   = 80; // set word wrap

                                    $mail->MsgHTML($body);

                                 

                                    $mail->IsHTML(true); // send as HTML

                                    $mail->Send();
                                   // echo 'Message has been sent.';
								
								
								//// SMTP mail end
								

								//$msg1 = '<span style="color:red;">Message sent successfully.</span>';
								
								//Send_OTP_Mobile($country_phone_code,$mobile,$randomNumber_otp_mobile);
								
								$_SESSION['OTP'] = $randomNumber_otp;
								
								//header('location:registration.php?step=1');
								$resultData = array('status' => true, 'message' => 'OTP sent in your email. Please go for next step.', 'Email_OTP' => $randomNumber_otp);	
								 echo json_encode($resultData);	
							
							
							//}
				
						

				
				
							}
							else
							{
								//$msg1 = "Error while trying to inserting the record.";
								$resultData = array('status' => false, 'message' => 'Error while trying to inserting the record.');
										
							}
							
						 }
						 else{
							 //$msg1 = "This Email id already exists. Please use another email id.";
							 $resultData = array('status' => false, 'message' => 'This Email id already exists. Please use another email id.');
											
						 }
							
							
						}
						else{
							
							//$msg1 = "This Email or Mobile Already Exists. Please go for login.";
							//$resultData = array('status' => false, 'message' => 'This Email or Mobile Already Exists. Please go for login.');
										
						}
						
						
						 //echo json_encode($resultData);
						
							
						}
						else{
							 $resultData = array('status' => false, 'message' => 'First Name, Last Name, Email, Mobile, Country Code, Device Token And Device Type Can Not Be Blank.');
						}
					
					}		
		
		/**
				}
				else // phone number is not valid
				{
				  //echo 'Phone number invalid !';
				   $resultData = array('status' => false, 'message' => 'Phone number invalid !');
				   echo json_encode($resultData);
				}  
                
                **/
			}
			else // phone number is empty
			{
			 // echo 'You must provid a phone number !';
			   $resultData = array('status' => false, 'message' => 'You must provid a phone number !');
				 echo json_encode($resultData);
			  
			}
		
		
		
		
		
		
		if($_POST['OTP_EMAIL'] !="" )
		{
			$check_otp = "SELECT * FROM user_info_temp WHERE OTP = '".$_POST['OTP_EMAIL']."'  ";
			$check_otp_result = $conn->query($check_otp);
			$check_otp_exits = mysqli_num_rows($check_otp_result);
			
		  if($check_otp_exits == 1)	
		  {
				 $update_sql = $conn->query("update user_info_temp set OTP_Validate ='1' where OTP = '".$_POST['OTP_EMAIL']."'  ");
				 if($update_sql)
				 {
					// header('location:registration.php?step=2');
					$resultData = array('status' => true, 'message' => 'OTP is valid. Enter next details.');
							
				 }
			
		  }
		  else{
			 // $msg1 = "OTP entered is not valid. Please enter correct OTP.";
			 $resultData = array('status' => false, 'message' => 'OTP entered is not valid. Please enter correct OTP.');
							
		  }
		  
		   // echo json_encode($resultData);
		  
		}	
		
		
		
		if($_POST['OTP_EMAIL']!="" && $_POST['user_type']!="")
		{
			$check_otp = "SELECT * FROM user_info_temp WHERE OTP = '".$_POST['OTP_EMAIL']."' and OTP_Validate ='1' ";
			$check_otp_result = $conn->query($check_otp);
			$check_otp_exits = mysqli_num_rows($check_otp_result);
			
		  if($check_otp_exits == 1)	
		  {
			  $user_temp_record = mysqli_fetch_array($check_otp_result);
			  
				$sql = "insert into user_info set first_name ='".$user_temp_record['first_name']."', last_name = '".$user_temp_record['last_name']."', adminusername ='".$user_temp_record['adminusername']."', email = '".$user_temp_record['email']."', password ='".md5($_POST['password'])."', user_type ='".$_POST['user_type']."', Term_cond ='1', user_roll	= '0', device_token = '".$user_temp_record['device_token']."', device_type = '".$user_temp_record['device_type']."', profile_image = '".$profile_image."' ";
			
				if($res=$conn->query($sql))
				{
					
					//$conn->insert_id;
					$last_id = mysqli_insert_id($conn);
					
					
					if($_POST['user_type']=='I am an Educator')
					{
						$user_tutor = $conn->query("select user_id from user_tutor_info where user_id = '".$last_id."' ");
						
						if(mysqli_num_rows($user_tutor)>0)
						{
							$del_U_tutor = $conn->query("delete from user_tutor_info where user_id = '".$last_id."' ");
						}
						else{
							$Insert_tutor_profile_Image = $conn->query("insert into user_tutor_info set user_id = '".$last_id."', profile_image = '".$profile_image."' ");
						}
					}
					
					if($_POST['user_type']=='I am looking for a Tutor')
					{
						$user_tutor = $conn->query("select user_id from user_student_info where user_id = '".$last_id."' ");
						
						if(mysqli_num_rows($user_tutor)>0)
						{
							$del_U_tutor = $conn->query("delete from user_student_info where user_id = '".$last_id."' ");
						}
						else{
							$Insert_tutor_profile_Image = $conn->query("insert into user_student_info set user_id = '".$last_id."', profile_image = '".$profile_image."' ");
						}
					}
					
					
					$del_sql = $conn->query("delete from user_info_temp WHERE OTP_Validate ='1' and OTP = '".$_POST['OTP_EMAIL']."' ");
				
					$_SESSION['adminusername'] = $user_temp_record['email'];
					$_SESSION['user_name'] = $user_temp_record['first_name']." ".$user_temp_record['last_name'];
					$_SESSION['username'] = $user_temp_record['email'];
					$_SESSION['loggedIn_user_id'] = $last_id; 
					///header("location:admin/welcome.php");
					
					 $resultData = array('status' => true, 'message' => 'Registration success.',$last_id);
							
				}
			
		  }
		  else{
			  ///$msg1 = "OTP entered is not valid. Please enter correct OTP.";
			   $resultData = array('status' => false, 'message' => 'OTP entered is not valid. Please enter correct OTP.');
							
		  }
		  
		 // echo json_encode($resultData);
		  
		  
		}
		
					
			
			
?>