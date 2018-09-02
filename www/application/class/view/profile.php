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
    $cur_section = "me";
    $cur_entry = "";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta content='text/html; charset=utf-8' http-equiv='content-type'/>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'/>
        <title><?=text($con, "PROFILE_TITLE", $lang)?> - <?=text($con, "USER_NAME", $lang);?></title>
        <link rel='shortcut icon' href='<?=$lserver?>/img/logo/x2/favicon.ico'/>
        <!-- CSS files -->
        <style>
<?php
            include $doc_root . "css/ui.css";
            include $doc_root . "css/profile.css";
?>
        </style>
        <!-- CSS for mobile version -->
        <style media='(max-width : 990px)'>
<?php
            include $doc_root . "css/m/ui.css";
            include $doc_root . "css/m/profile.css";
?>
        </style>
        <!-- Script files -->
        <script type='text/javascript'>
<?php
            include $doc_root . "script/ui.js";
            include $doc_root . "script/me.js";
?>
        </script>
        <!-- Meta tags -->
        <link rel='canonical' href='<?=$lserver?>/me/'/>
        <link rel='author' href='<?=$lserver?>'/>
        <link rel='publisher' href='<?=$lserver?>'/>
        <meta name='description' content='<?=text($con, "PROFILE_DESCRIPTION", $lang)?>'/>
        <meta property='og:title' content='<?=text($con, "PROFILE_TITLE", $lang)?> - <?=text($con, "USER_NAME", $lang);?>'/>
        <meta property='og:url' content='<?=$lserver?>/me'/>
        <meta property='og:description' content='<?=text($con, "PROFILE_DESCRIPTION", $lang)?>'/>
        <meta property='og:image' content='<?=$lserver?>/img/logo/x3/favicon.ico'/>
        <meta property='og:site_name' content='<?=text($con, "USER_NAME", $lang);?>'/>
        <meta property='og:type' content='website'/>
        <meta property='og:locale' content='<?=$lang?>'/>
        <meta name='twitter:card' content='summary'/>
        <meta name='twitter:title' content='<?=text($con, "PROFILE_TITLE", $lang)?> - <?=text($con, "USER_NAME", $lang);?>'/>
        <meta name='twitter:description' content='<?=text($con, "PROFILE_DESCRIPTION", $lang)?>'/>
        <meta name='twitter:image' content='<?=$lserver?>/img/logo/x3/favicon.ico'/>
        <meta name='twitter:url' content='<?=$lserver?>'/>
        <meta name='robots' content='index follow'/>
    </head>
    <body>
        <div id='body'>
            <div id='body_row'>
                <div id='left'>
                    <div id='logo'>
                        <img id='logo' src='<?=$lserver?>/img/logo/x6/inigovalentin.png' alt='<?=text($con, "USER_NAME", $lang);?>'/>
                    </div>
                    <a class='profile_button a_button' href='<?=$lserver?>/profile/'>
                        <span class='header_container'>
                            <span class='header_icon_container'><img class='header_icon' alt='<?=text($con, "PROFILE_CV", $lang);?>' src='<?=$lserver?>/img/icon/profile.gif'/></span>
                            <?=text($con, "PROFILE_CV", $lang);?>
                        </span>
                    </a>
                    <br/>
                    <a class='profile_button a_button' href='<?=$lserver?>/project/'>
                        <span class='header_container'>
                            <span class='header_icon_container'><img class='header_icon' alt='<?=text($con, "PROFILE_SKILLS", $lang);?>' src='<?=$lserver?>/img/icon/project.gif'/></span>
                            <?=text($con, "PROFILE_SKILLS", $lang);?>
                        </span>
                    </a>
<?php
                    include $doc_root . "footer.php";
                    stats($con, $cur_section, $cur_entry);
?>
                </div> <!-- #left -->
                <div id='right'>
<?php
                    if ($_GET['section'] == 'skills'){
                        include "skills.php";
                    }
                    else{
                        include "cv.php";
                    }
?>
                </div> <!-- #right -->
            </div> <!-- #body_row -->
        </div> <!-- #body -->
    </body>
</html>
