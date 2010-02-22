<?

# ==================================================================
function c_mode($input){

	$modes = array(
		"xray"
		,"normal"
		,"insane"
		);

	$modelist = "";
	foreach($modes as $mode){
		$modelist .= "<strong>".$mode."</strong> ";
	}

	if (in_array($input[1], $modes)) {
		$output = '/*function*/';
		$output .= 'that.mode("'.$input[1].'");';
		$output .= 'x = "Now in '.$input[1].' mode.";';
	} else {

		$output = '/*function*/';
		$output .= 'that.mode("'.$input.'");';
		$output .= 'x = "Which mode?\r'.$modelist.'";';
	}

	return $output;
}

?>