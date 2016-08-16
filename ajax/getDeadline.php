<?php

session_start();
require_once("../classes/task.class.php");

$deadline = htmlspecialchars($_POST['deadline']);
$task = new Tasks;
$data = $task->getTime($deadline);



header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
?>
