<?
# ==================================================================
# list of the commands available, and their description (output in 'man')
# commands that start with _ are private, and not listed by the help command
$words  = array(
	//"cd"		=> "",
	"clear"		=> "Clears the screen.",
	"clock"		=> "Tells the time. <strong>clock U</strong> gives number of seconds since the Unix Epoch.",
	"encrypt"	=> "Encrypts words.",
	"eko"		=> "Repeats input.",
	"feel"		=> "Uses wefeelfine.org to find a sentence from today that includes a given feeling.",
	"find"		=> "Find things",
	"hello"		=> "Yep. Hello.",
	"help"		=> "Provides overall help, and a list of available commands.",
	"last"		=> "Checks the last lastfm track played by a user.",
	"logout"	=> "Logs you out.",
	//"ls"		=> "",
	"man"		=> "Provides help on individual commands.",
	//"play"		=> "",
	//"pwd"		=> "",
	"reverse"	=> "Reverses words.",
	"rotate"	=> "Returns words with each character rotated 13 positions through the alphabet.",
	"selftest"	=> "Run tests on all commands.",
	"scramble"	=> "Randomly sorts letters within a word.",
	//"stop"		=> "",
	"test"		=> "Just a test.",
	"tweet"		=> "Send a tweet (not yet done...)",
	"twhois"	=> "Find out who a Twitter user really is",
	"twitter"	=> "Get the last tweet from a user.",
	"zoom"		=> "Change font size: minimum is 1.0, maximum is 2.0.",
	"_auth"		=> "",
	"_login"	=> "",
	"_restart"	=> "",
	"_startup"	=> ""
	);

# ==================================================================
# tests JS features

function test($input){
	if($input == ""){
		$output = "Pick a colour\r<strong>test red</strong>";
	} else {
		$output = '/*function*/ $("body").css("background", "'. $input .'"); alert("testing..."); $("body").css("background", "#000"); x = "test complete";';
	}
	return $output;
}

# ==================================================================
# run all commands
# ...excludes commands which return JS... for the moment...
function selftest($input){
	$output = "running basic tests: \r\r";

	$output .= "hello: ";
	if ( hello("test") == "Er... hello... test :-)" ){ $output .= " <strong>OK</strong>"; } else { $output .= " <strong>FAIL</strong>"; }
	$output .= "\r";

	$output .= "reverse: ";
	if ( reverse("test") == "test >> tset" ){ $output .= " <strong>OK</strong>"; } else { $output .= " <strong>FAIL</strong>"; }
	$output .= "\r";

	//tweet("test")."\r".
	//clock("r")."\r".
	//encrypt("test")."\r".
	//eko("test")."\r".
	//find("bbc")."\r".
	//last("rich13")."\r".
	//reverse("test")."\r".
	//rotate("test")."\r".
	//scramble("test")."\r".
	//twitter("twitter")."\r";

	return $output;
}

# ==================================================================
#
function hello($input){
	$output = "Er... hello... " . $input . " :-)";
	return $output;
}

# ==================================================================
#
function tweet($input){
	$output = "This would tweet '" . $input . "', if we had OAuth stuff...";
	return $output;
}

# ==================================================================
function twitter($input){
	if($input == ""){
		$output = "Which user do you want to check?\r<strong>twitter username</strong>";
	} else {
		$url = "http://twitter.com/status/user_timeline/" . htmlentities($input) . ".json?count=10";
		$rawdata = feeder($url);
		$data = json_decode($rawdata, true);
		$output = $data[0]["text"];

	}
	return $output;
}

