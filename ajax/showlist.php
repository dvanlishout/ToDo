<?php
session_start();
require_once("../classes/query.class.php");
$userID = $_SESSION['user_id'];
$q = new query;
$data = $q->getList($userID);


header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
?>