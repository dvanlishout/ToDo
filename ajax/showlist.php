<?php
session_start();
require_once("../classes/query.class.php");

$q = new query;
$data = $q->getList();


header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
?>