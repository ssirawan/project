<?php

require 'TypeMessage.php';

$ACCCES_TOKEN = gettokendata();
$richMenuId = 'richmenu-2e64f30b116cfd79224317814e696858';
 /// "richmenu-19344eb51574c5075621f9d4bc96afcc"



$curl = curl_init();
curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.line.me/v2/bot/user/all/richmenu/'.$richMenuId,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      //CURLOPT_POSTFIELDS => $post_body,
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
        var_dump($err);
    } else {
    	  var_dump($result);
    }	
}	

file_put_contents("php://stderr", "POST JSON ===> $result);

?>
