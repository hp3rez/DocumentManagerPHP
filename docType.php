<?php

include("functions.php");
$docLink = db_connect("Documents");

$types = [];

$sql = "Select `file_type` From `file_data`";
$result = $docLink->query($sql) or die("Something went wrong with $sql<br>".$docLink->error);

while($data=$result->fetch_array(MYSQLI_ASSOC)) {
	$types[] = $data['file_type'];
}

$docTypes = array_unique($types);

foreach($docTypes as $type) {
	$sql = "Insert Ignore into `doc_types` (`name`) Values ('$type')";
	$docLink->query($sql) or die("Something went wrong with $sql<br>".$docLink->error);
}

echo "<h1>Done.</h1>";

?>