<?php$id = $_REQUEST['id'];if(empty($id)){	echo "invalid";	exit;}$url = "http://www.sitewarranty.com/cgi-bin/swc/mreg.cgi?useridexists=".$id;if(function_exists('curl_version') && function_exists('curl_init') && function_exists('curl_exec')){	var_dump('curl');	$handle = curl_init($url);	curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);	$response = curl_exec($handle);	var_dump($response);	if($response == 1){		echo "valid";	}	else if($response==0){		echo "invalid";	}	else if(empty($response)){		echo "Unable to verify ID with sitewarranty. Please verify curl has been enabled in your server.";	}	else{		echo "Got invalid response from sitewarranty.";		}}elseif(function_exists('file_get_contents') && file_get_contents(__FILE__)){	var_dump('file_get_contents');	$response = file_get_contents($url);	var_dump($response);	if($response == 1){		echo "valid";	}	else if($response==0){		echo "invalid";	}	else if(empty($response)){		echo "Unable to verify ID with sitewarranty. Please verify file_get_contents has been enabled in your server.";	}	else{		echo "Got invalid response from sitewarranty.";		}}else{	echo 'err01';}?>