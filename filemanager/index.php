<?php 
if (session_id() == '') session_start();
if(empty($_SESSION['TYPE']) || $_SESSION['TYPE'] != '1'){
	// die('Access Denied!');
	$status_header = 'HTTP/1.1 403 Forbidden';
	header($status_header);
    // and the content type
	header('Content-type: text/html');
	$signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];
	$body = '
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>403 Forbidden</title>
	</head>
	<body>
	<h1>Forbidden</h1>
	<hr />
	<address>' . $signature . '</address>
	</body>
	</html>';
	echo $body;
	exit;
}
?>