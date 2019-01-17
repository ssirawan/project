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
	  $richmenu_id = create_rich_menu($RICH_URL,$ACCESS_TOKEN,$rich_obj_req); 
	  // อันนี้ลอง post กลับไปที่ LINE แต่ใช้ฟังก์ชันคล้ายกับ send_reply_msg แต่return ค่าต่างกัน
	  
	  file_put_contents("php://stderr", "POST JSON ===> ".$richmenu_id);
	  //file_put_contents("php://stderr", "POST URL ===> ".$RICH_URL);
  
	
  if( strlen($richmenu_id) > 0 ) 
  {
        $msg = [[
	'type'=>'text',
	'text'=>$richmenu_id[0]
	]];
	  
	$reply_msg = json_encode($msg);  
	$send_result = sentMessage($REPLY_URL, $POST_HEADER, $reply_msg);  

  };

	  
   


  }


echo "OK";



function create_rich_menu($post_url, $ACCESS_TOKEN , $post_body)
{
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "authorization: Bearer ".$ACCESS_TOKEN,
        "cache-control: no-cache",
        "content-type: application/json; charset=UTF-8",
      ));
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

 $result = curl_exec($ch);
 //$err = curl_error($ch);
 	
 curl_close($ch);
	
 //if (strlen($result)==0) {
    //    return $RICH_URL;
  //  } else {
    	return json_decode($result,true);
  //  }	

	
	
}




?>
