<?php
	require_once  'config.php';

	$dbconn = $db->connect();

	$currentpassword =post('currentpassword');
	$newpassword = post('newpassword');
	$confirmpassword = post('confirmpassword');
	$username = $_SESSION['user_username'];
	$email = $_SESSION['user_email'];
	$hashedcurrentpassword = hashpassword($currentpassword);
	$hashednewpassword = hashpassword($newpassword);

	$controlpassword = $dbconn->prepare("SELECT * FROM users WHERE user_password = :p AND user_email = :e");
	$controlpassword->execute([':p' => $hashedcurrentpassword, ':e' =>$email ]);

	if (empty($currentpassword) || empty($newpassword) || empty($confirmpassword)) {
		echo 'empty';
	}else if ($newpassword != $confirmpassword){
		echo 'paswordmismatch';
	}else if (!checkpassword($newpassword)){
		echo 'passwordlengtherr';
	}else if (!$controlpassword->rowCount()){
		echo 'currentpasswordmismatch';
	}else{
		$updatepassword = $dbconn->prepare("UPDATE users SET user_password = :p WHERE user_email = :e");
		$updatepassword->execute([':p' => $hashednewpassword , ':e' => $email ]);
		if ($updatepassword->rowCount()) {
			echo 'successful';
		}else{
			echo 'unsuccessful';
		}
	}
?>