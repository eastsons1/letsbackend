 <?php 
 
 function sendPushNotification($to = '', $data = array()){
    
        $api_key = 'AAAAf0sjSUk:APA91bEZkNVyHVbEVqpwegNX0QnJnh-ncfn3Lhq21NZVXyQmFcD3eApAnOoaVAlfxFJnUX2p1co4d5kTgLh_rVVmTnGIx8XG2cNXEzBtQDcfOGhNpkG3FoQhaLEm5XZNLIVWDPsnH249';
        $fields = array('to' => $to, 'notification' => $data);
    
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
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
    
    
    
    
    $to = 'dhHesK0UTRWlVqJgAGCOhB:APA91bELtdRxkGnow5hkde8iWQnQO0eUsKij_hq5f0Nb5DcdmCiH213NINJ5cwct2LuqIq4OSE8SpAjxH2dCzrOlHVKEOBvKqeO2OX9dliXUM5iAXQKG4v-EW1x-ch08O4o5p6UYzn7t'; //Device token 
    // You can get it from FirebaseInstanceId.getInstance().getToken();
    $message = array(
    'title' => 'Hi',
    'body' => 'I am pushpendra');
    
    echo sendPushNotification($to, $message);
	
	?>