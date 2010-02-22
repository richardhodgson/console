<?
# ==================================================================
function c_help($input, $commands){

	$output = '/*function*/'.
	'x = "Console.\r'.
	'These commands are defined internally.\r'.
	'Type \'help\' to see this list.\r';

	foreach ($commands as $command => $desc){

		if($input == "all"){
			$output .= '<strong>' . $command . '</strong>  ';
		} elseif(strstr($command, "_") == false){
			$output .= '<strong>' . $command . '</strong>  ';
		}
	}

	$output .= '";';

	return $output;
}
?>