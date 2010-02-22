<?

# ==================================================================
function c_clock($input){
	if($input[1] == ""){
		$output = "The time is ". date("r");
	} else {
		$output = "The time is ". date($input[1]);
	}
	return $output;
}
?>