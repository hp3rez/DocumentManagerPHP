<?php

include("functions.php");
$docLink = db_connect("Documents");

/**$sql = "SELECT * FROM `file_data` WHERE `file_type` REGEXP '^[0-9]'";
$result = $docLink->query($sql) or die("Something went wrong with $sql<br>".$docLink->error);
while($data=$result->fetch_array(MYSQLI_ASSOC)) {
	$fileName = explode("-", $data['file_type']);
	$loanNum = $fileName[0];
	$fileType = $fileName[1];
	$id = $data['auto_id'];
	
	$sql = "Update `file_data` Set `loan` = '$loanNum', `file_type` = '$fileType' Where `auto_id` = '$id'";
	$docLink->query($sql) or die("Something went wrong with checkFileType at file $name".$docLink->error);
	echo "<h1> Row $id successfully updated.</h1>";
}*/

$sql = "SELECT * FROM `file_data` WHERE NOT `file_type` REGEXP '^[0-9]'";
$result = $docLink->query($sql) or die("Something went wrong with $sql<br>".$docLink->error);
while($data=$result->fetch_array(MYSQLI_ASSOC)) {
	$fileName = explode("-", $data['file_type']);
	$loanNum = substr($fileName[0], 9, 9);
	$fileType = $fileName[1];
	$id = $data['auto_id'];
	
	$sql = "Update `file_data` Set `loan` = '$loanNum', `file_type` = '$fileType' Where `auto_id` = '$id'";
	$docLink->query($sql) or die("Something went wrong with checkFileType at file $name".$docLink->error);
	echo "<h1> Row $id successfully updated.</h1>";
}

?>