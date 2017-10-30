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
        <title><?=text($con, "USER_NAME", $lang);?></title>
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
        <meta property='og:title' content='<?=text($con, "USER_NAME", $lang);?>'/>
        <meta property='og:url' content='<?=$lserver?>'/>
        <meta property='og:description' content=''/>
        <meta property='og:image' content='<?=$lserver?>/img/logo/x3/favicon.ico''/>
        <meta property='og:site_name' content='<?=text($con, "USER_NAME", $lang);?>'/>
        <meta property='og:type' content='website'/>
        <meta property='og:locale' content='<?=$lang?>'/>
        <meta name='twitter:card' content='summary'/>
        <meta name='twitter:title' content='<?=text($con, "USER_NAME", $lang);?>'/>
        <meta name='twitter:description' content=''/>
        <meta name='twitter:image' content='<?=$lserver?>/img/logo/x3/favicon.ico''/>
        <meta name='twitter:url' content='<?=$lserver?>'/>
        <meta name='robots' content='index follow'/>
    </head>
    <body>
        <div id='logo'>
            <img id='logo' src='<?=$lserver?>/img/logo/x6/inigovalentin.png' alt='<?=text($con, "USER_NAME", $lang);?>'/>
        </div>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div id='content_row'>
                <div class='content_cell' id='content_cell_profile'>
                    <div class='section'>
                        <h3 class='section_title'><?=text($con, "USER_NAME", $lang);?></h3>
                        <div class='entry'>
                            <img id='profile' src='<?=$lserver?>/img/profile/x16/preview/0.png' alt='<?=text($con, "USER_NAME", $lang);?>' title='<?=text($con, "USER_NAME", $lang);?>' />
                        </div> <!-- .entry -->
                    </div> <!-- .section -->
                </div> <!-- #content_cell_profile -->
                <div class='content_cell' id='content_cell_content'>
                    <div class='section' id='projects_section'>
                        <h3 class='section_title'><?=text($con, 'INDEX_LATEST_PROJECTS', $lang)?></h3>
<?php
                        $q_project = mysqli_query($con, "SELECT id, permalink, type, title, logo, header, license, (SELECT dtime FROM project_version WHERE project = p.id AND visible = 1 ORDER BY dtime desc LIMIT 1) AS modified FROM project p WHERE visible = 1 ORDER BY modified DESC LIMIT 3;");
                        while ($r_project = mysqli_fetch_array($q_project)){
?>
                            <div class='entry entry_list project_row'>
                                <table>
                                    <tr>
<?php
                                        if (strlen($r_project["logo"]) > 0){
?>
                                            <td>
                                                <a title='<?=text($con, $r_project["title"], $lang)?>' href='<?=$lserver?>/project/<?=$r_project["permalink"]?>'>
                                                    <img clsass='project_list_image' alt='<?=text($con, $r_project["title"], $lang)?>' title='<?=text($con, $r_project["title"], $lang)?>' src='<?=$lserver?>/img/project/x2/<?=$r_project["logo"]?>'/>
                                                </a>
                                            </td>
<?php
                                        }
?>
                                        <td>
                                            <a title='<?=text($con, $r_project["title"], $lang)?>' href='<?=$lserver?>/project/<?=$r_project["permalink"]?>'>
                                                <h4><?=text($con, $r_project["title"], $lang)?></h4>
                                            </a>                                                <?=text($con, $r_project["header"], $lang)?>
                                        </td>
                                    </tr>
                                </table>
                            </div> <!-- .entry -->
<?php
                        }
?>
                    </div> <!-- .section -->
                    <div class='section' id='blog_section'>
                        <h3 class='section_title'><?=text($con, 'INDEX_LATEST_POSTS', $lang)?></h3>
<?php
                        $q_blog = mysqli_query($con, "SELECT id, permalink, title, text, DATE_FORMAT(dtime, '%Y-%m-%dT%T') AS isodate, dtime, comments FROM post WHERE visible = 1 ORDER BY dtime DESC;");
                        while($r_blog = mysqli_fetch_array($q_blog)){
?>
                            <div itemscope itemtype='http://schema.org/BlogPosting' class='entry entry_list blog_entry'>
                                <meta itemprop='inLanguage' content='<?=$lang?>'/>
                                <meta itemprop='datePublished dateModified' content='<?=$r_blog["isodate"]?>'/>
                                <meta itemprop='headline name' content='<?=text($con, $r_blog["title"], $lang)?>'/>
                                <meta itemprop='articleBody text' content='<?=text($con, $r_blog["text"], $lang)?>'/>
                                <meta itemprop='mainEntityOfPage' content='<?=$lserver?>'/>
                                <h3 class='entry_title'>
                                    <a itemprop='url' href='<?=$lserver?>/blog/<?=$r_blog["permalink"]?>'><?=text($con, $r_blog["title"], $lang)?></a>
                                </h3>
<?php
                                $q_image = mysqli_query($con, "SELECT image FROM post_image WHERE post = $r_blog[id] ORDER BY idx LIMIT 1;");
                                if (mysqli_num_rows($q_image) > 0){
                                    $r_image = mysqli_fetch_array($q_image);
?>
                                    <div class='post_list_image_container'>
                                        <a href='<?=$lserver?>/blog/<?=$r_blog["permalink"]?>'>
                                            <meta itemprop='image' content='<?=$lserver?>/img/blog/x4/<?=$r_image["image"]?>'/>
                                            <img class='post_list_image' alt='<?=$r_blog["title"]?>' src='<?=$lserver?>/img/blog/x2/<?=$r_image["image"]?>'/>
                                        </a>
                                    </div>
<?php
                                }
?>
                                <p><?=cut_text(text($con, $r_blog["text"], $lang), 150, text($con, "BLOG_MORE", $lang), "$lserver/blog/$r_blog[permalink]/")?></p>
                                <hr/>
                                <table class='post_list_footer'>
                                    <tr>
                                        <td class='date'>
                                            <span class='date'><?=format_date($r_blog['dtime'], $lang, false)?></span>
                                        </td>
<?php
                                        #Comment counter
                                        if ($r_blog["comments"] == 1){
                                            $q_comment = mysqli_query($con, "SELECT count(id) AS count FROM post_comment WHERE post = $r_blog[id] AND approved = 1;");
                                            $r_comment = mysqli_fetch_array($q_comment);
?>
                                            <meta itemprop='commentCount interationCount' content='<?=$r_comment["count"]?>'/>
                                            <td class='comment_counter'>
<?php
                                                if ($r_comment['count'] == 1){
?>
                                                    <span class='comment_counter'>1 <?=text($con, "BLOG_COMMENTS_1", $lang)?></span>
<?php
                                                }
                                                else if ($r_comment['count'] == 0){
?>
                                                    <span class='comment_counter'><?=text($con, "BLOG_COMMENTS_0", $lang)?></span>
<?php
                                                }
                                                else{
?>
                                                    <span class='comment_counter'><?=$r_comment["count"]?> <?=text($con, "BLOG_COMMENTS_X", $lang)?></span>
<?php
                                                }
?>
                                            </td>
<?php
                                        } // if ($r_blog["comments"] == 1)
?>
                                    </tr>
                                </table> <!-- .post_list_footer -->
                            </div> <!-- .blog_entry -->
                            </br>
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
