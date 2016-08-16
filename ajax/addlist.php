<?php
session_start();
require_once("../classes/query.class.php");

    $q = new query;
    if ($q->listnameQuery($this->m_sListname)) {

        $q = new query();
        $data = $q->newListquery($this->m_sListname, $_SESSION['user_id'] );
    }


    else{
        $_SESSION['feedback'] = "This listname is already taken!";
        return false;
    }

header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);



