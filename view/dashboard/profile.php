<?php
    require realpath('.').'/core/config.php';
	$dbconn = $db->connect();
?>
<script>
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

function addLinkToProfile() {
    var addLinkToProfileData = $('#addSocialLinkForm').serialize();
    $.ajax({
        type: 'POST',
        data: addLinkToProfileData,
        url: 'core/addsociallink.php',
        success: function(msg) {
            console.log(msg);
            if ($.trim(msg) == 'empty') {
                swal('Empty', 'please fill required areas', 'warning');
            } else if ($.trim(msg) == 'unknownsocialnetworktype') {
                swal('Unkown Social Network', 'Please select a valid social network', 'error');
            } else if ($.trim(msg) == 'unsupportedsocialnetwork') {
                swal('Unsupported social network',
                'The selected social network is temporary disabled in our system try different one',
                'error');
        } else if ($.trim(msg) == 'notusernameorpassword') {
            swal('Url or username format is wrong !',
                'The valid url format is http://facebook.com/example , and username must be alpha numeric',
                'warning');
            } else if ($.trim(msg) == 'phonenumberformaterr') {
                swal('Phone number format error', 'Correct phone number pattern is: +90 555 55 55',
                    'warning');
            } else if ($.trim(msg) == 'emailtypemismatch') {
                swal('Email type is wrong', 'Please type correct email adress', 'error');
            } else if ($.trim(msg) == 'successful') {
                swal('Successful', 'Link added to your profile', 'success');
                setTimeout(function() {
                    window.location = baseUrl+'/profile';
                }, 400);
            } else if ($.trim(msg) == 'unsuccessful') {
                swal('Unsuccessful', 'Something went wrong try again later and please report us', 'error');
            }
        }
    });

}
</script>
<div class="hero-body">
    <div class="container">
        <div class="columns is-vcentered">
            <div class="column is-3">
                <div class="box">
                    widgets are unavaible at beta
                </div>
            </div>
            <div class="column is-6">
                <div class="box ">
                    <form class="form" action="" method="POST" onsubmit="return false" id="addSocialLinkForm">
                        <div class="columns">
                            <div class="column is-4">
                                <div class="field">
                                    <label class="label center">Type</label>
                                    <div class="control" id="select">
                                        <div class="select">
                                            <select name="socialnetworkname" id="socialnetworkname">
                                                <option value="empty">Select one</option>
                                                <?php
													getAsnDisplayNames($dbconn);
												?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-6">
                                <div class="field">
                                    <label class="label center">Value</label>
                                    <div class="control">
                                        <input class="input" type="text" id="socialnetworkvalue"
                                            placeholder="Enter your profile url or username" name="socialnetworkvalue">
                                    </div>
                                </div>
                            </div>
                            <div class="column is-2">
                                <div class="field">
                                    <div class="control">
                                        <label class="label center" style="visibility: hidden;">.</label>
                                        <div class="center">
                                            <button class="button is-link" onclick="addLinkToProfile()">add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- a -->
                <div class="box center">

                <div style="width:100%;height:250px;overflow:-moz-scrollbars-vertical;overflow-y:auto;">

                    <table class="table is-striped is-narrow is-hoverable is-fullwidth">
                        <thead>
                            <tr>
                               <th>Icon</th>
								<th>Your Social Links</th>
								<th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            <?php getAllSocialLinksForDashboard(); ?>
                          
                        </tbody>
                    </table>
                    
                </div>
            </div>
            </div>

            <div class="column is-3">
                <div class="box">
                    widgets are unavaible at beta
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    function deleteLinkFromProfile(socialLinkId) {
        var data = {};
        data['sociallinkid'] = socialLinkId;
        $.ajax({
            type : 'POST',
            data : data,
            url : 'core/deletesociallink.php',
            success : function(msg){
                console.log(msg);
                if ($.trim(msg) == 'unsuccessful') {
                    swal('Unsuccessful', 'Something went wrong please try again', 'error');
                } else if ($.trim(msg) == 'linkdoesntfound') {
                    swal('Social link doesnt found ', 'Your are trying to delete sociallink already deleted or link doesnt belongs to you', 'error');
                }else if($.trim(msg) == 'successful' ){
                    swal('Successful', 'Link deleted from your profile', 'success');
                    setTimeout(function() {
                        window.location = baseUrl+'/profile';
                    }, 400);   
                }
            }
        });
}
</script>