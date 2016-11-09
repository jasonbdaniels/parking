<?php
	//Gets the parking spaces nearby.
	//http://localhost/parking/api/nearby/?lat=39.0991&lng=-84.5127
	
	header("Content-Type: application/javascript");
	
	include_once "../parking_util_functions.php";
	
	if(!isset($_GET["lat"]) || !isset($_GET["lng"])){
		echo createInvalidMessage("Require both lat and lng values.");
		exit();
	}
	
	$lat = $_GET["lat"];
	$lng = $_GET["lng"];
	
	//Query the database
	$selectStatement = "SELECT	id,".
							"name,".
							"latitude,".
							"longitude,".
							"ROUND(69*ST_Distance(POINT(latitude,longitude), POINT(?, ?)), 2) AS distance";
	
	if(isset($_GET["detail"]) && $_GET["detail"] == 1){
		$selectStatement .= ", spots, available_spots";
		$isDetailed = TRUE;
	}
	
	$query = "$selectStatement ".
			"FROM parking_place ".
			"JOIN parking_info ".
			"ON id = place_id ".
			"WHERE ROUND(69*ST_Distance(POINT(latitude,longitude), POINT(?, ?)), 2) <= 5.125 ".
			"ORDER BY SQRT(POW(latitude - ?, 2) + POW(longitude - ?, 2) + POW(LEAST(available_spots, 5) - 5.0, 2)) ASC;";
	
	$db = createMysqli();
	
	if($preparedQuery = $db->prepare($query)) {
		if(!$preparedQuery->bind_param("dddddd", $lat, $lng, $lat, $lng, $lat, $lng)) {
			echo createInvalidMessage("Failed to bind ($db->error): $query");
			exit;
		}
		$preparedQuery->execute();
		
		if($isDetailed) {
			$preparedQuery->bind_result($id, $name, $latitude, $longitude, $distance, $totalSpots, $availableSpots);
		}
		else {
			$preparedQuery->bind_result($id, $name, $latitude, $longitude, $distance);
		}
		
		$nearbyPlaces = array();
		
		while($preparedQuery->fetch()) {
			$parkingPlace = array();
			
			$parkingPlace["id"] = $id;
			$parkingPlace["name"] = $name;
			$parkingPlace["latitude"] = $latitude;
			$parkingPlace["longitude"] = $longitude;
			
			if($isDetailed) {
				$parkingPlace["total_spots"] = $totalSpots;
				$parkingPlace["available_spots"] = $availableSpots;
			}
			
			array_push($nearbyPlaces, $parkingPlace);
		}
		
		$responseMap = getValidMessageMap("Nearby parking spots, sorted by best available.");
		$responseMap["nearby"] = $nearbyPlaces;
		
		echo json_encode($responseMap);
	}
	else {
		echo createInvalidMessage("Failed to prepare ($db->error): $query");
		exit;
	}
?>
