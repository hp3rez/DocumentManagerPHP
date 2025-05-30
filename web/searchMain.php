<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Search Main</title>
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
	echo '<h1 class="page-head-line">Select the search criteria</h1>';
	echo '<div class="panel-body">';
	echo '<p><a class="btn btn-primary" href="searchLoanID.php">Loan Number</a></p>';
	echo '<p><a class="btn btn-primary" href="searchDocType.php">Document Type</a></p>';
	echo '<p><a class="btn btn-primary" href="searchDate.php">Date</a></p>';
	echo '<p><a class="btn btn-primary" href="searchDateRange.php">Date Range</a></p>';
	echo '<p><a class="btn btn-primary" href="searchallFile.php">Search All Files</a></p>';
		
	?>
	
</body>
</html>
    
    