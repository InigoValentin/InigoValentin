<?php

    include __DIR__ . "/auth.php";

    if (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on" || $_SERVER["HTTPS"] == 1) || isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https") {
        $root = "https://" . $_SERVER["HTTP_HOST"] . "/";
    }
    else {
        $root = "http://" . $_SERVER["HTTP_HOST"] . "/";
    }

    $base_dir = $_SERVER["DOCUMENT_ROOT"];

    $path = [
        "img" => [
            "content" => $root . "img/content/",
            "layout" => $root . "img/layout/"
        ],
        "fonts" => $root . "fonts/",
        "css" => $root . "css/",
        "js" => $root . "js/",
        "application" => "$base_dir../application/",
        "classes" => "$base_dir../application/class/",
        "controller" => "$base_dir../application/class/controller/Controller.php",
        "model" => "$base_dir../application/class/model/",
        "view" => "$base_dir../application/class/view/",
        "helper" => "$base_dir../application/helper/",
        "string" => "$base_dir../application/class/view/string/"
    ];

?>
