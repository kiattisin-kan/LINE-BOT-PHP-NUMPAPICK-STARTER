 <?php
  

function send_LINE($msg,$userID){
 $access_token = 'dhreZK83Nt7uaCxqJmZkRh8aebR3Qm6hf7aNQI85YaGiFQhJYWSPy/6Mc2jS/dSFh3oMjY8wyST2ysR78fTFIQy1FxcNtEoK+5F7AXV4HSgggwE9S+sr2W7Xm1H9s7u3IhvB+GfYZkpRwVC3PZZPgAdB04t89/1O/w1cDnyilFU='; 

  $messages = [
        'type' => 'text',
        'text' => $msg
        //'text' => $text
      ];

      // Make a POST Request to Messaging API to reply to sender
      $url = 'https://api.line.me/v2/bot/message/push';
      $data = [

        'to' => 'C9f60a96bc286dfa8855c4ae7979313fc',
        'messages' => [$messages],
      ];
      $post = json_encode($data);
      $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $result = curl_exec($ch);
      curl_close($ch);

      echo $result . "\r\n"; 
}

?>
