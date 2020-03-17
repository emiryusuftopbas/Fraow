<?php
require_once 'config.php';	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function route($req){
	$dirname = dirname($_SERVER['SCRIPT_NAME']);
	$basename = basename($_SERVER['SCRIPT_NAME']);
	$requesturi = str_replace([$dirname,$basename],null,$_SERVER['REQUEST_URI']);
	switch ($req) {
		case 'dirname':
			return $dirname;
			break;
		case 'basename':
			return $basename;
			break;
		case 'requesturi':
			return $requesturi;
			break;
		default:
			return '';
			break;
	}
}

function checkFakeEmail($email){
	$domain = strstr($email, '@');
	$domain1 = substr($domain, 1 , strlen($domain));
	
	$read = fopen("fakemaillist.txt","r"); 
	
	while (!feof($read)) {
		$row = fgets($read);
		if (trim($row) == $domain1) {
			return false;
		}
	}
	fclose($read);
	return true;
}
function checkUsername($username) {
	$username = strtolower($username);
	$bannedwords = array("settings", "profile","aboutus","signout","analyze","staticts","help","dashboard","index");
	$search_array = array_combine(array_map('strtolower', $bannedwords), $bannedwords);
    $allowed = array(".", "-", "_");
    $length = strlen($username);
    if(ctype_alnum(str_replace($allowed, '', $username )) && $length>=5 && !@$search_array[$username]) {
        return true;
    } else {
        return false;
    }
}
function checkPassword($password){
	$length = strlen($password);
	if ($length>=8) {
		return true;
	}else{
		return false;
	}
}
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); 
    $alphaLength = strlen($alphabet) - 1; 
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); 
}

function sendEmail($email,$name,$senderemail,$sendername,$subject,$message){
	require_once 'classes/PHPMailer/src/PHPMailer.php';
	require_once 'classes/PHPMailer/src/SMTP.php';

	$mail = new PHPMailer(true);                             
	$mail->SMTPDebug = 0;                               
    $mail->isSMTP();                                      
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;                               
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = 'tls';                  
    $mail->Port = 587;
    $mail->SetLanguage("tr", "phpmailer/language");
    $mail->CharSet  ="utf-8";
	$mail->SetFrom($senderemail, $sendername);			
	$mail->AddAddress($email, $name);
    $mail->ClearReplyTos();		
	$mail->IsHTML(true);										
	$mail->Subject = $subject;				
	$mail->Body = $message;
	if($mail->Send()){
		return true;
	}else{
		return false;
	}			
}
function emailMessage($message,$footermessage,$isbutton=false ,$buttontext ='',$buttonlink=''){
	$button = '  <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary center">
       <tbody>
         <tr>
           <td align="left">
             <table role="presentation" border="0" cellpadding="0" cellspacing="0">
               <tbody>
                 <tr>
                   <td> <a href="'.$buttonlink.'" target="_blank">'.$buttontext.'</a> </td>
                 </tr>
               </tbody>
          </table>';
	if (!$isbutton) {
		$button = '';
	}
	
	$messageheader =
	'<!doctype html><html> <head> <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <meta name="viewport" content="width=device-width"/> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> <title>email</title> <style>body,table td{font-size:14px}.body,body{background-color:#f6f6f6}body,h1,h2,h3,h4{line-height:1.4;font-family:sans-serif}body,h1,h2,h3,h4,ol,p,table td,ul{font-family:sans-serif}.btn,.btn a,.content,.wrapper{box-sizing:border-box}.btn a,h1{text-transform:capitalize}.align-center,.btn table td,.footer,h1{text-align:center}.clear,.footer{clear:both}img{border:none;-ms-interpolation-mode:bicubic;max-width:100%}body{-webkit-font-smoothing:antialiased;margin:0;padding:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}.container,.content{display:block;max-width:580px;padding:10px}table{border-collapse:separate;mso-table-lspace:0;mso-table-rspace:0;width:100%}table td{vertical-align:top}.body{width:100%}.btn a,.btn table td{background-color:#fff}.container{margin:0 auto!important;width:580px}.btn,.footer,.main{width:100%}.content{margin:0 auto}.main{background:#fff;border-radius:3px}.wrapper{padding:20px}.content-block{padding-bottom:10px;padding-top:10px}.footer{margin-top:10px}.footer a,.footer p,.footer span,.footer td{color:#999;font-size:12px;text-align:center}h1,h2,h3,h4{color:#000;font-weight:400;margin:0 0 30px}.btn a,a{color:#3498db}h1{font-size:35px;font-weight:300}.btn a,ol,p,ul{font-size:14px}ol,p,ul{font-weight:400;margin:0 0 15px}.first,.mt0{margin-top:0}.last,.mb0{margin-bottom:0}ol li,p li,ul li{list-style-position:inside;margin-left:5px}a{text-decoration:underline}.btn a,.powered-by a{text-decoration:none}.btn>tbody>tr>td{padding-bottom:15px}.btn table{width:auto}.btn table td{border-radius:5px}.btn a{border:1px solid #3498db;border-radius:5px;cursor:pointer;display:inline-block;font-weight:700;margin:0;padding:12px 25px}.btn-primary a,.btn-primary table td{background-color:#3498db}.btn-primary a{border-color:#3498db;color:#fff}.align-right{text-align:right}.align-left{text-align:left}.preheader{color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;visibility:hidden;width:0}hr{border:0;border-bottom:1px solid #f6f6f6;margin:20px 0}@media only screen and (max-width:620px){table[class=body] h1{font-size:28px!important;margin-bottom:10px!important}table[class=body] a,table[class=body] ol,table[class=body] p,table[class=body] span,table[class=body] td,table[class=body] ul{font-size:16px!important}table[class=body] .article,table[class=body] .wrapper{padding:10px!important}table[class=body] .content{padding:0!important}table[class=body] .container{padding:0!important;width:100%!important}table[class=body] .main{border-left-width:0!important;border-radius:0!important;border-right-width:0!important}table[class=body] .btn a,table[class=body] .btn table{width:100%!important}table[class=body] .img-responsive{height:auto!important;max-width:100%!important;width:auto!important}}@media all{.btn-primary a:hover,.btn-primary table td:hover{background-color:#34495e!important}.ExternalClass{width:100%}.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td{line-height:100%}.apple-link a{color:inherit!important;font-family:inherit!important;font-size:inherit!important;font-weight:inherit!important;line-height:inherit!important;text-decoration:none!important}.btn-primary a:hover{border-color:#34495e!important} .center{ display: flex;justify-content: center;align-items: center;}}</style> </head> <body class=""> <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body"> <tr> <td>&nbsp;</td><td class="container"> <div class="content"> <table role="presentation" class="main"> <tr> <td class="wrapper"> <table role="presentation" border="0" cellpadding="0" cellspacing="0"> <tr> <td>';

	$messagebody = '  
    		 <p>'.$message.'</p>'.$button.'
           </td>
         </tr>
       </tbody>
     </table>           
	';

	$messagefooter = ' </td></tr></table> </td></tr></table> <div class="footer"> <table role="presentation" border="0" cellpadding="0" cellspacing="0"> <tr> <td class="content-block"> <span class="apple-link">'.$footermessage.'</span></td></tr></table></div></div></td><td>&nbsp;</td></tr></table> </body></html>';

	$message = $messageheader.$messagebody.$messagefooter;
	return $message;
}

