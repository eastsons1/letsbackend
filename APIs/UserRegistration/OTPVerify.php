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
            
            
            if (($current_time - $otp_unix_timestamp) > 0 && ($current_time - $otp_unix_timestamp) <= 90) {
                $resultData = array('status' => true, 'message' => 'OTP Verified Successfully.');
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

echo json_encode($resultData);



			
?>