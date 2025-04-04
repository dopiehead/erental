<?php


require __DIR__ . '/vendor/autoload.php';
$apiKey = 'AIzaSyCL0LtlReopBM22H3uumKSLK2a5KukPduA';
$origin = $userLocation; // e.g., 'New York, NY'
$destination = $buyerLocation; // e.g., 'Los Angeles, CA'

$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . urlencode($origin) . "&destinations=" . urlencode($destination) . "&mode=driving&units=metric&language=en-US&key=" . $apiKey;
$response = json_decode(file_get_contents($url), true);

if ($response !== null && isset($response['status'])) {
    if ($response['status'] == 'OK') {
        if (isset($response['rows'][0]['elements'][0]) && isset($response['rows'][0]['elements'][0]['distance']) && isset($response['rows'][0]['elements'][0]['duration'])) {
            $distance = $response['rows'][0]['elements'][0]['distance']['value'];
            $duration = $response['rows'][0]['elements'][0]['duration']['value'];
          
        } else {
            echo "Error: API response does not contain expected data.\n";
        }
    } else {
        echo "Error: API response status is ".$response['status']."\n";
    }
} else {
    echo "Error: API request was not successful.\n";
}

?>