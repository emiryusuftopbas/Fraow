$( document ).ready(function() {
	var $uploadCrop;
      
	function readFile(input) {
		var fileInput = input;
		var filePath = fileInput.value;
		var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
		if(!allowedExtensions.exec(filePath)){
			swal('error' , 'Please upload file having extensions .jpeg/.jpg/.png/.gif only.','error');
			fileInput.value = '';
			return false;
		}else{
			if (input.files && input.files[0]) {
				var reader = new FileReader();          
				reader.onload = function (e) {
					$uploadCrop.croppie('bind', {
						url: e.target.result
					});
					$('.upload-demo').addClass('ready');
				}           
				reader.readAsDataURL(input.files[0]);
				$("#Croppie").show();
				$("#UploadCroppedImage").show();
			}
		}
	}

	$uploadCrop = $('#Croppie').croppie({
		enableExif: true,
				viewport: {
					width: 96,
					height: 96,
					type: 'circle'
				},
				boundary: {
					width: 200,
					height: 200
				}

	});

	$('#uploadImageCroppie').on('change', function () {
		 console.log("On change çalıştı");
		 readFile(this);
	 });
	$('#UploadCroppedImage').on('click', function (ev) {
		$uploadCrop.croppie('result', {
			type: 'canvas',
			size: 'original'
		}).then(function (resp) {
			$("#imagePreviewCroppie").attr('src',resp);
			var image ={ "profileimage": resp };
			$.ajax({
				type : 'POST',
				url: 'core/setprofilphoto.php',
				data: image,
				success : function(msg){
					if ($.trim(msg) == 'unsuccessful' ){
						swal('Profile Image Upload Unsuccessful','Please report us and try again','error');
					}else if ($.trim(msg) == 'successful'){
						swal('Profile Image Upload Successful', 'Profile image successfully added', 'success');
						setTimeout(function() {
							window.location = '/myapp/settings';
						}, 400);
					}else if ($.trim(msg) == 'updated'){
						swal('Profile Image Update Successful', 'Profile image successfully updated', 'success');
						setTimeout(function() {
							window.location = '/myapp/settings';
						}, 400);
					}
				}

			});
		});
	});

});
