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
        <title>Error - I&ntilde;igo Valentin</title>
        <link rel='shortcut icon' href='<?=$lserver?>/img/logo/favicon.ico'>
        <!-- CSS files -->
        <link rel='stylesheet' type='text/css' href='/css/ui.css'/>
        <style>
            table#error-code{
                margin-top:        5em;
                margin-left:     10%;
            }
            td#error-number{
                font-size:        300%;
                border-right:    0.063em solid #000000;
                padding-right:    1.875em;
                padding-left:    1.250em;
            }
            td#error-tag{
                font-size:        110%;
                padding-left:    1.750em;
                padding-right:    1.250em;
            }
            div#error-message{
                width:            80%;
                margin-left:    10%;
            }
            @media (max-width: 990px){
                table#error-code{
                    width:            90%;
                    margin-left:    auto;
                    margin-right:    auto;
                    margin-top:        0;
                    margin-bottom:    0;
                }
                div#error-message{
                    width:            90%;
                    margin-left:    auto;
                    margin-right:    auto;
                    margin-top:        0;
                    margin-bottom:    0;
                }
            }
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
                        ERROR<br/>CODE
                    </td>
                <tr>
            </table>
            <br/><br/><br/><br/>
            <div id='error-message' class='entry'>
                <h2>Forbidden</h2>
                This means you are trying to view something you are not allowed to, security wise.
                <br/><br/>
                Try a solution:
                <ul>
                    <li>
                        <a href='javascript: location.reload();'>Try again.</a>
                    </li>
                    <li>
                        <a href='javascript: history.go(-1);'>Go to the previous page.</a>
                    </li>
                    <li>
                        <a href='<?=$lserver?>/'>Go to the main page</a>
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
