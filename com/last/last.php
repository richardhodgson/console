<?

# ==================================================================
function c_last($input){
	if($input[1] == ""){
		$output = "Which user do you want to check?\r<strong>last username</strong>";
	} else {

		$url = "http://ws.audioscrobbler.com/2.0/?method=user.getRecentTracks&api_key=79455252ccf334688fc8efe7c5600c3b&user=" . htmlentities($input[1]) . "&format=json";

		$rawdata = c__feeder($url, null, true);

		$data = json_decode($rawdata, true) or die();

		$output = "On <strong>".$data["recenttracks"]["track"][0]["date"]["#text"]."</strong>, ";
		$output .= $input[1]." listened to <strong>".$data["recenttracks"]["track"][0]["name"]."</strong>";
		$output .= " by <strong>".$data["recenttracks"]["track"][0]["artist"]["#text"]."</strong>";
		if($data["recenttracks"]["track"][0]["album"]["#text"] != ""){
			$output .= " from the album <strong>".$data["recenttracks"]["track"][0]["album"]["#text"]."</strong>";
		}
	}
	return $output;
}

?>