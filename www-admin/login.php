<?php
    $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";
    include $doc_root . "functions.php";
    $con = start_db();
    $user = mysqli_real_escape_string($con, $_POST["user"]);
    $pass = mysqli_real_escape_string($con, $_POST["pass"]);
    $pass = sha1($pass);
    if (login($con, $user, $pass)){
        header("Location: /index.php");
    }
    else{
        header("Location: /authentication.php");
    }
?>
