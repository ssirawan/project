<?php
require 'sendMessage.php';
require 'TypeMessage.php';
require 'richmenu.jpg';



$RICH_URL = 'https://api.line.me/v2/bot/richmenu';
$REPLY_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = getTokenData(); 
$POST_HEADER = array('Content-Type: application/json ; charset=UTF-8', 'Authorization: Bearer ' . $ACCESS_TOKEN, 'cache-control: no-cache');


$request = file_get_contents('php://input');  
$request_array = json_decode($request, true); 

//foreach ($request_array['events'] as $event)
//{
  
	  $rich_object = []; 
	 // $reply_token = $event[0]['replyToken'];
	  $rich_area = array(
		  array('bounds'=> array( 'x'=>'0','y'=>'0','width' => 1254,'height' => 850 ), 'action' => array('type'=> 'postback', 'text' =>'ดูสินค้า','data' => 'action=buy&itemid=123')),
		  array('bounds'=> array( 'x'=>'0','y'=>'850','width' => 1258,'height' => 831 ), 'action' => array('type'=> 'postback', 'text' =>'Promotion','data' => 'action=buy&itemid=123')),
		  array('bounds'=> array( 'x'=>'1254','y'=>'0','width' => 1246,'height' => 850 ), 'action' => array('type'=> 'postback', 'text' =>'สินค้าที่บันทึกไว้','data' => 'action=buy&itemid=123')),
		  array('bounds'=> array( 'x'=>'1258','y'=>'850','width' => 1242,'height' => 835 ), 'action' => array('type'=> 'postback', 'text' =>'เช็คสถานะ','data' => 'action=buy&itemid=123'))
		  );
	  $rich_object = array('size'=> array('width'=>2500,'height'=>1686),'selected'=> false ,
			     'name'=>'rich_menu','chatBarText'=>'menu','areas'=>  $rich_area );
	  $rich_obj_req = json_encode($rich_object, JSON_UNESCAPED_UNICODE);
	  //$richmenu_id = create_rich_menu($RICH_URL,$ACCESS_TOKEN,$rich_obj_req); 
	  // เหมือนว่าทุกครั้งที่ deploy จะได้ richmenuid ใหม่กลับมา
	  //file_put_contents("php://stderr", "POST JSON ===> ".$richmenu_id);
  
	$richMenuId = 'richmenu-19344eb51574c5075621f9d4bc96afcc';
	
		
	$file = fopen("richmenu.jpg","r");
	$size = filesize("richmenu.jpg");
	$fildata = fread($file,$size);
	file_put_contents("php://stderr", "POST JSON ===> ".$size);

	//$upload_pic = upload_richmenu($richMenuId,$ACCESS_TOKEN,$fildata,$file);
	//file_put_contents("php://stderr", "POST JSON ===> ".$upload_pic);
	
	
	
	
	/*set rich menu default after upload img 
	$response = set_richmenu_default($richMenuId,$ACCESS_TOKEN);
	file_put_contents("php://stderr", "POST JSON ===> ".$response);
	*/
	
	
	
   
//}  
  
echo "OK";
//file_put_contents("php://stderr", "POST JSON ===> ".$richmenu_id);

			  
			
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

function upload_richmenu($richMenuId,$ACCESS_TOKEN,$fildata,$file)
{

$curl = curl_init();
	curl_setopt_array($curl, array(
	    CURLOPT_URL => "https://api.line.me/v2/bot/richmenu/".$richMenuId."/content",
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_BINARYTRANSFER => true,
	    CURLOPT_ENCODING => "",
	    CURLOPT_MAXREDIRS => 10,
	    CURLOPT_TIMEOUT => 30,
	    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	    CURLOPT_CUSTOMREQUEST => "POST",
	    CURLOPT_POSTFIELDS => $fildata,
	    CURLOPT_INFILE => $file,
	    CURLOPT_HTTPHEADER => array(
	       "authorization: Bearer ".$ACCESS_TOKEN,
               "cache-control: no-cache",
	       "Content-Type: image/jpg",
	 	"Content-Length: 0"
	    ),
	));
  
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
  
  
	if ($err) {
         return $err;
    } else {
    	return $response;
    }


}



function set_richmenu_default($richMenuId,$ACCESS_TOKEN)
{
$curl = curl_init();
	curl_setopt_array($curl, array(
	      CURLOPT_URL => "https://api.line.me/v2/bot/user/all/richmenu/".$richMenuId,
	      CURLOPT_RETURNTRANSFER => true,
	      CURLOPT_ENCODING => "",
	      CURLOPT_MAXREDIRS => 10,
	      CURLOPT_TIMEOUT => 30,
	      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	      CURLOPT_CUSTOMREQUEST => "POST",
	      CURLOPT_POSTFIELDS => $post_body,
	      CURLOPT_HTTPHEADER => "authorization: Bearer ".$ACCESS_TOKEN,
		
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

