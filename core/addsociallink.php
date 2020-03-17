<?php
	require_once 'config.php';
	$dbconn = $db->connect();	

	$sessionId = session('user_id');

	$socialnetworkname = post('socialnetworkname');
	$socialnetworkvalue = post('socialnetworkvalue');

	$controlSocialNetworkAvailable = $dbconn->prepare("SELECT * FROM available_social_networks WHERE asn_name = :n AND asn_status = :s ");

	$controlSocialNetworkAvailable->execute([':n' =>$socialnetworkname ,  ':s' => 1]);

	$getSocialLinkPosition = $dbconn->prepare("SELECT * FROM social_links WHERE user_id = :i ORDER BY social_link_position");
	$getSocialLinkPosition->execute([':i' => $sessionId]);
	$socialLinkPositionRowCount = $getSocialLinkPosition->rowCount();

	$getSocialNetworkType = $dbconn->prepare("SELECT * FROM available_social_networks WHERE asn_name = :n ");
	$getSocialNetworkType->execute([':n' => $socialnetworkname]);
	$socialNetworkType;
	if ($getSocialNetworkType->rowCount()) {
		$socialNetworkType = $getSocialNetworkType->fetch(PDO::FETCH_OBJ);
	}
	
	if (empty($socialnetworkname) || empty($socialnetworkvalue) || $socialnetworkname == 'empty') {
		echo 'empty';
	}else if(!$controlSocialNetworkAvailable->rowCount()){
	 	echo 'unknownsocialnetworktype';
	}else{
		if (function_exists($socialNetworkType->asn_type)) {
			call_user_func($socialNetworkType->asn_type,$dbconn,$socialnetworkname,$socialnetworkvalue,$sessionId,$socialLinkPositionRowCount);
		}else{
			echo 'unsupportedsocialnetwork';
		}
	}
	

	function socialmedia($dbconn,$socialnetworkname,$socialnetworkvalue,$sessionId,$socialLinkPositionRowCount){
		$validateSocialLink = validateSocialLink($dbconn,$socialnetworkvalue,$socialnetworkname);
		$validateUsername = validateUsername($socialnetworkvalue);
		if(!( $validateSocialLink || $validateUsername)){
			echo 'notusernameorpassword';
		}else {
			if($validateSocialLink){
				$linkPosition = $socialLinkPositionRowCount ;
				$username = parseSocialLink($dbconn,$socialnetworkvalue,$socialnetworkname);
				$addLink = $dbconn->prepare("INSERT INTO social_links SET 
					social_link_type = :t,
					social_link_value = :v,
					user_id = :i,
					social_link_position = :p
				 ");
				$addLink->execute([':t' => $socialnetworkname ,
					':v' => $username , 
					':i' => $sessionId ,
					':p' =>$linkPosition ]);
				if ($addLink->rowCount()) {
					echo 'successful';
				}else{
					echo 'unsuccessful';
				}
			}else if($validateUsername){
				$linkPosition = $socialLinkPositionRowCount ;
				$username = $socialnetworkvalue;
				$addLink = $dbconn->prepare("INSERT INTO social_links SET 
					social_link_type = :t,
					social_link_value = :v,
					user_id = :i,
					social_link_position = :p
				 ");
				$addLink->execute([':t' => $socialnetworkname ,
					':v' => $username , 
					':i' => $sessionId ,
					':p' =>$linkPosition ]);
				if ($addLink->rowCount()) {
					echo 'successful';
				}else{
					echo 'unsuccessful';
				}
			}
		}	
	}
	function contactinfo($dbconn,$socialnetworkname,$socialnetworkvalue ,$sessionId,$socialLinkPositionRowCount){
		$linkPosition = $socialLinkPositionRowCount;
		switch($socialnetworkname){
			case 'mobilephone':
				if(!validatePhoneNumber($socialnetworkvalue)){
					echo 'phonenumberformaterr';
				}else{
					$addLink = $dbconn->prepare("INSERT INTO social_links SET 
					social_link_type = :t,
					social_link_value = :v,
					user_id = :i,
					social_link_position = :p ");
				    $addLink->execute([':t' => $socialnetworkname ,
					':v' => $socialnetworkvalue , 
					':i' => $sessionId ,
					':p' =>$linkPosition ]);
					if ($addLink->rowCount()) {
						echo 'successful';
					}else{
						echo 'unsuccessful';
					}
				}
			break;
			case 'homephone':
				if(!validatePhoneNumber($socialnetworkvalue)){
					echo 'phonenumberformaterr';
				}else{
					$addLink = $dbconn->prepare("INSERT INTO social_links SET 
					social_link_type = :t,
					social_link_value = :v,
					user_id = :i,
					social_link_position = :p ");
				    $addLink->execute([':t' => $socialnetworkname ,
					':v' => $socialnetworkvalue , 
					':i' => $sessionId ,
					':p' =>$linkPosition ]);
					if ($addLink->rowCount()) {
						echo 'successful';
					}else{
						echo 'unsuccessful';
					}
				}
			break;
			case 'whatsapp':
				if(!validatePhoneNumber($socialnetworkvalue)){
					echo 'phonenumberformaterr';
				}else{
					$addLink = $dbconn->prepare("INSERT INTO social_links SET 
					social_link_type = :t,
					social_link_value = :v,
					user_id = :i,
					social_link_position = :p ");
				    $addLink->execute([':t' => $socialnetworkname ,
					':v' => $socialnetworkvalue , 
					':i' => $sessionId ,
					':p' =>$linkPosition ]);
					if ($addLink->rowCount()) {
						echo 'successful';
					}else{
						echo 'unsuccessful';
					}
				}
			break;
			case 'email':
				if(!filter_var($socialnetworkvalue,FILTER_VALIDATE_EMAIL)){
					echo 'emailtypemismatch';
				}else{
					$addLink = $dbconn->prepare("INSERT INTO social_links SET 
					social_link_type = :t,
					social_link_value = :v,
					user_id = :i,
					social_link_position = :p ");
				    $addLink->execute([':t' => $socialnetworkname ,
					':v' => $socialnetworkvalue , 
					':i' => $sessionId ,
					':p' =>$linkPosition ]);
					if ($addLink->rowCount()) {
						echo 'successful';
					}else{
						echo 'unsuccessful';
					}
				}
			break;
			case 'website':
				if(!validateWebsiteWithProtocol($socialnetworkvalue)){
					echo 'urlformaterr';
				}else{
					$addLink = $dbconn->prepare("INSERT INTO social_links SET 
					social_link_type = :t,
					social_link_value = :v,
					user_id = :i,
					social_link_position = :p ");
				    $addLink->execute([':t' => $socialnetworkname ,
					':v' => $socialnetworkvalue , 
					':i' => $sessionId ,
					':p' =>$linkPosition ]);
					if ($addLink->rowCount()) {
						echo 'successful';
					}else{
						echo 'unsuccessful';
					}
				}
			break;
			default : 
				echo 'unsupportedsocialnetwork';
			break;
		}

	}
	

?>