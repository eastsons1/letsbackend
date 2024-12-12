<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

function sendPushNotification($to = '', $data = array()) {
    $api_key = 'AAAAf0sjSUk:APA91bFcxtNxUFAm-5o_52jNXqoFjlqimXQanGi0zyaEDiSfSiYW7iT1cm0s0Bm5Qx8lur1jRZSi_qfbUa3OvSo51cu0_hvgMj_efnbjlFikJDRsFreSIymliWgIdPUz323oMSKvUMST'; // Replace with your FCM server key
    $fields = array('to' => $to, 'notification' => $data);
    $headers = array(
        'Content-Type: application/json',
        'Authorization: key=' . $api_key
    );
    $url = 'https://fcm.googleapis.com/fcm/send';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

$to = 'ennSF5RqRQeXeqgkRYz1Cn:APA91bFvi2k5auqi8u3KuDVxPdcuMR2nJusmD6DSWEMrWp7tTnELug4m3hn7Mj7Z1aqgZQJpZi1rPBVGyFxNQPCYx2_KoDg01vjP3uJjZWVnQnUXE8kT-2JjtaZ46W0OM6HsNFTXFxdj'; // Replace with your device token
$message = array(
    'title' => 'Hi',
    'body' => 'I am Pushpendra'
);
echo sendPushNotification($to, $message); // Output the result of sending the notification
?>
