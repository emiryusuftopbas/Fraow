<?php
	require_once 'config.php';

	$dbconn = $db->connect();
	$username =  mb_strtolower(post('username'));
	$email = mb_strtolower(post('email'));
	$message = mb_strtolower(post('message'));



	$usercontrol = $dbconn->prepare("SELECT * FROM users WHERE user_username = :u AND user_email = :e LIMIT 1");
	$usercontrol->execute([':u' => $username , ':e' => $email]);
	
	$messageLength = strlen($message);

	$activeTicketControl = $dbconn->prepare("SELECT * FROM users_tickets WHERE user_username = :u AND user_email = :e AND ticket_status = :s LIMIT 1");
	$activeTicketControl->execute([':u' => $username , ':e' => $email, 's' => 1]);

	

	if (empty($username) || empty($email) || empty($message)) {
		echo 'empty';
	}else if (!$usercontrol->rowCount()) {
		echo 'usernameandemailmismatch';
	}else if($activeTicketControl->rowCount()){
		echo 'ticketalreadyopen';
	}else if($messageLength >300){
		echo 'messagelengtherror';
	}else{
		$sendTicket = $dbconn->prepare("INSERT INTO users_tickets SET 
			user_username = :u ,
			user_email = :e ,
			ticket_message = :m ,
			ticket_status = :s
			");
		$sendTicket->execute([':u' => $username , ':e' => $email , ':m' => $message , ':s' => 1 ]);
		if ($sendTicket->rowCount()) {
			echo 'successful';
		}else{
			echo 'unsuccessful';
		}
	}
?>