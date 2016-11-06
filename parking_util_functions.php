<?php
	header("Access-Control-Allow-Origin: *");
	
	include_once "credentials.php";
	
	function createInvalidMessage($message){
		return "{\"valid\":0, \"message\":\"$message\"}";
	}
	
	function getValidMessageMap($message){
		return array("valid" => 1, "message" => $message);
	}
	
	function createMysqli() {
		return new mysqli($SQL_HOST, $SQL_USERNAME, $SQL_PASSWORD, $SQL_DATABASE);
	}
?>
