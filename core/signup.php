<?php
require_once 'config.php';


$dbconn = $db->connect();

$name = strtolower(post('name'));
$username = strtolower(post('username'));
$email = strtolower(post('email'));
$password = post('password');
$confirmpassword = post('confirmpassword');

$controlusedemail = $dbconn->prepare("SELECT * FROM users WHERE user_email = :e");
$controlusedemail->execute([':e'=>$email]);

$controlusedusername = $dbconn->prepare("SELECT * FROM users WHERE user_username = :u");
$controlusedusername->execute([':u'=>$username]);

$hashedpassword = hashPassword($password);

if (empty($name) || empty($username) || empty($email) || empty($password) || empty($confirmpassword)) {
	echo 'empty';
}else if (!($password == $confirmpassword)) {
	echo 'passwordmismatch';
}else if (!checkPassword($password)) {
	echo 'passwordlengtherr';
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
	echo 'emailtypemismatch';
}else if(!checkFakeEmail($email)){
	echo 'fakeemail';
}else if($controlusedemail->rowCount() && $controlusedusername->rowCount()){
	echo 'usedemailandusername';
}else if($controlusedemail->rowCount()){
	echo 'usedemail';
}else if($controlusedusername->rowCount()){
	echo 'usedusername';
}else if(!checkUsername($username)){
	echo 'usernametypemismatch';
}else{
	$signup = $dbconn->prepare("INSERT INTO users SET 
		user_fullname = ?,
		user_username = ?,
		user_email = ?,	
		user_password = ?
	");
	$signup->execute(array($name,$username,$email,$hashedpassword));
	if ($signup) {
		echo 'success';
	}else{
		echo 'dberror';
	}
}



?>