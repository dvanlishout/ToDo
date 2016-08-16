<?php
session_start();
	require_once("../classes/query.class.php");
	$listID = htmlspecialchars($_POST['listID']);

    $_SESSION["listid"] = $listID;
	$q = new query;
	$data = $q->getTask($listID);
	
	
	header('Content-Type: application/json');
	echo json_encode($data, JSON_PRETTY_PRINT);	
?>