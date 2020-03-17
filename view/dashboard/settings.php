<?php

	$dbconn = $db->connect();
	$sessionid = session('user_id');
	$vsd = getUserDataById('user_verification',$sessionid,$dbconn);
	$email = session('user_email');
	function verificationStatus($verificationstatusdata){
		if($verificationstatusdata == 1){
			echo 'disabled="true"';
		}
	}
	$fullname = getUserDataById('user_fullname',$sessionid,$dbconn);
	$gender = getUserDetailsById('user_gender',$sessionid,$dbconn);
	$about = getUserDetailsById('user_about',$sessionid,$dbconn);
	function genderStatus($gender,$at){
		if (trim($gender) == 'male' && $at=='male') {
			echo 'selected';
		}else if(trim($gender) == 'female' && $at=='female'){
			echo 'selected';
		}else{
			echo 'selected"';
		}
	}
	$currentProfileImage = getCurrentProfileImage($dbconn,$sessionid);
	
	$db->disconnect();
?>
<script type="text/javascript">
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    function changePassword(){
		var changepassworddata = $('#changePasswordForm').serialize();
		$.ajax({
			type : 'POST' ,
			data: changepassworddata,
			url : 'core/changepassword.php',
			success : function(msg){
				if ($.trim(msg) == 'empty' ) {
					swal('Error','Please fill required fields','error');
				}else if($.trim(msg) == 'paswordmismatch'){
					swal('Error' , 'Paswords doesnt match try again' , 'error');
				}else if($.trim(msg) == 'emailnotfound'){
					swal('Error' , 'Email not found in our system' , 'error');
				}else if($.trim(msg) == 'passwordlengtherr'){
					swal('Password length error' , 'Password length cannot be less than 8' , 'error');
				}else if($.trim(msg) == 'currentpasswordmismatch'){
					swal('Current pasword mismatch' , 'Your current password is wrong' , 'error');
				}else if($.trim(msg) == 'unsuccessful'){
					swal('oops' , 'Something wents wrong try again' , 'error');
				}else if($.trim(msg) == 'successful'){
					swal('Succesful' , 'Your password successfuly changed' , 'success');
					setTimeout(function(){
					window.location = baseUrl+'/settings';
					}, 400);
				}
			}
		});
	}
	function verifyAccount(){
		var verifyaccountdata = $('#verifyAccountForm').serialize();
		$.ajax({
			type : 'POST',
			data : verifyaccountdata,
			url : 'core/verifyaccount.php',
			success: function(msg){
				console.log(msg);
				if($.trim(msg) == 'empty'){
					swal('Error','Please fill required fields','error');
				}else if($.trim(msg) == 'emailtypemismatch'){
					swal('Wrong email' , 'Please enter valid email' , 'error');
				}else if($.trim(msg) == 'usedemail'){
					swal('Wrong email' , 'Email in use' , 'error');
				}else if($.trim(msg) == 'fakeemail'){
					swal('Fake email' , 'Please enter real email' , 'error');
				}else if($.trim(msg) == 'accountalreadyverified'){
					swal('Already verified' , 'Your account already verified' , 'error');
				}else if($.trim(msg) == 'successful'){
					swal('Successful' , 'Email sended to your mail adress , dont forget to check spam box' , 'success');
				}else if($.trim(msg) == 'unsuccessful'){
					swal('Error' , 'Email sending error try again' , 'error');
				}
			}
		});
	}
	function updateUserData(){
		var updateuserdata = $('#updateUserDataForm').serialize();
		$.ajax({
			type : 'POST',
			data : updateuserdata,
			url : 'core/updateuserdata.php',
			success : function(msg){
				console.log(msg);
				if ($.trim(msg) == 'successful') {
					swal('Update successful' , 'Information updated successfuly','success');
					setTimeout(function(){
					window.location = baseUrl'/settings';
					}, 700);
				}else if($.trim(msg) == 'nothingupdated'){
					swal('You didnt changed anything ?' , 'You need change something to update','warning');
				}else if($.trim(msg) == 'unsuccessful'){
					swal('Something went wrong' , 'Something went wrong try again and report error us','error');
					setTimeout(function(){
					window.location = baseUrl+'/settings';
					}, 700);
				}
			}
		});
	}


