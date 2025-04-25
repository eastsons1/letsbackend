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
			
			
			// Extracting row by row
			foreach($array as $row => $value) {
				
				
				
				if($value["student_id"] !="" && $value["tutor_id"] !="")   ///if($value["student_id"] !="" )
				{
				
					$arrayV[] = "('".$value["student_id"]."','".$value["student_level"]."','".$value["student_grade"]."','".$value["tutor_id"]."','".$value["tutor_duration_weeks"]."','".$value["tutor_duration_hours"]."','".$value["tutor_tution_fees"]."','".$value["tutor_tution_schedule_time"]."','".$value["tutor_tution_offer_amount_type"]."','".$value["tutor_tution_offer_amount"]."','".$value["booked_date"]."')";				
					
					$student_id_array[] = $value["student_id"];
					$tutor_id_array[] = $value["tutor_id"];
				}
				
				if($value["student_id"] !="")
				{
					$student_idV = $value["student_id"];
				}
				
				if($value["tutor_id"] !="")
				{
					$tutor_idV = $value["tutor_id"];
				}
			/**	
				if($value["tution_type"] !="")
				{
					$tution_type = $value["tution_type"];
				}
				
				if($value["postal_code"] !="")
				{
					$postal_code = $value["postal_code"];
				}
				if($value["level"] !="")
				{
					$level = $value["level"];
				}
				if($value["grade"] !="")
				{
					$grade = $value["grade"];
				}
				if($value["booking_status"] !="")
				{
					$booking_status = $value["booking_status"];
				}
				if($value["booking_date"] !="")
				{
					$booking_date = $value["booking_date"];
				}
				**/
				
				
				
			}
			
			
			/// Get student_id from array
				foreach($student_id_array as $idrow => $idvalue) 
				{
					$student_id = $idvalue;
				}
			
			
			/// Get tutor_id from array
				foreach($tutor_id_array as $idrow2 => $idvalue2) 
				{
					$tutor_id = $idvalue2;
				}	
				
				
			
			
			/// check user_tutor_info record
			
			$chk_rec = $conn->query("select * from tutor_booking_process where student_id = '".$student_idV."' and tutor_id = '".$tutor_idV."' ");
			//$chk_rec = $conn->query("select * from tutor_booking_process where student_id = '".$student_idV."'  ");
			
			
			
			if(mysqli_num_rows($chk_rec)>0)
			{
				
				$GET_Book_ID = mysqli_fetch_array($chk_rec);
				
				///Student Subjects
				$del_tinfo = $conn->query("delete from tutor_booking_process_StudentSubjects where tutor_booking_process_id = '".$GET_Book_ID['tutor_booking_process_id']."'  ");
				
				////Tutor Qualification
				$del_tinfo2 = $conn->query("delete from tutor_booking_process_TutorQualification where tutor_booking_process_id = '".$GET_Book_ID['tutor_booking_process_id']."'  ");
				
				////Tutor Schedule
				$del_tinfo3 = $conn->query("delete from tutor_booking_process_TutorSchedule where tutor_booking_process_id = '".$GET_Book_ID['tutor_booking_process_id']."'  ");
				
				
				
				$tqsg = $conn->query("delete from tutor_booking_process where tutor_booking_process_id = '".$GET_Book_ID['tutor_booking_process_id']."' ");
				
				$query = "INSERT INTO `tutor_booking_process` (student_id,student_level,student_grade,tutor_id,tutor_duration_weeks,tutor_duration_hours,tutor_tution_fees,tutor_tution_schedule_time,tutor_tution_offer_amount_type,tutor_tution_offer_amount,booked_date) VALUES " . implode(', ', $arrayV);  
			}
			else			
			{	
			
				$query = "INSERT INTO `tutor_booking_process` (student_id,student_level,student_grade,tutor_id, tutor_duration_weeks,tutor_duration_hours,tutor_tution_fees,tutor_tution_schedule_time,tutor_tution_offer_amount_type,tutor_tution_offer_amount,booked_date) VALUES " . implode(', ', $arrayV);  
			}
			
			
			
			
			//start second array
			
			foreach($value as $row2 => $value2) 
			{
					
				if($value2["subject"] !="")
				{
					$arrayV2[] = "('".$value2["subject"]."','".$value2["subject_id"]."')";
				}
				if($value2["qualification"] !="")
				{
					$arrayV3[] = "('".$value2["qualification"]."','".$value2["qualification_id"]."')";
				}
				if($value2["tutor_schedule"] !="")
				{
					$arrayV4[] = "('".$value2["tutor_schedule"]."')";
				}
				
			}		
			
				
			
			

			if($conn->query($query))
			{
				
				
				$getLastBooking_id = mysqli_fetch_array($conn->query("SELECT * FROM tutor_booking_process ORDER BY tutor_booking_process_id DESC LIMIT 0,1"));
				
				///empty records
				
				
				/// Student Subjects
				$sub = $conn->query("delete from tutor_booking_process_StudentSubjects where tutor_booking_process_id = 0 ");
				$sub2 = $conn->query("INSERT INTO `tutor_booking_process_StudentSubjects` (Student_Subjects,Student_Subjects_id) VALUES " . implode(', ', $arrayV2));  
				$sub3 = $conn->query("UPDATE tutor_booking_process_StudentSubjects SET tutor_booking_process_id = '".$getLastBooking_id['tutor_booking_process_id']."' where tutor_booking_process_id = 0 ");  
			
				/// Tutor Qualification
				$qua1 = $conn->query("delete from tutor_booking_process_TutorQualification where tutor_booking_process_id = 0 ");
				$qua2 = $conn->query("INSERT INTO `tutor_booking_process_TutorQualification` (Tutor_Qualification,Tutor_Qualification_id) VALUES " . implode(', ', $arrayV3));  
				$qua3 = $conn->query("UPDATE tutor_booking_process_TutorQualification SET tutor_booking_process_id = '".$getLastBooking_id['tutor_booking_process_id']."' where tutor_booking_process_id = 0 ");  
				
				
				/// Tutor Schedule
				$Schedule = $conn->query("delete from tutor_booking_process_TutorSchedule where tutor_booking_process_id = 0 ");
				$Schedule2 = $conn->query("INSERT INTO `tutor_booking_process_TutorSchedule` (tutor_schedule) VALUES " . implode(', ', $arrayV4));  
				$Schedule_update = $conn->query("UPDATE tutor_booking_process_TutorSchedule SET tutor_booking_process_id = '".$getLastBooking_id['tutor_booking_process_id']."' where tutor_booking_process_id = 0 ");  
				
					
					if($Schedule_update)
					{
						$resultData = array('status' => true, 'message' => 'Tutor Booking Process Successful.',$arrayV2);
					}
					
					

			}
			else
				{
					$resultData = array('status' => false, 'message' => 'Error Found.');
				}
				
				
				
				echo json_encode($resultData);
			
?>