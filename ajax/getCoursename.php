<?php

session_start();
require_once("../classes/query.class.php");

$courseID = htmlspecialchars($_POST['courseID']);
$q = new query;
$data = $q->getCoursename($courseID);



header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
?>
