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
        if (strlen($id) < 1){
            http_response_code(400); // No or bad ID: Bad request.
        }
        else{
            if (mysqli_num_rows(mysqli_query($con, "SELECT id FROM project WHERE id = $id;")) == 0){
                http_response_code(404); // Unexistent id: Not found.
            }
            else{
                mysqli_query($con, "DELETE FROM project_version WHERE project = $id;");
                mysqli_query($con, "DELETE FROM project_url WHERE project = $id;");
                mysqli_query($con, "DELETE FROM project_tag WHERE project = $id;");
                mysqli_query($con, "DELETE FROM project_image WHERE project = $id;");
                mysqli_query($con, "DELETE FROM project_comment WHERE project = $id;");
                mysqli_query($con, "DELETE FROM project WHERE id = $id;");
                http_response_code(200); //OK.
            }
        }
    }
?>
