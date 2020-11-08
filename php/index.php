<?php

// loading access token
require_once 'config.php'; // $access_token = "YourAccessTokenHere";

$request = file_get_contents("php://input");
$input = json_decode($request, true);

if($input['event'] == 'webhook') {
    $webhook_response['status'] = 0;
    $webhook_response['status_message'] = "ok";
    $webhook_response['event_types'] = "delivered";
    echo json_encode($webhook_response);
    die;
}

elseif($input['event'] == 'message') {
    $text_received = $input['message']['text'];
    $sender_id = $input['sender']['id'];
    $sender_name = $input['sender']['name'];

    // $log_msg = "\n";
    // $log_msg .= "SenderName => ".$sender_name;
    // $log_msg .= "SenderID => ".$sender_id;
    // error_log($log_msg, 3, "log.log");

    $data['auth_token'] = $access_token;
    $data['receiver'] = $sender_id;

    if($text_received == 'text') {
        // =================================
        // Text message
        // =================================
        $data['type'] = "text";
        $data['text'] = "Hello world!";
    }
    else if($text_received == 'picture') {
        // =================================
        // Picture message
        // =================================
        $data['type'] = "picture";
        $data['text'] = "Google Logo"; // Photo Description
        $data['media'] = "https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png";
    }
    else if($text_received == 'video') {
        // =================================
        // Video message
        // =================================
        $data['type'] = "video";
        $data['media'] = "https://file-examples-com.github.io/uploads/2017/04/file_example_MP4_480_1_5MG.mp4";
        $data['size'] = 1024000; // size of video in bytes
    }
    else if($text_received == 'file') {
        // =================================
        // File message
        // =================================
        $data['type'] = "file";
        $data['media'] = "https://file-examples-com.github.io/uploads/2017/10/file-sample_150kB.pdf";
        $data['size'] = 102400; // size of video in bytes
        $data['file_name'] = 'FileNameHere.pdf'; // file name + extension
    }
    else if($text_received == 'contact') {
        // =================================
        // Contact message
        // =================================
        $data['type'] = "contact";
        $data['contact'] = [
            'name' => 'Ko Ko',
            'phone_number' => '+972511123123'
        ];
    }
    else if($text_received == 'location') {
        // =================================
        // Location message
        // =================================
        $data['type'] = "location";
        $data['location'] = [
            'lat' => '16.812775',
            'lon' => '96.129981'
        ];
    }
    else if($text_received == 'url') {
        // =================================
        // URL message
        // =================================
        $data['type'] = "url";
        $data['media'] = 'https://www.google.com';
    }
    else if($text_received == 'sticker') {
        // =================================
        // Sticker message
        // =================================
        $data['type'] = "sticker";
        $data['sticker_id'] = 40133;
    }
    else if($text_received == 'rich_media') {
        // =================================
        // Rich Media message / Carousel content message
        // =================================
        $data['type'] = "rich_media";
        $data['min_api_version'] = 7;
        $data['rich_media'] = 
        [
            "Type" => "rich_media",
            "ButtonsGroupColumns" => 6,
            "ButtonsGroupRows" => 7,
            "BgColor" => "#FFFFFF",
            "Buttons" => [
                [
                    "Columns" => 3,
                    "Rows" => 3,
                    "ActionType" => "open-url",
                    "ActionBody" => "https://www.google.com",
                    "Image" => "https://png.pngtree.com/png-clipart/20190612/original/pngtree-green-url-png-image_3478473.jpg"
                ],
                [
                    "Columns" => 3,
                    "Rows" => 3,
                    "ActionType" => "open-url",
                    "ActionBody" => "https://www.google.com",
                    "Image" => "https://png.pngtree.com/png-clipart/20190612/original/pngtree-green-url-png-image_3478473.jpg"
                ],
                [
                    "Columns" => 6,
                    "Rows" => 2,
                    "Text" => "<font color=#323232><b>Headphones with Microphone, On-ear Wired [earphones</b></font><font color=#777777><br>Sound Intone </font><font [color=#6fc133>$17.99</font>",
                    "ActionType" => "open-url",
                    "ActionBody" => "https://www.google.com",
                    "TextSize" => "medium",
                    "TextVAlign" => "middle",
                    "TextHAlign" => "left"
                ],
                [
                    "Columns" => 6,
                    "Rows" => 1,
                    "ActionType" => "reply",
                    "ActionBody" => "https://www.google.com",
                    "Text" => "<font color=#ffffff>Buy</font>",
                    "TextSize" => "large",
                    "TextVAlign" => "middle",
                    "TextHAlign" => "middle",
                    "Image" => "https://png.pngtree.com/png-clipart/20190612/original/pngtree-green-url-png-image_3478473.jpg"
                ],
                [
                    "Columns" => 6,
                    "Rows" => 1,
                    "ActionType" => "reply",
                    "ActionBody" => "https://www.google.com",
                    "Text" => "<font color=#8367db>MORE DETAILS</font>",
                    "TextSize" => "small",
                    "TextVAlign" => "middle",
                    "TextHAlign" => "middle"
                ],
                [
                    "Columns" => 6,
                    "Rows" => 3,
                    "ActionType" => "open-url",
                    "ActionBody" => "https://www.google.com",
                    "Image" => "https://png.pngtree.com/png-clipart/20190612/original/pngtree-green-url-png-image_3478473.jpg"
                ],
                [
                    "Columns" => 6,
                    "Rows" => 2,
                    "Text" => "<font color=#323232><b>Hanes Men's Humor Graphic T-Shirt</b></font><font color=#777777><br>Hanes</font><font color=#6fc133>$10.99</font>",
                    "ActionType" => "open-url",
                    "ActionBody" => "https://www.google.com",
                    "TextSize" => "medium",
                    "TextVAlign" => "middle",
                    "TextHAlign" => "left"
                ],
                [
                    "Columns" => 6,
                    "Rows" => 1,
                    "ActionType" => "reply",
                    "ActionBody" => "https://www.google.com",
                    "Text" => "<font color=#ffffff>Buy</font>",
                    "TextSize" => "large",
                    "TextVAlign" => "middle",
                    "TextHAlign" => "middle",
                    "Image" => "https://png.pngtree.com/png-clipart/20190612/original/pngtree-green-url-png-image_3478473.jpg"
                ],
                [
                    "Columns" => 6,
                    "Rows" => 1,
                    "ActionType" => "reply",
                    "ActionBody" => "https://www.google.com",
                    "Text" => "<font color=#8367db>MORE DETAILS</font>",
                    "TextSize" => "small",
                    "TextVAlign" => "middle",
                    "TextHAlign" => "middle"
                ]
            ]
        ];
    }
    else if($text_received == 'keyboard') {
        // =================================
        // Keyboard
        // =================================
        $data['min_api_version'] = 7;
        $data['type'] = "text";
        $data['text'] = "Hello world to Keyboard";
        $data['keyboard'] = [
            'Type' => "keyboard",
            'DefaultHeight' => true,
            'Buttons' => [
                [
                    'ActionType' => 'reply',
                    'ActionBody' => 'reply to me',
                    'Text' => 'Key text',
                    'TextSize' => "regular"
                ]
            ]
        ];
    }
    else {
        $data['type'] = "text";
        $data['text'] = "Hi!".$sender_name." ($sender_id)";
    }

    if($text_received != 'broadcast') {
        sendMessage($data);
    } else {
        $data['min_api_version'] = 2;
        $data['type'] = 'text';
        $data['broadcast_list'] = [
            'QfzEzLbtpNeRjjFEe55VKw=='
        ];
        $data['text'] = 'broadcasting message to all subscribers';
        broadcastMessage($data);
    }
}

function sendMessage($data) {
    try {
        $url = "https://chatapi.viber.com/pa/send_message";
        $jsonData = json_encode($data);
        // print_r($jsonData);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        return $result;
    } catch(\Exception $ex) {
        error_log("\nYou messed up!", 3, "log.log");
    }
}

function broadcastMessage($data) {
    try {
        $url = "https://chatapi.viber.com/pa/broadcast_message";
        $jsonData = json_encode($data);
        // print_r($jsonData);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        return $result;
    } catch(\Exception $ex) {
        error_log("\nYou messed up!", 3, "log.log");
    }
}