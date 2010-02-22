<?

# ==================================================================
# code borrowed from php.net/levenshtein
# ...guesses the command by looking for closest match
# needs to be moved into a function...
function match($input, $commands){

	$shortest = -1;

	foreach ($commands as $command => $desc) {
		$lev = levenshtein($input, $command);
		if ($lev == 0) { // match
			$closest = $command;
			$shortest = 0;
			break;
		}
		if ($lev <= $shortest || $shortest < 0) {
			$closest  = $command;
			$shortest = $lev;
		}
	}
	return array($shortest, $closest);
}

# =================================================================
function import($folder){

	$handle = opendir($folder) or die ("Can't open $folder: $php_errormsg");
	while ($item = readdir($handle))

	if ( !strstr($item, '.trash') &&
		$item != ".DS_Store" &&
		$item != "." &&
		$item != ".."
	){

		$commands[$item] = "c_".$item;
	}

	closedir($handle);

	foreach($commands as $command => $function){
		include($folder."/".$command."/".$command.".php");
	}

	return $commands;
}

# =================================================================
function time_since($older_date, $newer_date = false)
{
	// array of time period chunks
	$chunks = array(
		array(60 * 60 * 24 * 365 , 'year'),
		array(60 * 60 * 24 * 30 , 'month'),
		array(60 * 60 * 24 * 7, 'week'),
		array(60 * 60 * 24 , 'day'),
		array(60 * 60 , 'hour'),
		array(60 , 'minute'),
		);

	// $newer_date will equal false if we want to know the time elapsed between a date and the current time
	// $newer_date will have a value if we want to work out time elapsed between two known dates
	$newer_date = ($newer_date == false) ? time() : $newer_date;

	// difference in seconds
	$since = $newer_date - $older_date;

	// we only want to output two chunks of time here, eg:
	// x years, xx months
	// x days, xx hours
	// so there's only two bits of calculation below:

	// step one: the first chunk
	for ($i = 0, $j = count($chunks); $i < $j; $i++)
	{
		$seconds = $chunks[$i][0];
		$name = $chunks[$i][1];

		// finding the biggest chunk (if the chunk fits, break)
		if (($count = floor($since / $seconds)) != 0)
		{
			break;
		}
	}

	// set output var
	$output = ($count == 1) ? '1 '.$name : "$count {$name}s";

	// step two: the second chunk
	if ($i + 1 < $j)
	{
		$seconds2 = $chunks[$i + 1][0];
		$name2 = $chunks[$i + 1][1];

		if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0)
		{
			// add to output var
			$output .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
		}
	}

	return $output;
}
?>