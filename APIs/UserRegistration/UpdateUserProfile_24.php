<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


$servername = "localhost";
$username = "eastsons_studylab";
$password = "studyLab@321";
$dbname = "eastsons_studylab";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 


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
			
			$user_id = $array['user_id'];
			
			if($user_id !="" && $user_id != 0)
			{
			
			
			$HistoryAcademy_Array = $array['HistoryAcademy'];
			$TutoringDetail_Array = $array['TutoringDetail'];
			
			
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
			
			
				$tutor_code = 'TUAC'.generateKey(4); //rand(10,10000);
			
			
			
				
				
				if($array["profile_image"] !="")
				{
					
					//// Remove image and update start
					
					$select     = $conn->query("select * from user_tutor_info where user_id = '".$user_id."' ");
					$select_res = mysqli_fetch_array($select);
					$fetch      = $select_res['profile_image'];
					@unlink("../../UPLOAD_file/".$fetch );

					$query_img_update = $conn->query("update user_tutor_info set profile_image = '' WHERE user_id='".$user_id."'");
					
					//// Remove image and update end
					
					
					
							
							// Define the Base64 value you need to save as an image
														
							$b64 = $array["profile_image"];

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
							if (!in_array($ext, ['png', 'gif', 'jpeg'])) {
							  die('Unsupported image type');
							}

							// Specify the location where you want to save the image
							$img_file = "../../UPLOAD_file/profile_image".time().".{$ext}";

							// Save binary data as raw data (that is, it will not remove metadata or invalid contents)
							// In this case, the PHP backdoor will be stored on the server
							file_put_contents($img_file, $bin);
														
							$img_name =  "profile_image".time().".{$ext}";


						
					
					$arrayV2[] = "('".$img_name."')";
					
				}
				
				
				if($array["user_id"] !="" && $array["age"] !="")
				{
				
					$arrayV[] = "('".$img_name."','".$array["age"]."','".$array["date_of_year"]."','".$array["gender"]."','".$array["nationality"]."','".$array["flag"]."','".$array["qualification"]."','".$array["name_of_school"]."','".$array["Course_Exam"]."','".$array["gra_year"]."','".$array["tutor_status"]."','".$array["tuition_type"]."','".$array["location"]."','".$array["postal_code"]."','".$array["travel_distance"]."','".$array["personal_statement"]."','".$array["lettitude"]."','".$array["longitude"]."','".$array["stream"]."','".$tutor_code."')";				
					
					$user_id_array[] = $array["user_id"];
				}
				
				if($array["age"] !="")
				{
					$age = $array["age"];
				}
				if($array["date_of_year"] !="")
				{
					$date_of_year = $array["date_of_year"];
				}
				if($array["gender"] !="")
				{
					$gender = $array["gender"];
				}
				if($array["nationality"] !="")
				{
					$nationality = $array["nationality"];
				}
				if($array["flag"] !="")
				{
					$flag = $array["flag"];
				}
				if($array["qualification"] !="")
				{
					$qualification = $array["qualification"];
				}
				if($array["name_of_school"] !="")
				{
					$name_of_school = $array["name_of_school"];
				}
				if($array["Course_Exam"] !="")
				{
					$Course_Exam = $array["Course_Exam"];
				}
				
				if($array["gra_year"] !="")
				{
					$gra_year = $array["gra_year"];
				}
				if($array["tutor_status"] !="")
				{
					$tutor_status = $array["tutor_status"];
				}
				if($array["tuition_type"] !="")
				{
					$tuition_type = $array["tuition_type"];
				}
				if($array["location"] !="")
				{
					$location = $array["location"];
				}
				if($array["postal_code"] !="")
				{
					$postal_code = $array["postal_code"];
				}	
				if($array["travel_distance"] !="")
				{
					$travel_distance = $array["travel_distance"];
				}	
				
				if($array["personal_statement"] !="")
				{
					$personal_statement = $array["personal_statement"];
				}
				
				if($array["lettitude"] !="")
				{
					$lettitude = $array["lettitude"];
				}
				
				if($array["longitude"] !="")
				{
					$longitude = $array["longitude"];
				}
				if($array["stream"] !="")
				{
					$stream = $array["stream"];
				}
				
				/**
				if($array["tutor_code"] !="")
				{
					$tutor_code = $array["tutor_code"];
				}				
				**/
				
				
				
			
			
			
			
			
			/// Get User_id from array
				foreach($user_id_array as $idrow => $idvalue) 
				{
					//$user_id = $idvalue;
				}
			
			
			/// check user_tutor_info record
			
			$chk_rec = $conn->query("select * from user_tutor_info where user_id = '".$user_id."' ");
			
			if(mysqli_num_rows($chk_rec)>0)
			{
				//$del_tinfo = $conn->query("delete from user_tutor_info where user_id = '".$user_id."' ");
				
				
				if($img_name != "")
				{
					$query = "UPDATE user_tutor_info SET profile_image = '".$img_name."', age = '".$age."', date_of_year = '".$date_of_year."', gender = '".$gender."',nationality = '".$nationality."',flag = '".$flag."',qualification = '".$qualification."',name_of_school = '".$name_of_school."',Course_Exam = '".$Course_Exam."',gra_year = '".$gra_year."',tutor_status = '".$tutor_status."',tuition_type = '".$tuition_type."',location = '".$location."',postal_code = '".$postal_code."',travel_distance = '".$travel_distance."',personal_statement = '".$personal_statement."',lettitude = '".$lettitude."',longitude = '".$longitude."',stream = '".$stream."',tutor_code = '".$tutor_code."' where user_id = '".$user_id."' ";  
				}
				else{
					
					$query = "UPDATE user_tutor_info SET age = '".$age."', date_of_year = '".$date_of_year."', gender = '".$gender."',nationality = '".$nationality."',flag = '".$flag."',qualification = '".$qualification."',name_of_school = '".$name_of_school."',Course_Exam = '".$Course_Exam."',gra_year = '".$gra_year."',tutor_status = '".$tutor_status."',tuition_type = '".$tuition_type."',location = '".$location."',postal_code = '".$postal_code."',travel_distance = '".$travel_distance."',personal_statement = '".$personal_statement."',lettitude = '".$lettitude."',longitude = '".$longitude."',stream = '".$stream."',tutor_code = '".$tutor_code."' where user_id = '".$user_id."' ";  
				}
				
			}
			else
			{
				$resultData = array('status' => false, 'message' => 'Record Not Found.');
			}
			
			
			
			

			if($conn->query($query)){
				
				
				$HistoryAcademy_del = $conn->query("delete from complete_user_profile_history_academy where user_id = 0 ");
				
				/// Delete History Academy Result
				 $query_result_delete = $conn->query("delete from complete_user_profile_history_academy where user_id = '".$user_id."' ");
				 $query_result_delete = $conn->query("delete from complete_user_profile_history_academy_result where user_id = '".$user_id."' ");
				
					
				/// For HistoryAcademy_Array		
				foreach($HistoryAcademy_Array as $entry) {
					
					
					$ID = $entry['HistoryID'];
					
					/// For History Academy Result	
					
						if($entry['result'] !="")
						{					
								
							/// Get Result value start
								foreach ($entry as $Result) 
								{
									foreach ($Result as $Result2) 
									{
										
									 $Result_Subject = $Result2['subject'];
									 $Result_Grade = $Result2['grade'];
									 
									 
									 $query_result = $conn->query("INSERT INTO complete_user_profile_history_academy_result (record_id, subject, grade, user_id) VALUES ('$ID', '$Result_Subject', '$Result_Grade', '$user_id')");
				
									 
									}
								}
							
						}		
					/// Get Result value end
					
					
					//$allSubjects = implode(',', $entry['ALL_Subjects']);
					$school = $entry['school'];
					$exam = $entry['exam'];
					
					
					$HistoryAcademy_del2 = $conn->query("delete from complete_user_profile_history_academy where user_id = '".$user_id."' ");
				
					
					$query = $conn->query("INSERT INTO complete_user_profile_history_academy (record_id, school, exam) VALUES ('$ID', '$school', '$exam')");
					
					
				}
				
				/// For TutoringDetail_Array	
				$TutoringDetail_del = $conn->query("delete from complete_user_profile_tutoring_detail where user_id = '".$user_id."' ");
				
				foreach ($TutoringDetail_Array as $entry2) {
					
					$TutoringLevel = $entry2['TutoringLevel'];
					$AdmissionLevel = $entry2['AdmissionLevel'];
					$Tutoring_Grade = implode(',', $entry2['Tutoring_Grade']);
					$Tutoring_ALL_Subjects = implode(',', $entry2['Tutoring_ALL_Subjects']);
					$Tutoring_Year = $entry2['Tutoring_Year'];
					$Tutoring_Month = $entry2['Tutoring_Month'];
					
					//$TutoringDetail_del = $conn->query("delete from complete_user_profile_tutoring_detail where user_id = '".$user_id."' ");
				
					$query2 = $conn->query("INSERT INTO complete_user_profile_tutoring_detail (TutoringLevel, AdmissionLevel, Tutoring_Grade, Tutoring_ALL_Subjects, Tutoring_Year, Tutoring_Month) VALUES ('$TutoringLevel', '$AdmissionLevel', '$Tutoring_Grade', '$Tutoring_ALL_Subjects', '$Tutoring_Year', '$Tutoring_Month')");
					
				}
				
				
					
				$Update_history_academy = $conn->query("UPDATE complete_user_profile_history_academy SET user_id = '".$user_id."' where user_id = 0 "); 	
				$Update_TutoringDetail = $conn->query("UPDATE complete_user_profile_tutoring_detail SET user_id = '".$user_id."' where user_id = 0 "); 	
					
				
					
					$resultData = array('status' => true, 'message' => 'Tutor Profile Data Updated Successfully.');
					
						//http_response_code(200);
						

				}
				else
				{
					$resultData = array('status' => false, 'message' => 'Error Found.');
				}
				
				
				}
			else{
				$resultData = array('status' => false, 'message' => 'User id can\'t blank');
			}
				
				echo json_encode($resultData);
			
?>