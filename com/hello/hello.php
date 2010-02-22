<?

# ==================================================================
#
function test_c_hello(){
	$test["i"] = "test";
	$test["o"] = "Er... hello... test :-)";
	return $test;
}

# ==================================================================
#
function c_hello($input){
	$output = "Er... hello... ".$input[1]." :-)";
	return $output;
}


?>