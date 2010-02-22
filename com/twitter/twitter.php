<?

# ==================================================================
function c_twitter($input){
	if($input[1] == ""){
		$output = "Which user do you want to check?\r<strong>twitter username</strong>";
	} else {
		$url = "http://twitter.com/status/user_timeline/" . htmlentities($input[1]) . ".json?count=10";
		$rawdata = c__feeder($url, null, true);
		$data = json_decode($rawdata, true);
		$output = $data[0]["text"];

	}
	return $output;
}


?>