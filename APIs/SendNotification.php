<?php
function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function createJWT($header, $payload, $privateKey) {
    $headerEncoded = base64UrlEncode(json_encode($header));
    $payloadEncoded = base64UrlEncode(json_encode($payload));

    // Combine header and payload to form the data to sign
    $signatureInput = $headerEncoded . '.' . $payloadEncoded;

    // Create the signature using the private key
    openssl_sign($signatureInput, $signature, $privateKey, 'sha256');

    // Encode signature to base64 URL-safe format
    $signatureEncoded = base64UrlEncode($signature);

    // Combine everything to form the JWT
    return $signatureInput . '.' . $signatureEncoded;
}

// Function to get the access token from Google OAuth 2.0 server
function getAccessToken() {
    // Service account details
    $serviceAccountEmail = 'mytutormoe@tutorapp-7522f.iam.gserviceaccount.com'; // Replace with your service account email
    $privateKey = "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCOLnTjBnN0eIb2\nChXt2ShpBqBElTYu8I1moWub3uRKX75e00gOMjFABJh+l1tVHDNDd7k9qVPxPPrb\nljV4pNzEcyafx85wzFF/Qh/L+eDAFoDlCfZmopNlYE1h9qGzzTWt2CVoPlJSFUVZ\nmPqVdBmOZqdLzZdCSQtHfyvbNJrFN4cnsEaylAaHEuYgyFiU4sHjsVBbwPTfvzgN\nH3gcRZMoYowxcGNhIs2bR9F6q9ySuidZf9VaXbqBzvD+6NoEq6DQUKNfL11H8yMA\n5fflFHctURrAN8+HoqseO9NrXE6oUWfwHlgqWQpJ7QSR4dm4ZPpVkQ0MaAA3V62I\n9PHyd+QZAgMBAAECggEAAQ/tLGVVZ1O9CNglXkGbnBBV6qXeHOpHAHfS35mfijoW\n43eMKPSHgJZlvZCuOLDJoPMFzGpdDLhBhfxzEQxdVntOrKP+CiU7ZRj+hdGrs/Jy\nK026SenaaDRTv6v/Lgmzl4BbgaXJ2pPnfR3LirE4WwrXSeRhsoaJ8eEufzwN6cym\nPX1EPuxuhklnj59jeWTxxV9pMVNZSypNKAAFEEWFbAViMyzfsjlrZ0o8UJD14wC9\nJI3Q5nv6WpozherdO8P7XAhbrSsqW0WEX+KgCpLS4QWVCGzAPxk3KEIuNjfz2Chk\nMdCBolzRz+6hvvCJl6QZzbfP4lvGQnfGQSQMxC9sEQKBgQDHEX4hVGp5rYswtpfv\n7v7qxtZ5nkPrneh84YnLHhvU0ZE3Yuei/srqfmr3/TmmuI05f4I3LnpTcRd0/7gh\nqnTBAN81XPhV1Ju8U4nY0HwWxCoW+FZXVhyb6LRU3xGhMVv+mPa0uit4rebYaup8\nd/bUWjmAwi3/NSRPirQGOY2rtQKBgQC22BKXVQpEHk2XCNfLOFAliWTRxSDuM7Eo\nkmARyuYNfXM4w0Y25rojVcL0GTwownsKYBC54wh9U0Wi8riBFSouB9F3WId52VMp\ndAGf6/aTkiMBH2RGmbu9b3hyjg5QlFEMpX+vxheEbS1QX4c8BGGmGL4dotlGBR5v\n5Sh5skz9VQKBgBmoYIhtN/gM7TbPIhAzzrl1/WjZhEmXJcMK0tbSP6YTiNMJtW9l\nxcOpnaHvCoI5oUI69A6mt++PUQWsfBAixz+lHB/lpsBxUc1ZOxgt7wCEMiSZx48k\nMzXJLY0O31fWY9QR5SJwKHA6gdl9FlIKqE7Afk7hOEp/j/mMmB2BR4hNAoGBALDZ\n65l+QpDCcq/ceMTyMessqlyPfBuJ2hfxBIURKFTx+ylzDw35Ox8ES63IXrzZ5yKQ\n6nyxkLuPeLJ0bGtGKmcdXsg908PSpbJZp1ykYfo4hi0GzPnQpptDH1BGAKiF3KML\nzKYaRxLqesLbszUk08JQ+ko2AkvMlbULBIw5HmiFAoGBAL8wvvc7MGBrUxjBDGUQ\ndZ59aabAsmwqVJlRxtT9x1c0vflX3pMlyK8A1TtyB+3pP0n6wU5bnetFEe30/pGm\npYsUGLTNDTilcrxi6rOySq01YEAyPmoRUpeLg6Cc3LmR6TXrwM9E3b0057ZuTrua\nQ4oYc+53V70eZ8djsT1KEXm8\n-----END PRIVATE KEY-----\n";

    // JWT Header
    $header = array(
        'alg' => 'RS256',
        'typ' => 'JWT'
    );

    // JWT Payload
    $now = time();
    $payload = array(
        'iss' => $serviceAccountEmail, // Issuer
        'sub' => $serviceAccountEmail, // Subject
        'aud' => 'https://oauth2.googleapis.com/token', // Audience
        'iat' => $now, // Issued at
        'exp' => $now + 3600, // Expires in 1 hour
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging' // Scope for Firebase Cloud Messaging
    );

    // Create JWT token
    $jwt = createJWT($header, $payload, $privateKey);
	
	//print_r($jwt);

    // Prepare the token request payload
    $postData = http_build_query(array(
        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
        'assertion' => $jwt,
    ));

    // Send the request to Google's OAuth 2.0 token endpoint
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

    // Get the response and close the connection
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode the response (JSON) to get the access token
    $responseDecoded = json_decode($response, true);

    if (isset($responseDecoded['access_token'])) {
        return $responseDecoded['access_token'];
		
    } else {
        throw new Exception('Failed to fetch access token: ' . $response);
    }
}



