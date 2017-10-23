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
        $user = mysqli_real_escape_string($_SESSION['id']);
        mysqli_query($con, "INSERT INTO project (id, permalink, type, title, user, visible) VALUES ((SELECT max(id) +1 FROM project p), concat((SELECT max(id) +1 FROM project p), ''), 'M', 'NULL', $user, 0);");
        $id = mysqli_fetch_array(mysqli_query($con, "SELECT max(id) AS id FROM project;"))["id"];
        header("Location: /projects/edit.php?p=" + $id);
    }
?>
