<?php
	require_once 'config.php';

	$dbconn = $db->connect();

	$email = strtolower(post('email'));

	$sessionemail =  session('user_email');
	$sessionusername =  session('user_username');

	$verifydata = 0;

	$usedemailcontrol = $dbconn->prepare("SELECT * FROM users WHERE user_email = :e");
	$usedemailcontrol->execute([':e' => $email]);

	$accountverification = $dbconn->prepare("SELECT * FROM users WHERE user_email = :e AND user_verification = :v");
	$accountverification->execute([':e' => $sessionemail , ':v' => $verifydata]);


	if (empty($email)) {
		echo 'empty';	
	}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		echo 'emailtypemismatch';
	}else if($usedemailcontrol->rowCount() && $email != $sessionemail) {
		echo 'usedemail';
	}else if(!checkFakeEmail($email)) {
		echo 'fakeemail';
	}else if(!$accountverification->rowCount()){
		echo 'accountalreadyverified';
	}else{
		$row = $accountverification->fetch(PDO::FETCH_OBJ);

		$name = $row->user_fullname;
		$sitename = 'http://localhost/myapp';	
		$subject = 'Verification of your account';
		$senderemail =  'noreply@gmail.com';
		$sendername = 'froaw';
        $bodymessage =  'Hi '.$name.', <br> to verify your account click the button below';
        $footermessage = $sendername.' incorporated';
        $username = $row->user_username;

  		$encodedemail = encode($email);
        $encodedusername = encode($username);

        $buttontext = 'verify';
        $buttonlink = $sitename.'/verify/'.$encodedemail.'/'.$encodedusername;


        $emailmessage = emailMessage($bodymessage,$footermessage,true,$buttontext,$buttonlink);

		$sendemail = sendEmail($email,$name,$senderemail,$sendername,$subject,$emailmessage);
		if ($sendemail) {
			$db->disconnect();
			echo 'successful';
		}else{
			$db->disconnect();
			echo 'unsuccessful';
		}
		
	}
?>