<?php
 require("line.php");
 require("pub.php");


// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON

$events = json_decode($content, true);
// Validate parsed JSON data
if(isset($events['events'][0]['source']['userId'])){
          $userId = $events['events'][0]['source']['userId'];
 	  $temp = "User Id คือ " . $userId;

}
else if(isset($events['events'][0]['source']['groupId'])){
          $userId = $events['events'][0]['source']['groupId'];
	  $temp = "Group Id คือ " . $userId;
}
else if(isset($events['events'][0]['source']['room'])){
          $userId = $events['events'][0]['source']['room'];
          $temp = "Room Id คือ " . $userId;
}

if (!is_null($events['ALARM'])) {
	
	send_LINE($events['ALARM'],$userID);
	echo "OK";
	}
if (!is_null($events['events'])) {
	echo "line bot";

	$replyToken = $events['events'][0]['replyToken'];
	//if(isset($events['events'][0]['source']['userId'])){
        //  $userId = $events['events'][0]['source']['userId'];
        //  $temp = "User Id คือ " . $userId;
        //}
        //else if(isset($events['events'][0]['source']['groupId'])){
        //  $userId = $events['events'][0]['source']['groupId'];
        //  $temp = "Group Id คือ " . $userId;
	//}
        //else if(isset($events['events'][0]['source']['room'])){
        //  $userId = $events['events'][0]['source']['room'];
	//  $temp = "Room Id คือ " . $userId;
	//}
       
	$text = $events['events][0]['message']['text'];
	$temp = $temp." ".$text;

	$messages = [];
	$messages['replyToken'] = $replyToken;
        $messages['messages'][0] = getFormatTextMessage($temp);

	$encodeJson = json_encode($messages);

	$LINEDatas['url'] = "https://api.line.me/v2/bot/message/reply";
 $LINEDatas['token'] = "dhreZK83Nt7uaCxqJmZkRh8aebR3Qm6hf7aNQI85YaGiFQhJYWSPy/6Mc2jS/dSFh3oMjY8wyST2ysR78fTFIQy1FxcNtEoK+5F7AXV4HSgggwE9S+sr2W7Xm1H9s7u3IhvB+GfYZkpRwVC3PZZPgAdB04t89/1O/w1cDnyilFU=";

 
	$results = sentMessage($encodeJson,$LINEDatas);
			
	foreach ($events['events'] as $event) 
	{
		
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') 
		{
			$text = $event['message']['text'];
			$Topic = "NamphongPP" ;
			getMqttfromlineMsg($Topic,$text);
			$results = sentMessage($encodeJson,$LINEDatas);
		}
	}

	/*Return HTTP Request 200*/
	http_response_code(200);
}

	function getFormatTextMessage($text)
	{
		$datas = [];
		$datas['type'] = 'text';
		$datas['text'] = $text;

		return $datas;
	}

	function sentMessage($encodeJson,$datas)
	{
		$datasReturn = [];
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $datas['url'],
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $encodeJson,
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Bearer ".$datas['token'],
		    "cache-control: no-cache",
		    "content-type: application/json; charset=UTF-8",
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		    $datasReturn['result'] = 'E';
		    $datasReturn['message'] = $err;
		} else {
		    if($response == "{}"){
			$datasReturn['result'] = 'S';
			$datasReturn['message'] = 'Success';
		    }else{
			$datasReturn['result'] = 'E';
			$datasReturn['message'] = $response;
		    }
		}

		return $datasReturn;
	}

?>
