<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


$servername = "127.0.0.1";
$username = "u418826474_tutorAppAPI";
$password = "tutorAppAPI446(#^%&^";
$dbname = "u418826474_tutorAppAPI";
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
			$booked_date = $array['booked_date'];
			
			
			$chk_booking = $conn->query("select * from tutor_booking_process where student_id = '".$student_id."' and tutor_id = '".$tutor_id."' ");
			
			if(mysqli_num_rows($chk_booking)==0)
			{	
			
			if($student_id !="" && $tutor_id !="")
			{
			
			
			$arrayV[] = "('".$array["student_id"]."','".$array["student_tution_type"]."','".$array["postal_code"]."','".$array["postal_address"]."','".$array["tutor_id"]."','".$array["tutor_duration_weeks"]."','".$array["tutor_duration_hours"]."','".$array["tutor_tution_fees"]."','".$array["tutor_tution_schedule_time"]."','".$array["tutor_tution_offer_amount_type"]."','".$array["tutor_tution_offer_amount"]."','".$array["booked_date"]."')";				
			
			$student_idV = $array["student_id"];
			$tutor_idV = $array["tutor_id"];
			
			$Tutor_Schedules_Slot_Time = $array['Tutor_Schedules_Slot_Time'];
			
			$Student_Level_Grade_Subjects = $array['Student_Level_Grade_Subjects'];
			
			
			$Qualifications = $array['Qualifications'];
			
			
			
			
			
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
				
				$query = "INSERT INTO `tutor_booking_process` (student_id,student_tution_type,tutor_id,tutor_duration_weeks,tutor_duration_hours,tutor_tution_fees,tutor_tution_schedule_time,tutor_tution_offer_amount_type,tutor_tution_offer_amount,booked_date) VALUES " . implode(', ', $arrayV);  
			}
			else			
			{	
			
				$query = "INSERT INTO `tutor_booking_process` (student_id,student_tution_type,postal_code,postal_address,tutor_id,tutor_duration_weeks,tutor_duration_hours,tutor_tution_fees,tutor_tution_schedule_time,tutor_tution_offer_amount_type,tutor_tution_offer_amount,booked_date) VALUES " . implode(', ', $arrayV);  
			}
			
			
			
			
			// For Qualifications
				foreach($Qualifications as $row2 => $value2) 
				{
					
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
			
			
			

			if($conn->query($query))
			{
				
				
				$getLastBooking_id = mysqli_fetch_array($conn->query("SELECT * FROM tutor_booking_process ORDER BY tutor_booking_process_id DESC LIMIT 0,1"));
				
				$getLastBooking_id_val = $getLastBooking_id['tutor_booking_process_id'];
				
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
					
					$level1 = $conn->query("delete from tutor_booking_process_Level_Grade_Subjects where Level = '".$level."' and Grade = '".$grade."' ");
				
					
					$query = $conn->query("INSERT INTO tutor_booking_process_Level_Grade_Subjects (ID, ALL_Subjects, Grade, Level, Admission_Level, tutor_booking_process_id) VALUES ('$id', '$allSubjects', '$grade', '$level', '$Admission_level', '$getLastBooking_id_val')");
					
					
					
					
					
					if($level=="Secondary")
					{
						
						$Stream1 = $conn->query("delete from tutor_booking_process_streams where tutor_booking_process_id = '".$getLastBooking_id_val."' "); 
						
						//print_r($entry['Stream']);
						
						foreach($entry['Stream'] as $streamData)
						{
							$query_stream = $conn->query("INSERT INTO tutor_booking_process_streams (streams, tutor_booking_process_id) VALUES ('$streamData', '$getLastBooking_id_val')");
					
						}
						
						
					}
				
					
					
				}
				
				
				
				///empty records
				
				
				
				/// Tutor Qualification
				$qua1 = $conn->query("delete from tutor_booking_process_TutorQualification where tutor_booking_process_id = 0 ");
				$qua2 = $conn->query("INSERT INTO `tutor_booking_process_TutorQualification` (Tutor_Qualification) VALUES " . implode(', ', $arrayV3));  
				$qua3 = $conn->query("UPDATE tutor_booking_process_TutorQualification SET tutor_booking_process_id = '".$getLastBooking_id['tutor_booking_process_id']."' where tutor_booking_process_id = 0 ");  
				
				
				
					
					if($qua3)
					{
						
						
						/// For Add Schedule and Times		
						foreach($Tutor_Schedules_Slot_Time as $scheduleTime) 
						{
							
							$slot_times = implode(',', $scheduleTime['slot_time']);
							$tutor_schedule = $scheduleTime['tutor_schedule'];
							
							
							$scheduleTime_del = $conn->query("delete from tutor_booking_process_Schedules_Slot_Time where tutor_schedule = '".$tutor_schedule."' and slot_times = '".$slot_times."' ");
						
							
							$scheduleTime_insrt = $conn->query("INSERT INTO tutor_booking_process_Schedules_Slot_Time (tutor_schedule, slot_times, tutor_booking_process_id) VALUES ('$tutor_schedule', '$slot_times', '$getLastBooking_id_val')");
							
							
						}
						
						$Level_Grade_Subjects = $conn->query("UPDATE tutor_booking_process_Level_Grade_Subjects  SET tutor_booking_process_id = '".$getLastBooking_id['tutor_booking_process_id']."' where tutor_booking_process_id = 0 "); 
						$scheduleTime_update = $conn->query("UPDATE tutor_booking_process_Schedules_Slot_Time SET tutor_booking_process_id = '".$getLastBooking_id['tutor_booking_process_id']."' where tutor_booking_process_id = 0 ");  	
					
					
						
						
						
						$resultData = array('status' => true, 'message' => 'Tutor Booking Process Successful.');
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
			

			}
			else{
				$resultData = array('status' => false, 'message' => 'This Tutor has been booked already.');
			}				
				
				echo json_encode($resultData);
			
?>