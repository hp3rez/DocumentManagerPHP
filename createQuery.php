<?php

//login to the server 
include('functions.php');
$sid = create_SID();
$un="ygb374";

if($sid == null) {
	clear_sid();
	$sid = create_SID();
}

//ensure variables can be sent to post in the url
$data="uid=$un&sid=$sid";
$ch=curl_init('https://cs4743.professorvaladez.com/api/query_files');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	//sends out the data
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(		//sets the format for the returned data
	'content-type: application/x-www-form-urlencoded',
	'content-length: '.strlen($data)));

$time_start=microtime(true);
$result=curl_exec($ch);
$time_end=microtime(true);
$exec_time=($time_end-$time_start)/60;
curl_close($ch);

$cinfo=json_decode($result, true);
echo "<pre>";
print_r($cinfo);
echo "</pre>";

$tmp=explode(":", $cinfo[1]);
$payload=json_decode($tmp[1]);
echo "<pre>";
print_r($payload);
echo "</pre>";

foreach($payload as $key=>$value) {
	$data="uid=$un&sid=$sid&id=$value";
	$ch=curl_init('https://cs4743.professorvaladez.com/api/request_files');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	//sends out the data
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(		//sets the format for the returned data
		'content-type: application/x-www-form-urlencoded',
		'content-length: '.strlen($data)));

	$time_start=microtime(true);
	$result=curl_exec($ch);
	$time_end=microtime(true);
	$exec_time=($time_end-$time_start)/60;
	curl_close($ch);

	if(strstr($result, "Status")=="Status") {
		echo "<h3>There was an error with file $value.</h3>";
		echo "<pre> $result </pre>";
		continue;
	} else { 
		$content=$result;
		if(strlen($content) == 0) {
			echo "<h2>File $value has a length of zero.</h2>";
			continue;
		} else {
			$fp=fopen("/var/www/files/$value", "wb");
			fwrite($fp, $content);
			fclose($fp);
			echo "<h3>File $value written to the filesystem.</h3>";
		}
	}
	
}

close_SID($sid);

?>