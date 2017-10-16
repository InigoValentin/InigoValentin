<?php
    session_start();
    $http_host = $_SERVER["HTTP_HOST"];
    $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";
    include $doc_root . "functions.php";
    $proto = get_protocol();
    $con = start_db();
    $server = $proto . $http_host;
    $pserver = substr($server, 0, strpos($http_host, ':')); // public server
    if (check_session($con)){
        header("Location: /");
        exit(-1);
    }
    else{
?>
<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=windows-1252" http-equiv="content-type"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
        <link rel='shortcut icon' href='<?=$pserver?>/img/logo/x2/favicon.ico'/>
        <title>Administration</title>
        <style>
<?php
            include $doc_root . "css/ui.css";
            include $doc_root . "css/home.css";
?>
        </style>
        <!-- CSS for mobile version -->
        <style media='(max-width : 990px)'>
<?php
            include $doc_root . "css/m/ui.css";
            include $doc_root . "css/m/home.css";
?>
        </style>
        <!-- Script files -->
        <script type='text/javascript'>
<?php
            include $doc_root . "script/ui.js";
?>
        </script>
    </head>
    <body>
        <div class='section' id='authentication'>
            <h3 class='section_title'>Log In</h3>
            <div class='entry'>
                <form method='post' action='/login.php'>
                    <table>
                        <tr>
                            <td>User:</td>
                            <td><input name="user" type="text"/></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input name="pass" type="password"/></td>
                        </tr>
                        <tr>
                            <td></td><td><input type="submit" value="Entrar"/></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </body>
</html>
<?php
    }
?>
