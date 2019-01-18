<?php

	/*Function GET Token*/
	function getTokenData()
	{
		$token = 'sOEyFKdoKFQDFMhGL5xv2pliXwALUNCvZYG0QeHWRFXXmwbdnfv1Zdj6BkCbkK8qPGomLXbzjZOWaK7MQjJsJ3c0kPBhnDo2vxEdES6a2Kk6Vs4W/8jXaNYjLZOKTf0wnCnHoAeptCHg7CTZl+Zw4gdB04t89/1O/w1cDnyilFU=';
		return $token;
	}

	
	/*Function SET Message Format*/
	function getFormatTextMessage($text)
	{
		$datas = [];
		$datas['type'] = 'text';
		$datas['text'] = $text;
		return $datas;
	}


	/*Function SET Sticker Format*/
	function getFormatStickerMessage($packageId,$stickerId)
	{
		$datas = [];
		$datas['type'] = 'sticker';
		$datas['packageId'] = $packageId;
		$datas['stickerId'] = $stickerId;
		return $datas;
	}


	/*Function SET Image Format*/
	function getFormatImageMessage($originalUrl,$previewImageUrl)
	{
		$datas = [];
		$datas['type'] = 'image';
		$datas['originalContentUrl'] = $originalUrl;
		$datas['previewImageUrl'] = $previewImageUrl;
		return $datas;
	}


	/*Function SET Video Format*/
	function getFormatVideoMessage($originalUrl,$previewImageUrl)
	{
		$datas = [];
		$datas['type'] = 'video';
		$datas['originalContentUrl'] = $originalUrl;
		$datas['previewImageUrl'] = $previewImageUrl;
		return $datas;
	}
	

?>
