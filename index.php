<?php

require 'sendMessage.php';
require 'TypeMessage.php';
require '/RichMenu/setrichMenuDefault.php';




$RICH_URL = 'https://api.line.me/v2/bot/richmenu';
$REPLY_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = getTokenData(); 
$POST_HEADER = array('Content-Type: application/json ; charset=UTF-8', 'Authorization: Bearer ' . $ACCESS_TOKEN, 'cache-control: no-cache');



	

  
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
	       "Content-Type: image/png",
	 	
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
      CURLOPT_POSTFIELDS => $post_data,
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

