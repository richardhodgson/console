<?

# ==================================================================
function c_logout(){

	$output = '/*function*/'.
	'that.clear();'.
	'var expiry = new Date();'.
	'expiry.setDate(expiry.getDate()-100);'.
	'setCookie("console_auth","0",{ "expires": expiry });'.
	'x = "You are now logged out.";'.
	'command = "_login ";';

	return $output;
}
?>