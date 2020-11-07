<?php

$access_token = "YourAccessTokenHere";
$url = "https://e64749feaa38.ngrok.io";

$data = [
    "auth_token" => $access_token,
    "url" => $url
];

$url = "https://chatapi.viber.com/pa/set_webhook";
$jsonData = json_encode($data);
print_r($jsonData);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$result = curl_exec($ch);
return $result;