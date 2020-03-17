<script>
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    function signin(){
		var signindata = $('#signinform').serialize();
		$.ajax({
			type : 'POST' ,
			data: signindata,
			url : 'core/signin.php',
			success : function(msg){
				console.log(msg);
				if ($.trim(msg) == 'empty' ) {
					swal('error','please fill required fields','error');
				}else if($.trim(msg) == 'successful'){
					swal('successful' , 'sign in successful' , 'success');
					setTimeout(function(){
					window.location = baseUrl;
					}, 700);
				}else if($.trim(msg) == 'unsuccessful'){
					swal('unsuccessfull' , 'check your username and password and try again' , 'error');
				}else{
					swal('unsuccessfull' , 'something went wrong' , 'error');
				}
			}
		});
	}
	function signup() {
		var signupdata = $('#signupform').serialize();
		$.ajax({
			type : 'POST' ,
			data : signupdata ,
			url : 'core/signup.php',
			success : function(msg){
				if ($.trim(msg) == 'empty' ) {
					setTimeout(function(){
					swal('Error','Please fill required fields','error');
							}, 500);
				}else if($.trim(msg) == 'success'){
					setTimeout(function(){
					swal('Successful' , 'Sign up successful' , 'success');
								}, 500);
					setTimeout(function(){
					window.location = baseUrl;
					}, 700);
				}else if($.trim(msg) == 'passwordmismatch'){
					setTimeout(function(){
					swal('Password mismatch' , 'Retype password and try again' , 'error');
					}, 500);
				}else if($.trim(msg) == 'passwordlengtherr'){
					setTimeout(function(){
					swal('Password length error' , 'Password length cannot be less than 8' , 'error');
					}, 500);
				}else if($.trim(msg) == 'emailtypemismatch'){
					setTimeout(function(){
					swal('Wrong email' , 'Please enter valid email' , 'error');
					}, 500);
				}else if($.trim(msg) == 'fakeemail'){
					setTimeout(function(){
					swal('Fake email' , 'Please enter real email' , 'error');
					}, 500);
				}else if($.trim(msg) == 'usedemail'){
					setTimeout(function(){
					swal('Wrong email' , 'Email in use' , 'error');
					}, 500);
				}else if($.trim(msg) == 'usedusername'){
					setTimeout(function(){
					swal('Wrong username' , 'Username in use' , 'error');
					}, 500);
				}else if($.trim(msg) == 'usedemailandusername'){
					setTimeout(function(){
					swal('Wrong username and password' , 'Username and email in use' , 'error');
					}, 500);
				}else if($.trim(msg) == 'usernametypemismatch'){
					setTimeout(function(){
					swal('Wrong username' , 'Username must be alfa-numeric' , 'error');
					}, 500);
				}else if($.trim(msg) == 'dberror'){
					setTimeout(function(){
					swal('System error' , 'System error try again' , 'error');
					}, 500);
				}
			}
		});
	}


	function renewpassword() {
		var renewData = $('#forgotPasswordForm').serialize();
		$.ajax({
			type : 'POST' ,
			data : renewData,
			url  : 'core/renewpassword.php',
			success: function(msg){
				if ($.trim(msg) == 'empty' ) {
					swal('Error','Please enter a email','error');
				}else if($.trim(msg) == 'emailtypemismatch'){
					swal('Error' , 'Please enter a valid email' , 'error');
				}else if($.trim(msg) == 'emailnotfound'){
					swal('Error' , 'Email not found in our system' , 'error');
				}else if($.trim(msg) == 'unsuccessful'){
					swal('oops' , 'Something went wrong try again' , 'error');
				}else if($.trim(msg) == 'successful'){
					swal('Succesful' , 'Your new password sent to your email adress' , 'success');
					setTimeout(function(){
					window.location = baseUrl;
					}, 600);
				}
			}
		});
	}

