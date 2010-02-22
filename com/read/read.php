<?
include("simple_html_dom.php");
# ==================================================================
function c_read($input){
	if($input[1] == ""){
		$output = "Enter a URL to read.\r <strong>read bbc.co.uk/news</strong>";

	} else {

		    // create HTML DOM
		    $html = file_get_html("http://".$input[1]);

		    // get title
		    $page['Title'] = $html->find('title', 0)->innertext;
		    $page['h1'] = $html->find('h1', 0)->innertext;

			foreach($html->find('h2') as $h2){
			    $page[] = $h2->innertext;
			}

		    // clean up memory
		    $html->clear();
		    unset($html);

			$output = "";

			foreach($page as $key => $val)
				$output .= "<strong>" . $key . "</strong>: " . $val . "\r";
			}

	return strip_tags($output);
}

?>

