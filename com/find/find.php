<?

# ==================================================================
# return results from Google
function c_find($input){

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
?>