<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>View File</title>
<!-- BOOTSTRAP STYLES-->
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<!-- FONTAWESOME STYLES-->
<link href="assets/css/font-awesome.css" rel="stylesheet" />
   <!--CUSTOM BASIC STYLES-->
<link href="assets/css/basic.css" rel="stylesheet" />
<!--CUSTOM MAIN STYLES-->
<link href="assets/css/custom.css" rel="stylesheet" />
<!-- PAGE LEVEL STYLES -->
<link href="assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/bootstrap-fileupload.js"></script>
</head>
<body>

<?php

echo '<div id="page-inner">';
	include("../functions.php");
	$docLink = db_connect("Documents");
	
	echo '<h1 class="head-line">View Document</h1>';
	echo '<div class="panel-body">';
			echo '<table class="table table-hover">';
			echo '<tbody>';
	
	$docId = $_GET['docId'];
	$sql = "Select * From `file_data` where `auto_id` = $docId";
	$result = $docLink->query($sql) or die("Something went wrong with $sql".$docLink->error);
	$file = $result->fetch_array(MYSQLI_ASSOC);
	$fileData = explode("-", $file['file_name']);
	$fileName = $file['file_name'];
	$id = $file['auto_id'];
	if(is_numeric(substr($fileName, 0, 1))) {
		$loanNum = $fileData[0];
		$fileType = $fileData[1];
	} else {
		$loanNum = substr($fileData[0], 9, 9);
		$fileType = $fileData[1];
	}
	
	echo '<tr>';
	echo '<td>Document Name: '.$fileName.'</td>';
	echo '<td>Loan Id: '.$loanNum.'</td>';
	echo '<td>File Size: '.$file['file_size'].'</td>';
	echo '<td>Document Type: '.$fileType.'</td>';
	echo '<td>Last Access: '.$file['last_access'].'</td>';
	
	$now=date("Y-m-d H:i:s");
	echo "<h1>$now $docId</h3>";
	$sql = "Update `file_data` Set `last_access` = '$now' Where `auto_id` = '$docId'";
	
	$sql = "Select `file_content` From `file_content` Where `file_name` Like '$fileName'";
	$result=$docLink->query($sql) or die("Something went wrong with $sql".$docLink->error);
	$data = $result->fetch_array(MYSQLI_ASSOC);
	$fileContent = $data['file_content'];
	
	$fp = fopen("/var/www/html/views/$fileName", "wb");
	fwrite($fp, $fileContent);
	fclose($fp);
	
	echo '<td><a href="/views/'.$fileName.'">View Document</a></td>';
	//echo '<iframe width = "100%" height="600" src="/views/'.$fileName.'" title="View Document"></iframe>"';
	echo '</tbody></table>';
	echo '</div>';
echo '</div>';
?>	
	
</body>
</html>