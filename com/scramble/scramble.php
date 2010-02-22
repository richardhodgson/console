<?

# ==================================================================
function c_scramble($input){

	if($input == ""){
		$output = "Please provide a string to be scrambled\r<strong>scramble string\rstring >> nrtgsi</strong>";
	} else {
		$output = $input . " >> " . str_shuffle($input);
	}

	return $output;
}

?>