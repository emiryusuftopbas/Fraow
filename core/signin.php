<?php
require_once 'config.php';


$dbconn = $db->connect();

if ($_POST) {
	$username = strtolower(post('username'));
	$password = post('password');
	$hashedpassword = hashPassword($password);
	if (empty($username) || empty($password)) {
		echo 'empty';
	}else {
		$signin = $dbconn->prepare("SELECT * FROM users where user_username =:u AND user_password=:s LIMIT 1");
		$signin->execute([':u'=>$username, ':s'=>$hashedpassword]);

		if ($signin->rowCount()){
			$row = $signin->fetch(PDO::FETCH_OBJ);
			$_SESSION['loginsession'] = true;
			$_SESSION['user_id'] = $row->user_id;
			$_SESSION['user_fullname'] = $row->user_fullname;
			$_SESSION['user_email'] = $row->user_email;
			$_SESSION['user_username'] = $row->user_username;
			$_SESSION['user_verification'] = $row->user_verification;
			$db->disconnect();
			echo 'successful';
		}else{
			echo 'unsuccessful';
		}
	}	
}


?>