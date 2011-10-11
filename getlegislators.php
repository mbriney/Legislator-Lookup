<?php

// Show errors
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

//Sunlight API Key
$sunlightkey = 'c09e97ef88ce40f79b957b5e82a3f433';


// Get address
$address = $_GET['address'];

// Lookup lat and long
$getcoordinates = file_get_contents('http://www.datasciencetoolkit.org/street2coordinates/'.urlencode($address));
$getcoordinates = str_replace($address,'result',$getcoordinates);
$getcoordinates_data = json_decode($getcoordinates);
$latitude = $getcoordinates_data->result->latitude;
$longitude = $getcoordinates_data->result->longitude;
$state = $getcoordinates_data->result->region;

$getlegislators = file_get_contents('http://services.sunlightlabs.com/api/legislators.allForLatLong.json?apikey='.$sunlightkey.'&latitude='.$latitude.'&longitude='.$longitude);
$getlegislators_data = json_decode($getlegislators);

//echo $getlegislators;

foreach ( $getlegislators_data->response->legislators as $legislators ){
	echo "<img src='http://www.govtrack.us/data/photos/".$legislators->legislator->govtrack_id."-100px.jpeg'><br>";
	echo $legislators->legislator->title." ".$legislators->legislator->firstname." ".$legislators->legislator->lastname."<br>";
	echo $legislators->legislator->phone."<br><br>";
}

?>