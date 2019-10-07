<?php  

$text = $_POST['skus'];

$array_data = explode(PHP_EOL, $text);

$url_array = array();
foreach ($array_data as $data){
    $format_data = explode(' ',$data);
    $url_array[] = trim($format_data[0]);
};

$array_length = count($url_array);

for ($i = 0; $i < $array_length; $i++) {

	$returnedUrl = $url_array[$i];
	$sunriseCode = 0;
	$access_key_id = "AKIAIXCON5DQR3WKRNBA";
	$secret_key = "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";
	$endpoint = "webservices.amazon.com";
	$uri = "/onca/xml";
	$params = array(
	    "Service" => "AWSECommerceService",
	    "Operation" => "ItemSearch",
	    "AWSAccessKeyId" => "AKIAIXCON5DQR3WKRNBA",
	    "AssociateTag" => "mobilea060334-20",
	    "SearchIndex" => "All",
	    "Keywords" => $returnedUrl,
	    "ResponseGroup" => "Images,ItemAttributes,Offers"
	);

	// Set current timestamp if not set
	if (!isset($params["Timestamp"])) {
	    $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
	}

	// Sort the parameters by key
	ksort($params);

	$pairs = array();

	foreach ($params as $key => $value) {
	    array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
	}

	// Generate the canonical query
	$canonical_query_string = join("&", $pairs);

	// Generate the string to be signed
	$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

	// Generate the signature required by the Product Advertising API
	$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $secret_key, true));

	// Generate the signed URL
	$request_url = 'https://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);


	$xml = simplexml_load_file("$request_url");

	$finalFormat = $xml->Items->Item->ItemAttributes->Binding;
	$finalFormatLC = strtolower($finalFormat);
	$finalFormat2 = array ($xml->Items->Item->ItemAttributes->Format[0], $xml->Items->Item->ItemAttributes->Format[1], $xml->Items->Item->ItemAttributes->Format[2], $xml->Items->Item->ItemAttributes->Format[3], $xml->Items->Item->ItemAttributes->Format[4], $xml->Items->Item->ItemAttributes->Format[5], $xml->Items->Item->ItemAttributes->Format[6]);
	$finalFormat2LC = array_map('strtolower', $finalFormat2);

	if (in_array("4k", $finalFormat2LC)){
 	 $fourKay = true;
  	}
	else{
  	$fourKay = false;
 	 };

	if (strpos($finalFormatLC, 'cd') !== false) {
    	$sunriseCode = 47;
	}
	elseif (strpos($finalFormatLC, 'vinyl') !== false){
		$sunriseCode = 53;
	}
	elseif (strpos($finalFormatLC, 'cassette') !== false){
		$sunriseCode = 80;
	}
	elseif (strpos($finalFormatLC, 'hardcover') !== false || strpos($finalFormatLC, 'paperback') !== false || strpos($finalFormatLC, 'book') !== false){
		$sunriseCode = 82;
	}
	elseif (strpos($finalFormatLC, 'dvd') !== false){
		$sunriseCode = 55;
	}
	elseif (strpos($finalFormatLC, 'blu') !== false && $fourKay == true){
		$sunriseCode = 57;
	}
	elseif (strpos($finalFormatLC, 'blu') !== false){
		$sunriseCode = 56;
	}
	echo $sunriseCode . "<br/>";
	//echo "Signed URL: \"".$request_url."\" <br/>";
	//sleep(5);

};//loop

?> 

</body>
<footer>
</footer>

</html>