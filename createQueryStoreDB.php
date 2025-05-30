<?php

//include functions file
include('functions.php');

//login to database
$dblink = db_connect("Documents");

//login to server
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

//calculate execution time for query files
$time_start=microtime(true);
$result=curl_exec($ch);
$time_end=microtime(true);
$exec_time=($time_end-$time_start)/60;
curl_close($ch);

//decode and print json results
$cinfo=json_decode($result, true);
echo "<pre>";
print_r($cinfo);
echo "</pre>";

//display the payload array specifically
$tmp=explode(":", $cinfo[1]);
$payload=json_decode($tmp[1]);
echo "<pre>";
print_r($payload);
echo "</pre>";

//call request files for each file queried
foreach($payload as $key=>$value) {
	$data="uid=$un&sid=$sid&id=$value";
	$ch=curl_init('https://cs4743.professorvaladez.com/api/request_files');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	//sends out the data
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(		//sets the format for the returned data
		'content-type: application/x-www-form-urlencoded',
		'content-length: '.strlen($data)));

	//calculate execution time for request_files
	$time_start=microtime(true);
	$result=curl_exec($ch);
	$time_end=microtime(true);
	$exec_time=($time_end-$time_start)/60;
	curl_close($ch);

	//check for errors returning the file
	if(strstr($result, "Status")=="Status") {
		echo "<h3>There was an error with file $value.</h3>";
		echo "<pre> $result </pre>";
		continue;
	} else { 
		//check for files with no content
		$content=$result;
		if(strlen($content) == 0) {
			echo "<h2>File $value has a length of zero.</h2>";
			continue;
		} else {
			//sanitize content for a mysql database and establish table values
			$contentClean=addslashes($content);
			$fileSize=strlen($content);
			$fileName=addslashes($value);
			$now=date("Y-m-d H:i:s");
			$tmp = '0';
			//create and execute sql query
			$sql="Insert into `file_data` (`loan`,`file_name`,`file_size`,`upload_date`,`upload_type`) values ('$tmp','$fileName','$fileSize','$now','cron')";
			$dblink->query($sql) or die("Something went wrong with: $sql".$dblink->error);
			
			$sql="Insert into `file_content` (`file_name`,`file_content`) values ('$fileName','$contentClean')";
			$dblink->query($sql) or die("Something went wrong with: $sql".$dblink->error);
				
			echo "<h3>File $value written to the database.</h3>";
		}
	}
	
}

close_SID($sid);

?>