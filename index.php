<?php
error_reporting(E_ALL & ~E_NOTICE);

$REPLY_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'vEcA9SC+uVHF+zBZZQod5Yp/fS2Xn+lUkqHKi1EE1OGXZjtGJlfwrKfkLFu+wOyVPGomLXbzjZOWaK7MQjJsJ3c0kPBhnDo2vxEdES6a2Kk8PnQNwJRLHbPslhqvzC1xk8lM8HLtnERPSG8oXBLNvwdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$CHANNEL_SECRET = 'e33ac5e982da548d1c1984ac6a97a69e';
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($ACCESS_TOKEN);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $CHANNEL_SECRET]);
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

// $request = file_get_contents('php://input');   // Get request content
// $request_array = json_decode($request, true);   // Decode JSON to Array

foreach ($events as $event)
{
  if($event->strlen(getText()) > 0)
  {
	  $reply_token = $event->getReplyToken();
	  $rich_menu = createNewRichmenu(getenv($ACCESS_TOKEN));
	  //$bot->replyMessage($event->getReplyToken(),$data);
  }
  if( strlen($rich_menu) > 0 )  // ตั้งแต่ตรงนี้คือส่วนใหม่
  {

   $data = [
    'replyToken' => $reply_token,
    'messages' => [['type' => 'text', 'text' => $rich_menu]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
	  
   $send_result = send_reply_msg($REPLY_URL, $POST_HEADER, $post_body);


}


echo "OK";
	

function createNewRichmenu($channelAccessToken) {
  $sh = <<< EOF
  curl -X POST \
  -H 'Authorization: Bearer $channelAccessToken' \
  -H 'Content-Type:application/json' \
  -d '{"size": {"width": 2500,"height": 1686},"selected": true, "name": "Controller","chatBarText": "index","areas": [
    {
      "bounds" : {
        "x": 0,
        "y": 0,
        "width": 1254,
        "height": 850
      },
      "action": {
        "type": "postback",
        "text": "ดูสินค้า",
        "data": "Data 1"
      }
    },
    {
      "bounds": {
        "x": 0,
        "y": 850,
        "width": 1258,
        "height": 831
      },
      "action": {
        "type": "postback",
        "text": "Promotion",
        "data": "Data 3"
      }
    },
    {
      "bounds": {
        "x": 1254,
        "y": 0,
        "width": 1246,
        "height": 850
      },
      "action": {
        "type": "postback",
        "text": "สินค้าที่บันทึกไว้",
        "data": "Data 3"
      }
    },
    {
      "bounds": {
        "x": 1258,
        "y": 850,
        "width": 1242,
        "height": 835
      },
      "action": {
        "type": "postback",
        "text": "เช็คสถานะ",
        "data": "Data 4"
      }
    }
  ]}' https://api.line.me/v2/bot/richmenu;
EOF;
  $result = json_decode(shell_exec(str_replace('\\', '', str_replace(PHP_EOL, '', $sh))), true);
  return $result['richMenuId'];	
  /*
	if(isset($result['richMenuId'])) {
    return $result['richMenuId'];
  }
  else {
    return $result['message'];
  }
  */
}



function send_reply_msg($url, $post_header, $post_body)
{
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 $result = curl_exec($ch);
 curl_close($ch);
 return $result;	
}





?>
