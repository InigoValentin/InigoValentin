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
        http_response_code(401);
        header("Location: /authentication.php");
    }
    else{
        $table = mysqli_real_escape_string($con, $_GET["t"]);
        $column = mysqli_real_escape_string($con, $_GET["c"]);
        $value = htmlspecialchars_decode(mysqli_real_escape_string($con, $_GET["v"]));
        $id = mysqli_real_escape_string($con, $_GET["i"]);
        // TODO: Validation!
        if ($table == 'text'){
            if (mysqli_query($con, "UPDATE text SET text = '$value' WHERE id = '$id' AND lang = '$column';")){
                http_response_code(200); // OK.
            }
            else{
                http_response_code(500); // Generic internal error.
            }
        }
        else{
            if (mysqli_query($con, "UPDATE $table SET $column = '$value' WHERE id = $id;")){
                http_response_code(200); // OK.
            }
            else{
                http_response_code(500); // Generic internal error.
            }
        }
    }
?>
