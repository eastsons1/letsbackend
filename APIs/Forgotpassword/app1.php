<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

//require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');



$appid = "766090b1-948f-4eb3-ad69-9fc723b4e7d8";
$tennantid = "9728fcf8-f04b-4271-b352-022a33fbfcc4";
$secret = "J~48Q~TEp7NhfobQYBv6iocPxMHCLIWGBORlYa~2";
$login_url ="https://login.microsoftonline.com/".$tennantid."/oauth2/v2.0/authorize";

session_start ();

$_SESSION['state'] = session_id();

//echo '<h2><p>You can <a href="?action=login">Log In</a> with Microsoft</p></h2>';

if($_POST['action'] == 'login') {
    $params = array (
        'client_id' => $appid,
        'redirect_uri' => 'https://stagingclientportal.taxleaf.com/MicrosoftConnect',
        'response_type' => 'token',
        'response_mode' => 'form_post',
        'scope' => 'https://graph.microsoft.com/User.Read',
        'state' => $_SESSION['state']
    );

    header('Location: '.$login_url.'?'.http_build_query($params));
}

if(array_key_exists('access_token', $_POST)) {
    $_SESSION['t'] = $_POST['access_token'];
    $t = $_SESSION['t'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$t, 'Content-type: application/json'));

    curl_setopt($ch, CURLOPT_URL, "https://graph.microsoft.com/v1.0/me/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $rez = json_decode(curl_exec($ch), 1);

    if (array_key_exists('error', $rez)) {  
        var_dump($rez['error']);    
        die();
    }
	
	
	
	// Check if the key 'fEnableShowResendCode' exists
    if (array_key_exists('fEnableShowResendCode', $rez)) {
        echo $rez['fEnableShowResendCode'];
    } else {
        echo 'Key fEnableShowResendCode not found in the response.';
    }
	
	
	//print_r($rez);
			
	
	//echo $rez['fEnableShowResendCode'];
	
	
	
}


?>