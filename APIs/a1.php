<?php

function sendMessageThroughFCM($arr) {
    // Google Firebase messaging FCM-API url
    $url = 'https://fcm.googleapis.com/fcm/send';
    $fields = $arr;
    define("GOOGLE_API_KEY","AAAAf0sjSUk:APA91bFcxtNxUFAm-5o_52jNXqoFjlqimXQanGi0zyaEDiSfSiYW7iT1cm0s0Bm5Qx8lur1jRZSi_qfbUa3OvSo51cu0_hvgMj_efnbjlFikJDRsFreSIymliWgIdPUz323oMSKvUMST");
    $headers = array(
        'Authorization: key=' . GOOGLE_API_KEY,
        'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);   
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);               
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

$androidTokens = ['dDVqoZUpTcegbm-A465c3E:APA91bEqUZzKf6kJYyTcOObQP_mck6dAOwO3nL_T0yPIVuFtPiZwB27siYFnl4QmsjqQZU5_U4vYRlonqqgmdRcg0cDm4KOOUicKmsWr5AfNP6zd90ArNfI30o1nVFqQ6WrNUbcYFh3M'];
$notificationTitle = 'Hello';
$notificationBody = 'Test api';

$arr2 = array(
    'registration_ids' => $androidTokens,
    'notification' => array('title' => $notificationTitle, 'body' => $notificationBody),
    'data' => array('title' => $notificationTitle, 'body' => $notificationBody)
);

echo sendMessageThroughFCM($arr2);

?>