function sendPushNotification($accessToken, $deviceToken, $title, $body, $imageUrl) {
    $url = 'https://fcm.googleapis.com/v1/projects/tutorapp-7522f/messages:send';
    
    // Payload for the notification
    $notificationPayload = array(
        'message' => array(
            'token' => $deviceToken, // Device token where notification will be sent
            'notification' => array(
                'title' => $title, // Title of the notification
                'body' => $body,   // Body of the notification
				'image' => $imageUrl, // Image URL to include in the notification
            )
        )
    );

    // Convert payload to JSON
    $payloadJson = json_encode($notificationPayload);

    // Set up curl to send the request to Firebase FCM
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadJson);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Add the Authorization header with the access token and content type as JSON
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken
    ));

    // Execute the request and get the response
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }

    // Close the connection
    curl_close($ch);

    // Return the response
    return $response;
}


try {
    // Get the access token
    $accessToken = getAccessToken();

    // Device token for the user (This token is obtained from the client side - typically the user's mobile device)
    $deviceToken = 'eG4RO6SMToKjVS1bwEi_US:APA91bENx6XmQ4foPdxXYW7_7WIxpjpnzRyJK3CC3XfJ-KDmELhdkTeZG8WyYKjtQ-RaCS9s66h93Vy5M-M9Uyv5rJkCl-mh_nlWJZsl3E4HiClcYj3CAPY';  // Replace with actual device token

    // Notification details
    $title = 'Hello!';
    $body = 'This is Great Fastival.';
	$imageUrl = 'https://mytutors.moe/version3/APIs/T.png'; // Replace with your image URL

    // Send push notification
    $response = sendPushNotification($accessToken, $deviceToken, $title, $body, $imageUrl);
    
    echo "Notification sent successfully: " . $response;

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}


?>