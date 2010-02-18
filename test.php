<p>12s3</p>

<?php
//$input = "rich13";
//$url = "http://twitter.com/status/user_timeline/" . $input . ".json?count=10";
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//$contents = curl_exec ($ch);
//curl_close ($ch);
//
////var_dump($contents);
//
//$decode = json_decode($contents, true);

//echo $decode[0]["text"];

//echo "<img src=\"".$decode[0][user][profile_image_url]."\"</img><br>"; //getting the profile image
//echo "Name: ".$decode[0][user][name]."<br>"; //getting the username
//echo "Web: ".$decode[0][user][url]."<br>"; //getting the web site address
//echo "Location: ".$decode[0][user][location]."<br>"; //user location
//echo "Updates: ".$decode[0][user][statuses_count]."<br>"; //number of updates
//echo "Follower: ".$decode[0][user][followers_count]."<br>"; //number of followers
//echo "Following: ".$decode[0][user][friends_count]."<br>"; // following
//echo "Description: ".$decode[0][user][description]."<br>"; //user description
$googleApiKey = "ABQIAAAABfXxDILyk96j5T1zbuTHIxQT1hIDXS725cbed6gUJzJpaC_7sRRatJmrT6uDc6Xuwpu8kSdbeQ0Rag";

$input = "rich13";
$url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&"
    . "q=".$input."&key=".$googleApiKey;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, "http://other.thing13.net/console");
$body = curl_exec($ch);
curl_close($ch);
$json = json_decode($body);
echo $json->responseData->results[0]->title;
//foreach($json->responseData->results as $searchresult)
//{
//  if($searchresult->GsearchResultClass == 'GwebSearch')
//  {
//    echo '
//    <div class="searchresult">
//      <h3><a href="' . $searchresult->unescapedUrl . '">' . $searchresult->titleNoFormatting . '</a></h3>
//      <p>' . $searchresult->content . '</p>
//      <p>' . $searchresult->visibleUrl . '</p>
//    </div>';
//  }
//}
?>
<p>345</p>