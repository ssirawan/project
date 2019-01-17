<?php
function sentMessage($post_url,$post_header,$jsonbody)
{
  $datareturned =[];
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $post_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => $post_header,
    CURLOPT_POSTFIELDS => $post_body,
    CURLOPT_FOLLOWLOCATION => 1));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  
  curl_close($curl);
  
  if($err)
  {
     $datareturned['result'] = 'E';
     $datareturned['message'] = $err;
  }
  else
  {
    if($response== "{}")
    {
      $datareturned['result'] = 'S';
      $datareturned['message'] = 'Success';
    }
    else
    {
      $datareturned['result'] = 'E';
      $datareturned['message'] = $response;
    }
  }
  
  
  return $datareturned;
  
}
?>
