<?
$rawinput = $_POST["input"]; // the command that has just been passed over...

// for now, commands are very simple... only first (and sometimes second) chunk of input is processed
$inputparts = explode(" ", $rawinput);
$input = $inputparts[0];


# ==================================================================
# dumb list of usernames
$users  = array(
	"thing",
	"rich13"
	);

# ==================================================================
# list of the commands available, and their description (output in 'man')
# commands that start with _ are private, and not listed by the help command
$words  = array(
	"cd"		=> "",
	"clear"		=> "Clears the screen.",
	"clock"		=> "Tells the time. <strong>clock U</strong> gives number of seconds since the Unix Epoch.",
	"encrypt"	=> "Encrypts words.",
	"find"		=> "Find things",
	"hello"		=> "Yep. Hello.",
	"help"		=> "Provides overall help, and a list of available commands.",
	"logout"	=> "Logs you out.",
	"ls"		=> "",
	"man"		=> "Provides help on individual commands.",
	"play"		=> "",
	"pwd"		=> "",
	"reverse"	=> "Reverses words.",
	"rotate"	=> "Returns words with each character rotated 13 positions through the alphabet.",
	"scramble"	=> "Randomly sorts letters within a word.",
	"stop"		=> "",
	"test"		=> "Just a test.",
	"tweet"		=> "Send a tweet (not yet done...)",
	"zoom"		=> "Change font size: minimum is 1.0, maximum is 2.0.",
	"_auth"		=> "",
	"_login"	=> "",
	"_restart"	=> "",
	"_startup"	=> ""

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
#
function test($input){
	if($input == ""){
		$output = "Pick a colour\r<strong>test red</strong>";
	} else {
		$output = '/*function*/ $("body").css("background", "'. $input .'"); alert("testing..."); $("body").css("background", "#000"); x = "test complete";';
	}
	return $output;
}

# ==================================================================
#
function hello($input){
	$output = "Er... hello :-)";
	return $output;
}

# ==================================================================
#
function tweet($input){
	$output = "That would be cool :-)";
	return $output;
}

# ==================================================================
# this function is fired first...
# it causes the _login command to be fired next
function _startup($input){
	$output = '/*function*/'.
	'that.clear();'.
	'command="_login ";'.
	'x = "'.
	'Welcome\r'.
	date("r").
	'\r'.
	'Console, version <strong>0.0.1</strong>\r'.
	'";';
	return $output;
}

# ==================================================================
# fired on refresh, if login cookie present...
function _restart($input){
	$output = '/*function*/ that.clear(); command="";'.
	'x = "Restarting secure session.";';
	return $output;
}

# ==================================================================
#
function find($input){
	$output = "Nowhere to look, yet.";
	return $output;
}

# ==================================================================
#
function ls($input){
	$output = "ls";
	return $output;
}

# ==================================================================
function cd($input){
	if($input == ""){
		$output = '/*function*/ '.
		'that.pwd = "home";'.
		'x = that.pwd';
	} else {
		//if(in_array($input)){}
		if($input == "applications" || $input == "pictures"){
			$output = '/*function*/ '.
			'that.pwd = "'.$input.'";'.
			'x = that.pwd';
		} else {
			$output = "cd: ".$input.": No such file or directory";
		}
	}
	return $output;
}

# ==================================================================
function pwd($input){
	$output = '/*function*/ '.
	'x = that.pwd';
	return $output;
}

# ==================================================================
function play($input){
	$output = "play";
	return $output;
}

# ==================================================================
function stop($input){
	$output = "stop";
	return $output;
}

# ==================================================================
function zoom($input){
	if($input > 0.999 && $input < 2.0001 ){
		$output = '/*function*/ '.
		'$("#outputter").css("font-size", "' . $input . 'em");'.
		'x = ""';
	} else {
		$output = '/*function*/ '.
		'$("#outputter").css("font-size", "1em");'.
		'x = "Please choose a zoom level between 1.0 and 2.0";';
	}
	return $output;
}

# ==================================================================
function man($input, $words){
	$output = '/*function*/ x = "';

	if($input == ""){
		$output .= "What manual page do you want?";

	} elseif($words[$input] != ""){
		$output .= '<strong>' . $input . '</strong>: ';
		$output .= $words[$input];

	} else {
		$output .= "No manual entry for " . $input;

	}

	$output .= '";';
	return $output;
}

# ==================================================================
function help($input, $words){

	$output = '/*function*/ x = "Console.\rThese commands are defined internally.\rType \'help\' to see this list.\r';

	foreach ($words as $word => $desc){

		if(strstr($word, "_") == false){
			$output .= '<strong>' . $word . '</strong>  ';
		}
	}

	$output .= '";';

	return $output;
}

# ==================================================================
function scramble($input){

	if($input == ""){
		$output = "Please provide a string to be scrambled\r<strong>scramble string\rstring >> nrtgsi</strong>";
	} else {
		$output = $input . " >> " . str_shuffle($input);
	}

	return $output;
}

# ==================================================================
function rotate($input){

	if($input == ""){
		$output = "Please provide a string to be rotated\r<strong>rotate string\rstring >> fgevat</strong>";
	} else {
		$output = $input . " >> " . str_rot13($input);
	}

	return $output;
}

# ==================================================================
function reverse($input){

	if($input == ""){
		$output = "Please provide a string to be reversed\r<strong>reverse string\rstring >> gnirts</strong>";
	} else {
		$output = $input . " >> " . strrev($input);
	}

	return $output;
}

# ==================================================================
function encrypt($input){

	if($input == ""){
		$output = "Please provide a string to be encrypted\r<strong>encrypt string\rstring >> b45cffe084dd3d20d928bee85e7b0f21</strong>";
	} else {
		$output = $input . " >> " . md5($input);
	}

	return $output;
}


# ==================================================================
function clock($input){
	if($input == ""){
		$output = "The time is ". date("r");
	} else {
		$output = "The time is ". date($input);
	}
	return $output;
}

# ==================================================================
function clear($input){
	$output =	'/*function*/'.
	'that.clear();'.
	'that.pre="> ";'.
	'x = "";';
	return $output;
}

# ==================================================================
# check password and either login or reject
function _auth($input="wrong"){
	if(md5($input) == '3c709b10a5d47ba33d85337dd9110917'){ // progress

		$output = '/*function*/'.
		'that.clear();'.
		'var expiry = new Date();'.
		'expiry.setDate(expiry.getDate()+1);'.
		'setCookie("console_auth","1",{ "expires": expiry });'.
		'x= "Advanced security clearance <strong>confirmed</strong> \rAccess granted on '.
		date("r").'\r";';
		return $output;
	} else {

		$output = '/*function*/'.
		'x = "Access denied.";'.
		'command = "_login ";';
		return $output;
	}
}

# ==================================================================
function _login($input=false, $words, $users){

	if(!$input){
		$output = "Please enter your username.";
		return $output;
	}

	$output = '/*function*/'.
	'that.pre = ">> ";'. # sets the text before the cursor
	'x = "";'.
	'command = "_auth ";'; # checks the password

	return $output;
}

# ==================================================================
function logout(){

	$output = '/*function*/'.
	'that.clear();'.
	'var expiry = new Date();'.
	'expiry.setDate(expiry.getDate()-100);'.
	'setCookie("console_auth","0",{ "expires": expiry });'.
	'x = "You are now logged out.";'.
	'command = "_login ";';

	return $output;
}



# ==================================================================
# PROCESS THE COMMAND...
# ==================================================================
function process($input, $words, $users){

	$parts = explode(" ", $input);

	$command = $parts[0]; # only using the first 2 chunks
	$thing = $parts[1];

	foreach ($words as $word => $desc) {
		if(strstr($command, $word) != false){
			return $word($thing, $words, $users); # this needs to be more powerful
		}
	}
}

?>