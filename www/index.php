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
    $cur_section = "";
    $cur_entry = "";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta content='text/html; charset=utf-8' http-equiv='content-type'/>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'/>
        <title>I&ntilde;igo Valentin</title>
        <link rel='shortcut icon' href='<?=$lserver?>/img/logo/x2/favicon.ico'/>
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
        <meta property='og:title' content='I&ntilde;igo Valentin'/>
        <meta property='og:url' content='<?=$lserver?>'/>
        <meta property='og:description' content=''/>
        <meta property='og:image' content='<?=$lserver?>/img/logo/x3/favicon.ico''/>
        <meta property='og:site_name' content='I&ntilde;igo Valentin'/>
        <meta property='og:type' content='website'/>
        <meta property='og:locale' content='<?=$lang?>'/>
        <meta name='twitter:card' content='summary'/>
        <meta name='twitter:title' content='I&ntilde;igo Valentin'/>
        <meta name='twitter:description' content=''/>
        <meta name='twitter:image' content='<?=$lserver?>/img/logo/x3/favicon.ico''/>
        <meta name='twitter:url' content='<?=$lserver?>'/>
        <meta name='robots' content='index follow'/>
    </head>
    <body>
        <div id='logo'>
            <img id='logo' src='<?=$lserver?>/img/logo/x6/inigovalentin.png' alt='I&ntilde;igo Valentin'/>
        </div>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div id='content_row'>
                <div class='content_cell' id='content_cell_profile'>
                    <div class='section'>
                        <h3 class='section_title'>I&ntilde;igo Valentin</h3>
                        <div class='entry'>
                            <img id='profile' src='<?=$lserver?>/img/profile/x16/preview/0.png' alt='I&ntilde;igo Valentin' title='I&ntilde;igo Valentin' />
                        </div> <!-- .entry -->
                    </div> <!-- .section -->
                </div> <!-- #content_cell_profile -->
                <div class='content_cell' id='content_cell_content'>
                    <div class='section'>
                        <h3 class='section_title'>TR#Ultimos proyectos</h3>
<?php
                        $q_project = mysqli_query($con, "SELECT id, permalink, type, title, logo, header, license, (SELECT dtime FROM project_version WHERE project = p.id AND visible = 1 ORDER BY dtime desc LIMIT 1) AS modified FROM project p WHERE visible = 1 ORDER BY modified DESC LIMIT 3;");
                        while ($r_project = mysqli_fetch_array($q_project)){
?>
                            <a href='<?=$lserver?>/project/<?=$r_project["permalink"]?>'>
                                <div class='entry project_row'>
                                    <table>
                                        <tr>
<?php
                                            if (strlen($r_project["logo"]) > 0){
?>
                                                <td>
                                                    <img alt='<?=text($con, $r_project["title"], $lang)?>' title='<?=text($con, $r_project["title"], $lang)?>' src='<?=$lserver?>/img/project/x2/<?=$r_project["logo"]?>'/>
                                                </td>
<?php
                                            }
?>
                                            <td>
                                                <h4><?=text($con, $r_project["title"], $lang)?></h4>
                                                <?=text($con, $r_project["header"], $lang)?>
                                            </td>
                                        </tr>
                                    </table>
                                </div> <!-- .entry -->
                            </a>
<?php
                        }
?>
                        <h3 class='section_title'>TR#Ultimos posts</h3>
<?php
                        $q_blog = mysqli_query($con, "SELECT * FROM post WHERE visible = 1 ORDER BY dtime DESC LIMIT 2;");
                        while ($r_blog = mysqli_fetch_array($q_blog)){
                            $q_image = mysqli_query($con, "SELECT * FROM post_image WHERE post = $r_blog[id] ORDER BY id LIMIT 1;");
?>
                            <a href='<?=$lserver?>/blog/<?=$r_blog["permalink"]?>'>
                                <div class='entry blog_row'>
                                    <table>
                                        <tr>
<?php
                                            if (mysqli_num_rows($q_image) > 0){
                                                $r_image = mysqli_fetch_array($q_image);
?>
                                                <td>
                                                    <img alt='<?=text($con, $r_blog["title"], $lang)?>' title='<?=text($con, $r_blog["title"], $lang)?>' src='<?=$lserver?>/img/blog/x2/<?=$r_image["image"]?>'/>
                                                </td>
<?php
                                            }
?>
                                            <td>
                                                <h4><?=text($con, $r_blog["title"], $lang)?></h4>
                                                <?=cut_text(text($con, $r_project["header"], $lang), 165, "TR#Leer mas", $lserver . "/blog/" . $r_blog["permalink"])?>
                                            </td>
                                        </tr>
                                    </table>
                                </div> <!-- .entry -->
                            </a>
<?php
                        }
?>
                    </div> <!-- .section -->
                </div> <!-- #content_cell_content -->
            </div> <!-- .content_row -->
        </div> <!-- #content -->
<?php
        include $doc_root . "footer.php";
        stats($con, $cur_section, $cur_entry);
?>
    </body>
</html>