</script>		
<!-- sign in modal -->
<div class="modal" id="signinModal">
	<div class="modal-background"></div>
	<div class="modal-content">
		<div class="section modal-wrap">
			<div class="box">
				<div class="center mb10">
					<h3 class="title is-5">Sign In</h3>
				</div>
				<form action="" method="POST" onsubmit="return false" id="signinform">
					<div class="field">
						<div class="control">
							<input class="input" type="text" placeholder="Username" name="username">
						</div>
					</div>
					<div class="field">
						<div class="control">
							<input class="input" type="password" placeholder="Password" name="password">
						</div>
					</div>
					<div class="columns is-mobile">
						<div class="column is-5 is-size-7">
							<label class="checkbox" class="">
								<input type="checkbox" checked="true" disabled="true">
								Remember me
							</label>
						</div>
						<div class="column is-7">
							<a href="#" class="is-link has-text-grey-dark" id="forgotPasswordModalButton"><p class="has-text-right is-size-7">Did you forget your password ?</p></a>
						</div>
					</div>
					<div class="center">
						<button class="button" onclick="signin()">Sign in</button>
					</div>
					<br>
					<div class="center">
						<p>Don't you have an account ? <a href="#" class="has-text-info" id="signupModalButton">sign up</a> </p>
					</div>
				</form>
			</div>
		</div>
	</div>
	<button class="modal-close is-large" aria-label="close" id="signinModalClose"></button>
</div>
<!-- sign in modal -->

<!-- signup modal -->
<div class="modal" id="signupModal">
	<div class="modal-background"></div>
	<div class="modal-content">
		<div class="section modal-wrap">
			<div class="box">
				<a href="#" class="backToModalArrowButton"><b><i class="fa fa-arrow-circle-o-left fa-lg" aria-hidden="true"></i></b></a>
				<div class="center mb10" >
					<h3 class="title is-5">Sign Up</h3>
				</div>
				<form action="" method="POST" onsubmit="return false" id="signupform">
					<div class="field">
						<div class="control">
							<input class="input" type="text" placeholder="Name" name="name">
						</div>
					</div>
					<div class="field">
						<div class="control">
							<input class="input" type="text" placeholder="Username" name="username">
						</div>
					</div>
					<div class="field">
						<div class="control">
							<input class="input" type="email" placeholder="Email" name="email">
						</div>
					</div>
					<div class="field">
						<div class="control">
							<input class="input" type="password" placeholder="Password" name="password">
						</div>
					</div>
					<div class="field">
						<div class="control">
							<input class="input" type="password" placeholder="Confirm password" name="confirmpassword">
						</div>
					</div>
					
					<div class="center">
						<button class="button is-success" onclick="signup()">Sign Up</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<button class="modal-close is-large" aria-label="close" id="signupModalClose"></button>
</div>
<!-- signup modal -->

<!-- forgot password modal -->
<div class="modal" id="forgotPasswordModal">
	<div class="modal-background"></div>
	<div class="modal-content">
		<div class="section modal-wrap">
			<div class="box">
				<a href="#" class="backToModalArrowButton"><b><i class="fa fa-arrow-circle-o-left fa-lg" aria-hidden="true"></i></b></a>
				<div class="center mb10">
					<h3 class="title is-5">Did you forgot your password ?</h3>
				</div>
				<br>
				<br>
				<form action="" method="POST" onsubmit="return false" id="forgotPasswordForm">
					<div class="field">
						<div class="control">
							<input class="input" type="text" placeholder="email" name="email">
						</div>
					</div>
					<p class="is-small center">Wait for the message after pressing the button</p>
					<br>
					<div class="center">
						<button class="button is-success" onclick="renewpassword()">Renew your password</button>
					</div>
					<br>
				</form>
			</div>
		</div>
	</div>
	<button class="modal-close is-large" aria-label="close" id="forgotPasswordModalClose"></button>
</div>
<!-- forgot password modal -->