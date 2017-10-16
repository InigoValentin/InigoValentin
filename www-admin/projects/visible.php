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
        http_response_code(401); // Not logged in: Forbidden.
    }
    else{
        $id = intval(mysqli_real_escape_string($con, $_GET["p"]));
        $visible = intval(mysqli_real_escape_string($con, $_GET["v"]));
        if (strlen($id) < 1 || ($visible != 1 && $visible != 0)){
            http_response_code(400); // No or bad ID, visible not 1 or 0: Bad request.
        }
        else{
            if (mysqli_num_rows(mysqli_query($con, "SELECT id FROM project WHERE id = $id;")) == 0){
                http_response_code(404); // Unexistent id: Not found.
            }
            else{
                mysqli_query($con, "UPDATE project SET visible = $visible WHERE id = $id;");
                http_response_code(200); //OK.
            }
        }
    }
?>
