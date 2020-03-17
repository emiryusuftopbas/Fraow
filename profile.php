<?php
	
	$username = $par[0];
	$dbconn = $db->connect();


	$getUser = $dbconn->prepare("SELECT * FROM users WHERE user_username = :u");
	$getUser->execute([':u' => $username]);
	$user;
	if ($getUser->rowCount()) {
		$user = $getUser->fetch(PDO::FETCH_OBJ);
	}else{
		echo 'user not found';
	}
	$userId = $user->user_id;
	
	$getUserDetails = $dbconn->prepare("SELECT * FROM users_details WHERE user_id = :i");
	$getUserDetails->execute([':i' => $userId]);
	$userDetails;
	if ($getUserDetails->rowCount()) {
		$userDetails = $getUserDetails->fetch(PDO::FETCH_OBJ);
	}else{
		
	}
	
	$getSocialLinks = $dbconn->prepare("SELECT * FROM social_links WHERE user_id = :i ORDER BY social_link_position");
	$getSocialLinks->execute([':i' => $userId]);
	if($getSocialLinks->rowCount()){
		$links = $getSocialLinks->fetchAll();
	}else{
		
	}
	$getProfilePhoto = $dbconn->prepare("SELECT * FROM users WHERE user_id = :i ");
	$getProfilePhoto->execute([':i' => $userId]);
	if ($getSocialLinks->rowCount()) {
		$profilePhotoRow = $getProfilePhoto->fetch(PDO::FETCH_OBJ);
		$profilePhoto = $profilePhotoRow->user_profileimage;
		if(empty($profilePhoto)){
			$profilePhoto = route('dirname').'/assets/images/empty.png';
		}
	}

	$db->disconnect();
?>
<div class="container">
	<div class="columns is-vcentered">
		<div class="column is-3">
			
		</div>
		<div class="column is-6">
			<div class="box is-box-transparent">
				<div class="column">
					<div class="columns">
						<div class="column is-3">
							<figure class="image is-96x96" id="profilePhoto">
								<img class="is-rounded" src="assets/profileimages/<?php echo $profilePhoto; ?>" >
							</figure>
						</div>
						<div class="column is-9">
							<div id="userDetails">
								<div class="name"><h5 class="is-size-5 is-first-upper"><?php echo $user->user_fullname; ?></h5></div>
								<div class="username"><h6 class="is-size-6 has-text-grey-dark has-text-weight-semibold  ">@<?php echo $user->user_username; ?></h6></div>
								<div class="about">
								<p style="white-space: pre-line">
								<?php echo $userDetails->user_about; ?>
								</p>
							</div>
							</div>
						</div>
					</div>
				</div>
				<div class="column">
					<div id="scrollableArea">
						<aside class="menu center">
							  <ul class="menu-list">
							  	<?php
							  		foreach ($links as $link) {?>
							    <li><a target="_blank"  href="<?php echo getSocialLinkHref($dbconn,$link['social_link_type'], $link['social_link_value']); ?>"><i class="<?php echo getSocialIcon($dbconn,$link['social_link_type']); ?>" aria-hidden="true" ></i>&nbsp;<?php echo $link['social_link_value'];?></a></li>
							    <?php } ?>
							</ul>
							</aside>
					</div>	
				</div>
			</div>
	
	<div class="column is-3">
		
	</div>
</div>
</div>
</div>