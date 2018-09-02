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
    $cur_section = "";
    $cur_entry = "";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta content='text/html; charset=utf-8' http-equiv='content-type'/>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'/>
        <title><?=text($con, "USER_NAME", $lang);?></title>
        <link rel='shortcut icon' href='<?=$lserver?>/img/logo/favicon.ico'/>
        <!-- CSS files -->
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
        <!-- Meta tags -->
        <link rel='canonical' href='<?=$lserver?>'/>
        <link rel='author' href='<?=$lserver?>'/>
        <link rel='publisher' href='<?=$lserver?>'/>
        <meta name='description' content=''/>
        <meta property='og:title' content='<?=text($con, "USER_NAME", $lang);?>'/>
        <meta property='og:url' content='<?=$lserver?>'/>
        <meta property='og:description' content=''/>
        <meta property='og:image' content=''/>
        <meta property='og:site_name' content='<?=text($con, "USER_NAME", $lang);?>'/>
        <meta property='og:type' content='website'/>
        <meta property='og:locale' content='<?=$lang?>'/>
        <meta name='twitter:card' content='summary'/>
        <meta name='twitter:title' content='<?=text($con, "USER_NAME", $lang);?>'/>
        <meta name='twitter:description' content=''/>
        <meta name='twitter:image' content=''/>
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
                    <div class='entry'>
                        <img id='profile' src='<?=$lserver?>/img/profile/x6/0.png' alt='<?=text($con, "USER_NAME", $lang);?>' title='<?=text($con, "USER_NAME", $lang);?>' />
                        <br/>
                        <span id='tagline'><?=text($con, "USER_TAGLINE", $lang);?></span>
                    </div> <!-- .entry -->
                    <a class='a_button' href='<?=$lserver?>/profile/'>
                        <span class='header_container'>
                            <span class='header_icon_container'><img class='header_icon' alt='<?=text($con, "HEADER_ME", $lang);?>' src='<?=$lserver?>/img/icon/profile.gif'/></span>
                            <?=text($con, "INDEX_PROFILE", $lang);?>
                        </span>
                    </a>
                    <span class='link_separator desktop'></span>
                    <a class='a_button' href='<?=$lserver?>/project/'>
                        <span class='header_container'>
                            <span class='header_icon_container'><img class='header_icon' alt='<?=text($con, "HEADER_PROJECTS", $lang);?>' src='<?=$lserver?>/img/icon/projects.gif'/></span>
                            <?=text($con, "INDEX_PROJECTS", $lang);?>
                        </span>
                    </a>
<?php
                    include $doc_root . "footer.php";
?>
                </div> <!-- left -->
                <div id='right'>
                    <p>
                        <?=text($con, "USER_BIO", $lang);?>
                    </p>
                </div>
            </div> <!-- #body_row -->
        </div> <!-- #body -->
    </body>
</html>