</script>

<div class="hero-body">
	<div class="container" id="SettingsContainer">
		<div class="columns  is-vcentered">
			<div class="column auto">
				<div class="box">
					<form action="" method="POST" onsubmit="return false" id="changePasswordForm">
						<div class="field">
							<div class="control">
								<input class="input" type="text" placeholder="Current password" name="currentpassword">
							</div>
						</div>
						<div class="field">
							<div class="control">
								<input class="input" type="password" placeholder="New password" name="newpassword">
							</div>
						</div>
						<div class="field">
							<div class="control">
								<input class="input" type="password" placeholder="Confirm password" name="confirmpassword">
							</div>
						</div>
						<div class="center">
							<button class="button is-link" onclick="changePassword()">Change password</button>
						</div>
					</form>
				</div>
				<div class="box">
					<form action="" method="POST" onsubmit="return false" id="verifyAccountForm">
						<div class="field">
							<label class="label is-size-7">Email</label>
							<div class="control">
								<input class="input" type="text" value="<?php echo $_SESSION['user_email']; ?>" placeholder="Email" name="email" <?php verificationStatus($vsd); ?> >
							</div>
						</div>
						<div class="center">
							<button class="button is-link" onclick="verifyAccount()" <?php verificationStatus($vsd); ?>>Verify account</button>
						</div>
					</form>
				</div>
			</div>
			<div class="column auto">
				<div class="box">
					<form action="" method="POST" onsubmit="return false" id="updateUserDataForm">
						<div class="field">
							<label class="label is-size-7">Full name</label>
							<div class="control">
								<input class="input" type="text" placeholder="Full name" value="<?php echo $fullname; ?>" name="name">
							</div>
						</div>
						<div class="field">
							<label class="label is-size-7">Gender</label>
							<div class="control">
								<div class="select"   >
									<select name="gender">
										<option <?php genderStatus($gender,'unknown'); ?> value="unknown">I dont want to specify</option>
										<option <?php genderStatus($gender,'male');?> >Male</option>
										<option <?php genderStatus($gender,'female');?> >Female</option>
									</select>
								</div>
							</div>
						</div>
					
					
						<div class="field">
							<label class="label is-size-7">About you (max 40 characters)</label>
							<div class="control">
								<textarea class="textarea" rows="3" name="about"><?php echo $about?> </textarea>
								<!-- <<input class="input" type="text" value="<?php echo $about?>" placeholder="" name="about"> -->
							</div>
						</div>
						<div class="center">
							<button class="button is-link" onclick="updateUserData()">Update</button>
						</div>
					</form>
				</div>
			</div>
			<div class="column auto">
				<div class="box ">
					<div id="profilPhotoImagePreview" class="center" style="margin-bottom: 10px;">
						<figure class="image is-96x96" id="profilePhoto">
							<img class="is-rounded" id="imagePreviewCroppie" src="./assets/profileimages/<?php echo $currentProfileImage ?>"  >
						</figure>
					</div>

					<form id="form1"  method="POST" onsubmit="return false;">
						<div class="file center" style="margin-bottom:10px;">
							<label class="file-label">
								<input class="file-input" type="file" name="resume" id="uploadImageCroppie">
								<span class="file-cta">
								<span class="file-icon">
									<i class="fa fa-upload"></i>
								</span>
								<span class="file-label">
									Choose profile picture
								</span>
								</span>
							</label>
						</div>
					<div id="Croppie"></div>
					</form>
					<div class="center">
						<button id="UploadCroppedImage" class="button is-link">Upload</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
