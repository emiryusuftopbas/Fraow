<?php
	require_once 'config.php';

	
	$dbconn = $db->connect();

	$email = strtolower(post('email'));

	$emailcontrol = $dbconn->prepare("SELECT * FROM users WHERE user_email = :e");
	$emailcontrol->execute([':e'=> $email]);

	if (empty($email)) {
		echo 'empty';
	}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		echo 'emailtypemismatch';
	}else if(!$emailcontrol->rowCount()){
		echo 'emailnotfound';
	}else{
		$newpassword = randomPassword();
		$hashedpassword = hashPassword($newpassword);
		$changepassword = $dbconn->prepare(" UPDATE users SET user_password = :p WHERE user_email = :e");
		$changepassword->execute([':p' => $hashedpassword , ':e' => $email]);

		$row = $emailcontrol->fetch(PDO::FETCH_OBJ);
		$domainname = 'localhost/myapp';
		$name = $row->user_fullname;
		$subject = 'Successfully renewed your password';
		$senderemail =  'noreply@gmail.com';
		$sendername = 'froaw';		

        $bodymessage =  'Hi '.$name.', <br>'.'We renewed your password <br> '.'<b>Your new password is : '.$newpassword.'</b> <br> After sign in dont forget to change your password';
        $footermessage = $sendername.' incorporated';

        $emailmessage = emailMessage($bodymessage,$footermessage,true,'Sign In',$domainname);

		$sendemail = sendEmail($email,$name,$senderemail,$sendername,$subject,$emailmessage);
		if ($sendemail && $changepassword->rowCount()) {
			echo 'successful';
		}else{
			echo 'unsuccessful';
		}
	}

?>

