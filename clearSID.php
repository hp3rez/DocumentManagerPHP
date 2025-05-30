<?php

include('functions.php');

$ch = login('clear_session');

//calculatesthe execution time of the curl handler
$time_start=microtime(true);
$result=curl_exec($ch);
$time_end=microtime(true);
$exec_time=($time_end-$time_start)/60;

//decode the json results array
$cinfo=json_decode($result, true);
echo "<pre>";
print_r($cinfo);
echo "<pre>";

?>