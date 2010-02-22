<?

# ==================================================================
function c_encrypt($input){

	if($input[1] == ""){
		$output = "Please provide a string to be encrypted\r<strong>encrypt string\rstring >> b45cffe084dd3d20d928bee85e7b0f21</strong>";
	} else {
		$output = md5($input[1]);
		///$output = $input[1] . " >> " . md5($input[1]);
	}

	return $output;
}

?>