<?

# ==================================================================
# this function is fired first...
# it causes the _login command to be fired next
function c__startup($input){
	$output = '/*function*/'.
	'that.clear();'.
		'command = "_login ";'.
		'x = "'.
		'Welcome\r'.
		date("r").
		'\r'.
		'Console, version <strong>0.0.2</strong> experimental\r'.
		'";';
	return $output;
}

?>