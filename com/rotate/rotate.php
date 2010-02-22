<?

# ==================================================================
function c_rotate($input){

	if($input == ""){
		$output = "Please provide a string to be rotated\r<strong>rotate string\rstring >> fgevat</strong>";
	} else {
		$output = $input . " >> " . str_rot13($input);
	}

	return $output;
}

?>