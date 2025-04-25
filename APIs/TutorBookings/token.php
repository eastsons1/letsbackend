<?php
//error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
	
	function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function createJWT($header, $payload, $privateKey) {
    $headerEncoded = base64UrlEncode(json_encode($header, JSON_UNESCAPED_SLASHES));
    $payloadEncoded = base64UrlEncode(json_encode($payload, JSON_UNESCAPED_SLASHES));

    $signatureInput = $headerEncoded . '.' . $payloadEncoded;

    if (!openssl_sign($signatureInput, $signature, $privateKey, OPENSSL_ALGO_SHA256)) {
        throw new Exception('Failed to sign JWT.');
    }

    $signatureEncoded = base64UrlEncode($signature);

    return $signatureInput . '.' . $signatureEncoded;
}

function getAccessToken() {
    $serviceAccountEmail = 'firebase-adminsdk-fbsvc@tutorapp-7522f.iam.gserviceaccount.com'; // Replace with your service account email
    $privateKey = "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCwZcOIvh9XPQD6\nqwqnA89sHaase9+3s18TR3C4CFwqN6cqTv1tsAWqEMEg0aYFm2i3/KMFAma6LgN1\n8hDt4ZNqeVSj/XzL60iWDIDHKAE2F65upKUNMxeLc5qaYk4i9nJP7FbL/0EEhak2\nrJcHx63LNb/974vb26zy7jfXiGEJrDgLZkOrZMpO25g+MHH5h97L1s+hYF77Eygh\nuourI/ls6rn50mWlPgDqe1YgpK3H7xDvavtilktttZalbgv1bABHwlzE9Uas1H5y\neXqfAPaJu2hN+8CxaG6KUUmLqRaWTFFf0EnB5MDI1yJnVlKE2mtSfNdKZZs0zxlu\nDFc26zc5AgMBAAECggEAK+YbeB2mk5GfO4LTCxb36SZk6yKF3cPyOoxKKUaNV0VT\n4QPY7pICit0SDx6VlGolcLpbAJ1lHtriKhlkrKq5guMwlQI5607B2PPCHa4fRQy2\nMJthZwxKxP3vYRHrc6iE8M52mFyNG/i+kJh5mqpPHlYhUmsp0XyVSTzPIWCzk5IB\nWB6Q0fFrRfuFOX3pwoFWkjbqs0nRNxNy9/oAxcZUnwQw8m6Iv48NLFajgE4tNx9+\n0Vz8hNJ5LPeAVTiBU6+XQ9dmvQQKIIAzrzR7ujLP8syBq39+1DpCTr2ZVnITmIpX\nhy1bNmK/8K/tnO5R0BdVu84wiYnDK20zFRzRFSTJzQKBgQD124cM+sioke7+Rg6n\nARWz/zzvuDcRfT8lQM+Dl9SVW/PP3DH/+KmhkbRa89r39PnfpAkJtq7uSRB0+xis\nCw4W62iDOTgZ37clamOe2kvh8iidHbG0LUSZOK34V4TV+SkttLqWeFW3Gdaa751k\nqjbIK9fZnPFbMC/cZdqooH8/bQKBgQC3rK1eGkzK03yaNFscdlDNyXtNyM+zhqGR\nLU3Dn8jzgv71mHP4aXJJ4E74lgISINi2fXnX3rxeRTEu8tso79GQu8zruinsZTuD\nSXsOccW0SmdyBdMfO/a+3pg5BOfLTpM+dBVaU2GVpaIv0JhOB5MtweNnt5DISfY0\n5ICtdEPbfQKBgQDwMlWzHKBF8K1pxtAx4SFvBYJnQbarY435u2QB0Khkc72z6hD/\nX9V6gHuQEIZxkek90WjzEIO/Uaq+X0Mvcm2FfuBQs+pXfPXVnCdP3z4btRZwyb3/\npepLN9Dfu8GPuym7+cIBl/dGN/wuysMewh1bW1o6xNYYnO9liC0kagln0QKBgBq3\nnnxKvRLf0ocnyH0KZNSaUzpMVJIbqlLQ0Tf8fSGW03lsFKp0xDAk1bfpMiHq7zsU\nY23YM3RPAkl/AAwjXkt8VeGQMdr2GsMNJD5EpGqGTCfU2xH3CfxXqrLYmNME+fwi\nrJx39oDrF/12jUEEbw8/3dFPbVsFDzBAcMtKVziNAoGAAYYoBfrGhZBoEBzXBM+V\nxaa2Aly0VvkF4AZQTMGdMzlAosh8BE9VnE+pna4I9qhyYrOjJgX285GXz8r5EXbZ\nbLWZmte9CC9ENrT3RcKZWmW3Bxv5VvpITWQcNrB3j9D2uc+cfscCvVvCBxkV/LmQ\nzI4R2gJYm7sNq5AlmKNSprA=\n-----END PRIVATE KEY-----\n";

    $now = time();
    $header = ['alg' => 'RS256', 'typ' => 'JWT'];
    $payload = [
        'iss'   => $serviceAccountEmail,
        'sub'   => $serviceAccountEmail,
        'aud'   => 'https://oauth2.googleapis.com/token',
        'iat'   => $now,
        'exp'   => $now + 3600,
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging'
    ];

    $jwt = createJWT($header, $payload, $privateKey);

    $postData = http_build_query([
        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
        'assertion'  => $jwt,
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

    $response = curl_exec($ch);
    if ($response === false) {
        throw new Exception('cURL Error: ' . curl_error($ch));
    }
    curl_close($ch);

    $responseDecoded = json_decode($response, true);
	
	
	

    if (isset($responseDecoded['access_token'])) {
        return $responseDecoded['access_token'];
    } else {
        throw new Exception('Failed to fetch access token: ' . $response);
    }
}

	
	echo getAccessToken();
	
	
	?>