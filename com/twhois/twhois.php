<?

# ==================================================================
function c_twhois($input){
	if($input == ""){
		$output = "Which user do you want to check?\r<strong>twhois username</strong>";
	} else {
		$url = "http://twitter.com/status/user_timeline/" . htmlentities($input) . ".json?count=10";

		$rawdata = _feeder($url, null, true);
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

?>