<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Upload Main</title>
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
	echo '<h1 class="page-head-line">Select the type of Upload</h1>';
	
	echo '<div class="panel-body">';
	if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="fileUploaded") {
		echo '<div class="alert alert-success" role="alert">File uploaded successfully.</div>';
	}
	echo '<p><a class="btn btn-primary" href="uploadNew.php">Upload New Loan</a></p>';
	echo '<p><a class="btn btn-primary" href="uploadExisting.php">Upload Existing Loan</a></p>';
	echo '</div></div>';
		
	?>
	
</body>
</html>
    
    