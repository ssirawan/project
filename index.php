<?php
require 'sendMessage.php';



$RICH_URL = 'https://api.line.me/v2/bot/richmenu';
$REPLY_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'sOEyFKdoKFQDFMhGL5xv2pliXwALUNCvZYG0QeHWRFXXmwbdnfv1Zdj6BkCbkK8qPGomLXbzjZOWaK7MQjJsJ3c0kPBhnDo2vxEdES6a2Kk6Vs4W/8jXaNYjLZOKTf0wnCnHoAeptCHg7CTZl+Zw4gdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$CHANNEL_SECRET = 'b41da5ab3d233c34e1bffc5a75a63846';
$POST_HEADER = array('Content-Type: application/json ; charset=UTF-8', 'Authorization: Bearer ' . $ACCESS_TOKEN, 'cache-control: no-cache');

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($ACCESS_TOKEN);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $CHANNEL_SECRET]);
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

//$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

$request = file_get_contents('php://input');  
$request_array = json_decode($request, true); 

foreach ($request_array['events'] as $event)
{
  
	  $reply_token = $event[0]['replyToken'];
	  $rich_area = array(
		  array('bounds'=> array( 'x'=>'0','y'=>'0','width' => 1254,'height' => 850 ), 'action' = array('type'=> 'postback', 'text' =>'ดูสินค้า')),
		  array('bounds'=> array( 'x'=>'0','y'=>'850','width' => 1258,'height' => 831 ), 'action' = array('type'=> 'postback', 'text' =>'Promotion')),
		  array('bounds'=> array( 'x'=>'1254','y'=>'0','width' => 1246,'height' => 850 ), 'action' = array('type'=> 'postback', 'text' =>'สินค้าที่บันทึกไว้')),
		  array('bounds'=> array( 'x'=>'1258','y'=>'850','width' => 1242,'height' => 835 ), 'action' = array('type'=> 'postback', 'text' =>'เช็คสถานะ'))
		  );
	  $rich_object = array('size'=> array('width'=>2500,'height'=>1686),'selected'=>true,
			     'name'=>'menu','chatBarText'=>'menu','areas'=>$rich_area);
	  $rich_obj_req = json_encode($rich_object, JSON_UNESCAPED_UNICODE);
	  //$bot->replyMessage($event->getReplyToken(),new \LINE\LINEBot\MessageBuilder\TextMessageBuilder(createNewRichmenu(getenv($ACCESS_TOKEN))));
	  $rich_menu = create_rich_menu($RICH_URL,$POST_HEADER,$rich_obj_req); 
	  // อันนี้ลอง post กลับไปที่ LINE แต่ใช้ฟังก์ชันคล้ายกับ send_reply_msg แต่return ค่าต่างกัน
	  file_put_contents("php://stderr", "POST JSON ===> ".$rich_menu);
  
	
  if( $result ) 
  {
        $post_data = json_decode($result,true);
	$rich_id = $post_data['richmenuid'];


	);

	  
   $send_result = sentMessage($REPLY_URL, $POST_HEADER, $rich_id);


  }
}

echo "OK";



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

function create_rich_menu($post_url, $post_header, $post_body)
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
