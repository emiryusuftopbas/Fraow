(function() {
	var burger = document.querySelector('.burger');
	var nav = document.querySelector('#'+burger.dataset.target);
	burger.addEventListener('click',function() {
	burger.classList.toggle('is-active');
	nav.classList.toggle('is-active');
	});
})();


try{
	var signinModalButton = document.getElementById('signinModalButton');
	var signinModal = document.getElementById('signinModal');
	var signinModalClose = document.getElementById('signinModalClose');
	signinModalButton.onclick = function() {
		signinModal.style.display = 'block';
	}
	signinModalClose.onclick = function() {
		signinModal.style.display = 'none';
	}
}catch(e){
	console.log('You leapt from crumbling bridges watching cityscapes turn to dust');
}


try{
	var signupModalButton = document.getElementById('signupModalButton');
	var signupModal = document.getElementById('signupModal');
	var signupModalClose = document.getElementById('signupModalClose');
	signupModalButton.onclick = function(){
		signinModal.style.display = 'none';
		signupModal.style.display = 'block';
	}
	signupModalClose.onclick = function(){
		signupModal.style.display = 'none';
	}
}catch(e){
	console.log('Filming helicopters crashing in the ocean from way above');
}

try{
	var forgotPasswordModal = document.getElementById('forgotPasswordModal');
	var forgotPasswordModalButton = document.getElementById('forgotPasswordModalButton');
	var forgotPasswordClose = document.getElementById('forgotPasswordClose');
	forgotPasswordModalButton.onclick = function(){
		forgotPasswordModal.style.display = 'block';
		signinModal.style.display = 'none';
	}
	forgotPasswordModalClose.onclick = function(){
		forgotPasswordModal.style.display = 'none';
	}
	
}catch(e){
	console.log('Got the music in you baby,');
}

try{
	var userMenuDropdownButton = document.getElementById('userMenuDropdownButton');
	var userMenuDropdown = document.getElementById('userMenuDropdown');
	var userMenuDropdownMain = document.getElementById("userMenuDropdownMain");

	userMenuDropdownButton.onclick = function(){
		userMenuDropdownMain.classList.toggle("is-active");
	}
}catch(e){
	console.log("L-l-lick like a salad bowl, Edgar Allen Poe ");
}

try{
	window.onclick = function(event) {
		var modals = document.getElementsByClassName('modal');
		for(var i =0; i<modals.length; i++){
			if(event.target.className == 'modal-background'){
				modals[i].style.display = 'none';
			}
		}
		
	}
}catch(e){
	console.log('Tell me why');
}

try{
	var backToModalArrowButtons = document.getElementsByClassName('backToModalArrowButton');
	for(var i =0; i<backToModalArrowButtons.length; i++){
		backToModalArrowButtons[i].onclick = function(){
		if (signupModal.style.display == 'block') {
			signupModal.style.display = 'none';
			signinModal.style.display = 'block';
		}else if(forgotPasswordModal.style.display == 'block'){
			forgotPasswordModal.style.display = 'none';
			signinModal.style.display = 'block';
		}
	}
}
}catch(e){
	console.log('js is awesome =D' + e)
}
try{
	$(function() {
	$("#socialnetworkname").on("change", function() {
	var snt = $("#socialnetworkname").val();
	var mobilephonemask = "+99-999-999-99-99";
	var homephonemask = "+99-999-999-99-99";
	if(snt == "mobilephone"){
		$("#socialnetworkvalue").val('');
		$("#socialnetworkvalue").attr("type","text");
		$("#socialnetworkvalue").mask(mobilephonemask);
	}else if(snt == "homephone"){
		$("#socialnetworkvalue").val('');
		$("#socialnetworkvalue").attr("type","text");
		$("#socialnetworkvalue").mask(homephonemask);
	}else if(snt == "whatsapp"){
		$("#socialnetworkvalue").val('');
		$("#socialnetworkvalue").attr("type","text");
		$("#socialnetworkvalue").mask(mobilephonemask);
	}else if(snt == "email"){
		$("#socialnetworkvalue").val('');
		$("#socialnetworkvalue").unmask();
		$("#socialnetworkvalue").attr("type","email");
	}else{
		$("#socialnetworkvalue").unmask();
		$("#socialnetworkvalue").attr("type","text");
	}


	}).trigger("change");
});

}catch(e){
	console.log('Dont need to deny the hurt and the lies');
}

