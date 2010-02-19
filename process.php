<?
# ==================================================================
include("commands.php");
include("utils.php");
# ==================================================================

$rawinput = $_POST["input"]; // the command that has just been passed over...

// for now, commands are very simple... only first (and sometimes second) chunk of input is processed
$inputparts = explode(" ", $rawinput);
$input = $inputparts[0];

if( is_numeric($input) ){ echo basic($rawinput); exit(); }

# ==================================================================
# dumb list of usernames
$users  = array(
	"thing",
	"rich13"
);

# ==================================================================
# code borrowed from php.net/levenshtein
# ...guesses the command by looking for closest match
# needs to be moved into a function...

$shortest = -1;

foreach ($words as $word => $desc) {

	$lev = levenshtein($input, $word);

	if ($lev == 0) { // match

		$closest = $word;
		$shortest = 0;
		break;
	}

	if ($lev <= $shortest || $shortest < 0) {
		$closest  = $word;
		$shortest = $lev;
	}
}

if ($shortest == 0) {
	echo process($rawinput, $words, $users);
} else if(strstr($closest, "_") != false){
	echo "$input: command not found.";
} else {
	echo "$input: command not found. Did you mean '$closest'?";
}





# ==================================================================
# PROCESS THE COMMAND...
# needs to be cleaner, to be able to handle array input, etc.
# ==================================================================
function process($input, $words, $users){

	$parts = explode(" ", $input);

	$command = $parts[0]; # only using the first 2 chunks if there's no ""
	$thing = $parts[1];

	$inputquoted = explode('"', $input); # use strings inside "" as full string with spaces
	$quoted = str_replace("\\", "", $inputquoted[1]);

	if($quoted !=""){ $thing = $quoted; }

	foreach ($words as $word => $desc) {
		if(strstr($command, $word) != false){
			return $word($thing, $words, $users); # this needs to be more powerful
		}
	}
}


function basic($input){
	$parts = explode(" ", $input);
	$number = $parts[0];
	$line = str_replace($number." ", "", $input);

	return _addline($number, $line);
}

?>