function encode($value){
	$key = sha1('BurnInHell');
	if(!$value){
		return false;
	}
	$strLen = strlen($value);
	$keyLen = strlen($key);
	$j=0;
	$crypttext= '';
	for ($i = 0; $i < $strLen; $i++) {
		$ordStr = ord(substr($value,$i,1));
		if ($j == $keyLen) { $j = 0; }
			$ordKey = ord(substr($key,$j,1));
			$j++;
			$crypttext .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
	}
	return $crypttext;

}

function decode($value){
    if(!$value){return false;}
        $key = sha1('BurnInHell');
        $strLen = strlen($value);
        $keyLen = strlen($key);
        $j=0;
        $decrypttext= '';
        for ($i = 0; $i < $strLen; $i+=2) {
            $ordStr = hexdec(base_convert(strrev(substr($value,$i,2)),36,16));
            if ($j == $keyLen) { $j = 0; }
            $ordKey = ord(substr($key,$j,1));
            $j++;
            $decrypttext .= chr($ordStr - $ordKey);
        }

    return $decrypttext;
}
function hashPassword($password){
	$hashed1 = sha1(md5(md5(sha1(md5(md5(trim($password)))))));
	$hashed2 = mb_substr($hashed1, 0 , 32);
	return $hashed2;
}

function post($parameter,$condition=false){
	if ($condition == false) {
		$result = strip_tags(@$_POST[$parameter]);
	}else if ($condition == true) {
		$result = strip_tags(addslashes(@$_POST[$parameter]));
	}
	return $result;
}
function get($parameter,$condition=false){
	if ($condition == false) {
		$result = trim(strip_tags(@$_GET[$parameter]));
	}else if($condition == true){
		$result = addslashes(trim(strip_tags(@$_GET[$parameter])));
	}
	return $result;
}

function getUserDataById($data,$identifier,$db){
	$getuserdata = $db->prepare("SELECT * FROM users WHERE user_id = :i ");
	$getuserdata->execute([':i' => $identifier]);
	if ($getuserdata->rowCount()) {
		 $row = $getuserdata->fetch(PDO::FETCH_ASSOC);
		 return  $row[$data];
	}
}
function getUserDetailsById($data,$identifier,$db){
	$getuserdetail = $db->prepare("SELECT * FROM users_details WHERE user_id = :i");
	$getuserdetail->execute([':i' => $identifier]);
	if ($getuserdetail->rowcount()) {
		$row = $getuserdetail->fetch(PDO::FETCH_ASSOC);
		return $row[$data];
	}
}

function session($data){
	return @$_SESSION[$data];
}

