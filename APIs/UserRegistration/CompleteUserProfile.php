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
if ($conn->connect_error) {
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
    foreach ($all_mimes as $key => $value) {
        if(array_search($mime,$value) !== false) return $key;
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
			
			
			
			
			// Extracting row by row
			foreach($array as $row => $value) {
				
				
				
				if($value["profile_image"] !="")
				{
					
							
							// Define the Base64 value you need to save as an image
														
							$b64 = $value["profile_image"];

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
				
				
				if($value["user_id"] !="" && $value["age"] !="")
				{
				
					$arrayV[] = "('".$value["user_id"]."','".$img_name."','".$value["age"]."','".$value["date_of_year"]."','".$value["gender"]."','".$value["nationality"]."','".$value["flag"]."','".$value["qualification"]."','".$value["name_of_school"]."','".$value["Course_Exam"]."','".$value["OtherCourse_Exam"]."','".$value["gra_year"]."','".$value["tutor_status"]."','".$value["tuition_type"]."','".$value["location"]."','".$value["postal_code"]."','".$value["travel_distance"]."','".$value["tutor_tutoring_experience_years"]."','".$value["tutor_tutoring_experience_months"]."','".$value["personal_statement"]."','".$tutor_code."')";				
					
					$user_id_array[] = $value["user_id"];
				}
				
				if($value["age"] !="")
				{
					$age = $value["age"];
				} 
				if($value["date_of_year"] !="")
				{
					$date_of_year = $value["date_of_year"];
				} 				 
				if($value["gender"] !="")
				{
					$gender = $value["gender"];
				}
				if($value["nationality"] !="")
				{
					$nationality = $value["nationality"];
				}
				if($value["qualification"] !="")
				{
					$qualification = $value["qualification"];
				}
				if($value["flag"] !="")
				{
					$flag = $value["flag"];
				}
				if($value["name_of_school"] !="")
				{
					$name_of_school = $value["name_of_school"];
				}
				if($value["Course_Exam"] !="")
				{
					$Course_Exam = $value["Course_Exam"];
				}
				if($value["OtherCourse_Exam"] !="")
				{
					$OtherCourse_Exam = $value["OtherCourse_Exam"];
				}
				if($value["gra_year"] !="")
				{
					$gra_year = $value["gra_year"];
				}
				if($value["tutor_status"] !="")
				{
					$tutor_status = $value["tutor_status"];
				}
				if($value["tuition_type"] !="")
				{
					$tuition_type = $value["tuition_type"];
				}
				if($value["location"] !="")
				{
					$location = $value["location"];
				}
				if($value["postal_code"] !="")
				{
					$postal_code = $value["postal_code"];
				}	
				if($value["travel_distance"] !="")
				{
					$travel_distance = $value["travel_distance"];
				}	
				if($value["tutor_tutoring_experience_years"] !="")
				{
					$tutor_tutoring_experience_years = $value["tutor_tutoring_experience_years"];
				}
				if($value["tutor_tutoring_experience_months"] !="")
				{
					$tutor_tutoring_experience_months = $value["tutor_tutoring_experience_months"];
				}
				if($value["personal_statement"] !="")
				{
					$personal_statement = $value["personal_statement"];
				}
				/**
				if($value["tutor_code"] !="")
				{
					$tutor_code = $value["tutor_code"];
				}				
				**/
				
				
				
			}
			
			
			
			
			/// Get User_id from array
				foreach($user_id_array as $idrow => $idvalue) 
				{
					$user_id = $idvalue;
				}
			
			
			/// check user_tutor_info record
			
			$chk_rec = $conn->query("select * from user_tutor_info where user_id = '".$user_id."' ");
			
			if(mysqli_num_rows($chk_rec)>0)
			{
				//$del_tinfo = $conn->query("delete from user_tutor_info where user_id = '".$user_id."' ");date_of_year
				
				$query = "UPDATE user_tutor_info SET profile_image = '".$img_name."', age = '".$age."', date_of_year = '".$date_of_year."', gender = '".$gender."',nationality = '".$nationality."',flag = '".$flag."',qualification = '".$qualification."',name_of_school = '".$name_of_school."',Course_Exam = '".$Course_Exam."',OtherCourse_Exam = '".$OtherCourse_Exam."',gra_year = '".$gra_year."',tutor_status = '".$tutor_status."',tuition_type = '".$tuition_type."',location = '".$location."',postal_code = '".$postal_code."',travel_distance = '".$travel_distance."',tutor_tutoring_experience_years = '".$tutor_tutoring_experience_years."',tutor_tutoring_experience_months = '".$tutor_tutoring_experience_months."',personal_statement = '".$personal_statement."',tutor_code = '".$tutor_code."' where user_id = '".$user_id."' ";  
			
			}
			else			
			{	
			
				$query = "INSERT INTO `user_tutor_info` (user_id,profile_image,age,date_of_year,gender,nationality,flag,qualification,name_of_school,Course_Exam,OtherCourse_Exam,gra_year,tutor_status,tuition_type,location,postal_code,travel_distance,tutor_tutoring_experience_years,tutor_tutoring_experience_months,personal_statement,tutor_code) VALUES " . implode(', ', $arrayV);  
			}
			
			
			
			
			
			//start second array
			
			foreach($value as $row2 => $value2) 
			{
					
				if($value2["tutor_qualification_Subject"] !="")
				{
					$arrayV3[] = "('".$value2["tutor_qualification_Subject"]."','".$value2["tutor_qualification_Grade"]."','".$value2["user_id"]."')";
					$addStatus = 1;
				}
				else{
					$addStatus = 0;
				}
				
				if($value2["Tutoring_Grade"] !="")
				{
					$arrayV4[] = "('".$value2["Tutoring_Grade"]."','".$value2["user_id"]."')";
					$addStatus2 = 1;
				}
				else{
					$addStatus2 = 0;
				}
				if($value2["Tutoring_Stream"] !="")
				{
					$arrayV5[] = "('".$value2["Tutoring_Stream"]."','".$value2["user_id"]."')";
					$addStatus3 = 1;
				}
				else{
					$addStatus3 = 0;
				}
				if($value2["Tutoring_Subjects"] !="")
				{
					$arrayV6[] = "('".$value2["Tutoring_Subjects"]."','".$value2["user_id"]."')";
					$addStatus4 = 1;
				}
				else{
					$addStatus4 = 0;
				}
				if($value2["Tutoring_Level"] !="")
				{
					$arrayV7[] = "('".$value2["Tutoring_Level"]."','".$value2["user_id"]."')";
					$addStatus5 = 1;
				}
				else{
					$addStatus5 = 0;
				}
			}		
			
				
			
			

			if($conn->query($query)){
				
					
				
				///empty records
				$tqsg = $conn->query("delete from tutor_qualification_subject_grade where user_id = '".$user_id."' ");
				$tqsg2 = $conn->query("delete from tutor_totoring_grade where user_id = '".$user_id."' ");
				$tqsg3 = $conn->query("delete from tutor_totoring_stream where user_id = '".$user_id."' ");
				$tqsg4 = $conn->query("delete from tutor_tutorial_subjects where user_id = '".$user_id."' ");
				$tqsg5 = $conn->query("delete from tutor_totoring_levels where user_id = '".$user_id."' ");
				
				
				if($addStatus==1)
				{
					$tutor_qualification_subject_grade = $conn->query("INSERT INTO `tutor_qualification_subject_grade` (tutor_qualification_Subject,tutor_qualification_Grade,user_id) VALUES " . implode(', ', $arrayV3));  
				//$product_selection2 = $conn->query("UPDATE `product_selection` SET product_id = '".$pro_last_id."' WHERE product_id = '0' ");	
				}
				if($addStatus2==1)
				{
					$tutor_totoring_grade = $conn->query("INSERT INTO `tutor_totoring_grade` (Tutoring_Grade,user_id) VALUES " . implode(', ', $arrayV4));  
				}
				if($addStatus3==1)
				{
					$tutor_totoring_stream = $conn->query("INSERT INTO `tutor_totoring_stream` (Tutoring_Stream,user_id) VALUES " . implode(', ', $arrayV5));  
				}
				if($addStatus4==1)
				{
					$tutor_tutorial_subjects = $conn->query("INSERT INTO `tutor_tutorial_subjects` (Tutoring_Subjects,user_id) VALUES " . implode(', ', $arrayV6));  
				}
				if($addStatus5==1)
				{
					$tutor_totoring_level = $conn->query("INSERT INTO `tutor_totoring_levels` (Tutoring_Level,user_id) VALUES " . implode(', ', $arrayV7));  
				}
				
				$resultData = array('status' => true, 'message' => 'Tutor Profile Data Inserted Successfully.');
				
					//http_response_code(200);
					

				}
				else
				{
					$resultData = array('status' => false, 'message' => 'Error Found.');
				}
				
				
				echo json_encode($resultData);
			
?>