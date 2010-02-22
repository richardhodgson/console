<?

# ==================================================================
function c_man($input, $words){
	$output = '/*function*/ x = "';

	if($input == ""){
		$output .= "What manual page do you want?";

	} elseif($words[$input] != ""){
		$output .= '<strong>' . $input . '</strong>: ';
		$output .= $words[$input];

	} else {
		$output .= "No manual entry for " . $input;
	}

	$output .= '";';
	return $output;
}

?>