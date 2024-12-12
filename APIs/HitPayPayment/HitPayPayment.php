<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

include("HitPay.php");



if($_POST['logged_in_user_id'] !="" && $_POST['amount'] && $_POST['currency'])
{

$logged_in_user_id = $_POST['logged_in_user_id'];
$amount = $_POST['amount'];
$currency = $_POST['currency'];
$created_date = date('d-m-Y');

//$api = new HitPay('d0890ad21586febdc932411b81077e2d0cbfd725cdbb9c7596c4aa584e214e7d', true);
  
   $api = new HitPay('37f86f75bea64831c372daaae76f76f9f93f30981ca81617ea116ce9be7dc6d4', true);
  
 // $api = new HitPay('87f5773083689f80893d5438914da5617830b480f2672d34a36a10937dd6e66c', true);
  
  

try {
    $response = $api->paymentRequestCreate(array(
		'logged_in_user_id'    =>  $logged_in_user_id,
        'amount'    =>  $amount,
        'currency'  =>  $currency,
		'created_date'  =>  $created_date
        ));
    //print_r($response);
}
catch (Exception $e) {
    print('Error: ' . $e->getMessage());
}

 if(!empty($response))
 {
	 
	 $sql_payment = $conn->query("INSERT INTO tbl_payment SET logged_in_user_id = '".$logged_in_user_id."', amount = '".$amount."', currency = '".$currency."', created_date = '".$created_date."' ");
	 
	 $resultData = array('status' => true, 'Message' => $response);
 }
 else{
	 $resultData = array('status' => false, 'Message' => 'No record found. ');
 }

}
else			
{
	$resultData = array('status' => false, 'Message' => 'logged in user id, amount, currency can\'t blank. ');
}


echo json_encode($resultData);

?>