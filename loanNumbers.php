<?php

include("functions.php");
$docLink = db_connect("Documents");

$sql = "SELECT `auto_id`, `file_name`, `file_size`, `upload_date`, `last_access`, `file_content`, `upload_type` FROM `file_data` WHERE `file_name` REGEXP '^[0-9]'";
$result = $docLink->query($sql) or die("Something went wrong with $sql<br>".$docLink->error);
$loanNumbers = [];
while($data=$result->fetch_array(MYSQLI_ASSOC)) {
	$fileName = $data['file_name'];
	$loanNum = substr($fileName, 0, 9);
	$loanNumbers[] = $loanNum;
	//echo "<h2>$fileName $loanNum</h2>";
}

$sql = "SELECT `auto_id`, `file_name`, `file_size`, `upload_date`, `last_access`, `file_content`, `upload_type` FROM `file_data` WHERE NOT `file_name` REGEXP '^[0-9]'";
$result = $docLink->query($sql) or die("Something went wrong with $sql<br>".$docLink->error);
while($data=$result->fetch_array(MYSQLI_ASSOC)) {
	$fileName = $data['file_name'];
	$loanNum = substr($fileName, 9, 9);
	$loanNumbers[] = $loanNum;
	//echo "<h2>$fileName $loanNum</h2>";
}

$numbers = array_unique($loanNumbers);
foreach ($numbers as $num) {
	//echo "<h2>$num</h2>";
	$sql="Insert Ignore into `loans` (`loan_number`) values ('$num')";
	$docLink->query($sql) or die("Something went wrong with: $sql".$doclink->error);
				
	echo "<h3>Loan $num written to the database.</h3>";
}

?>