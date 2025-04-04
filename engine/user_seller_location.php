<?php
require __DIR__ . '/vendor/autoload.php';

use Google\Geocoding\Location;
use Google\Maps\DistanceMatrix;

$apiKey = "AIzaSyCL0LtlReopBM22H3uumKSLK2a5KukPduA";
$origin = 'user_location'; // e.g., 'New York, NY'
$destination = 'seller_location'; // e.g., 'Los Angeles, CA'

$geocoding = new Google\Geocoding\Geocoding($apiKey);
$location = $geocoding->geocode($origin);
$originLat = $location->getLatitude();
$originLng = $location->getLongitude();

$distanceMatrix = new Google\Maps\DistanceMatrix($apiKey);
$response = $distanceMatrix->matrix($origin, $destination);

$distance = $response->getRows()[0]->getElements()[0]->getDistance()->getValue();
$duration = $response->getRows()[0]->getElements()[0]->getDuration()->getValue();

echo "Distance: $distance km\n";
echo "Duration: $duration seconds\n";
?>