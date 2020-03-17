<?php
	require_once 'config.php';
	
	$dbconn = $db->connect();

	$sociallinkid = post('sociallinkid');
	$sessionid = session('user_id');

	$linkcontrol = $dbconn->prepare("SELECT * FROM social_links WHERE social_link_id = :si AND user_id = :ui");
	$linkcontrol->execute([':si' => $sociallinkid , ':ui' => $sessionid]);
	
	if($linkcontrol->rowCount()){
		// delete
		$deletelink = $dbconn->prepare("DELETE FROM social_links WHERE social_link_id = :si AND user_id = :ui");
		$deletelink->execute([':si' => $sociallinkid , ':ui' => $sessionid]);
		if($deletelink->rowCount()){
			echo 'successful';
		}else{
			echo 'unsuccessful';
		}
	}else{
		echo 'linkdoesntfound';
	}
?>