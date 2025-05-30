<?php

function login($endpoint) {
	//set username and password variables
	$un="ygb374";
	$pass="RwvCq9hp8jtJ#XZ";
	//ensure variables can be sent to post in the url
	$data="username=$un&password=$pass";
	$ch=curl_init('https://cs4743.professorvaladez.com/api/'.$endpoint);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	//sends out the data
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(		//sets the format for the returned data
		'content-type: application/x-www-form-urlencoded',
		'content-length: '.strlen($data)));
	return $ch;
}

function create_SID() {
	//login to the server 
	$ch = login("create_session");

	//calculate execution time
	$time_start=microtime(true);
	$result=curl_exec($ch);
	$time_end=microtime(true);
	$exec_time=($time_end-$time_start)/60;
	
	//close the curl channel
	curl_close($ch);

	//decode the json results to find the session id
	$cinfo=json_decode($result, true);
	if($cinfo[0] == "Status: OK"){
		$sid = $cinfo[2];
		return $sid;
	}
	
	return null;
	
}

function clear_SID() {
	$ch = login('clear_session');

	//calculates the execution time
	$time_start=microtime(true);
	$result=curl_exec($ch);
	$time_end=microtime(true);
	$exec_time=($time_end-$time_start)/60;
	curl_close($ch);
}

function close_SID($sid) {
	
	//set curl channel
	$data="sid=$sid";
	$ch=curl_init('https://cs4743.professorvaladez.com/api/close_session');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	//sends out the data
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(		//sets the format for the returned data
		'content-type: application/x-www-form-urlencoded',
		'content-length: '.strlen($data)));
	
	//execute and close channel
	curl_exec($ch);
	curl_close($ch);
	echo "<h3>Session closed.</h3>";
}
function close_SIDCron($sid) {
	
	//set curl channel
	$data="sid=$sid";
	$ch=curl_init('https://cs4743.professorvaladez.com/api/close_session');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	//sends out the data
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(		//sets the format for the returned data
		'content-type: application/x-www-form-urlencoded',
		'content-length: '.strlen($data)));
	
	//execute and close channel
	curl_exec($ch);
	curl_close($ch);
	echo "\r\nSession closed.\r\n";
}

function query_files($sid) {
	$un="ygb374";
	//ensure variables can be sent to post in the url
	$data="username=$un&sid=$sid";
	$ch=curl_init('https://cs4743.professorvaladez.com/api/query_files');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	//sends out the data
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(		//sets the format for the returned data
		'content-type: application/x-www-form-urlencoded',
		'content-length: '.strlen($data)));
	return $ch;
}

function db_connect($db) {
	$hostname="localhost";
	$username="hp3rez";
	$password="galaxy_MNMs_13";
	$dblink=new mysqli($hostname, $username, $password, $db);
	if(mysqli_connect_error())
		die("Error connecting to the database: ".mysqli_connect_error());
	return $dblink;
}

function redirect($uri) { ?>

	<script type="text/javascript">
	<!--
	document.location.href="<?php echo $uri; ?>";
	-->
	</script>
	<?php die;
	
}

?>