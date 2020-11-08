<?php

// loading access token
require_once 'config.php'; // $access_token = "YourAccessTokenHere";
$url = "https://94c472479359.ngrok.io";

$data = [
    "auth_token" => $access_token,
    "url" => $url
];

// print_r($data);

$url = "https://chatapi.viber.com/pa/set_webhook";
$jsonData = json_encode($data);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$result = curl_exec($ch);
print_r($result);