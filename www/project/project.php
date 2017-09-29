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

    // Get project data
    $permalink = mysqli_real_escape_string($con, $_GET["permalink"]);
    $q_project = mysqli_query($con, "SELECT * FROM project WHERE permalink = '$permalink' AND visible = 1;");
    if (mysqli_num_rows($q_project) == 0){
        header("Location: $lserver/project/");
        exit(-1);
    }
    $r_project = mysqli_fetch_array($q_project);
    $id = $r_project["id"];

    $title = text($con, $r_project["title"], $lang);
    $summary = text($con, $r_project["header"], $lang);

    $cur_section = "project";
    $cur_entry = $id;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1"/>
        <title><?=$title?> - I&ntilde;igo Valentin</title>
<?php
        if (strlen($r_project["logo"]) > 0){
?>
            <link rel="shortcut icon" href="<?=$lserver?>/img/logo/favicon.ico"/>
<?php
        }
        else{
?>
            <link rel="shortcut icon" href="<?=$lserver?>/img/project/icon/<?=$r_project["logo"]?>"/>
<?php
        }
?>
        <!-- CSS files -->
        <style>
<?php
            include $doc_root . "css/ui.css";
            include $doc_root . "css/project.css";
?>
        </style>
        <!-- CSS for mobile version -->
        <style media="(max-width : 990px)">
<?php
            include $doc_root . "css/m/ui.css";
            include $doc_root . "css/m/project.css";
?>
        </style>
        <!-- Script files -->
        <script type="text/javascript">
<?php
            include $doc_root . "script/ui.js";
            include $doc_root . "script/project.js";
?>
        </script>
        <!-- Meta tags -->
        <link rel="canonical" href="<?=$lserver?>/project/<?=$r_project["permalink"]?>"/>
        <link rel="author" href="<?=$lserver?>"/>
        <link rel="publisher" href="<?=$lserver?>"/>
        <meta name="description" content="<?=$summary?>"/>
        <meta property="og:title" content="<?=$title?> - I&ntilde;igo Valentin"/>
        <meta property="og:url" content="<?=$lserver?>/project/<?=$r_project["permalink"]?>"/>
        <meta property="og:description" content="<?=$summary?>"/>
<?php
        if (strlen($r_project["logo"]) > 0){
?>
            <meta property="og:image" content="<?=$lserver?>/img/logo/favicon.ico"/>
<?php
        }
        else{
?>
            <meta property="og:image" content="<?=$lserver?>/img/project/icon/<?=$r_project["logo"]?>"/>
<?php
        }
?>
        <meta property="og:site_name" content="I&ntilde;igo Valentin"/>
        <meta property="og:type" content="website"/>
        <meta property="og:locale" content="<?=$lang?>"/>
        <meta name="twitter:card" content="summary"/>
        <meta name="twitter:title" content="<?=$title?> - I&ntilde;igo Valentin"/>
        <meta name="twitter:description" content="<?=$summary?>"/>
<?php
        if (strlen($r_project["logo"]) > 0){
?>
            <meta name="twitter:image" content="<?=$lserver?>/img/logo/favicon.ico"/>
<?php
        }
        else{
?>
            <meta name="twitter:image" content="<?=$lserver?>/img/project/icon/<?=$r_project["logo"]?>"/>
<?php
        }
?>
        <meta name="twitter:url" content="<?=$lserver?>/project/<?=$r_project["permalink"]?>"/>
        <meta name="robots" content="index follow"/>
    </head>
    <body>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div id='content_row'>
                <div class='content_cell' id='content_cell_main'>
                    <div class='section' id='main_column'>
                        <h3 class='section_title'><?=$title?></h3>
                        <div class='entry'>
                            <h4><?=$summary?></h4>
<?php
                            $q_embed = mysqli_query($con, "SELECT * FROM project_url WHERE type = 'E' AND project = $id;");
                            while ($r_embed = mysqli_fetch_array($q_embed)){
?>
                                <br/><br/>
                                <div class='iframe_container'>
                                    <iframe class='project_embed' onload='resizeIframe(this);' src='<?=$lserver?><?=$r_embed["url"]?>'></iframe>
                                </div>
<?php
                            }
?>
                        </div> <!-- .entry -->
                    </div> <!-- #main_column -->
                </div> <!-- #content_cell_main -->
                <div class='content_cell'  id='content_cell_right'>
                    <div class='section section_no_title' id='right_column'>
                        <div class='entry'>
<?php
                            $q_url = mysqli_query($con, "SELECT url, title, summary, logo FROM project_url, project_url_type WHERE project_url_type.id = project_url.type AND project = $id AND type <> 'E';");
                            while ($r_url = mysqli_fetch_array($q_url)){
?>
                                <div class='url'>
                                    <a target='_blank' title='<?=text($con, $r_url["title"], $lang);?>' href='<?=text($con, $r_url["url"], $lang);?>'>
<?php
                                        if (strlen($r_url["logo"]) > 0){
?>
                                            <img title='<?=text($con, $r_url["title"], $lang);?>' src='<?=$lserver?>/img/url/<?=$r_url["logo"]?>'/>
<?php
                                        }
?>
                                        <?=text($con, $r_url["summary"], $lang);?>
                                    </a>
                                </div> <!-- .url -->
<?php
                            }
?>
                        </div> <!-- .entry -->
                        <div class='entry'>
<?php
                            $q_license = mysqli_query($con, "SELECT * FROM license WHERE id = '$r_project[license]';");
                            $r_license = mysqli_fetch_array($q_license);
?>
                            <span class='hidden' id='license_id'><?=$r_license["id"]?></span>
                            <span class='hidden' id='license_text'><?=$r_license["summary"]?></span>
                            <span class='fakelink pointer' onClick='showLicense();'>
                                <img title='<?=$r_license["id"]?>' src='<?=$lserver?>/img/license/icon/<?=$r_license["logo"]?>' />
                            <span>
                            <br/>
                            <br/>
<?php
                            $q_version = mysqli_query($con, "SELECT version_name, project_version.summary AS summary, dtime, title, project_version_type.summary AS vsummary, color FROM project_version, project_version_type WHERE type = id AND visible = 1 AND project = $id ORDER BY dtime DESC LIMIT 1;");
                            $r_version = mysqli_fetch_array($q_version);
?>
                            <?=text($con, 'PROJECT_VERSION', $lang)?> <?=$r_version["version_name"]?>
                            <span class='version_type' style='background-color: <?=$r_version["color"]?>'>
                                <?=text($con, $r_version["title"], $lang)?>
                            </span>
                        </div>
                    </div> <!-- #right_column -->
                </div> <!-- #content_cell_right -->
            </div> <!-- #content_row -->
        </div> <!-- #content -->
<?php

        //Footer
        include $doc_root . "footer.php";
        stats($con, $cur_section, $cur_entry);
?>
    </body>
</html>
