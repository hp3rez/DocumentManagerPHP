<?php

#change directory and include functions
chdir('/var/www/html');
include('functions.php');

//connect to Documents and Errors databases
$docLink = db_connect('Documents');
$errorLink = db_connect('Metrics');

//get a list of all files
$files = glob('../files/*');

//foreach loop to iterate through each file
foreach($files as $key =>$value) {
	//check if file is a pdf
	$fileType = pathinfo($value, PATHINFO_EXTENSION);
	echo "file is a $fileType";
	if($fileType == "pdf") {
		//get info for table
		$name = addslashes($value);
		$size = filesize("../files/$value");
		$now = date("Y-m-d H:i:s");
		$content = addslashes(file_get_contents("../files/$value"));
		
		//run insert query
		$sql = "Insert into `file_data` (`loan`,`file_name`,`file_size`,`upload_date`) values ('0', '$name','$size','$now')";
		$docLink->query($sql) or die("Something went wrong with checkFileType at file $name".$docLink->error);
		
		//write to file_content as well
		$sql = "Insert into `file_content` (`file_name`,`file_content`) values ('$name','$content')";
		$docLink->query($sql) or die("Something went wrong with checkFileType at file $name".$docLink->error);
		
		//log that call was successful
		echo "\r\n File $value uploaded to database.";
		
		//delete file from file system to save space
		unlink("../files/$value");
		
	} else {
		//file type is not a pdf, put into errors for further evaluation
		$msg = "\r\nFile is not a pdf.\r\n";
		$now = date("Y-m-d H:i:s");
		$name = addslashes($value);
		
		//write query for errors and execute
		$sql = "Insert into `errors` (`message`,`file_name`,`time_occurred`) values ('$msg','$name','$now')";
		$errorLink->query($sql) or die("Something went wrong with checkFileType at file $name".$errorLink->error);
		
		echo "\r\nError sent to database\r\n";
		
	}
}

?>