function getAsnDisplayNames($dbconn){
	$getAsnDisplayName = $dbconn->prepare("SELECT * FROM available_social_networks  WHERE asn_status = :s");
	$getAsnDisplayName->execute([':s' => 1]);
	if ($getAsnDisplayName->rowCount()) {										
		while($row = $getAsnDisplayName->fetchObject()) {
			echo '<option value="'.$row->asn_name.'">'.$row->asn_display_name.'</option>';
		}
	}									
}
function validateUsername($str) 
{
    $allowed = array(".", "-", "_" ,"@"); 
    if(ctype_alnum(str_replace($allowed, '', $str ))) {
        return true;
    } else {
        return false;
    }
}
function validatePhoneNumber($phone)
{
	$filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
	$phone_to_check = str_replace("-", "", $filtered_phone_number);
	if (strlen($phone_to_check) == 13 ) {
	   return true;
	} else {
	  return false;
	}
}


function parseSocialLink($dbconn,$url,$socialnetworkname){
	$getAsnUrl = $dbconn->prepare("SELECT * FROM available_social_networks WHERE asn_name = :n");
	$getAsnUrl->execute([':n' => $socialnetworkname]);
	$row = $getAsnUrl->fetch(PDO::FETCH_OBJ);

	$asnUrl = $row->asn_url;

	$parsedUrl = @explode($asnUrl, $url);
	$parsedUrlWithSlash = @explode('/',$parsedUrl[1]);
	$username = $parsedUrlWithSlash[1];
	return $username;
}


function validateWebsiteWithProtocol($url){
	$url = filter_var($url, FILTER_SANITIZE_URL);
	if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
    	return true;
	}else {
    	return false;
	}
}
function validateSocialLink($dbconn,$url,$socialnetworkname){
	$getLinkType = $dbconn->prepare("SELECT * FROM available_social_networks WHERE asn_name = :n");
	$getLinkType->execute([':n' => $socialnetworkname]);

	$row = $getLinkType->fetch(PDO::FETCH_OBJ);

	$parsedUrl = @explode($row->asn_url, $url);
	$parsedurlWithSlash = @explode('/', $parsedUrl[1]);
	
	$cond1 = $parsedUrl[0] == 'http://www.' || $parsedUrl[0] == 'https://www.' || $parsedUrl[0] == 'http://' || $parsedUrl[0] == 'https://' ;
	$cond2 = count($parsedUrl) == 2 && count($parsedurlWithSlash) ==2 && validateUsername($parsedurlWithSlash[1]);
	$url = filter_var($url, FILTER_SANITIZE_URL);
	if (!filter_var($url, FILTER_VALIDATE_URL) === false && $cond2 == true && $cond1 == true) {
		return true;
	}else {
    	return false;
	}
}

function getSocialIcon($dbconn,$socialnetworkname){

	$getSocialIcons = $dbconn->prepare("SELECT * FROM social_network_icons WHERE asn_name = :n");
	$getSocialIcons->execute([':n' => $socialnetworkname]);

	$icon = $getSocialIcons->fetch(PDO::FETCH_ASSOC);
	return $icon['icon_value'];

}

function getAllSocialLinksForDashboard(){

	global $db;
	$dbconn = $db->connect();
	
	$sesssionId = session('user_id');
	$getSocialLinks = $dbconn->prepare("SELECT * FROM social_links WHERE user_id = :i ORDER BY social_link_position");
	$getSocialLinks->execute([':i' => $sesssionId]);
	$data = $getSocialLinks->fetchAll();
	
	if ($getSocialLinks->rowCount()) {
		foreach($data as $row){
			$encodedLinkId = $row['social_link_id'];
			 $link = '
<tr  >
	<th  class="dashboardSocialLinkIcon"><i class="'.getSocialIcon($dbconn,$row['social_link_type']).'"  ></i></th>
	<td  class="dashboardSocialLinkValue">'.$row['social_link_value'].'</td>
	<td  class="dashboardSocialLinkDelete">
		<a href="#" onclick="deleteLinkFromProfile('.$encodedLinkId.')" ><i class="fa fa-trash-o " ></i></a>
	</td>
</tr>';
	echo $link;
	}
	}
}

function getSocialLinkHref($dbconn,$socialNetworkName,$socialNetworkValue){
	$getUrlPattern = $dbconn->prepare("SELECT * FROM available_social_networks WHERE asn_name = :n");
	$getUrlPattern->execute([':n' => $socialNetworkName]);
	if ($getUrlPattern->rowCount()) {
		$row = $getUrlPattern->fetch(PDO::FETCH_OBJ);
	}

	return $link = 'http://'.$row->asn_url.'/'.$socialNetworkValue;
}

function getCurrentProfileImage($dbconn,$userId){
    $getCurrentProfileImage = $dbconn->prepare("SELECT user_profileimage FROM users WHERE user_id = :id");
    $getCurrentProfileImage->execute([':id' => $userId]);

    if ($getCurrentProfileImage->rowCount()){
        $profileImage = $getCurrentProfileImage->fetchColumn();
        return $profileImage;
    }else{
        return 'empty.png';
    }
}


?>