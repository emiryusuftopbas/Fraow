<?php
	require_once 'functions.php';
	require_once 'classes/classes.php';

	@session_start();
	@ob_start();

	$dbhost = 'localhost';
	$dbname = 'fraow';
	$dbuser = 'root';
	$dbpass = '';

	// For verification mail
	@define('SMTP_HOST',"");
	@define('SMTP_USERNAME',"");
	@define('SMTP_PASSWORD',"");

	$db = new db($dbhost,$dbuser,$dbpass,$dbname);


?>
