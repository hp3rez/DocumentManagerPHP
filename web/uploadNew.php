<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Upload to New Loan</title>
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
	echo '<h1 class="page-head-line">Upload a New File to Database</h1>';
	echo '<div class="panel-body">';
		if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="noLoanNum") {
			echo '<div class="alert alert-danger" role="alert">Please provide a loan number.</div>';
		} else if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="noDocType") {
			echo '<div class="alert alert-danger" role="alert">Please select a document type.</div>';
		} else if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="wrongFileType") {
			echo '<div class="alert alert-danger" role="alert">Please select a pdf file.</div>';
		} else if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="invalidLoanNum") {
			echo '<div class="alert alert-danger" role="alert">Please provide a valid loan number.</div>';
		}
		echo '<form method="post" enctype="multipart/form-data" action="">';
			echo '<input type="hidden" name="MAX_FILE_SIZE" value="10000000">';
			echo '<div class="form-group">';
				echo '<label for="loanNum" class="control-label">Loan Number</label>';
				echo '<input type="text" name="loanNum" class="form-control" pattern="[0-9]{,9}" required>';
				echo '<p>Loan numbers must be 9 digits or less.</p>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<label for="docType" class="control-label">Document Type</label>';
				echo '<select class="form-control" name="docType">';
					
					include("../functions.php");
					$docLink = db_connect("Documents");
					$sql = "Select * from doc_types"; 
					$result = $docLink->query($sql) or die("Something went wrong with $sql<br>".$docLink->error);
					
					while($data=$result->fetch_array(MYSQLI_ASSOC)) {
						echo '<option value = "'.$data['auto_id'].'">'.$data['name'].'</option>';
					}
					//echo '<option value="1">Tax Returns</option>';
					//echo '<option value="2">MOU</option>';
					//echo '<option value="3">Credit Report</option>';
					//echo '<option value="4">Bank Statement</option>';
					//echo '<option value="5">Other</option>';
				echo '</select>';
				echo '<div class="form-group">';
					echo '<label class="control-label col-lg-4">File Upload</label>';
					echo '<div class=""><div class="fileupload fileupload-new" data-provides="fileupload">';
						echo '<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>';
						echo '<div class="row">';
							echo '<div class="col-md-2">';
								echo '<span class="btn btn-file btn-primary">';
									echo '<span class="fileupload-new">Select File</span>';
									echo '<span class="fileupload-exists">Change</span>';
									echo '<input name="userfile" type="file" accept="application/pdf" required>';
								echo '</span>';
							echo '</div>';
							echo '<div class="col-md-2">';
								echo '<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>';
							echo '</div>';
						echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
				echo '<hr>';
				echo '<button type="submit" name="submit" value="submit" class="btn btn-lg btn-block btn-success">Upload File</button>';
				echo '</form>';
			echo '</div>';
	echo '</div>';
echo '</div>';
echo '</body>';
echo '</html>';
if (isset($_POST['submit']) && $_POST['submit']=='submit') {
	$fileMime = $_FILES['userfile']['type'];
	if($fileMime != 'application/pdf') {
		redirect("uploadNew.php?msg=wrongFileType");
	} else {
		$loanNumber = $_POST['loanNum'];
		
		if (isset($_POST['loanNum']) || ($loanNumber != NULL)) {
			
			if(!preg_match('[0-9]{,9}')) {
				redirect("uploadNew.php?msg=invalidLoanNum");
			} else {
				if(isset($_POST['docType'])) {
					redirect("uploadMain.php?msg=fileUploaded");
				} else {
					redirect("uploadNew.php?msg=noDocType");
				}
			}
			
		} else {
			redirect("uploadNew.php?msg=noLoanNum");
		}
		$docId = $_POST['docType'];
		$fileUpload = $_FILES['userfile']['name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileContents = $_FILES['userfile']['tmp_name'];
		$fp = fopen($fileContents, 'r');
		$contents = fread($fp, filesize($fileContents));
		fclose($fp);
		
		$cleanContents = addslashes($contents);
	}
	
	
}
		
?>