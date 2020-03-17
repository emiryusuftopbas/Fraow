<?php
	require_once 'config.php';


	$dbconn = $db->connect();

	$positions = $_POST['positions'];
	foreach ($positions as $position) {
		$index = $position[0];
        $newPosition = $position[1];

        $update = $dbconn->prepare("UPDATE social_links SET social_link_position = :p WHERE social_link_id = :i ");
        $update->execute([':p' => $newPosition , ':i' => $index]);
        if ($update->rowCount()) {
        	
        }
	}
?>