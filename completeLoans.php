<?php

include("functions.php");
$docLink = db_connect("Documents");

$sql = "Select * From `loans`";
$loanResults = $docLink->query($sql) or die("Something went wrong with $sql".$docLink->error);

while($loanData=$loanResults->fetch_array(MYSQLI_ASSOC)) {
	$loanId = $loanData['auto_id'];
	$loanNum = $loanData['loan_number'];
	
	$sql = "Select * From `file_data` Where `loan` = '$loanNum'";
	$taxCount = 0;
	
	$fileResults = $docLink->query($sql) or die("Something went wrong with $sql".$docLink->error);
	$docNum = mysqli_num_rows($fileResults);
	$complete = -1;
	
	while($fileData=$fileResults->fetch_array(MYSQLI_ASSOC)) {
		$fileType = $fileData['file_type'];
		if(strpos($fileType, "Tax") !== false) {
			$taxCount+=1;
		}
	}
	
	if($docNum >= 10 && $taxCount >= 2) {
		$complete = 1;
	}
	
	$sql = "Update `loans` Set `num_documents` = '$docNum', `complete` = '$complete' where `auto_id` = '$loanId'";
	$docLink->query($sql) or die("Something went wrong with $sql".$docLink->error);
	echo "<h2>Loan $loanNum is $complete completed with $docNum documents and $taxCount tax returns.</h2>";
}

?>