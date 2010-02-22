<?

# ==================================================================
function c_reverse($input){

	if($input == ""){
		$output = "Please provide a string to be reversed\r<strong>reverse string\rstring >> gnirts</strong>";
	} else {
		$output = $input . " >> " . strrev($input);
	}

	return $output;
}


?>