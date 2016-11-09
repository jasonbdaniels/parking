<?php
	header("Access-Control-Allow-Origin: *");
	
	function createInvalidMessage($message){
		return "{\"valid\":0, \"message\":\"$message\"}";
	}
	
	function getValidMessageMap($message){
		return array("valid" => 1, "message" => $message);
	}
	
	function createMysqli() {
		include_once "credentials.php";
		
		return new mysqli($SQL_HOST, $SQL_USERNAME, $SQL_PASSWORD, $SQL_DATABASE);
	}
?>
