<?

# ===================================================================
function c__feeder($url, $commands, $access=false){

	if($access == false){
		return "Sorry, you don't have access to this command.";
		die();

	} else {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$contents = curl_exec ($ch);
		curl_close ($ch);

		//var_dump($contents);

		return $contents;
	}
}

?>