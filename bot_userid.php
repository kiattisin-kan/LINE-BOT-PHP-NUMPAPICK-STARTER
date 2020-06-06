<?php

$API_URL = 'https://api.line.me/v2/bot/message';
//###### Token Line Bot Register ######//
$accessToken = "dhreZK83Nt7uaCxqJmZkRh8aebR3Qm6hf7aNQI85YaGiFQhJYWSPy/6Mc2jS/dSFh3oMjY8wyST2ysR78fTFIQy1FxcNtEoK+5F7AXV4HSgggwE9S+sr2W7Xm1H9s7u3IhvB+GfYZkpRwVC3PZZPgAdB04t89/1O/w1cDnyilFU=";
 
$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array
 
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$accessToken}";
echo "test";
//########### Find IDUser IDGroup IDRoom From Source ###############//
if ( sizeof($request_array['events']) > 0 ) {
    foreach ($request_array['events'] as $event) {
        $reply_message = '';
        $reply_token = $event['replyToken'];
 
    if(isset($event['source']['userId'])){
        $id = $event['source']['userId'];
    } else if(isset($event['source']['groupId'])){
        $id = $event['source']['groupId'];
    } else if(isset($event['source']['room'])){
        $id = $event['source']['room'];
    }
 
    $text = $event['message']['text'];
                $arrayPostData['replyToken'] = $request_array['events'][0]['replyToken'];
                $arrayPostData['messages'][0]['type'] = "text";
                $arrayPostData['messages'][0]['text'] = $id;
                replyMsg($arrayHeader,$arrayPostData);
    }//Close For.
}//Close If.
?>
