<?php
    session_start();
    $http_host = $_SERVER["HTTP_HOST"];
    $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";
    include $doc_root . "functions.php";
    $proto = get_protocol();
    $lang = "en";
    $con = start_db();
    $server = $proto . $http_host;
    $pserver = $proto . substr($http_host, 0, strpos($http_host, ':')); // public server
    if (!check_session($con)){
        http_response_code(401);
        header("Location: /authentication.php");
    }
    else{
        foreach ($_POST as $key => $value){
            error_log("{$key} = {$value}");
        }
        $name = mysqli_real_escape_string($con, $_GET["name"]);
        $base64string = $_POST["image"];
        error_log("FILENAME: $name");
        error_log("PATH: $doc_root../www/img/blog/DEBUG_$name");
        error_log("B64: $base64string");
        file_put_contents("$doc_root../www/img/blog/DEBUG_$name", base64_decode($base64string));

        echo("OK");
    }
?>
