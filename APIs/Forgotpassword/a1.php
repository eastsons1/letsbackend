<?php
//error_reporting(0);
//header('Content-Type: application/json; charset=utf-8');
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: PUT, GET, POST");

//require_once("config.php");
//require_once("dbcontroller.php");
//header('content-type:application/json');


/**
$url = "https://login.windows.net/common/oauth2/authorize" . "?response_type=code". "&client_id=766090b1-948f-4eb3-ad69-9fc723b4e7d8". "&resource=https://analysis.windows.net/powerbi/api". "&redirect_uri=https://stagingclientportal.taxleaf.com/MicrosoftConnect";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$head = curl_exec($ch);

curl_close($ch);

**/


$url = "https://login.windows.net/common/oauth2/authorize" . "?response_type=code" . "&client_id=766090b1-948f-4eb3-ad69-9fc723b4e7d8" . "&resource=https://analysis.windows.net/powerbi/api" . "&redirect_uri=https://stagingclientportal.taxleaf.com/MicrosoftConnect";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // Corrected this line

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo 'Response: ' . $response;
}

curl_close($ch);



?>