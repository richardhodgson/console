<?

# ==================================================================
# run all commands
# ...excludes commands which return JS... for the moment...
function c_selftest($input, $commands){

	if($input[1] == ""){
		$output = "Running basic tests: ";
		$mode = "basic";
	} elseif($input[1] == "all"){
		$output = "Running full tests: \r\r";
		$mode = "full";
	}

	$tests = 0;
	$passes = 0;

	foreach($commands as $command){
		$testfunction = "test_".$command;

		if(function_exists($testfunction)){
			$tests++;
			$name = str_replace("c_", "", $command);

			if ($mode == "full") { $output .= $name . ": "; }

			$test = $testfunction();

			if( $command( array($command, $test["i"]) ) == $test["o"]){
				if ($mode == "full") {
					$output .= '<var class="positive">PASS</var>'."\r";
				} else {
					$output .= '<var class="positive">&bull;</var>';
				}
				$passes++;
			} else {
				if ($mode == "full") {
					$output .= '<var class="negative">FAIL</var>'."\r";
				} else {
					$output .= '<var class="negative">&bull;</var>';
				}
			}
		}

	}

	if ($mode == "full") {
		$output .= "\r";
		$output .= $tests . "/" . sizeof($commands)  . " commands tested.\r";
		$output .= $passes . "/" . $tests . " tests passed.";
	}

	return $output;
}
?>