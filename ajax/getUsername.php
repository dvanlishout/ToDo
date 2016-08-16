<?php

session_start();
require_once("../classes/query.class.php");

$userID = htmlspecialchars($_POST['userID']);
$q = new query;
$data = $q->getUsername($userID);



header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
?>
