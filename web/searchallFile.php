<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Search All Files</title>
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
<?php
	
	include("../functions.php");
	$docLink = db_connect("Documents");
	
		
	echo '<div id="page-inner">';
		echo '<h1 class="page-head-line">Results for all files</h1>';
		echo '<div class="panel-body">';
			echo '<table class="table table-hover">';
			echo '<tbody>';
		
	$sql = "Select `auto_id`, `file_name` From `file_data`";
	$result = $docLink->query($sql) or die("Something went wrong with $sql".$docLink->error);

	while ($data=$result->fetch_array(MYSQLI_ASSOC)) {
		echo '<tr><td>';
		echo '<a href="viewFile.php?docId='.$data['auto_id'].'">'.$data['file_name'].'</a>';
		echo '</tr></td>';
	}
			echo '</tbody></table>';
	echo '</div></div>';
	
?>
<body>
</body>
</html>