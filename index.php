<?php
require 'sendMessage.php';
require 'TypeMessage.php';
$RICH_URL = 'https://api.line.me/v2/bot/richmenu';
$REPLY_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = getTokenData(); 
$CHANNEL_SECRET = 'b41da5ab3d233c34e1bffc5a75a63846';
$POST_HEADER = array('Content-Type: application/json ; charset=UTF-8', 'Authorization: Bearer ' . $ACCESS_TOKEN, 'cache-control: no-cache');
/*
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($ACCESS_TOKEN);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $CHANNEL_SECRET]);
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
*/
$request = file_get_contents('php://input');  
$request_array = json_decode($request, true); 
foreach ($request_array['events'] as $event)
{
  
	  $rich_object = []; 
	  $reply_token = $event[0]['replyToken'];
	  $rich_area = array(
		  array('bounds'=> array( 'x'=>'0','y'=>'0','width' => 1254,'height' => 850 ), 'action' => array('type'=> 'postback', 'text' =>'ดูสินค้า')),
		  array('bounds'=> array( 'x'=>'0','y'=>'850','width' => 1258,'height' => 831 ), 'action' => array('type'=> 'postback', 'text' =>'Promotion')),
		  array('bounds'=> array( 'x'=>'1254','y'=>'0','width' => 1246,'height' => 850 ), 'action' => array('type'=> 'postback', 'text' =>'สินค้าที่บันทึกไว้')),
		  array('bounds'=> array( 'x'=>'1258','y'=>'850','width' => 1242,'height' => 835 ), 'action' => array('type'=> 'postback', 'text' =>'เช็คสถานะ'))
		  );
	  $rich_object = array('size'=> array('width'=>2500,'height'=>1686),'selected'=>true,
			     'name'=>'menu','chatBarText'=>'menu','areas'=>  $rich_area );
	  $rich_obj_req = json_encode($rich_object, JSON_UNESCAPED_UNICODE);
	  //$bot->replyMessage($event->getReplyToken(),new \LINE\LINEBot\MessageBuilder\TextMessageBuilder(createNewRichmenu(getenv($ACCESS_TOKEN))));
	  $richmenu_id = create_rich_menu($RICH_URL,$ACCESS_TOKEN,$rich_obj_req); 
	  // อันนี้ลอง post กลับไปที่ LINE แต่ใช้ฟังก์ชันคล้ายกับ send_reply_msg แต่return ค่าต่างกัน
	  file_put_contents("php://stderr", "POST JSON ===> ".$richmenu_id['replyToken']);
  
	
  if( strlen($richmenu_id) > 0 ) 
  {
        $msg = [[
	'type'=>'text',
	'text'=>$richmenu_id
	]];
	  
	$reply_msg = json_encode($msg);  
	$send_result = sentMessage($REPLY_URL, $POST_HEADER, $reply_msg);  
  };
	  
   
  }
echo "OK";
function create_rich_menu($post_url, $ACCESS_TOKEN , $post_body)
{

	$curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $post_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $post_body,
      CURLOPT_HTTPHEADER => array(
        "authorization: Bearer ".$ACCESS_TOKEN,
        "cache-control: no-cache",
        "content-type: application/json; charset=UTF-8",
      ),
    ));

 
 $result = curl_exec($curl);
 $err = curl_error($curl);
 	
 curl_close($curl);
	
 if ($err) {
        return $err;
    } else {
    	return $result;
    }	
	
	
}
?>
