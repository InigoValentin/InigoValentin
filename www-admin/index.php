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
        header("Location: /authentication.php");
        exit(-1);
    }
    else{
?>
<html>
    <head>
        <meta content='text/html; charset=windows-1252' http-equiv='content-type'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'>
        <link rel='shortcut icon' href='<?=$pserver?>/img/logo/x2/favicon.ico'/>
        <title>I&ntilde;igo Valentin - Administration Panel</title>
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
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div id='section_table'>
                <div class='section_row'>
                    <div class='section_cell'>
                        <div class='section'>
                            <h3 class='section_title'>Blog</h3>
                            <div class='entry'>
                                <ul>
                                    <li><a href='<?=$server?>/blog/add/'>New post</a></li>
                                    <li><a href='<?=$server?>/blog/'>Manage posts</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class='section_cell'>
                        <div class='section'>
                            <h3 class='section_title'>Projects</h3>
                            <div class='entry'>
                                <ul>
                                    <li><a href='<?=$server?>/projects/add/'>New project</a></li>
                                    <li><a href='<?=$server?>/projects/'>Manage projects</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> <!-- .section_row -->
                <div class='section_row'>
                    <div class='section_cell'>
                        <div class='section'>
                            <h3 class='section_title'>Stats</h3>
                            <div class='entry'>
                                <ul>
                                    <li><a href='<?=$server?>/stats/'>View stats</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class='section_cell'>
                        <div class='section'>
                            <h3 class='section_title'>Settings</h3>
                            <div class='entry'>
                                <ul>
                                    <li><a href='<?=$server?>/settings/'>Page settings</a></li>
                                    <li><a href='<?=$server?>/settings/profile.php'>Profile settings</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> <!-- .section_row -->
            </div> <!-- #section_table -->
        </div> <!-- #content -->
    </body>
</html>
<?php
    }
?>
