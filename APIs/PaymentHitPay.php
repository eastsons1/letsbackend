<?php

$client = new http\Client;
$request = new http\Client\Request;
$request->setRequestUrl('https://api.sandbox.hit-pay.com/v1/payment-requests');
$request->setRequestMethod('POST');
$body = new http\Message\Body;
$body->append(new http\QueryString(array(
  'email' => 'tom@test.com',
  'redirect_url' => 'https://test.com/success',
  'reference_number' => 'REF123',
  'webhook' => 'https://test.com/webhook',
  'currency' => 'SGD',
  'amount' => '599')));$request->setBody($body);
$request->setOptions(array());
$request->setHeaders(array(
  'X-BUSINESS-API-KEY' => 'meowmeowmeow',
  'Content-Type' => 'application/x-www-form-urlencoded',
  'X-Requested-With' => 'XMLHttpRequest'
));
$client->enqueue($request)->send();
$response = $client->getResponse();
echo $response->getBody();

?>