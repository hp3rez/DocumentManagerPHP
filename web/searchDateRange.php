<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Search Date</title>
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
			echo '<h1 class="page-head-line">Choose date</h1>';
			echo '<div class="panel-body">';
				echo '<form action="" method="post">';
				echo '<div class="form-group">';
							echo '<label for="date1" class="control-label">Date</label>';
							echo '<select class="form-control" name="date1">';

								$sql = "Select Distinct DATE_FORMAT(`upload_date`, '%Y-%m-%d') AS date From `file_data`"; 
								$result = $docLink->query($sql) or die("Something went wrong with $sql<br>".$docLink->error);

								while($data=$result->fetch_array(MYSQLI_ASSOC)) {
									echo '<option>'.$data['date'].'</option>';
								}
							echo '</select>';
							echo '</div>';
				echo '<div class="form-group">';
							echo '<label for="date2" class="control-label">Date</label>';
							echo '<select class="form-control" name="date2">';

								$sql = "Select Distinct DATE_FORMAT(`upload_date`, '%Y-%m-%d') AS date From `file_data`"; 
								$result = $docLink->query($sql) or die("Something went wrong with $sql<br>".$docLink->error);

								while($data=$result->fetch_array(MYSQLI_ASSOC)) {
									echo '<option>'.$data['date'].'</option>';
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
		
		
		$date1 = $_POST['date1'];
		$date2 = $_POST['date2'];
		
		echo '<div id="page-inner">';
			echo '<h1 class="page-head-line">Results for '.$date1.' to '.$date2.'</h1>';
			echo '<div class="panel-body">';
				echo '<table class="table table-hover">';
				echo '<tbody>';
		
		$sql = "Select `auto_id`, `file_name` From `file_data` Where date_format(`upload_date`, '%Y-%m-%d') Between '$date1' And '$date2'";
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