<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Search Document Type</title>
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
	if(!isset($_POST['submit'])) {
		echo '<div id="page-inner">';
			echo '<h1 class="page-head-line">Choose document type</h1>';
			echo '<div class="panel-body">';
				echo '<form action="" method="post">';
				echo '<div class="form-group">';
							echo '<label for="docType" class="control-label">Document Type</label>';
							echo '<select class="form-control" name="docType">';

								$sql = "Select * from doc_types"; 
								$result = $docLink->query($sql) or die("Something went wrong with $sql<br>".$docLink->error);

								while($data=$result->fetch_array(MYSQLI_ASSOC)) {
									echo '<option value = "'.$data['auto_id'].'">'.$data['name'].'</option>';
								}
							echo '</select>';
							echo '</div>';
				echo '</div>';
				echo '<hr>';
				echo '<button type="submit" name="submit" value="submit" class="btn btn-lg btn-block btn-success">Search</button>';
				echo '</form>';
				echo '</div>';
		echo '</div>';
	} else {
		
		
		$docTypeId = $_POST['docType'];

		$sql = "Select `name` From `doc_types` Where `auto_id` = '$docTypeId'";
		$result = $docLink->query($sql) or die("Something went wrong with $sql".$docLink->error);
		$tmp = $result->fetch_array(MYSQLI_ASSOC);
		$docType = $tmp['name'];
		
		echo '<div id="page-inner">';
			echo '<h1 class="page-head-line">Results for '.$docType.'</h1>';
			echo '<div class="panel-body">';
				echo '<table class="table table-hover">';
				echo '<tbody>';
		
		$sql = "Select `auto_id`, `file_name` From `file_data` Where `file_name` Like '%$docType%'";
		$result = $docLink->query($sql) or die("Something went wrong with $sql".$docLink->error);

		while ($data=$result->fetch_array(MYSQLI_ASSOC)) {
			echo '<tr><td>';
			echo '<a href="viewFile.php?docId='.$data['auto_id'].'">'.$data['file_name'].'</a>';
			echo '</tr></td>';
		}
				echo '</tbody></table>';
			echo '</div></div>';
	}
	
	
	
?>
<body>
</body>
</html>