<?php

//connect to database
include('functions.php');
$docLink = db_connect('Documents');

//run query to get relevant data
$sql = "Insert into `file_content` (`file_name`,`file_content`) Select `file_name`,`file_content` FROM `file_data`";
$docLink->query($sql) or die("Something went wrong with moveFileContent.php: ".$docLink->error);


//confirm transfer
echo "\r\nContent transferred.\r\n";

?>