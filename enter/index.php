<?php
	include_once("../parking_util_functions.php");
	
	if(!isset($_POST['parkplaceid'])){
		echo createInvalidMessage("Require parkplaceid.");
		exit();
	}
	
	$placeId = $_POST['parkplaceid'];
	
	$db = createMysqli();
	
	$enterPrepare = $db->prepare("UPDATE parking_info SET available_spots=available_spots - 1 WHERE place_id=? AND available_spots > 0");
	$enterPrepare->bind_param("i", $placeId);
	$enterPrepare->execute();
	
	if($enterPrepare->affected_rows > 0){
		$responseMap = getValidMessageMap("Parking place entered.");
		$jsonResponse = json_encode($responseMap);
	
		echo $jsonResponse;
	}
	else{
		echo createInvalidMessage("Unable to enter parking place with parkplaceid<$placeId>.");
	}
?>
