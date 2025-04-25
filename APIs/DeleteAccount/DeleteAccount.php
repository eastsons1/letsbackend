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

    $currentTimestamp = date('Y-m-d H:i:s');

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
			
			$first_name = ucfirst($user_data['first_name']);
			$last_name = ucfirst($user_data['last_name']);
			$full_name = $first_name." ".$last_name;
			
            $randomNumber_otp = rand(1000, 9999); // Generate 4-digit OTP

            $updateStmt = $conn->prepare("UPDATE user_info SET otp = ?, otp_timestamp = ? WHERE user_id = ?");
            $updateStmt->bind_param("sss", $randomNumber_otp, $currentTimestamp, $user_login_id);

            if ($updateStmt->execute()) {
                // Send email
							
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
												' . implode(' ', str_split($randomNumber_otp)) . '
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
									 $to	=	$user_data['email'];	
									$mail->AddAddress($to);

									// Email subject
									$mail->Subject = 'OTP For Delete Record';

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
									
								 $response = ['status' => true, 'message' => 'OTP sent to user email.', 'OTP' => $randomNumber_otp];
									
									

								} catch (Exception $e) {
									echo 'Mailer Error: ' . $mail->ErrorInfo; // Provide error message in case of failure
								}
									
									////////////////////
									
									
									
									
									
									
									
									
									

               
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
            $stored_otp = $user_data['otp'];
            $otp_unix_timestamp = strtotime($user_data['otp_timestamp']);
            $current_time = time();

            if ($stored_otp == $otp) {
                if (($current_time - $otp_unix_timestamp) <= 90) {
                    $conn->begin_transaction();
                    try {
                        
					// Delete all related data
					
					$user_tutor_info_img     = $conn->query("select * from user_tutor_info where user_id = '".$user_login_id."' ");
					$user_tutor_info_img_res = mysqli_fetch_array($user_tutor_info_img);
					$fetch1      = $user_tutor_info_img_res['profile_image'];
					@unlink("../../UPLOAD_file/".$fetch1 );
					@unlink("../../UPLOAD_file/".$fetch1 );
					@unlink("../../UPLOAD_file/".$fetch1 );
					
					$deleteStmt2 = $conn->prepare("DELETE FROM user_tutor_info WHERE user_id = ?");
					$deleteStmt2->bind_param("s", $user_login_id);
					$deleteStmt2->execute();
					
					
					$user_student_info_img     = $conn->query("select * from user_student_info where user_id = '".$user_login_id."' ");
					$user_student_info_img_res = mysqli_fetch_array($user_student_info_img);
					$fetch2      = $user_student_info_img_res['profile_image'];
					@unlink("../../UPLOAD_file/".$fetch2 );
					@unlink("../../UPLOAD_file/".$fetch2 );
					@unlink("../../UPLOAD_file/".$fetch2 );

					$deleteStmt3 = $conn->prepare("DELETE FROM user_student_info WHERE user_id = ?");
					$deleteStmt3->bind_param("s", $user_login_id);
					$deleteStmt3->execute();

					$deleteStmt4 = $conn->prepare("DELETE FROM user_password WHERE email = ?");
					$deleteStmt4->bind_param("s", $user_data['email']);
					$deleteStmt4->execute();
					
					$deleteStmt5 = $conn->prepare("DELETE FROM user_info_temp WHERE user_id = ?");
					$deleteStmt5->bind_param("s", $user_login_id);
					$deleteStmt5->execute();

					$deleteStmt6 = $conn->prepare("DELETE FROM user_info_device_token WHERE user_id = ?");
					$deleteStmt6->bind_param("s", $user_login_id);
					$deleteStmt6->execute();
					
					$deleteStmt7 = $conn->prepare("DELETE FROM tutor_tutorial_subjects WHERE user_id = ?");
					$deleteStmt7->bind_param("s", $user_login_id);
					$deleteStmt7->execute();

					$deleteStmt8 = $conn->prepare("DELETE FROM tutor_totoring_stream WHERE user_id = ?");
					$deleteStmt8->bind_param("s", $user_login_id);
					$deleteStmt8->execute();

					$deleteStmt9 = $conn->prepare("DELETE FROM tutor_totoring_levels WHERE user_id = ?");
					$deleteStmt9->bind_param("s", $user_login_id);
					$deleteStmt9->execute();

					$deleteStmt10 = $conn->prepare("DELETE FROM tutor_totoring_grade WHERE user_id = ?");
					$deleteStmt10->bind_param("s", $user_login_id);
					$deleteStmt10->execute();
					
					$deleteStmt11 = $conn->prepare("DELETE FROM add_notifcations WHERE user_id_to_notification = ?");
					$deleteStmt11->bind_param("s", $user_login_id);
					$deleteStmt11->execute();
					
					$deleteStmt12 = $conn->prepare("DELETE FROM booked_tutor WHERE booked_by_user_id = ?");
					$deleteStmt12->bind_param("s", $user_login_id);
					$deleteStmt12->execute();
					$deleteStmt13 = $conn->prepare("DELETE FROM booked_tutor WHERE booked_to_user_id = ?");
					$deleteStmt13->bind_param("s", $user_login_id);
					$deleteStmt13->execute();
					
					$deleteStmt14 = $conn->prepare("DELETE FROM chatrooms WHERE loggedIn_user_id = ?");
					$deleteStmt14->bind_param("s", $user_login_id);
					$deleteStmt14->execute();
					
					$deleteStmt15 = $conn->prepare("DELETE FROM chat_users_details WHERE tutor_id = ?");
					$deleteStmt15->bind_param("s", $user_login_id);
					$deleteStmt15->execute();
					
					$deleteStmt16 = $conn->prepare("DELETE FROM chat_users_details WHERE student_id = ?");
					$deleteStmt16->bind_param("s", $user_login_id);
					$deleteStmt16->execute();
					
					$deleteStmt17 = $conn->prepare("DELETE FROM chat_users_details WHERE student_id = ?");
					$deleteStmt17->bind_param("s", $user_login_id);
					$deleteStmt17->execute();
					
					
					$del = $conn->query("DELETE FROM complete_user_profile_history_academy WHERE user_id = '".$user_login_id."' ");
					
					$del2 = $conn->query("DELETE FROM complete_user_profile_history_academy_result WHERE user_id = '".$user_login_id."' ");
					
					$del3 = $conn->query("DELETE FROM complete_user_profile_qualification_academy_result WHERE user_id = '".$user_login_id."' ");
					$del4 = $conn->query("DELETE FROM complete_user_profile_tutoring_admission_level WHERE user_id = '".$user_login_id."' ");
					$del5 = $conn->query("DELETE FROM complete_user_profile_tutoring_admission_stream WHERE user_id = '".$user_login_id."' ");
					$del6 = $conn->query("DELETE FROM complete_user_profile_tutoring_detail WHERE user_id = '".$user_login_id."' ");
					
					$del7 = $conn->query("DELETE FROM complete_user_profile_tutoring_grade_detail WHERE user_id = '".$user_login_id."' ");
					
					$del8 = $conn->query("DELETE FROM complete_user_profile_tutoring_tutoring_subjects_detail WHERE user_id = '".$user_login_id."' ");
					$del9 = $conn->query("DELETE FROM favourite_student_post_requirement_by_tutor WHERE tutor_login_id = '".$user_login_id."' ");
					
					$del9 = $conn->query("DELETE FROM favourite_tutor_by_student WHERE logged_in_student_id = '".$user_login_id."' ");
					$del10 = $conn->query("DELETE FROM favourite_tutor_by_student WHERE tutor_id = '".$user_login_id."' ");
					$del11 = $conn->query("DELETE FROM post_rating WHERE userid = '".$user_login_id."' ");
					
					$spri = mysqli_fetch_array($conn->query("SELECT student_post_requirements_id FROM student_post_requirements WHERE logged_in_user_id = '".$user_login_id."' "));
					$del27 = $conn->query("DELETE FROM tbl_Student_Level_Grade_Subjects_Post_Requirement WHERE student_post_requirements_id = '".$spri['student_post_requirements_id']."' ");
					
					
					$del12 = $conn->query("DELETE FROM student_post_requirements WHERE logged_in_user_id = '".$user_login_id."' ");
					$del13 = $conn->query("DELETE FROM student_post_requirements_Applied_by_tutor WHERE tutor_login_id = '".$user_login_id."' ");
					$del14 = $conn->query("DELETE FROM student_post_requirements_Applied_by_tutor WHERE student_loggedIn_id = '".$user_login_id."' ");
					$del15 = $conn->query("DELETE FROM student_post_requirements_Favourite_Assigned WHERE tutor_login_id = '".$user_login_id."' ");
					$del16 = $conn->query("DELETE FROM student_post_requirements_Favourite_Assigned WHERE student_login_id = '".$user_login_id."' ");
					$del17 = $conn->query("DELETE FROM student_post_requirement_amount_negotiate WHERE tutor_login_id = '".$user_login_id."' ");
					$del18 = $conn->query("DELETE FROM student_post_requirement_amount_negotiate WHERE student_login_id = '".$user_login_id."' ");
					$del19 = $conn->query("DELETE FROM tbl_appRating WHERE user_id = '".$user_login_id."' ");
					$del20 = $conn->query("DELETE FROM tbl_book_tutor_by_student WHERE student_id = '".$user_login_id."' ");
					$del21 = $conn->query("DELETE FROM tbl_book_tutor_by_student WHERE tutor_id = '".$user_login_id."' ");
					$del22 = $conn->query("DELETE FROM tbl_chatrooms_acceptance WHERE loggedIn_user_id = '".$user_login_id."' ");
					$del23 = $conn->query("DELETE FROM tbl_chatrooms_acceptance WHERE chat_userid = '".$user_login_id."' ");
					$del24 = $conn->query("DELETE FROM tbl_payment WHERE logged_in_user_id = '".$user_login_id."' ");
					$del25 = $conn->query("DELETE FROM tbl_rating WHERE student_id = '".$user_login_id."' ");
					$del26 = $conn->query("DELETE FROM tbl_rating WHERE tutor_id = '".$user_login_id."' ");
					
					
					$del28 = $conn->query("DELETE FROM tbl_temp_documents WHERE user_id = '".$user_login_id."' ");
					
					
					$tbl_user_documents_img     = $conn->query("select * from tbl_user_documents where user_id = '".$user_login_id."' ");
					$tbl_user_documents_img_res = mysqli_fetch_array($tbl_user_documents_img);
					$fetch5      = $tbl_user_documents_img_res['document_name'];
					@unlink("../../UPLOAD_file/".$fetch5 );
					@unlink("../../UPLOAD_file/".$fetch5 );
					@unlink("../../UPLOAD_file/".$fetch5 );
					$del29 = $conn->query("DELETE FROM tbl_user_documents WHERE user_id = '".$user_login_id."' ");
					
					$tbl_user_order_request_docs_img     = $conn->query("select * from tbl_user_order_request_docs where user_id = '".$user_login_id."' ");
					$tbl_user_order_request_docs_img_res = mysqli_fetch_array($tbl_user_order_request_docs_img);
					$fetch4      = $tbl_user_order_request_docs_img_res['order_request_document'];
					@unlink("../../UPLOAD_file/".$fetch4 );
					@unlink("../../UPLOAD_file/".$fetch4 );
					@unlink("../../UPLOAD_file/".$fetch4 );
					$del30 = $conn->query("DELETE FROM tbl_user_order_request_docs WHERE user_id = '".$user_login_id."' ");
					
					$del31 = $conn->query("DELETE FROM tbl_user_suspended WHERE user_id = '".$user_login_id."' ");
					$del32 = $conn->query("DELETE FROM token_table WHERE user_id = '".$user_login_id."' ");
					$del33 = $conn->query("DELETE FROM tutor_booking_process WHERE student_id = '".$user_login_id."' ");
					$del34 = $conn->query("DELETE FROM tutor_booking_process WHERE tutor_id = '".$user_login_id."' ");
					$del35 = $conn->query("DELETE FROM tutor_booking_process_discount WHERE student_id = '".$user_login_id."' ");
					$del36 = $conn->query("DELETE FROM tutor_qualification_subject_grade WHERE user_id = '".$user_login_id."' ");
					$del37 = $conn->query("DELETE FROM tutor_totoring_grade WHERE user_id = '".$user_login_id."' ");
					$del38 = $conn->query("DELETE FROM tutor_totoring_levels WHERE user_id = '".$user_login_id."' ");
					$del39 = $conn->query("DELETE FROM tutor_totoring_stream WHERE user_id = '".$user_login_id."' ");
					$del40 = $conn->query("DELETE FROM tutor_tutorial_subjects WHERE user_id = '".$user_login_id."' ");
					
					$user_info_img     = $conn->query("select * from user_info where user_id = '".$user_login_id."' ");
					$user_info_img_res = mysqli_fetch_array($user_info_img);
					$fetch3      = $user_info_img_res['profile_image'];
					@unlink("../../UPLOAD_file/".$fetch3 );
					@unlink("../../UPLOAD_file/".$fetch3 );
					@unlink("../../UPLOAD_file/".$fetch3 );
					$del41 = $conn->query("DELETE FROM user_info WHERE user_id = '".$user_login_id."' ");
					$del42 = $conn->query("DELETE FROM user_info_device_token WHERE user_id = '".$user_login_id."' ");
					$del43 = $conn->query("DELETE FROM user_info_temp WHERE user_id = '".$user_login_id."' ");
					$del44 = $conn->query("DELETE FROM user_student_info WHERE user_id = '".$user_login_id."' ");
					$del45 = $conn->query("DELETE FROM user_tutor_info WHERE user_id = '".$user_login_id."' ");
					
					$email = mysqli_fetch_array($conn->query("SELECT email FROM user_info WHERE user_id = '".$user_login_id."' "));
					
					$del46 = $conn->query("DELETE FROM user_password WHERE email = '".$email['email']."' ");
					
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
                    throw new Exception("OTP has Expired.");
                }
            } else {
                throw new Exception("OTP is Incorrect.");
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
