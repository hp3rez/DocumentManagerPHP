<?php

//include functions file
chdir('/var/www/html');
include('functions.php');

//login to databases
$dblink = db_connect("Documents");
$metricDB = db_connect("Metrics");

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
echo "\r\n";
print_r($cinfo);
echo "\r\n";
if($cinfo[1] == 'MSG: No new files found') {
	echo "\r\n No new files found \r\n";
} else {
	//display the payload array specifically
	$tmp=explode(":", $cinfo[1]);
	$payload=json_decode($tmp[1]);
	echo "\r\n";
	print_r($payload);
	echo "\r\n";

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
			//set error values
			$message = "\r\nThere was an error with file $value.\r\n";
			$now=date("Y-m-d H:i:s");

			//put error in output
			echo $message;
			echo "\r\n Error detected \r\n";

			//insert error into table
			$sql="Insert into `errors` (`message`,`file_name`,`time_occured`) values ('$message',$value','$now')";
			$metricDB->query($sql) or die("Something went wrong with: $sql".$metricDB->error);
			continue;
		} else { 
			$content=$result;
			if(strlen($content) == 0) {
				$message = "File $value has a length of zero.\r\n";
				$fileName = "createQueryRequestCron.php";
				$now=date("Y-m-d H:i:s");

				echo $message;
				echo "\r\n Error detected \r\n";

				//insert error into table
				$sql="Insert into `errors` (`message`,`file_name`,`time_occured`) values ('$message',$fileName','$now')";
				$metricDB->query($sql) or die("Something went wrong with: $sql".$metricDB->error);
				continue;
			} else {
				$fp=fopen("/var/www/files/$value", "wb");
				fwrite($fp, $content);
				fclose($fp);
				echo "\r\nFile $value written to the filesystem.\r\n";
			}
		}

	}
}



close_SIDCron($sid);

?>