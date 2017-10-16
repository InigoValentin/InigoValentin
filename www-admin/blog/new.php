<?php
    session_start();
    $http_host = $_SERVER["HTTP_HOST"];
    $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";
    include $doc_root . "functions.php";
    $proto = get_protocol();
    $con = start_db();
    $server = $proto . $http_host;
    $pserver = substr($server, 0, strpos($http_host, ':')); // public server
    if (!check_session($con)){
        header("Location: /authentication.php");
        exit(-1);
    }
    else{
    }
?>
