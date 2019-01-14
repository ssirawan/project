<?php
error_reporting(E_ALL & ~E_NOTICE);
/*
$db = pg_connect("host=ec2-54-235-133-42.compute-1.amazonaws.com port=5432 dbname=dd9n7qflnjtae8 user=ynezixirsjupio password=8aa84c7e317c93709b62657ac0a26d2f8696df1eaee0f6bb108e6cd3a2ca4d22");
echo $db;
*/

$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'vEcA9SC+uVHF+zBZZQod5Yp/fS2Xn+lUkqHKi1EE1OGXZjtGJlfwrKfkLFu+wOyVPGomLXbzjZOWaK7MQjJsJ3c0kPBhnDo2vxEdES6a2Kk8PnQNwJRLHbPslhqvzC1xk8lM8HLtnERPSG8oXBLNvwdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);
$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array
if ( sizeof($request_array['events']) > 0 )
{
 foreach ($request_array['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];
  if ($event['type'] == 'message' && $event['message']['type'] == 'text') //สนใจแค่ text ที่รับมา
  {
	  $text = $event['richMenuId'];
	  $reply_message = $text;
  }

 
  if( strlen($reply_message) > 0 )
  {
   //$reply_message = iconv("tis-620","utf-8",$reply_message);
   $data = [
    'replyToken' => $reply_token,
    'messages' => [['type' => 'text', 'text' => $reply_message]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
   $send_result = send_reply_message($API_URL, $POST_HEADER, $post_body);
   echo "Result: ".$send_result."\r\n";
  }
 }
}
echo "OK";

$richmenu_post_body = {"size": {"width": 2500,"height": 1686},"selected": true,"name": "Controller","chatBarText": "index",
"areabuilders": [
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
  ]
};

$RICH_URL = 'https://api.line.me/v2/bot/richmenu';

$send_richmenu = create_richmenu($RICH_URL, $post_header,$richmenu_post_body);

function send_reply_message($url, $post_header, $post_body)
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
	
function create_richmenu($url, $post_header, $post_body)
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
}





?>
