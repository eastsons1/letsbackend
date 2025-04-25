<?php
error_reporting(0);
ini_set('display_errors', 1);

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
require '../../phpmailer-master/class.phpmailer.php';

$response = ['status' => false, 'message' => 'An unknown error occurred.'];

try {
    $user_login_id = $_POST['user_login_id'] ?? null;
    $otp = $_POST['very_otp'] ?? null;

    if (empty($user_login_id)) {
        throw new Exception("User Login ID cannot be blank.");
    }

    if (empty($otp)) {
        // Fetch user and generate OTP
        $stmt = $conn->prepare("SELECT * FROM user_info WHERE user_id = ?");
        $stmt->bind_param("s", $user_login_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            $randomNumber_otp = rand(1000, 9999); // Generate 4-digit OTP
            //$hashedOtp = password_hash($randomNumber_otp, PASSWORD_DEFAULT);

            $updateStmt = $conn->prepare("UPDATE user_info SET otp = ? WHERE user_id = ?");
            $updateStmt->bind_param("ss", $randomNumber_otp, $user_login_id);

            if ($updateStmt->execute()) {
                // Send email
                 $mail = new PHPMailer(true); //New instance, with exceptions enabled

                                   // $body             = file_get_contents('../../phpmailer-master/contents.html');
                                    //$body             = preg_replace('/\\\\/','', $body); //Strip backslashes

                                    $body = '<table border="0" >

                                                <tr><td></td><td><strong>OTP For Delete Record</strong></td></tr>
                                                <tr><td></td><td><strong></strong></td></tr>
                                                <tr><td><strong>Hi '.$first_name.',</strong></td><td></td></tr>
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
                                    $mail->SMTPSecure = 'ssl'; 
									$mail->Port       = 465;                    // set the SMTP server port
                                    $mail->Host       = "cloud-9af00c.managed-vps.net"; // SMTP server
                                    $mail->Username   = "info@mytutors.moe";     // SMTP server username
                                    $mail->Password   = "PVzn08KRAzDhV";            // SMTP server password

                                    $mail->IsSendmail();  // tell the class to use Sendmail

                                    $mail->AddReplyTo("info@mytutors.moe","First Last");

                                    $mail->From       = "info@mytutors.moe";
                                    $mail->FromName   = "MyTutors Registration Service";

                                    
                                    $to	=	$user_data['email'];	

                                    $mail->AddAddress($to);

                                    $mail->Subject  = "OTP For Delete Record";

                                    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                                    $mail->WordWrap   = 80; // set word wrap

                                    $mail->MsgHTML($body);

                                 

                                    $mail->IsHTML(true); // send as HTML

                                    $mail->Send();

                $response = ['status' => true, 'message' => 'OTP sent to user email.', 'OTP' => $randomNumber_otp];
            } else {
                throw new Exception("Failed to update OTP in the database.");
            }
        } else {
            throw new Exception("User not found.");
        }
    } else {
        // Validate OTP and delete user data
        $stmt = $conn->prepare("SELECT * FROM user_info WHERE user_id = ?");
        $stmt->bind_param("s", $user_login_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            if($user_data['otp']) {
                $conn->begin_transaction();
                try {
                    // Delete all related data
                    $deleteStmt = $conn->prepare("DELETE FROM user_info WHERE user_id = ?");
                    $deleteStmt->bind_param("s", $user_login_id);
                    $deleteStmt->execute();
                    $conn->commit();

                    $response = ['status' => true, 'message' => 'Account deleted successfully.'];
                } catch (Exception $e) {
                    $conn->rollback();
                    throw $e;
                }
            } else {
                throw new Exception("Invalid OTP.");
            }
        } else {
            throw new Exception("User not found.");
        }
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
