<?php
/**
 * Created by PhpStorm.
 * User: Ditte
 * Date: 07/08/16
 * Time: 15:02
 */

session_start();
session_destroy();
header('Location: login.php');
?>