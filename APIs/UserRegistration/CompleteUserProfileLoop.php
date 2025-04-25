<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
//header('content-type:application/json');




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






			// Read the JSON file in PHP
			$data = file_get_contents("php://input");
			
			//print_r($data);
			
			
			// Convert the JSON String into PHP Array
			$array = json_decode($data, true);
			
				
				
				
				
				
				// Ensure proper JSON decoding
				if ($array === null) {
					echo json_encode(['status' => false, 'message' => 'Invalid JSON data']);
					exit;
				}

				// Further processing here...

				// Print data for debugging at the end
				//print_r($data);
				//print_r($array);
				
				
				
				
				
				
				
				
				
			
			$arrayV = array();  
			$arrayV2 = array(); 
			$arrayV3 = array(); 
			$arrayV4 = array(); 
			$arrayV5 = array(); 
			$arrayV6 = array();
			$arrayV7 = array(); 	
			
			$user_id = $array['user_id'];
			
		//print_r($array);









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



	
			
			//if($user_id !="" && $user_id != 0)
			//{
			
			$QualificationAcademy_Array = $array['QualificationAcademy'];
			$HistoryAcademy_Array = $array['HistoryAcademy'];
			$TutoringDetail_Array = $array['TutoringDetail'];
			
			
			/**
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
			**/
			
			
			
			
			
			// Extracting row by row
			
				
				
				/**
				
				if($array["profile_image"] !="" )
				{
					
							
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
				**/
				
				
				
                
				 date_default_timezone_set("Asia/Kolkata");
				$create_date = date("d-m-Y h:i:s");
				
				
				 $location_str = str_replace("'", '', $array["location"]);
				 $personal_statement_str = str_replace("'", '', $array["personal_statement"]);
				
				
				
				
				/////////###############////////////
				
				
			
function fetchUserDetails($conn, $user_id) {
    /**
	$query = "
        SELECT info.created_date, tinfo.gender 
        FROM user_info AS info 
        INNER JOIN user_tutor_info AS tinfo ON info.user_id = tinfo.user_id 
        WHERE info.user_id = '$user_id'";
		**/
	$query = "
        SELECT info.created_date, tinfo.gender 
        FROM user_info AS info 
        INNER JOIN user_tutor_info AS tinfo ON info.user_id = tinfo.user_id 
        WHERE info.user_id = '$user_id'";	
		
    
    $result = $conn->query($query);
    return $result->num_rows > 0 ? $result->fetch_array() : null;
}

function fetchTutorCount($conn, $created_date, $exclude_user_id) {
   	
	$query = "
		SELECT COUNT(info.user_id) AS user_count
		FROM user_info AS info 
		INNER JOIN user_tutor_info AS tinfo ON info.user_id = tinfo.user_id
		WHERE info.user_type = 'I am an Educator' 
		AND DATE_FORMAT(STR_TO_DATE(info.created_date, '%d-%m-%Y'), '%Y-%m') = 
			DATE_FORMAT(STR_TO_DATE('$created_date', '%d-%m-%Y'), '%Y-%m') 
		AND info.user_id <> '$exclude_user_id' ";
		
		
    
    $result = $conn->query($query);
    return $result->fetch_array()['user_count'] ?? 0;
}

