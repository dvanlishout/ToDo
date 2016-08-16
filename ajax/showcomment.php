<?php

session_start();
	require_once("../classes/query.class.php");
	$taskID = htmlspecialchars($_POST['taskID']);

	$_SESSION["taskid"] = $taskID;
	$q = new query;
	$data = $q->getComment($taskID);



	header('Content-Type: application/json');
	echo json_encode($data, JSON_PRETTY_PRINT);
?>