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
    $cur_section = "blog";
    $cur_entry = "";

?>
<!DOCTYPE html>
<html>
    <head>
        <meta content='text/html; charset=utf-8' http-equiv='content-type'/>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'/>
        <title><?=text($con, "BLOG_TITLE", $lang)?> - <?=text($con, "USER_NAME", $lang);?></title>
        <link rel='shortcut icon' href='<?=$lserver?>/img/logo/favicon.ico'/>
        <!-- CSS files -->
        <style>
<?php
            include $doc_root . "css/ui.css";
            include $doc_root . "css/blog.css";
?>
        </style>
        <!-- CSS for mobile version -->
        <style media='(max-width : 990px)'>
<?php
            include $doc_root . "css/m/ui.css";
            include $doc_root . "css/m/blog.css";
?>
        </style>
        <!-- Script files -->
        <script type='text/javascript'>
<?php
            include $doc_root . "script/ui.js";
            include $doc_root . "script/blog.js";
?>
        </script>
        <!-- Meta tags -->
        <link rel='canonical' href='<?=$lserver?>/blog/'/>
        <link rel='author' href='<?=$lserver?>'/>
        <link rel='publisher' href='<?=$lserver?>'/>
        <meta name='description' content='<?=text($con, "BLOG_DESCRIPTION", $lang)?>'/>
        <meta property='og:title' content='<?=text($con, "BLOG_TITLE", $lang)?> - <?=text($con, "USER_NAME", $lang);?>'/>
        <meta property='og:url' content='<?=$lserver?>/blog/'/>
        <meta property='og:description' content='<?=text($con, "BLOG_DESCRIPTION", $lang)?>'/>
        <meta property='og:image' content='<?=$lserver?>/img/logo/favicon.ico'/>
        <meta property='og:site_name' content='<?=text($con, "USER_NAME", $lang);?>'/>
        <meta property='og:type' content='website'/>
        <meta property='og:locale' content='<?=$lang?>'/>
        <meta name='twitter:card' content='summary'/>
        <meta name='twitter:title' content='<?=text($con, "BLOG_TITLE", $lang)?> - <?=text($con, "USER_NAME", $lang);?>'/>
        <meta name='twitter:description' content='<?=text($con, "BLOG_DESCRIPTION", $lang)?>'/>
        <meta name='twitter:image' content='<?=$lserver?>/img/logo/favicon.ico'/>
        <meta name='twitter:url' content='<?=$lserver?>/project/'/>
        <meta name='robots' content='index follow'/>
    </head>
    <body>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div id='content_row'>
                <div class='content_cell' id='content_cell_main'>
                    <div id='post_list' class='section'>
                        <h3 class='section_title'><?=text($con, "BLOG_TITLE", $lang)?></h3>
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
                                    <p><?=cut_text(text($con, $r_blog["text"], $lang), 200, text($con, "BLOG_MORE", $lang), "$lserver/blog/$r_blog[permalink]/")?></p>
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
<?php
                                    // Tags
                                    $q_tag = mysqli_query($con, "SELECT tag FROM post_tag WHERE post= $r_blog[id];");
                                    if (mysqli_num_rows($q_tag) > 0){
                                        $tag_string = "<span class='tags'>" . text($con, "BLOG_TAGS", $lang);
                                        $tag_raw = "";
                                        while ($r_tag = mysqli_fetch_array($q_tag)){
                                            $tag_string = $tag_string . "<a href='$proto$http_host/blog/search/tag/$r_tag[tag]'> " . text($con, $r_tag["tag"], $lang) . "</a>, ";
                                            $tag_raw = $tag_raw . "$r_tag[tag],";
                                        }
                                        $tag_string = substr($tag_string, 0, strlen($tag_string) - 2);
                                        $tag_string = $tag_string . "</span>";
                                        $tag_raw = substr($tag_raw, 0, strlen($tag_raw) - 1);
?>
                                        <meta itemprop='keywords' content='<?=$tag_raw?>'/>
                                        <?=$tag_string?>
<?php
                                    }
?>
                                </div> <!-- .blog_entry -->
                                </br>
<?php
                            } // while($r_blog = mysqli_fetch_array($q_blog))
