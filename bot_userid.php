<?php 
	/*Get Data From POST Http Request*/
	$datas = file_get_contents('php://input');
	/*Decode Json From LINE Data Body*/
	$deCode = json_decode($datas,true);

	//file_put_contents('log.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);

	$replyToken = $deCode['events'][0]['replyToken'];
	$userId = $deCode['events'][0]['source']['userId'];
	$groupId = $deCode['events'][0]['source']['groupId'];
        $text = $deCode['events'][0]['message']['text'];

	$messages = [];
	$messages['replyToken'] = $replyToken;
 $temp = "User Id คือ " . $userId . " group id = " . $groupId;
	$messages['messages'][0] = getFormatTextMessage($temp);

	$encodeJson = json_encode($messages);

	$LINEDatas['url'] = "https://api.line.me/v2/bot/message/reply";
// $LINEDatas['token'] = "dhreZK83Nt7uaCxqJmZkRh8aebR3Qm6hf7aNQI85YaGiFQhJYWSPy/6Mc2jS/dSFh3oMjY8wyST2ysR78fTFIQy1FxcNtEoK+5F7AXV4HSgggwE9S+sr2W7Xm1H9s7u3IhvB+GfYZkpRwVC3PZZPgAdB04t89/1O/w1cDnyilFU=";

$LINEDatas['token'] = "byGpBm4Uynbu2BIoib18qsj/xdispkCnW1gIn6BP/pejdrPtq/lVLE0kFPpwWGZLT9O2ZNUeqdALPakWXcsPsxCZPx6BEIv3jogJRXYY+FIl0MN65WBgCV/ZblTF5Q9mZdZ2GQPl4WRHTEFskfnGPwdB04t89/1O/w1cDnyilFU=";

	
 $results = sentMessage($encodeJson,$LINEDatas);

	/*Return HTTP Request 200*/
	http_response_code(200);

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