# ==================================================================
function twhois($input){
	if($input == ""){
		$output = "Which user do you want to check?\r<strong>twhois username</strong>";
	} else {
		$url = "http://twitter.com/status/user_timeline/" . htmlentities($input) . ".json?count=10";

		$rawdata = feeder($url);
		$data = json_decode($rawdata, true);

		if(isset($data[0]["user"]["id"])){

			$output = "";

			if($input == $data[0]["user"]["name"]){
				$output .= "<strong>" .$input . "</strong> hasn't provided a real name.\r";
			} else {
				$output .= "<strong>" .$input . "</strong> is really <strong>" . $data[0]["user"]["name"] . "</strong>. \r";
			}

			//.$data[0]["user"]["description"].".\r";

			$output .= "They are Twitter user number <strong>" . $data[0]["user"]["id"] . "</strong>, and have been a Twitter user for <strong>" . time_since(strtotime($data[0]["user"]["created_at"])) . "</strong>.\r";
			$output .= "They have <strong>" . $data[0]["user"]["friends_count"]  . "</strong> friends, and <strong>";
			$output .= $data[0]["user"]["followers_count"] . "</strong> followers.\r";
			$output .= "They have tweeted <strong>" . $data[0]["user"]["statuses_count"] . "</strong> times.\r";

			if($data[0]["user"]["location"] !=""){
				$output .= "They are based in <strong>" . $data[0]["user"]["location"] ."</strong>.";
			} else {
				$output .= "Not sure where they are in the world.";
			}

		} else {
			$output = "Dunno, sorry.";
		}

	}
	return $output;
}

# ==================================================================
function last($input){
	if($input == ""){
		$output = "Which user do you want to check?\r<strong>last username</strong>";
	} else {
		$url = "http://ws.audioscrobbler.com/2.0/?method=user.getRecentTracks&api_key=79455252ccf334688fc8efe7c5600c3b&user=" . htmlentities($input) . "&format=json";
		$rawdata = feeder($url);
		$data = json_decode($rawdata, true);

		$output = $data["recenttracks"]["track"][0]["name"]." by ".$data["recenttracks"]["track"][0]["artist"]["#text"];
	}
	return $output;
}

# ==================================================================
function feel($input){
	if($input == ""){
		$output = "What feeling are you looking for?\r<strong>feel hungry</strong>";
	} else {
		$url = "http://api.wefeelfine.org:8080/ShowFeelings?display=json&returnfields=sentence&postdate=".date("Y-m-d")."&limit=1&feeling=" . htmlentities($input);
		$data = feeder($url);
		$output = strip_tags($data);
			if($output == ""){ $output = "nobody's feeling ".$input." at the moment..."; }
	}
	return $output;
}



# ===================================================================
function feeder($url){

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$contents = curl_exec ($ch);
	curl_close ($ch);

	//var_dump($contents);

	return $contents;
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
	'x = "";';
	return $output;
}

# ==================================================================
# return results from Google
function find($input){

	if($input == ""){
		$output = "Find what?";
	} else {

		$googleApiKey = "ABQIAAAABfXxDILyk96j5T1zbuTHIxQT1hIDXS725cbed6gUJzJpaC_7sRRatJmrT6uDc6Xuwpu8kSdbeQ0Rag";

		$url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&"
		   . "q=".urlencode($input)."&key=".$googleApiKey;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_REFERER, "http://other.thing13.net/console");
			$body = curl_exec($ch);
			curl_close($ch);
			$json = json_decode($body);
			$output = $json->responseData->results[0]->content;

	}
	return $output;
}

# ==================================================================
#
function ls($input){
	$output = "ls";
	return $output;
}

# ==================================================================
# basic simulation of cd... should be totally redone
function cd($input){
	if($input == ""){
		$output = '/*function*/ '.
		'that.pwd = "home";'.
		'x = that.pwd';
	} else {
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
function eko($input){

	if($input == ""){
		$output = "Quiet, isn't it?";
	} else {
		$output = $input;
	}

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
	if(md5($input) == 'd1133275ee2118be63a577af759fc052'){ // joshua :-)

		$output = '/*function*/'.
		'that.clear();'.
		'var expiry = new Date();'.
		'expiry.setDate(expiry.getDate()+1);'.
		'setCookie("console_auth","1",{ "expires": expiry });'.
		'x= "Advanced security clearance <strong>confirmed</strong> \rAccess granted on '.
		date("r").
		'\r";';
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

?>