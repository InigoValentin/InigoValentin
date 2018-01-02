<?php
    session_start();
    $http_host = $_SERVER["HTTP_HOST"];
    $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";
    include $doc_root . "functions.php";
    $proto = get_protocol();
    $con = start_db();
    $server = $proto . $http_host;
    $lang = select_language($con);
    $lserver = $server . "/" . $lang;
    $cur_section = "error";
    $cur_entry = http_response_code();
    $error = $cur_entry;
    if (!in-array($error, array("400", "401", "403", "404", "500")){
        $error = "XXX";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta content='text/html; charset=windows-1252' http-equiv='content-type'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'>
        <title><?=text($con, "ERROR_TITLE", $lang);?> - <?=text($con, "USER_NAME", $lang);?></title>
        <link rel='shortcut icon' href='<?=$lserver?>/img/logo/favicon.ico'>
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
        <div class='section' >
            <h3 class='section_title'><?=text($con, "ERROR_ERROR", $lang)?></h3>
            <table id='error_header'>
                <tr>
                    <td>
                        <table id='error_code' class='entry'>
                            <tr>
                                <td id='error_number'>
                                    404
                                </td>
                                <td id='error_tag'>
                                    <?=text($con, "ERROR_ERROR", $lang);?>
                                    <br/>
                                    <?=text($con, "ERROR_CODE", $lang);?>
                                </td>
                            <tr>
                        </table>
                    </td>
                    <td>
                        <h2><?=text($con, "ERROR_" . $error . "_TITLE", $lang);?></h2>
                    </td>
                </tr>
            </table>
            <div id='error_message' class='entry'>
                <?=text($con, "ERROR_" . $error . "_DESCRIPTION", $lang);?>
                <br/><br/>
                <?=text($con, "ERROR_" . $error . "_SOLUTION", $lang);?>
                <ul>
                    <li>
                        <a href='javascript: location.reload();'><?=text($con, "ERROR_" . $error . "_SOLUTION_0", $lang);?></a>
                    </li>
                    <li>
                        <a href='javascript: history.go(-1);'><?=text($con, "ERROR_" . $error . "_SOLUTION_1", $lang);?></a>
                    </li>
                    <li>
                        <a href='<?=$lserver?>/'><?=text($con, "ERROR_" . $error . "_SOLUTION_2", $lang);?></a>
                    </li>
                </ul>
            </div> <!-- #error_message -->
        </div> <!-- .section -->
<?php
        include $doc_root . "footer.php";
        stats($con, $cur_section, $cur_entry);
        http_response_code($cur_entry);
?>
    </body>
</html>
