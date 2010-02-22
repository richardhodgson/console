<?

# ==================================================================
#
function test_c_print(){
	$test["i"] = "";
	$test["o"] = "Quiet, isn't it?";

	//$test["i"] = "test";
	//$test["o"] = "test";

	return $test;
}
# ==================================================================
#
function c_print($input){

	if($input[1] == ""){
		$output = "Quiet, isn't it?";
	} else {
		$output = $input[1];
	}

	return $output;
}

?>