?>
                    </div> <!-- #main_column -->
                </div> <!-- #content_cell_main -->
                <div class='content_cell'  id='content_cell_right'>
                    <div class='section' id='info'>
                        <h3 class='section_title'><?=text($con, "BLOG_DETAILS", $lang)?></h3>
                        <div id='info_search' class='entry'>
                            <h4><?=text($con, "BLOG_SEARCH", $lang)?></h4>
                            <div id='search_panel_inputs'>
                                <form action='#' onSubmit='event.preventDefault();launchSearch("<?=$lng["search_field_all"]?>");'>
                                    <input id='search_panel_input' class='search_element' type='text' name='query' placeholder='<?=text($con, "BLOG_SEARCH", $lang)?>'/>
                                    <input id='search_panel_submit' class='search_element' type='submit' value='<?=text($con, "BLOG_SEARCH", $lang)?>'/>
                                </form>
                            </div>
                        </div> <!-- #info_search -->
                        <hr/>
                        <div id='info_tag_cloud' class='entry'>
                            <h4><?=text($con, "BLOG_TAG_CLOUD", $lang)?></h4>
                            <div id='cloud'>
<?php
                                //Get the most used tag
                                $q_max = mysqli_query($con, "SELECT max(count) AS max FROM (SELECT count(post) AS count FROM post_tag GROUP BY tag) AS t;");
                                $r_max = mysqli_fetch_array($q_max);
                                $max = $r_max["max"];
                                $q_tag = mysqli_query($con, "SELECT tag, count(post) AS count FROM post_tag GROUP BY tag;");
                                while($r_tag = mysqli_fetch_array($q_tag)){
                                    $size = round(60 + 100 * $r_tag['count'] / $max);
?>
                                    <a href='<?=$lserver?>/blog/search/tag/<?=$r_tag["tag"]?>'>
                                        <span style='font-size: <?=$size?>%'><?=text($con, $r_tag["tag"], $lang)?></span>
                                    </a>
<?php
                                }
?>
                            </div>
                        </div> <!-- #info_tag_cloud -->
                        <hr/>
                        <div id='info_all' class='entry'>
                            <h4><?=text($con, "BLOG_ARCHIVE", $lang)?></h4>
<?php
                            $q_year = mysqli_query($con, "SELECT year(dtime) AS year FROM post WHERE visible = 1 GROUP BY year(dtime) ORDER BY year DESC;");
                            while($r_year = mysqli_fetch_array($q_year)){
?>
                                <div class='year pointer' onClick='toggleElement("year_<?=$r_year["year"]?>");'>
                                    <img class='slider' id='slid_year_<?=$r_year["year"]?>' src='<?=$server?>/img/misc/slid-right.png' alt='<?=$r_year["year"]?>'/>
                                    <span class='fake_a'><?=$r_year["year"]?></span>
                                </div>
                                <div class='list_year pointer' id='list_year_<?=$r_year["year"]?>'>
<?php
                                    $q_month = mysqli_query($con, "SELECT month(dtime) AS month FROM post WHERE visible = 1 AND year(dtime) = $r_year[year] GROUP BY month(dtime) ORDER BY month DESC;");
                                    while($r_month = mysqli_fetch_array($q_month)){
?>
                                        <div class='month pointer' onClick='toggleElement("month_<?=$r_year["year"]?>_<?=$r_month["month"]?>");'>
                                            <img class='slider' id='slid_month_<?=$r_year["year"]?>_<?=$r_month["month"]?>' src='<?=$server?>/img/misc/slid-right.png' alt='<?=$r_month["month"]?>'/>
                                            <span class='fake_a'><?=ucfirst(text($con, "MONTH_" . str_pad($r_month["month"], 2, "0", STR_PAD_LEFT), $lang))?></span>
                                        </div>
                                        <ul id='list_month_<?=$r_year["year"]?>_<?=$r_month["month"]?>' class='post_list'>
<?php
                                            $q_title = mysqli_query($con, "SELECT id, permalink, title FROM post WHERE visible = 1 AND year(dtime) = $r_year[year] AND month(dtime) = '$r_month[month]' ORDER BY dtime DESC;");
                                            while($r_title = mysqli_fetch_array($q_title)){
?>
                                                <li>
                                                    <a href='<?=$lserver?>/blog/<?=$r_title["permalink"]?>'><?=text($con, $r_title["title"], $lang)?></a>
                                                </li>
<?php
                                            }
?>
                                        </ul>
<?php
                                    }
?>
                                </div> <!-- #list_year_<?=$r_year["year"]?> -->
<?php
                            } //while($r_year = mysqli_fetch_array($q_year))
?>
                        </div> <!-- #info_all -->
                    </div> <!-- #info -->
                </div> <!-- .content_cell -->
             </div> <!-- #content_row -->
         </div> <!-- #content -->
<?php
        include $doc_root . "footer.php";
        stats($con, $cur_section, $cur_entry);
?>
    </body>
</html>
