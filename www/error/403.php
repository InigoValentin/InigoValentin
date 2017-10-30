<?php
    session_start();
    $http_host = $_SERVER["HTTP_HOST"];
    $doc_root = $_SERVER["DOCUMENT_ROOT"]; 
    include $doc_root . "functions.php";
    $proto = get_protocol();
    $con = start_db();
    $server = $proto . $http_host;
    $lang = select_language();
    $lserver = $server . "/" . $lang;
    $cur_section = "error";
    $cur_entry = "403";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta content='text/html; charset=windows-1252' http-equiv='content-type'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'>
        <title><?=text($con, "ERROR_TITLE", $lang);?> - <?=text($con, "USER_NAME", $lang);?></title>
        <link rel='shortcut icon' href='<?=$lserver?>/img/logo/favicon.ico'>
        <!-- CSS files -->
        <link rel='stylesheet' type='text/css' href='/css/ui.css'/>
                <!-- CSS files -->
        <style>
<?php
            include $doc_root . "css/ui.css";
            include $doc_root . "css/error.css";
?>
        </style>
        <!-- CSS for mobile version -->
        <style media="(max-width : 990px)">
<?php
            include $doc_root . "css/m/ui.css";
            include $doc_root . "css/m/error.css";
?>
        </style>
        <meta name="robots" content="noindex follow"/>
    </head>
    <body>
<?php
        include $doc_root . "header.php";
?>
        <div class='section section_no_title' >
            <table id='error-code' class='entry'>
                <tr>
                    <td id='error-number'>
                        403
                    </td>
                    <td id='error-tag'>
                        <?=text($con, "ERROR_DISPLAY", $lang);?>
                    </td>
                <tr>
            </table>
            <br/><br/><br/><br/>
            <div id='error-message' class='entry'>
                <h2><?=text($con, "ERROR_403", $lang);?></h2>
                <?=text($con, "ERROR_403_DESC", $lang);?>
                <br/><br/>
                <?=text($con, "ERROR_TRY", $lang);?>
                <ul>
                    <li>
                        <a href='javascript: location.reload();'><?=text($con, "ERROR_SOLUTION_0", $lang);?></a>
                    </li>
                    <li>
                        <a href='javascript: history.go(-1);'><?=text($con, "ERROR_SOLUTION_1", $lang);?></a>
                    </li>
                    <li>
                        <a href='<?=$lserver?>/'><?=text($con, "ERROR_SOLUTION_2", $lang);?></a>
                    </li>
                </ul>
            </div> <!-- #error_message -->
        </div> <!-- .section -->
<?php
        include $doc_root . "footer.php";
        stats($con, $cur_section, $cur_entry);
?>
    </body>
</html>
