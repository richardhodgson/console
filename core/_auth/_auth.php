<?

# ==================================================================
# check password and either login or reject
function c__auth($input){

	if(md5($input[1]) == 'd1133275ee2118be63a577af759fc052'){ // joshua :-)

		$output = '/*function*/'.
		'that.clear();'.
		'var expiry = new Date();'.
		'expiry.setDate(expiry.getDate()+1);'.
		'setCookie("console_auth","1",{ "expires": expiry });'.

//		'that.process("selftest");'.

		'x= "Advanced security clearance <strong>confirmed</strong> \rAccess granted on '.date("r").'";';

		return $output;
	} else {

		$output = '/*function*/'.
		'x = "Access denied.";'.
		'command = "_login ";';
		return $output;
	}
}

?>