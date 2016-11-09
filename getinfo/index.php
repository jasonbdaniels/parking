<?php
	include_once("../parking_util_functions.php");
	
	header("Content-Type: application/json");
	
	if(!isset($_GET['parkplaceid'])){
		echo createInvalidMessage("Require parkplaceid");
		exit();
	}
	
	$placeId = $_GET['parkplaceid'];
	
	$db = createMysqli();
	
	$infoPrepare = $db->prepare("SELECT spots, available_spots FROM parking_info WHERE place_id=?");
	
	$infoPrepare->bind_param("i", $placeId);
	$infoPrepare->execute();
	$infoPrepare->bind_result($spots, $available_spots);
	$infoPrepare->fetch();
	
	$responseMap = getValidMessageMap("Got info.");
	
	$info = array("spots" => $spots, "available_spots" => $available_spots);
	
	$responseMap["info"] = $info;
	
	$jsonResponse = json_encode($responseMap);
	
	echo $jsonResponse;
?>
