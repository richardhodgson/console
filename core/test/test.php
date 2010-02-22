<?

# ==================================================================
# tests JS features

function c_test($input){
	if($input == ""){
		$output = "Pick a colour\r<strong>test red</strong>";
	} else {
		$output = '/*function*/ $("body").css("background", "'. $input .'"); alert("testing..."); $("body").css("background", "#000"); x = "test complete";';
	}
	return $output;
}

?>