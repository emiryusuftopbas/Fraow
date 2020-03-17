<?php
	$dbconn = $db->connect();
	$username = getUserDataById('user_username',session('user_id'),$dbconn);
	$email = getUserDataById('user_email',session('user_id'),$dbconn);
	$db->disconnect();
?>
<script>
	function sendticket(){
		var sendTicketFormData = $('#sendTicketForm').serialize();
		$.ajax({
			type : 'POST',
			data : sendTicketFormData,
			url : 'core/sendticket.php',
			success: function(msg){
				console.log(msg);
				if ($.trim(msg) == 'empty') {
					swal('Fields empty' , 'Please fill required fields','warning');
				}else if($.trim(msg) == 'usernameandemailmismatch'){
					swal('Username and email mismatch' , 'Please type correct information','error');
				}else if($.trim(msg) == 'messagelengtherror'){
					swal('Message length error :( ' , 'Message cannot be more than 300 characters', 'warning');
				}else if($.trim(msg) == 'ticketalreadyopen'){
					swal('You already sent message', 'Your help ticket is open , please wait until we resolve your problem', 'warning');
				}else if($.trim(msg) == 'unsuccessful'){
					swal('Oops', 'Something went wrong please try again later', 'error');
				}else if($.trim(msg) == 'successful'){
					swal('Successfull' , 'Your message successfully send','success');
				}
			}
		});
	}
</script>
<div class="hero-body">
	<div class="container">
		<div class="columns ">
			<div class="column is-half is-offset-one-quarter">
				<div class="box">
					<form class="form" action="" method="POST" onsubmit="return false" id="sendTicketForm">
						<div class="field">
							<label class="label">Username</label>
							<div class="control">
								<input class="input" type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" >
							</div>
						</div>
						<div class="field">
							<label class="label">Email</label>
							<div class="control">
								<input class="input" type="text" placeholder="Email" name="email" value="<?php echo $email;?>"  >
							</div>
						</div>
						<div class="field">
							<label class="label">Message</label>
							<div class="control">
								<textarea maxlength="300" class="textarea" name="message" placeholder="What is your problem please tell us , after reporting we are going to try to fix it."></textarea>
							</div>
						</div>
						<div class="field">
							<div class="center">
								<div class="control">
							    	<button class="button is-link" onclick="sendticket()">Send report</button>
								</div>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>