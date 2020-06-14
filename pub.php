 <?php
 function pubMqtt($topic,$msg){
    $Topic = "$topic"; 
      put("https://api.netpie.io/v2/device/message?topic=".$Topic,$msg);
  
  //curl -X PUT "https://api.netpie.io/v2/device/message?topic=test" -H  "Authorization: Device a68289b1-4a53-4a73-8275-12de7f4353dc:a2wAzJvLRFTuoKJSss6VH1PSQi1LRr5e" -H  "Content-Type: text/plain" -d "hello"
   
  }
 function getMqttfromlineMsg($Topic,$lineMsg){
 
    $pos = strpos($lineMsg, ":");
    if($pos){
      $splitMsg = explode(":", $lineMsg);
      $topic = $splitMsg[0];
      $msg = $splitMsg[1];
      pubMqtt($topic,$msg);
    }else{
      $topic = $Topic;
      $msg = $lineMsg;
      pubMqtt($topic,$msg);
    }
  }
 
  function put($url,$tmsg)
{
      
    $ch = curl_init($url);
 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
     
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $tmsg);
 
    curl_setopt($ch, CURLOPT_USERPWD, "a68289b1-4a53-4a73-8275-12de7f4353dc:a2wAzJvLRFTuoKJSss6VH1PSQi1LRr5e");
     
    $response = curl_exec($ch);
    
      curl_close($ch);
      echo $response . "\r\n";
    return $response;
}
// $Topic = "NodeMCU1";
 //$lineMsg = "CHECK";
 //getMqttfromlineMsg($Topic,$lineMsg);
?>
