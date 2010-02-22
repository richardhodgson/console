<?

# ==================================================================
function c_feel($input){
	if($input[1] == ""){
		$output = "What feeling are you looking for?\r<strong>feel hungry</strong>";
	} else {
		$url = "http://api.wefeelfine.org:8080/ShowFeelings?display=json&returnfields=sentence&postdate=".date("Y-m-d")."&limit=1&feeling=" . htmlentities($input[1]);
		$data = c__feeder($url, null, true);
		$output = strip_tags($data);
			if($output == ""){ $output = "nobody's feeling ".$input[1]." at the moment..."; }
	}
	return $output;
}
?>