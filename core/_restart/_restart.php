<?

# ==================================================================
# fired on refresh, if login cookie present...
function c__restart($input){
	$output = '/*function*/'.
	'that.clear();'.
	'command = "";'.
	'x = "";';
	return $output;
}

?>