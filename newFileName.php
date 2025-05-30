<?php

include("functions.php");
$docLink = db_connect("Documents");

$names = [];
$ids = [];

$sql = "Select `auto_id`, `file_name` From `file_content`";
$result = $docLink->query($sql) or die("Something went wrong with $sql<br>".$docLink->error);

while($data=$result->fetch_array(MYSQLI_ASSOC)) {
	$names[] = $data['file_name'];
	$ids[] = $data['auto_id'];
}

$count = 0;

foreach($names as $name) {
	$id = $ids[$count];
	echo "<h1>$id<?h1>";
	$sql = "Update `file_data` Set `file_name` = '$name' Where `auto_id` = '$id'";
	$docLink->query($sql) or die("Something went wrong with $sql<br>".$docLink->error);
	$count++;
	echo "<h1>$name updated.</h1>";
}



?>