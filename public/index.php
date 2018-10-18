<?php

    //require_once("../application/config/config.php");
    include "../application/config/config.php";
    include_once($path["controller"]);

    $request = $_SERVER['REQUEST_URI'];
    $params = explode('/', $request);
    // Here you should probably gather the rest as params

error_log($path["controller"]);

    // Call the action
    $controller = new Controller($params);
?>
