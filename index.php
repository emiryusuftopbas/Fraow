<?php

require_once 'core/config.php';
require_once 'view/header.php'; 
	$dbconn = $db->connect();

	$index = 'view/index.php';
	$dashboard = 'view/dashboard/dashboard.php';
	
	$par = trim(get('u')); 
	$par = array_filter(explode('/', $par));

	if (@function_exists($par[0])) {
		call_user_func($par[0], $par, $db);
	}else if(!empty($par[0])){
		$usercontrol = $dbconn->prepare('SELECT * FROM users where user_username =:u');
		$usercontrol->execute([':u' => $par[0]]);
		$db->disconnect();
		if ($usercontrol->rowCount()) {
			$dashboard = null;
			$index = null;
			@require_once 'profile.php';
		}else{
			$dashboard = null;
			$index = null;
			@require_once 'view/404.php';
		}
	}


	function signout($par,$db){
		if (session('loginsession')) {
			session_destroy();
			header("location:".route('dirname'));
		}
	}
	function settings($par,$db){
		$dashboardSettings = 'view/dashboard/settings.php';
		if (session('loginsession')) {
			$dashboard=null;
		    require_once $dashboardSettings;
		}
	}
	function profile($par,$db){
		$dashboardProfile = 'view/dashboard/profile.php';
		if (session('loginsession')){
			$dashboard=null;
		 	require_once $dashboardProfile;
		}
	}
	function help($par,$db){
		$dashboardHelp = 'view/dashboard/help.php';
		if (session('loginsession')) {
			$dashboard=null;
			require_once $dashboardHelp;
		}
	}
	function aboutus($par,$db){
		$aboutus = 'view/page/aboutus.php';
		$dashboard = null;
		$index = null;
		require_once $aboutus;
	}
	function ourcrew($par,$db){
		$aboutus = 'view/page/ourcrew.php';
		$dashboard = null;
		$index = null;
		require_once $aboutus;
	}
	function verify($par,$db){
		$dbconn = $db->connect();

		$encodedemail = @$par[1];
		$encodedusername = @$par[2]; 
		$decodedemail = decode($encodedemail);
		$decodedusername = decode($encodedusername);
		if (!empty($encodedemail) && !empty($encodedusername)) {
			$verifycontrol = $dbconn->prepare("SELECT * FROM users WHERE user_username = :e AND user_verification = :v");
			$verifycontrol->execute([':e' => $decodedusername , ':v' => 0]);
			if ($verifycontrol->rowCount()) {
				$verifyaccount = $dbconn->prepare("UPDATE users SET user_email = :e , user_verification = :v WHERE user_username = :u");
				$verifyaccount->execute([':e' => $decodedemail , ':v' => 1 , ':u' => $decodedusername]);
				if ($verifyaccount->rowCount()) {
					echo "<script>alert('Your account successfuly verified');</script>";
					header("Refresh:1; url=".route('dirname'));
				}else{
					echo "<script>alert('Something went wrong try again');</script>";
					header("Refresh:1; url=".route('dirname'));
				}
			}else{
				echo "<script>alert('already verified');</script>";
				header("Refresh:1; url=".route('dirname'));	
			}
		}
		
	}


if (session('loginsession') && empty($par[0]) && empty($par[1])) {
	@include_once $dashboard;
}else if(empty($par[0]) && empty($par[1])){
	@include_once $index;
}
require_once 'view/footer.php';
?>
