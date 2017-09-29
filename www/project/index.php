<?php
    session_start();
    $http_host = $_SERVER["HTTP_HOST"];
    $doc_root = $_SERVER["DOCUMENT_ROOT"];
    include $doc_root . "functions.php";
    $proto = get_protocol();
    $con = start_db();
    $server = $proto . $http_host;
    $lang = select_language();
    $cur_section = "project";
    $cur_entry = "";

?>
<!DOCTYPE html>
<html>
    <head>
        <meta content='text/html; charset=utf-8' http-equiv='content-type'/>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'/>
        <title><?=text($con, "PROJECT_TITLE", $lang)?> - I&ntilde;igo Valentin</title>
        <link rel='shortcut icon' href='<?=$server?>/img/logo/favicon.ico'/>
        <!-- CSS files -->
        <style>
<?php
            include $doc_root . "css/ui.css";
            include $doc_root . "css/project.css";
?>
        </style>
        <!-- CSS for mobile version -->
        <style media='(max-width : 990px)'>
<?php
            include $doc_root . "css/m/ui.css";
            include $doc_root . "css/m/project.css";
?>
        </style>
        <!-- Script files -->
        <script type='text/javascript'>
<?php
            include $doc_root . "script/ui.js";
            include $doc_root . "script/project.js";
?>
        </script>
        <!-- Meta tags -->
        <link rel='canonical' href='<?=$server?>/project/'/>
        <link rel='author' href='<?=$server?>'/>
        <link rel='publisher' href='<?=$server?>'/>
        <meta name='description' content='<?=text($con, "PROJECT_DESCRIPTION", $lang)?>'/>
        <meta property='og:title' content='<?=text($con, "PROJECT_TITLE", $lang)?> - I&ntilde;igo Valentin'/>
        <meta property='og:url' content='<?=$server?>/project/'/>
        <meta property='og:description' content='<?=text($con, "PROJECT_DESCRIPTION", $lang)?>'/>
        <meta property='og:image' content='<?=$server?>/img/logo/favicon.ico'/>
        <meta property='og:site_name' content='I&ntilde;igo Valentin'/>
        <meta property='og:type' content='website'/>
        <meta property='og:locale' content='<?=$lang?>'/>
        <meta name='twitter:card' content='summary'/>
        <meta name='twitter:title' content='<?=text($con, "PROJECT_TITLE", $lang)?> - I&ntilde;igo Valentin'/>
        <meta name='twitter:description' content='<?=text($con, "PROJECT_DESCRIPTION", $lang)?>'/>
        <meta name='twitter:image' content='<?=$server?>/img/logo/favicon.ico'/>
        <meta name='twitter:url' content='<?=$server?>/project/'/>
        <meta name='robots' content='index follow'/>
    </head>
    <body>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div id='content_row'>
                <div class='content_cell' id='content_cell_main'>
                    <div class='section' id='main_column'>
                        <h3 class='section_title'><?=text($con, "PROJECT_TITLE", $lang)?></h3>
<?php
                        $q_project = mysqli_query($con, "SELECT id, permalink, type, title, logo, header, license, (SELECT dtime FROM project_version WHERE project = p.id AND visible = 1 ORDER BY dtime desc LIMIT 1) AS modified FROM project p WHERE visible = 1 ORDER BY modified DESC;");
                        while ($r_project = mysqli_fetch_array($q_project)){
?>
                            <div class='entry project_row'>
                                <h4><?=text($con, $r_project["title"], $lang)?></h4>
<?php
                                if (strlen($r_project["logo"]) > 0){
?>
                                    <img title='<?=text($con, $r_project["title"], $lang)?>' src='<?=$server?>/img/project/logo/<?=$r_project["logo"]?>'/>
<?php
                                }
?>
                                <?=text($con, $r_project["header"], $lang)?>
                            </div> <!-- .entry -->
<?php
                        }
?>
                    </div> <!-- #main_column -->
                </div> <!-- #content_cell_main -->
                <div class='content_cell'  id='content_cell_right'>
                    <div class='section section_no_title' id='right_column'>
                        <div class='entry'>
                            <input type='text' placeholder='<?=text($con, "PROJECT_SEARCH", $lang)?>' name='text'/>
                            <input type='hidden' id='advanced_search_indicator' value='0'/>
                            <div class='pointer' onClick='showAdvancedSearch();'>
                                <img class='slider' id='advanced_search_slider' src='<?=$server?>/img/misc/slid-right.png'/>
                                <?=text($con, "PROJECT_SEARCH_ADVANCED", $lang)?>
                            </div>
                            <div id='advanced_search'>
                                <?=text($con, "PROJECT_SEARCH_TYPE", $lang)?>
<?php
                                $q_type = mysqli_query($con, "SELECT id, title FROM project_type;");
                                while ($r_type = mysqli_fetch_array($q_type)){
?>
                                    <br/>
                                    <label>
                                        <input type='checkbox' name='type_<?=$r_type["id"]?>' checked/>
                                        <?=text($con, $r_type["title"], $lang)?>
                                    </lable>
<?php
                                }
?>
                                <br/><br/>
                                <?=text($con, "PROJECT_SEARCH_LICENSE", $lang)?>
<?php
                                $q_license = mysqli_query($con, "SELECT id FROM license;");
                                while ($r_license = mysqli_fetch_array($q_license)){
?>
                                    <br/>
                                    <label>
                                        <input type='checkbox' name='type_<?=$r_license["id"]?>' checked/>
                                        <?=$r_license["id"]?>
                                    </lable>
<?php
                                }
?>
                            </div>

                        </div> <!-- .entry -->
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