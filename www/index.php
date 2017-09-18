<?php
    session_start();
    $http_host = $_SERVER['HTTP_HOST'];
    $doc_root = $_SERVER['DOCUMENT_ROOT']; 
    include $doc_root . 'functions.php';
    $proto = get_protocol();
    $con = start_db();
    $server = $proto . $http_host;

    //Language
    $lang = select_language();

    $cur_section = '';
    $cur_entry = '';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta content='text/html; charset=utf-8' http-equiv='content-type'/>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'/>
        <title>I&ntilde;igo Valentin</title>
        <link rel='shortcut icon' href='<?=$server?>/img/logo/favicon.ico'/>
        <!-- CSS files -->
        <style>
<?php
            include $doc_root . 'css/ui.css';
            include $doc_root . 'css/home.css';
?>
        </style>
        <!-- CSS for mobile version -->
        <style media='(max-width : 990px)'>
<?php
            include $doc_root . 'css/m/ui.css';
            include $doc_root . 'css/m/home.css';
?>
        </style>
        <!-- Script files -->
        <script type='text/javascript'>
<?php
            include $doc_root . 'script/ui.js';
?>
        </script>
        <!-- Meta tags -->
        <link rel='canonical' href='<?=$server?>'/>
        <link rel='author' href='<?=$server?>'/>
        <link rel='publisher' href='<?=$server?>'/>
        <meta name='description' content=''/>
        <meta property='og:title' content='I&ntilde;igo Valentin'/>
        <meta property='og:url' content='<?=$server?>'/>
        <meta property='og:description' content=''/>
        <meta property='og:image' content=''/>
        <meta property='og:site_name' content='I&ntilde;igo Valentin'/>
        <meta property='og:type' content='website'/>
        <meta property='og:locale' content='<?=$lang?>'/>
        <meta name='twitter:card' content='summary'/>
        <meta name='twitter:title' content='I&ntilde;igo Valentin'/>
        <meta name='twitter:description' content=''/>
        <meta name='twitter:image' content=''/>
        <meta name='twitter:url' content='<?=$server?>'/>
        <meta name='robots' content='index follow'/>
    </head>
    <body>
        <div id='logo'>
            <img id='logo' src='<?=$server?>/img/logo/inigovalentin.png' alt='I&ntilde;igo Valentin'/>
        </div>
<?php
        include $doc_root . 'header.php';
?>
        <div id='content'>

        </div> <!-- #content -->
<?php

        //Footer
        include $doc_root . 'footer.php';
        stats($cur_section, $cur_entry);
?>
    </body>
</html>
