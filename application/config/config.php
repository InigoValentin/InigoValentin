<?php

    require_once(__DIR__ . "/auth.php");
    require_once(__DIR__ . "/../helper/net.php");

    /**
     * Server base url, including protocol, without language indicator.
     * It may be overwritten by the controller to add the language.
     */
    $base_url = get_protocol() . $_SERVER["HTTP_HOST"];
    $static_url = get_protocol() . $_SERVER["HTTP_HOST"];

    /**
     * Static url, absolute, language independant.
     */
    $static = [
        "layout" => $static_url . "/img/layout/",
        "content" => $static_url . "/img/content/",
        "fonts" => $static_url . "/fonts/",
        "css" => $static_url . "/css/",
        "demo" => $static_url . "/demo/",
        "js" => $static_url . "/js/",
        "cv" => $static_url . "/cv/"
    ];

    /**
     * Server document root.
     */
    $base_dir = $_SERVER["DOCUMENT_ROOT"];

    /**
     * Paths within the server.
     */
    $path = [
        "application" => $base_dir . "/../application/",
        "controller" => $base_dir . "/../application/Controller.php",
        "entity" => $base_dir . "/../application/entity/",
        "page" => $base_dir . "/../application/page/",
        "helper" => $base_dir . "/../application/helper/",
        "view" => $base_dir . "/../application/view/",
        "inc" => $base_dir . "/../application/view/inc/",
        "string" => $base_dir . "/../application/view/string/"
    ];

?>
