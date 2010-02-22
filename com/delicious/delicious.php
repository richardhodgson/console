<?

# ==================================================================
function c_delicious($input){
	if($input[1] == ""){
		$output = "Which user do you want to check?\r<strong>delicious username</strong>";
	} else {
		$url = "http://feeds.delicious.com/v2/json/" . htmlentities($input[1]);
		$rawdata = c__feeder($url, null, true);

		$data = json_decode($rawdata, true);

		if($data[0]['u'] == $url && $data[0]['d'] == '404 Not Found'){
			$output = 'User "' . $input[1] . '" not found.';
		}
		else{
			$output = '<a href="' . $data[0]['u'] . '">' . $data[0]['d'] . '</a> <strong>(posted at ' . $data[0]['dt'] . ')</strong>';
		}
	}
	return $output;
}
?>