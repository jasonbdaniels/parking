<?php
	//Gets the parking spaces nearby.
	//http://localhost/parking/api/nearby/?lat=39.0991&lng=-84.5127
	
	include_once("../parking_util_functions.php");
	
	$MILES_PER_LATITUDE = 69;
	
	function calculateDistanceAway($startingDegree, $distanceInMiles){
		$distanceInDegrees = $distanceInMiles/69;
		
		return $startingDegree + $distanceInDegrees;
	}
	
	function getPlacesNearby($db, $minLat, $maxLat, $minLng, $maxLng){
		$nearbyQuery = "SELECT id, name, latitude, longitude FROM parking_place WHERE ? <= latitude AND latitude <= ? AND ? <= longitude AND longitude <= ?";
		
		$nearbyPrepare = $db->prepare($nearbyQuery);
		$nearbyPrepare->bind_param("dddd", $minLat, $maxLat, $minLng, $maxLng);
		$nearbyPrepare->execute();
		$nearbyPrepare->bind_result($id, $name, $latitude, $longitude);
	
		$resultsArray = array();
	
		while($nearbyPrepare->fetch()){
			$parkingPlace = array();
		
			$parkingPlace["id"] = $id;
			$parkingPlace["name"] = $name;
			$parkingPlace["latitude"] = $latitude;
			$parkingPlace["longitude"] = $longitude;
		
			array_push($resultsArray, $parkingPlace);
		}
		
		return $resultsArray;
	}
	
	function getDetailedPlacesNearby($db, $minLat, $maxLat, $minLng, $maxLng){
		$nearbyQuery = "SELECT pp.id, pp.name, pp.latitude, pp.longitude, pi.spots, pi.available_spots FROM parking_place AS pp, parking_info AS pi WHERE pp.id=pi.place_id AND ? <= latitude AND latitude <= ? AND ? <= longitude AND longitude <= ?";
		
		$nearbyPrepare = $db->prepare($nearbyQuery);
		$nearbyPrepare->bind_param("dddd", $minLat, $maxLat, $minLng, $maxLng);
		$nearbyPrepare->execute();
		$nearbyPrepare->bind_result($id, $name, $latitude, $longitude, $totalSpots, $availableSpots);
	
		$resultsArray = array();
	
		while($nearbyPrepare->fetch()){
			$parkingPlace = array();
		
			$parkingPlace["id"] = $id;
			$parkingPlace["name"] = $name;
			$parkingPlace["latitude"] = $latitude;
			$parkingPlace["longitude"] = $longitude;
			$parkingPlace["total_spots"] = $totalSpots;
			$parkingPlace["available_spots"] = $availableSpots;
		
			array_push($resultsArray, $parkingPlace);
		}
		
		return $resultsArray;
	}
	
	if(!isset($_GET["lat"]) || !isset($_GET["lng"])){
		echo createInvalidMessage("Require both lat and lng values.");
		exit();
	}
	
	$lat = $_GET["lat"];
	$lng = $_GET["lng"];
	
	$searchRadiusInMiles = 15;
	
	//Find min and max latitude.
	$minLat = calculateDistanceAway($lat, -$searchRadiusInMiles);
	$maxLat = calculateDistanceAway($lat, $searchRadiusInMiles);
	
	//Find approximate min and max longitude.
	$minLng = calculateDistanceAway($lng, -$searchRadiusInMiles);
	$maxLng = calculateDistanceAway($lng, $searchRadiusInMiles);
	
	//Query the database
	$db = createMysqli();
	
	if(isset($_GET["detail"]) && $_GET["detail"] == 1){
		$resultsArray = getDetailedPlacesNearby($db, $minLat, $maxLat, $minLng, $maxLng);
	}
	else{
		$resultsArray = getPlacesNearby($db, $minLat, $maxLat, $minLng, $maxLng);
	}
	
	$responseArray = getValidMessageMap("Got parking places nearby");
	
	$responseArray["parking_places"] = $resultsArray;
	
	
	echo json_encode($responseArray);
?>
