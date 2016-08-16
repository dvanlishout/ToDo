<?php
session_start();
	require_once("../classes/query.class.php");
	$listID = htmlspecialchars($_POST['listID']);
	$q = new query;
    $data = $q->deleteList($listID);







	//header('Content-Type: application/json');
	//echo json_encode($data, JSON_PRETTY_PRINT);
?>
