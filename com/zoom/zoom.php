<?

# ==================================================================
function c_zoom($input){
	if($input > 0.999 && $input < 2.0001 ){
		$output = '/*function*/ '.
		'$("#outputter").css("font-size", "' . $input . 'em");'.
		'x = ""';
	} else {
		$output = '/*function*/ '.
		'$("#outputter").css("font-size", "1em");'.
		'x = "Please choose a zoom level between 1.0 and 2.0";';
	}
	return $output;
}

?>