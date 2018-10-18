<?php

    include __DIR__ . "/auth.php";
    require_once(__DIR__ . "/../helper/net.php");

    $root = get_protocol() . $_SERVER["HTTP_HOST"] . "/";

    $base_dir = $_SERVER["DOCUMENT_ROOT"] . "/";

    $path = [
        "img" => [
            "content" => $root . "img/content/",
            "layout" => $root . "img/layout/"
        ],
        "fonts" => $root . "fonts/",
        "css" => $root . "css/",
        "demo" => $root . "demo/",
        "js" => $root . "js/",
        "application" => "$base_dir../application/",
        "controller" => "$base_dir../application/Controller.php",
        "entity" => "$base_dir../application/entity/",
        "page" => "$base_dir../application/page/",
        "view" => "$base_dir../application/view/",
        "helper" => "$base_dir../application/helper/",
        "string" => "$base_dir../application/view/string/"
    ];

?>
