<?php
	require_once 'config.php';
	
	$sessionid = session('user_id');

	$dbconn = $db->connect();


	$name = mb_strtolower(post('name'));
	$gender = mb_strtolower(post('gender'));
	$about = $_POST['about'];

	
	$nameUpdateStatus = false;
	$genderUpdateStatus = false;
	$aboutUpdateStatus = false;

	$nameIsSame = false;
	$genderIsSame = false;
	$aboutIsSame = false;



	$controlUsersDetails = $dbconn->prepare("SELECT * FROM users_details WHERE user_id = :i");
	$controlUsersDetails->execute([':i' => $sessionid]);

	$controlName = $dbconn->prepare("SELECT * FROM users WHERE user_id = :i");
	$controlName->execute([':i' => $sessionid]);
	$row = $controlUsersDetails->fetch(PDO::FETCH_OBJ);
	$rowUsers = $controlName->fetch(PDO::FETCH_OBJ);
	
	if ($controlUsersDetails->rowCount()) {
		
		if ($controlName->rowCount()) {
			if ($rowUsers->user_fullname == $name) {
				$nameIsSame = true;
			}else{
				$updateName = $dbconn->prepare("UPDATE users SET user_fullname = :n WHERE user_id = :i");
				$updateName->execute([':n' => $name , ':i' => $sessionid]);
				if ($updateName->rowCount()) {
					$nameUpdateStatus = true;
				}
			}
		}

	
		if ($row->user_gender == $gender) {
			$genderIsSame = true;
		}else{
			$updateGender = $dbconn->prepare("UPDATE users_details SET user_gender = :g WHERE user_id = :i");
			$updateGender->execute([':g' => $gender ,':i' => $sessionid]);
			if ($updateGender->rowCount()) {
				$genderUpdateStatus = true;
			}
		}

		if ($row->user_about == $about) {
			$aboutIsSame = true;
		}else{
			$updateAbout = $dbconn->prepare("UPDATE users_details SET user_about = :a WHERE user_id = :i");
			$updateAbout->execute([':a' => $about ,':i' => $sessionid]);
			if ($updateAbout->rowCount()) {
				$aboutUpdateStatus = true;
			}
		}

		if ($nameUpdateStatus  || $genderUpdateStatus || $aboutUpdateStatus ) {
			echo 'successful';
		}else if($nameIsSame && $genderIsSame && $aboutIsSame){
			echo 'nothingupdated';
		}else{
			echo 'unsuccessful';
		}
	}else{
		$createUserDetails = $dbconn->prepare("INSERT INTO users_details SET 
			user_gender = :g ,
			user_about = :a,
			user_id = :i
			");

		$createUserDetails->execute([
		 ':g' => $gender , 
		 ':a' => $about,
		 ':i' => $sessionid
		]);
		
		if ($rowUsers->user_fullname == $name) {
			$nameUpdateStatus=true;
		}else{
			$updateName = $dbconn->prepare("UPDATE users SET user_fullname = :n WHERE user_id = :i");
			$updateName->execute([':n' => $name , ':i' =>$sessionid]);
			if ($updateName->rowCount()) {
				$nameUpdateStatus=true;
			}
		}

		if ($createUserDetails->rowCount() && $nameUpdateStatus) {
			echo 'successful';	
		}else{
			echo 'unsuccessful';
		}

	}
?>