if (is_array($array['user_id'])) {
    // Loop through the array of user IDs
    foreach ($array['user_id'] as $user_id) {
        if (!empty(trim($user_id))) {
			
			//echo $user_id;
			
			////
			//$del_profile = $conn->query("DELETE FROM user_tutor_info WHERE user_id = '$user_id' ");
			
			
			
			
			
			/// created date
			$get_create_date = mysqli_fetch_array($conn->query("SELECT created_date FROM user_info WHERE user_id = '$user_id' "));
			
			
			
			$genderv = mysqli_fetch_array($conn->query("SELECT gender FROM user_tutor_info WHERE user_id = '$user_id' "));
			
			
			
            //$userDetails = fetchUserDetails($conn, $user_id);
            $created_date = $get_create_date['created_date'];
            $gender = $array['gender']; //!empty($genderv['gender']) ? $genderv['gender'] : $value['gender'];

            $tutor_count = fetchTutorCount($conn, $created_date, $user_id);
            $date_parts = explode('-', $created_date);
            $year = substr($date_parts[2], -2);
            $month = $date_parts[1];
            $genderFC = substr($gender, 0, 1);

            $tutor_code = $year . $genderFC . $month . str_pad($tutor_count + 1, 1, '0', STR_PAD_LEFT);

            //echo $tutor_code . '==';
			
			
			
			
				 // Process profile image if exists
				// Process profile image if exists
				if (!empty($array["profile_image"])) {
					// Define the Base64 value you need to save as an image
					$b64 = $array["profile_image"];
					$bin = base64_decode($b64);

					// Gather information about the image using the GD library
					$size = getImageSizeFromString($bin);

					// Check if the binary data is an image
					if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
						die('Base64 value is not a valid image');
					}

					// Ensure the image has a valid extension
					$ext = substr($size['mime'], 6);
					if (!in_array($ext, ['png', 'gif', 'jpeg'])) {
						die('Unsupported image type');
					}

					// Specify the location where you want to save the image
					$unique_id = uniqid('', true);  // Generate a unique ID
					$img_file = "../../UPLOAD_file/profile_image_{$unique_id}.{$ext}";  // Append the unique ID
					file_put_contents($img_file, $bin);
					$img_name = "profile_image_{$unique_id}.{$ext}";  // Use unique ID in image name
				}
			
			
			
			
			
			
			////#####//////
			
			
			
				
				if($array["user_id"] !="" && $array["age"] !="")
				{
				
					$arrayV[] = "('".$array["user_id"]."','".$img_name."','".$array["age"]."','".$array["date_of_year"]."','".$array["gender"]."','".$array["nationality"]."','".$array["flag"]."','".$array["qualification"]."','".$array["name_of_school"]."','".$array["Course_Exam"]."','".$array["gra_year"]."','".$array["tutor_status"]."','".$array["tuition_type"]."','".$location_str."','".$array["postal_code"]."','".$array["travel_distance"]."','".$personal_statement_str."','".$array["lettitude"]."','".$array["longitude"]."','".$tutor_code."','','','".$create_date."')";				
					
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
					$location = $location_str;
					
				
					
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
					$personal_statement = $personal_statement_str;
				}
				if($array["lettitude"] !="")
				{
					$lettitude = $array["lettitude"];
				}
				if($array["longitude"] !="")
				{
					$longitude = $array["longitude"];
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
					 $user_id = $idvalue;
				}
			
			
			/// check user_tutor_info record
			
			$chk_rec = $conn->query("select * from user_tutor_info where user_id = '".$user_id."' ");
			
			
			
			
			if(mysqli_num_rows($chk_rec)>0)
			{
				//$del_tinfo = $conn->query("delete from user_tutor_info where user_id = '".$user_id."' ");
				
				 $query = "UPDATE user_tutor_info SET profile_image = '".$img_name."', age = '".$age."', date_of_year = '".$date_of_year."', gender = '".$gender."',nationality = '".$nationality."',flag = '".$flag."',qualification = '".$qualification."',name_of_school = '".$name_of_school."',Course_Exam = '".$Course_Exam."',gra_year = '".$gra_year."',tutor_status = '".$tutor_status."',tuition_type = '".$tuition_type."',location = '".$location_str."',postal_code = '".$postal_code."' ,travel_distance = '".$travel_distance."',personal_statement = '".$personal_statement_str."',lettitude = '".$lettitude."',longitude = '".$longitude."' where user_id = '".$user_id."' ";  
			
				$imgup = 1;
			
			}
			else			
			{	
				 $query = "INSERT INTO `user_tutor_info` (user_id,profile_image,age,date_of_year,gender,nationality,flag,qualification,name_of_school,Course_Exam,gra_year,tutor_status,tuition_type,location,postal_code,travel_distance,personal_statement,lettitude,longitude,tutor_code,OtherCourse_Exam,stream,create_date) VALUES " . implode(', ', $arrayV);  
			
				$imgup = 0;
				
			}
			
			
			

			if($conn->query($query))
			{
				if($imgup==0 || $imgup==1)
				{
					$update_user_info = $conn->query("UPDATE user_info SET profile_image = '".$img_name."' where user_id = '".$user_id."' ");  
				
				}
				
				
				// Delay for 5 seconds
				sleep(5);
				// Introduce a delay (e.g., 5 seconds)
				//$conn->query("DO SLEEP(5)");
				
				///+++++++++++++++++
				
				
				
				
				$HistoryAcademy_del = $conn->query("delete from complete_user_profile_history_academy where user_id = 0 ");
				
				/// Delete History Academy Result
				 $query_result_delete = $conn->query("delete from complete_user_profile_history_academy_result where user_id = '".$user_id."' ");
				
				
				
				$ak = 0;
				
				$QAcademy_del2 = $conn->query("delete from complete_user_profile_qualification_academy_result where user_id = '".$user_id."' ");
					
				
				/// For QualificationAcademy_Array		
				foreach($QualificationAcademy_Array as $entry) 
				{
					
					//print_r($entry['subject']);
	
										
					 $Result_Subject = $entry['subject'];
					 $Result_Grade = $entry['grade'];
					 
					 
					 $query_result = $conn->query("INSERT INTO complete_user_profile_qualification_academy_result ( subject, grade, user_id) VALUES ( '$Result_Subject', '$Result_Grade', '$user_id')");

					 
									
							
							
					/// Get Result value end
					
					
					
					
				}
				
				
				/// For HistoryAcademy_Array		
				foreach($HistoryAcademy_Array as $entry) 
				{

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
					
					if($exam == 'Others')
					{
						$examName = $entry['examName'];
					}
					else{
						$examName = '';
					}
					
					
					$HistoryAcademy_del2 = $conn->query("delete from complete_user_profile_history_academy where user_id = '".$user_id."' ");
				
					
					$query = $conn->query("INSERT INTO complete_user_profile_history_academy (record_id, school, exam,examName) VALUES ('$ID', '$school', '$exam', '$examName')");
					
					
				}
				
				
				
				$Update_history_academy = $conn->query("UPDATE complete_user_profile_history_academy SET user_id = '".$user_id."' where user_id = 0 "); 	
				
				
				
				
				
				
				//// +++++++++ Start Tutoting Details ++++++
				
				
				                                                                                                                                                                                                                                                                 
				$qua1 = $conn->query("delete from complete_user_profile_tutoring_grade_detail where user_id = 0 ");
				$qua1 = $conn->query("delete from complete_user_profile_tutoring_grade_detail where user_id = '".$user_id."' ");
				$qua4 = $conn->query("delete from complete_user_profile_tutoring_tutoring_subjects_detail where user_id = 0 ");
				$qua4 = $conn->query("delete from complete_user_profile_tutoring_tutoring_subjects_detail where user_id = '".$user_id."' ");
				
				
				$AdmissionStreamResult_del34 = $conn->query("delete from complete_user_profile_tutoring_admission_stream where user_id = 0 ");
				$AdmissionStreamResult_del = $conn->query("delete from complete_user_profile_tutoring_admission_stream where user_id = '".$user_id."' ");
				
				
				$AdmissionStreamResult_del34 = $conn->query("delete from complete_user_profile_tutoring_admission_level where user_id = 0 ");
				$AdmissionStreamResult_del = $conn->query("delete from complete_user_profile_tutoring_admission_level where user_id = '".$user_id."' ");
				
				$TutoringDetail_del = $conn->query("delete from complete_user_profile_tutoring_detail where user_id = '".$user_id."' ");
				$TutoringDetail_del22 = $conn->query("delete from complete_user_profile_tutoring_detail where user_id = 0 ");

				/// For TutoringDetail_Array		
				foreach($TutoringDetail_Array as $entry2Sub) 
				{
				}
				
				
				/// for Subject start
					foreach($entry2Sub['Tutoring_ALL_Subjects'] as $aa2 => $vv2) 
					{
						$arrayV4[] = "('".$vv2."')";
						
						//print_r($vv1);
						
					}

					
					$qua4 = $conn->query("delete from complete_user_profile_tutoring_tutoring_subjects_detail where user_id = '".$user_id."' ");
					$qua5 = $conn->query("INSERT INTO `complete_user_profile_tutoring_tutoring_subjects_detail` (Tutoring_ALL_Subjects) VALUES " . implode(', ', $arrayV4));  
					$qua6 = $conn->query("UPDATE complete_user_profile_tutoring_tutoring_subjects_detail SET user_id = '".$user_id."' where user_id = 0 ");  
					/// For Subject End
					
					
					
					
					/// ----------
					
					
					
				
				/// For TutoringDetail_Array		
				foreach($TutoringDetail_Array as $entry2) 
				{
					
			
					
					
					if($entry2['TutoringLevel'] == "Secondary" )
					{
						
						$AdmissionStreamResult_del34 = $conn->query("delete from complete_user_profile_tutoring_admission_stream where user_id = 0 ");
						$AdmissionStreamResult_del = $conn->query("delete from complete_user_profile_tutoring_admission_stream where user_id = '".$user_id."' ");
				
						
					
						$TutoringLevel = $entry2['TutoringLevel'];
						
						
						$Tutoring_ALL_Subjects = implode(',', $entry2['Tutoring_ALL_Subjects']);
						$Tutoring_Year = $entry2['Tutoring_Year'];
						$Tutoring_Month = $entry2['Tutoring_Month'];
						
						$query2 = $conn->query("INSERT INTO complete_user_profile_tutoring_detail (TutoringLevel, AdmissionLevel, Tutoring_ALL_Subjects, Tutoring_Year, Tutoring_Month, user_id,Tutoring_Grade) VALUES ('$TutoringLevel', '', '$Tutoring_ALL_Subjects', '$Tutoring_Year', '$Tutoring_Month', '$user_id','')");
						
						
						$Update_TutoringDetail = $conn->query("UPDATE complete_user_profile_tutoring_detail SET user_id = '".$user_id."' where user_id = 0 "); 	
					
					
					
					
						//////////
						//print_r($entry2['AdmissionStreamResult']);
						
						$all_streams = [];
						$all_AdmissionLevels = [];
						
						foreach($entry2['AdmissionStreamResult'] as $entry3) 
						{
							//print_r($entry3);
							 $AdmissionLevel = $entry3['AdmissionLevel'];
							 $AdmissionStreamResultID = $entry3['AdmissionStreamResultID'];
							 
							 

							$all_AdmissionLevels[] = $entry3['AdmissionLevel'];
							$all_streams = array_merge($all_streams, $entry3['Stream']);
							
							 
							
							$AdmissionStreamResultquery2 = $conn->query("INSERT INTO complete_user_profile_tutoring_admission_level (AdmissionStreamResultID, AdmissionLevel, user_id) VALUES ('$AdmissionStreamResultID', '$AdmissionLevel', '$user_id')");
							
							foreach($entry3['Stream'] as $entry4) 
							{
								 $streamDatavval = $entry4;
								 
								 
								
									//echo $streamDatavval;
									
									$AdmissionStreamquery2 = $conn->query("INSERT INTO complete_user_profile_tutoring_admission_stream (AdmissionStreamResultID, Stream, user_id) VALUES ('$AdmissionStreamResultID', '$streamDatavval', '$user_id')");
									if($AdmissionStreamquery2)
									{
										 $succ = 1;
										 
									}
									else{
										$succ = 0;
									}
									
									
								
								
								
							}
						}
						
						// Remove duplicate values
						$unique_streams = array_unique($all_streams);

						// Convert to a comma-separated string
						$stream_values = implode(",", $unique_streams);

						$Update_streamD = $conn->query("UPDATE complete_user_profile_tutoring_detail SET Stream = '".$stream_values."' WHERE user_id = '".$user_id."' "); 	

						/////////
						
						
						// Remove duplicate values (if needed)
						$unique_admission_levels = array_unique($all_AdmissionLevels);

						// Convert to a comma-separated string
						$admission_level_values = implode(",", $unique_admission_levels);

						$Update_AdmissionLevel_1 = $conn->query("UPDATE complete_user_profile_tutoring_detail SET AdmissionLevel = '".$admission_level_values."' WHERE user_id = '".$user_id."' "); 	


						/////////
							
					
					
					
					
					
					
						
					}  
					
					
					/**
					if($entry2['TutoringLevel'] == "AEIS" )
					{
						
						
					
						$TutoringLevel = $entry2['TutoringLevel'];
						
						
						$Tutoring_ALL_Subjects = implode(',', $entry2['Tutoring_ALL_Subjects']);
						$Tutoring_Year = $entry2['Tutoring_Year'];
						$Tutoring_Month = $entry2['Tutoring_Month'];
						
						
						foreach($entry2['AdmissionStreamResult'] as $entry3) 
						{
							//print_r($entry3);
							 $AdmissionLevel = $entry3['AdmissionLevel'];
							 $AdmissionStreamResultID = $entry3['AdmissionStreamResultID'];
							
							$AdmissionStreamResultqueryarr = $conn->query("INSERT INTO complete_user_profile_tutoring_admission_level (AdmissionStreamResultID, AdmissionLevel, user_id) VALUES ('$AdmissionStreamResultID', '$AdmissionLevel', '$user_id')");
							
							
						}
						
						
					} 
					
					**/
					
					
					if($entry2['TutoringLevel'] != "Secondary")
					{
						
						
						$TutoringLevel = $entry2['TutoringLevel'];
						$AdmissionLevel = $entry2['AdmissionLevel'];
						$Tutoring_Grade = implode(',', $entry2['Tutoring_Grade']);
						$Tutoring_ALL_Subjects = implode(',', $entry2['Tutoring_ALL_Subjects']);
						$Tutoring_Year = $entry2['Tutoring_Year'];
						$Tutoring_Month = $entry2['Tutoring_Month'];
						
						
						$query2 = $conn->query("INSERT INTO complete_user_profile_tutoring_detail (TutoringLevel, AdmissionLevel, Tutoring_Grade, Tutoring_ALL_Subjects, Tutoring_Year, Tutoring_Month) VALUES ('$TutoringLevel', '$AdmissionLevel', '$Tutoring_Grade', '$Tutoring_ALL_Subjects', '$Tutoring_Year', '$Tutoring_Month')");
					
					
						if(!empty($entry2['Tutoring_Grade']))
						{					
						/// for Grade start
							foreach($entry2['Tutoring_Grade'] as $aa1 => $vv1) 
							{
								$arrayV3[] = "('".$vv1."')";
								
								//print_r($vv1);
								
							}	
						
						
						$qua1 = $conn->query("delete from complete_user_profile_tutoring_grade_detail where user_id = '".$user_id."' ");
						$qua2 = $conn->query("INSERT INTO `complete_user_profile_tutoring_grade_detail` (Tutoring_Grade) VALUES " . implode(', ', $arrayV3));  
						$qua3 = $conn->query("UPDATE complete_user_profile_tutoring_grade_detail SET user_id = '".$user_id."' where user_id = 0 ");  
						/// For Grade End
						
						}
					
					
					
					
					}
					
					
					
				}
				
				
				
				
				
				
				
				
				
				
				
				
				$Update_TutoringDetail = $conn->query("UPDATE complete_user_profile_tutoring_detail SET user_id = '".$user_id."' where user_id = 0 "); 	
				
					
					
					
					
					
					
				
				//// +++++++++ End Tutoting Details ++++++
				
				
				
				
				
				
				///+++++++++++++++
				
				
						
				

					/// Get Registration data
					
							//// Average Rating of student_date_time_offer_confirmation
					
					
							$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$user_id."' ");
							
							
							
							$nn = 0;
							$sn = 0;
							while($avg_rating = mysqli_fetch_array($avg_rating_sql))
							{
								$sn = $sn+1;
								$nn = $nn+$avg_rating['rating_no'];
							}
							
							
							if($nn !=0 && $sn !=0)
							{
								
								 $avg_rating = round($nn/$sn); 
							}
							else
							{
								 $avg_rating = 'No rating.';
							}
					
					
					
							 ///check suspended accound
		
							$check_sus = $conn->query("SELECT * FROM tbl_user_suspended WHERE user_id = '".$user_id."' and account_suspended = 'suspended' ");
						
							if(mysqli_num_rows($check_sus) > 0)
							{
								$AccountType = 'suspended';
							}
							else{
								$AccountType = 'active';
							}
					
					
					
								$pprofile_data = $conn->query("SELECT user.mobile,user.first_name,user.last_name,user.user_type, user.user_id,user.accessToken,user.device_token, info.postal_code,info.profile_image FROM user_tutor_info as info INNER JOIN user_info as user ON info.user_id = user.user_id WHERE info.user_id = '".$user_id."' ");
								
								if(mysqli_num_rows($pprofile_data)>0)
								{
									$RData = mysqli_fetch_array($pprofile_data);
									$complete_profile = 'Yes';
									$first_name = $RData['first_name'];
									$last_name = $RData['last_name'];
									$mobileNo = $RData['mobile'];
									
								}
								else{
									$complete_profile = 'No';
								}
								
									
									
								
								
								if($RData['user_type'] !="")
								{
									
									$resultData = array('status' => true, 'message' => 'Tutor Profile Data Inserted Successfully.', 'user_type'=>$RData['user_type'], 'user_id'=>$RData['user_id'], 'accessToken'=>$RData['accessToken'], 'device_token'=>$RData['device_token'], 'postal_code'=>$RData['postal_code'], 'profile_image' => $RData['profile_image'], 'first_name' => $first_name, 'last_name' => $last_name, 'complete_profile' => $complete_profile, 'Mobile' => $mobileNo, 'Average_rating' => $avg_rating, 'AccountType' => $AccountType);
								
									$chk = 1;
									//echo json_encode($resultData2);
								}
								else{
									
									$resultData = array('status' => false, 'message' => 'Error Found.');
									$chk = 0;
									//echo json_encode($resultData2);
								}
				

			}
			else
			{
				$resultData = array('status' => false, 'message' => 'Error Found.');
			}
			
			
			/////#####/////
			
			
			
			
			
			
			
			
			
			
        }
    }
} else {
    // Handle a single user ID
    $user_id = $array['user_id'];
    if(!empty(trim($user_id))) {
		
		////
			//$del_profile = $conn->query("DELETE FROM user_tutor_info WHERE user_id = '$user_id' ");
			
		
		//echo $user_id;
		/// created date
			$get_create_date = mysqli_fetch_array($conn->query("SELECT created_date FROM user_info WHERE user_id = '$user_id' "));
			$genderv = mysqli_fetch_array($conn->query("SELECT gender FROM user_tutor_info WHERE user_id = '$user_id' "));
			
		
		
        //$userDetails = fetchUserDetails($conn, $user_id);
        $created_date = $get_create_date['created_date'];
        $gender = $array['gender']; //!empty($genderv['gender']) ? $genderv['gender'] : $value['gender'];

        $tutor_count = fetchTutorCount($conn, $created_date, $user_id);
        $date_parts = explode('-', $created_date);
        $year = substr($date_parts[2], -2);
        $month = $date_parts[1];
        $genderFC = substr($gender, 0, 1);

        $tutor_code = $year . $genderFC . $month . str_pad($tutor_count + 1, 1, '0', STR_PAD_LEFT);

       // echo $tutor_code . '==';
	   
	   
	   
	   
				// Process profile image if exists
				// Process profile image if exists
				if (!empty($array["profile_image"])) {
					// Define the Base64 value you need to save as an image
					$b64 = $array["profile_image"];
					$bin = base64_decode($b64);

					// Gather information about the image using the GD library
					$size = getImageSizeFromString($bin);

					// Check if the binary data is an image
					if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
						die('Base64 value is not a valid image');
					}

					// Ensure the image has a valid extension
					$ext = substr($size['mime'], 6);
					if (!in_array($ext, ['png', 'gif', 'jpeg'])) {
						die('Unsupported image type');
					}

					// Specify the location where you want to save the image
					$unique_id = uniqid('', true);  // Generate a unique ID
					$img_file = "../../UPLOAD_file/profile_image_{$unique_id}.{$ext}";  // Append the unique ID
					file_put_contents($img_file, $bin);
					$img_name = "profile_image_{$unique_id}.{$ext}";  // Use unique ID in image name
				}
	   
	   
	   
	   
	   
	   
	   
	   
				////#####//////
			
			
			
				
				if($array["user_id"] !="" && $array["age"] !="")
				{
				
					$arrayV[] = "('".$array["user_id"]."','".$img_name."','".$array["age"]."','".$array["date_of_year"]."','".$array["gender"]."','".$array["nationality"]."','".$array["flag"]."','".$array["qualification"]."','".$array["name_of_school"]."','".$array["Course_Exam"]."','".$array["gra_year"]."','".$array["tutor_status"]."','".$array["tuition_type"]."','".$location_str."','".$array["postal_code"]."','".$array["travel_distance"]."','".$personal_statement_str."','".$array["lettitude"]."','".$array["longitude"]."','".$tutor_code."','','','".$create_date."')";				
					
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
					$location = $location_str;
					
				
					
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
					$personal_statement = $personal_statement_str;
				}
				if($array["lettitude"] !="")
				{
					$lettitude = $array["lettitude"];
				}
				if($array["longitude"] !="")
				{
					$longitude = $array["longitude"];
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
					 $user_id = $idvalue;
				}
			
			
			/// check user_tutor_info record
			
			$chk_rec = $conn->query("select * from user_tutor_info where user_id = '".$user_id."' ");
			
			
			
			
			if(mysqli_num_rows($chk_rec)>0)
			{
				//$del_tinfo = $conn->query("delete from user_tutor_info where user_id = '".$user_id."' ");
				
				 $query = "UPDATE user_tutor_info SET profile_image = '".$img_name."', age = '".$age."', date_of_year = '".$date_of_year."', gender = '".$gender."',nationality = '".$nationality."',flag = '".$flag."',qualification = '".$qualification."',name_of_school = '".$name_of_school."',Course_Exam = '".$Course_Exam."',gra_year = '".$gra_year."',tutor_status = '".$tutor_status."',tuition_type = '".$tuition_type."',location = '".$location_str."',postal_code = '".$postal_code."' ,travel_distance = '".$travel_distance."',personal_statement = '".$personal_statement_str."',lettitude = '".$lettitude."',longitude = '".$longitude."' where user_id = '".$user_id."' ";  
			
				$imgup = 1;
			
			}
			else			
			{	
				 $query = "INSERT INTO `user_tutor_info` (user_id,profile_image,age,date_of_year,gender,nationality,flag,qualification,name_of_school,Course_Exam,gra_year,tutor_status,tuition_type,location,postal_code,travel_distance,personal_statement,lettitude,longitude,tutor_code,OtherCourse_Exam,stream,create_date) VALUES " . implode(', ', $arrayV);  
			
				$imgup = 0;
				
			}
			
			
			

			if($conn->query($query))
			{
				if($imgup==0 || $imgup==1)
				{
					$update_user_info = $conn->query("UPDATE user_info SET profile_image = '".$img_name."' where user_id = '".$user_id."' ");  
				
				}
				
				
				// Delay for 5 seconds
				sleep(5);
				// Introduce a delay (e.g., 5 seconds)
				//$conn->query("DO SLEEP(5)");
				
				///+++++++++++++++++
				
				
				
				
				$HistoryAcademy_del = $conn->query("delete from complete_user_profile_history_academy where user_id = 0 ");
				
				/// Delete History Academy Result
				 $query_result_delete = $conn->query("delete from complete_user_profile_history_academy_result where user_id = '".$user_id."' ");
				
				
				
				$ak = 0;
				
				$QAcademy_del2 = $conn->query("delete from complete_user_profile_qualification_academy_result where user_id = '".$user_id."' ");
					
				
				/// For QualificationAcademy_Array		
				foreach($QualificationAcademy_Array as $entry) 
				{
					
					//print_r($entry['subject']);
	
										
					 $Result_Subject = $entry['subject'];
					 $Result_Grade = $entry['grade'];
					 
					 
					 $query_result = $conn->query("INSERT INTO complete_user_profile_qualification_academy_result ( subject, grade, user_id) VALUES ( '$Result_Subject', '$Result_Grade', '$user_id')");

					 
									
							
							
					/// Get Result value end
					
					
					
					
				}
				
				
				/// For HistoryAcademy_Array		
				foreach($HistoryAcademy_Array as $entry) 
				{

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
					
					if($exam == 'Others')
					{
						$examName = $entry['examName'];
					}
					else{
						$examName = '';
					}
					
					
					$HistoryAcademy_del2 = $conn->query("delete from complete_user_profile_history_academy where user_id = '".$user_id."' ");
				
					
					$query = $conn->query("INSERT INTO complete_user_profile_history_academy (record_id, school, exam,examName) VALUES ('$ID', '$school', '$exam', '$examName')");
					
					
				}
				
				
				
				$Update_history_academy = $conn->query("UPDATE complete_user_profile_history_academy SET user_id = '".$user_id."' where user_id = 0 "); 	
				
				
				
				
				
				
				//// +++++++++ Start Tutoting Details ++++++
				
				
				                                                                                                                                                                                                                                                                 
				$qua1 = $conn->query("delete from complete_user_profile_tutoring_grade_detail where user_id = 0 ");
				$qua1 = $conn->query("delete from complete_user_profile_tutoring_grade_detail where user_id = '".$user_id."' ");
				$qua4 = $conn->query("delete from complete_user_profile_tutoring_tutoring_subjects_detail where user_id = 0 ");
				$qua4 = $conn->query("delete from complete_user_profile_tutoring_tutoring_subjects_detail where user_id = '".$user_id."' ");
				
				
				$AdmissionStreamResult_del34 = $conn->query("delete from complete_user_profile_tutoring_admission_stream where user_id = 0 ");
				$AdmissionStreamResult_del = $conn->query("delete from complete_user_profile_tutoring_admission_stream where user_id = '".$user_id."' ");
				
				
				$AdmissionStreamResult_del34 = $conn->query("delete from complete_user_profile_tutoring_admission_level where user_id = 0 ");
				$AdmissionStreamResult_del = $conn->query("delete from complete_user_profile_tutoring_admission_level where user_id = '".$user_id."' ");
				
				$TutoringDetail_del = $conn->query("delete from complete_user_profile_tutoring_detail where user_id = '".$user_id."' ");
				$TutoringDetail_del22 = $conn->query("delete from complete_user_profile_tutoring_detail where user_id = 0 ");

				/// For TutoringDetail_Array		
				foreach($TutoringDetail_Array as $entry2Sub) 
				{
				
				
				
				/// for Subject start
					foreach($entry2Sub['Tutoring_ALL_Subjects'] as $aa2 => $vv2) 
					{
						$arrayV4[] = "('".$vv2."')";
						
						//print_r($vv1);
						
					}

				}

					
					$qua4 = $conn->query("delete from complete_user_profile_tutoring_tutoring_subjects_detail where user_id = '".$user_id."' ");
					$qua5 = $conn->query("INSERT INTO `complete_user_profile_tutoring_tutoring_subjects_detail` (Tutoring_ALL_Subjects) VALUES " . implode(', ', $arrayV4));  
					$qua6 = $conn->query("UPDATE complete_user_profile_tutoring_tutoring_subjects_detail SET user_id = '".$user_id."' where user_id = 0 ");  
					/// For Subject End
					
					
					
					
					/// ----------
					
					
					
				
				/// For TutoringDetail_Array		
				foreach($TutoringDetail_Array as $entry2) 
				{
					
			
					
					
					if($entry2['TutoringLevel'] == "Secondary" )
					{
						
						$AdmissionStreamResult_del34 = $conn->query("delete from complete_user_profile_tutoring_admission_stream where user_id = 0 ");
						$AdmissionStreamResult_del = $conn->query("delete from complete_user_profile_tutoring_admission_stream where user_id = '".$user_id."' ");
				
						
					
						$TutoringLevel = $entry2['TutoringLevel'];
						
						
						$Tutoring_ALL_Subjects = implode(',', $entry2['Tutoring_ALL_Subjects']);
						$Tutoring_Year = $entry2['Tutoring_Year'];
						$Tutoring_Month = $entry2['Tutoring_Month'];
						
						$query2 = $conn->query("INSERT INTO complete_user_profile_tutoring_detail (TutoringLevel, AdmissionLevel, Tutoring_ALL_Subjects, Tutoring_Year, Tutoring_Month, user_id,Tutoring_Grade) VALUES ('$TutoringLevel', '', '$Tutoring_ALL_Subjects', '$Tutoring_Year', '$Tutoring_Month', '$user_id','')");
						
						
						$Update_TutoringDetail = $conn->query("UPDATE complete_user_profile_tutoring_detail SET user_id = '".$user_id."' where user_id = 0 "); 	
					
					
					
					
						$all_AdmissionLevels = [];
						$all_streams = [];
						
						foreach($entry2['AdmissionStreamResult'] as $entry3) 
						{
							//print_r($entry3);
							 $AdmissionLevel = $entry3['AdmissionLevel'];
							 $AdmissionStreamResultID = $entry3['AdmissionStreamResultID'];
							 
							 
							//$AdmissionLevel_val = implode(',', $entry3['AdmissionLevel']);
							//$Update_AdmissionLevel_1 = $conn->query("UPDATE complete_user_profile_tutoring_detail SET AdmissionLevel = '".$AdmissionLevel_val."' WHERE user_id = '".$user_id."' "); 	

							
							 
							 $all_AdmissionLevels[] = $entry3['AdmissionLevel'];
							 $all_streams = array_merge($all_streams, $entry3['Stream']);
							 
							
							$AdmissionStreamResultquery2 = $conn->query("INSERT INTO complete_user_profile_tutoring_admission_level (AdmissionStreamResultID, AdmissionLevel, user_id) VALUES ('$AdmissionStreamResultID', '$AdmissionLevel', '$user_id')");
							
							foreach($entry3['Stream'] as $entry4) 
							{
								 $streamDatavval = $entry4;
								 
							
								
									//echo $streamDatavval;
									
									$AdmissionStreamquery2 = $conn->query("INSERT INTO complete_user_profile_tutoring_admission_stream (AdmissionStreamResultID, Stream, user_id) VALUES ('$AdmissionStreamResultID', '$streamDatavval', '$user_id')");
									if($AdmissionStreamquery2)
									{
										 $succ = 1;
										 
									}
									else{
										$succ = 0;
									}
									
									
								
								
								
							}
						}
						
						
						// Remove duplicate values
						$unique_streams = array_unique($all_streams);

						// Convert to a comma-separated string
						$stream_values = implode(",", $unique_streams);

						$Update_streamD = $conn->query("UPDATE complete_user_profile_tutoring_detail SET Stream = '".$stream_values."' WHERE user_id = '".$user_id."' "); 	
							
						
						/////////
							
					
						
						// Remove duplicate values (if needed)
						$unique_admission_levels = array_unique($all_AdmissionLevels);

						// Convert to a comma-separated string
						$admission_level_values = implode(",", $unique_admission_levels);

						$Update_AdmissionLevel_1 = $conn->query("UPDATE complete_user_profile_tutoring_detail SET AdmissionLevel = '".$admission_level_values."' WHERE user_id = '".$user_id."' "); 	


						/////////
					
					
						
					}  
					
					
					if($entry2['TutoringLevel'] != "Secondary")
					{
						
						
						$TutoringLevel = $entry2['TutoringLevel'];
						$AdmissionLevel = $entry2['AdmissionLevel'];
						$Tutoring_Grade = implode(',', $entry2['Tutoring_Grade']);
						$Tutoring_ALL_Subjects = implode(',', $entry2['Tutoring_ALL_Subjects']);
						$Tutoring_Year = $entry2['Tutoring_Year'];
						$Tutoring_Month = $entry2['Tutoring_Month'];
						
						
						$query2 = $conn->query("INSERT INTO complete_user_profile_tutoring_detail (TutoringLevel, AdmissionLevel, Tutoring_Grade, Tutoring_ALL_Subjects, Tutoring_Year, Tutoring_Month) VALUES ('$TutoringLevel', '$AdmissionLevel', '$Tutoring_Grade', '$Tutoring_ALL_Subjects', '$Tutoring_Year', '$Tutoring_Month')");
					
							
					
						if(!empty($entry2['Tutoring_Grade']))
						{					
						/// for Grade start
							foreach($entry2['Tutoring_Grade'] as $aa1 => $vv1) 
							{
								$arrayV3[] = "('".$vv1."')";
								
								//print_r($vv1);
								
							}	
						
						
						$qua1 = $conn->query("delete from complete_user_profile_tutoring_grade_detail where user_id = '".$user_id."' ");
						$qua2 = $conn->query("INSERT INTO `complete_user_profile_tutoring_grade_detail` (Tutoring_Grade) VALUES " . implode(', ', $arrayV3));  
						$qua3 = $conn->query("UPDATE complete_user_profile_tutoring_grade_detail SET user_id = '".$user_id."' where user_id = 0 ");  
						/// For Grade End
						
						}
					
					
					
					
					}
					
					
					
				}
				
				
				
				
				
				
				
				
				
				
				
				
				$Update_TutoringDetail = $conn->query("UPDATE complete_user_profile_tutoring_detail SET user_id = '".$user_id."' where user_id = 0 "); 	
				
					
					
					
					
					
					
				
				//// +++++++++ End Tutoting Details ++++++
				
				
				
				
				
				
				///+++++++++++++++
				
				
						
				

					/// Get Registration data
					
							//// Average Rating of student_date_time_offer_confirmation
					
					
							$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$user_id."' ");
							
							
							
							$nn = 0;
							$sn = 0;
							while($avg_rating = mysqli_fetch_array($avg_rating_sql))
							{
								$sn = $sn+1;
								$nn = $nn+$avg_rating['rating_no'];
							}
							
							
							if($nn !=0 && $sn !=0)
							{
								
								 $avg_rating = round($nn/$sn); 
							}
							else
							{
								 $avg_rating = 'No rating.';
							}
					
					
					
							 ///check suspended accound
		
							$check_sus = $conn->query("SELECT * FROM tbl_user_suspended WHERE user_id = '".$user_id."' and account_suspended = 'suspended' ");
						
							if(mysqli_num_rows($check_sus) > 0)
							{
								$AccountType = 'suspended';
							}
							else{
								$AccountType = 'active';
							}
					
					
					
								$pprofile_data = $conn->query("SELECT user.mobile,user.first_name,user.last_name,user.user_type, user.user_id,user.accessToken,user.device_token, info.postal_code,info.profile_image FROM user_tutor_info as info INNER JOIN user_info as user ON info.user_id = user.user_id WHERE info.user_id = '".$user_id."' ");
								
								if(mysqli_num_rows($pprofile_data)>0)
								{
									$RData = mysqli_fetch_array($pprofile_data);
									$complete_profile = 'Yes';
									$first_name = $RData['first_name'];
									$last_name = $RData['last_name'];
									$mobileNo = $RData['mobile'];
									
								}
								else{
									$complete_profile = 'No';
								}
								
									
									
								
								
								if($RData['user_type'] !="")
								{
									
									$resultData = array('status' => true, 'message' => 'Tutor Profile Data Inserted Successfully.', 'user_type'=>$RData['user_type'], 'user_id'=>$RData['user_id'], 'accessToken'=>$RData['accessToken'], 'device_token'=>$RData['device_token'], 'postal_code'=>$RData['postal_code'], 'profile_image' => $RData['profile_image'], 'first_name' => $first_name, 'last_name' => $last_name, 'complete_profile' => $complete_profile, 'Mobile' => $mobileNo, 'Average_rating' => $avg_rating, 'AccountType' => $AccountType);
								
									$chk = 1;
									//echo json_encode($resultData2);
								}
								else{
									
									$resultData = array('status' => false, 'message' => 'Error Found.');
									$chk = 0;
									//echo json_encode($resultData2);
								}
				

			}
			else
			{
				$resultData = array('status' => false, 'message' => 'Error Found.');
			}
			
			
			
			
			/////#####/////				
	   
	   
	   
	   
	   
	   
	   
	   
    }
}
					
					
					
			/////###################//////
			
			
			
			
			/////#############///////
				
				
				
				
								
				echo json_encode($resultData);
			
?>