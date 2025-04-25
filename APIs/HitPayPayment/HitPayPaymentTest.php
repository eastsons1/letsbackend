<?php
session_start();
require_once("config.php");
// HitPay API credentials
$api_key = '37f86f75bea64831c372daaae76f76f9f93f30981ca81617ea116ce9be7dc6d4'; //'87f5773083689f80893d5438914da5617830b480f2672d34a36a10937dd6e66c';
$api_url = 'https://api.sandbox.hit-pay.com/v1/payment-requests'; 

//'https://api.hit-pay.com/v1/payment-requests';

// Get form data
$tutor_booking_process_id = $_GET['tutor_booking_process_id'];
$logged_in_user_id = $_GET['logged_in_user_id'];
$amount = $_GET['amount'];
//$currency = $_GET['currency'];
$email = $_GET['email'];
$currency = 'SGD';



//// add data in sesssion

$_SESSION['tutor_booking_process_id'] = $tutor_booking_process_id;
$_SESSION['logged_in_user_id'] = $logged_in_user_id;
$_SESSION['amount'] = $amount;




// Payment request data
$data = array(
    'amount' => $amount,
    'currency' => $currency,
	'email' => $email,
    'redirect_url' => 'https://mytutors.moe/version3/payment-success.php', // URL to redirect after payment success
    'webhook' => 'http://yourdomain.com/webhook.php' // URL to receive payment notifications
);

// Initialize cURL
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'X-BUSINESS-API-KEY: ' . $api_key,
    'Content-Type: application/x-www-form-urlencoded'
));

// Execute cURL request
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    die('Error: ' . curl_error($ch));
}

// Close cURL session
curl_close($ch);

//print_r($response);
//die();

// Decode JSON response
$responseData = json_decode($response, true);



// Redirect to HitPay payment URL
if(isset($responseData['url'])) {
	
	
	 $sql_payment = $conn->query("INSERT INTO tbl_payment SET tutor_booking_process_id = '".$tutor_booking_process_id."', logged_in_user_id = '".$logged_in_user_id."', amount = '".$amount."', currency = '".$currency."', created_date = '".$created_date."' ");
	 
	
		//$resultData = array('status' => true, 'Message' => $response);
	
	
    header('Location: ' . $responseData['url']);
    exit;
} else {
    echo 'Payment request failed: ' . $responseData['message'];
	
	//$resultData = array('status' => false, 'Message' => $responseData['message']);
}

//echo json_encode($resultData);
?>
