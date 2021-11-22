<?php

/**
 * Index page.
 *
 * Receives every request and instantiates a {@see Constroller}.
 *
 * @category Public
 */

require_once(__DIR__ . "/../application/Controller.php");

$controller = new Controller();

$request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$params = explode('/', $request);

function get_context(){
    global $controller;
    return $controller->get_context();
}

$request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$params = explode('/', $request);
$controller->prepare($params);
$controller->action();
