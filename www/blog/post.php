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

    // Get post data
    $permalink = mysqli_real_escape_string($con, $_GET["permalink"]);
    $q_post = mysqli_query($con, "SELECT * FROM post WHERE permalink = '$permalink' AND visible = 1;");
    if (mysqli_num_rows($q_post) == 0){
        header("Location: $lserver/blog/");
        exit(-1);
    }
    $r_post = mysqli_fetch_array($q_post);
    $id = $r_post["id"];
    $title = text($con, $r_post["title"], $lang);
    $text = text($con, $r_post["text"], $lang);

    $cur_section = "blog";
    $cur_entry = $id;

    // First image (if any)
    $image = "";
    $q_image = mysqli_query($con, "SELECT image FROM post_image WHERE post = $id ORDER BY idx LIMIT 1");
    if (mysqli_num_rows($q_image) > 0){
        $image = mysqli_fetch_array($q_image)["image"];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta content='text/html; charset=utf-8' http-equiv='content-type'/>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'/>
        <title><?=$title?> - <?=text($con, "USER_NAME", $lang);?></title>
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
        <link rel='canonical' href='<?=$lserver?>/blog/<?=$permalink?>'/>
        <link rel='author' href='<?=$lserver?>'/>
        <link rel='publisher' href='<?=$lserver?>'/>
        <meta name='description' content='<?=$text?>'/>
        <meta property='og:title' content='<?=$title?> - <?=text($con, "USER_NAME", $lang);?>'/>
        <meta property='og:url' content='<?=$lserver?>/blog/<?=$permalink?>'/>
        <meta property='og:description' content='<?=$text?>'/>
<?php
        if (strlen($image) == 0){
?>
            <meta property="og:image" content="<?=$lserver?>/img/logo/x3/favicon.ico"/>
<?php
        }
        else{
?>
            <meta property="og:image" content="<?=$lserver?>/img/blog/x3/<?=$image?>"/>
<?php
        }
?>
        <meta property='og:site_name' content='<?=text($con, "USER_NAME", $lang);?>'/>
        <meta property='og:type' content='website'/>
        <meta property='og:locale' content='<?=$lang?>'/>
        <meta name='twitter:card' content='summary'/>
        <meta name='twitter:title' content='<?=$title?> - <?=text($con, "USER_NAME", $lang);?>'/>
        <meta name='twitter:description' content='<?=$text?>'/>
<?php
        if (strlen($image) == 0){
?>
            <meta property="twitter:image" content="<?=$lserver?>/img/logo/x3/favicon.ico"/>
<?php
        }
        else{
?>
            <meta property="twitter:image" content="<?=$lserver?>/img/blog/x3/<?=$image?>"/>
<?php
        }
?>        <meta name='twitter:url' content='<?=$lserver?>/blog/<?=$permalink?>'/>
        <meta name='robots' content='index follow'/>
    </head>
    <body>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div id='content_row'>
                <div id='content_cell_post' class='content_cell'>
                    <div class='section' id='post'>
                        <h3 class='section_title'><?=$title?></h3>
                        <div class='entry'>
<?php
                            if (strlen($image) > 0){
?>
                                <img id='post_main_image' src='<?=$lserver?>/img/blog/x6/<?=$image?>' alt='<?=$title?>' title='<?=$title?>' />
<?php
                            }
?>
                            <?=$text?>
<?php
                            $q_image = mysqli_query($con, "SELECT image FROM post_image WHERE post = $id ORDER BY idx OFFSET 1");
                            if (mysqli_num_rows($q_image) > 0){
?>
                                <div id='image_reel'>
<?php
                                    while ($r_image = mysqli_fetch_array($q_image)){
?>
                                        <img src='<?=$lserver?>/img/blog/x6/<?=$r_image["image"]?>' alt='<?=$title?>' title='<?=$title?>' />
<?php
                                    }
?>
                                </div> <!-- #image_reel -->
<?php
                            }
?>
                            <hr/>
<?php
                            #Comments
                            if ($r_post["comments"] == 1){
                                $q_comment = mysqli_query($con, "SELECT id, post, DATE_FORMAT(dtime, '%Y-%m-%dT%T') AS cdate, DATE_FORMAT(dtime,'%b %d, %Y - %H:%i') AS dtime, user, username, text FROM post_comment WHERE post = $id;");
                                $count = mysqli_num_rows($q_comment);
                                if ($count == 1){
?>
                                    <span class='comment_counter'>1 <?=text($con, "BLOG_COMMENTS_1", $lang)?></span>
<?php
                                }
                                else if ($count == 0){
?>
                                    <span class='comment_counter'><?=text($con, "BLOG_COMMENTS_0", $lang)?></span>
<?php
                                }
                                else{
?>
                                    <span class='comment_counter'><?=$count?> <?=text($con, "BLOG_COMMENTS_X", $lang)?></span>
<?php
                                }
                                while ($r_comment = mysqli_fetch_array($q_comment)){
                                    $user = $r_comment["username"];
                                    $user_string = $user;
                                    if (strlen($user) == 0){
                                        $user = mysqli_fetch_array(mysqli_query($con, "SELECT concat(fname, concat(' ', lname)) AS name FROM user WHERE id = $r_comment[user];"))["name"];
                                        $user_string = "<span class='comment_user_registered'>$user</span>";
                                    }
?>
                                    <div itemprop='comment' itemscope itemtype='http://schema.org/UserComments' id='comment_<?=$r_comment["id"]?>' class='comment'>
                                        <h4  class='comment_user'><?=$user_string?></h4>
                                        <meta itemprop='creator' content='<?=$user?>'>
                                        <span class='comment_date date'>
                                            <time itemprop='commentTime' datetime='<?=$r_comment["cdate"]?>'>
                                            <?=$r_comment["dtime"]?>
                                        </span>
                                        <p itemprop='commentText' class='comment_text'><?=$r_comment["text"]?></p>
                                    </div>
<?php
                                }
                                //Comment form
?>
                                <div class='comment' id='comment_new'>
                                    <textarea id='new_comment_text' name='text' maxlength='1800' onfocus='showCommentIdentification();' placeholder='<?=text($con, "BLOG_COMMENTS_YOUR", $lang)?>'></textarea>
                                    <div id='identification_form'>
                                        <br/>
                                        <input id='new_comment_user' name='user' maxlength='50' type='text' placeholder='<?text($con, "COMMENT_YOUR_NAME", $lang)?>'/>
                                        <input type='button' value='<?text($con, "COMMENT_PUBLISH", $lang)?>'/>
                                    </div>
                                </div>
<?php
                            }
                            else{
?>
                                <h4><?text($con, "COMMENT_CLOSED_POST", $lang)?></h4>
<?php
                            }
?>
                        </div> <!-- .entry -->
                    </div> <!-- .section -->
                </div> <!-- .content_cell -->
                <div id='content_cell_info' class='content_cell'>
                    <div class='section' id='info'>
                        <h3 class='section_title'><?=text($con, "BLOG_DETAILS", $lang)?></h3>
                        <div id="info_date" class='entry'>
                            <span class='date'><?=format_date($r_post["dtime"], $lang)?></span>
                        </div>
                        <hr/>
                        <div id="info_share" class='entry'>
                            <h4><?=text($con, "BLOG_SHARE", $lang)?></h4>
                            <div id='social'>
<?php
                                $q_share = mysqli_query($con, "SELECT id FROM share WHERE visible = 1 ORDER BY idx;");
                                while ($r_share = mysqli_fetch_array($q_share)){
?>
                                    <?=share_link($con, $r_share["id"], $lserver, "$server/blog/$permalink", $lang)?>
<?php
                                }
?>
                            </div> <!-- #social -->
                        </div> <!-- #info_share -->
                        <hr/>
<?php
                        $q_tag = mysqli_query($con, "SELECT tag FROM post_tag WHERE post = $id;");
                        if (mysqli_num_rows($q_tag) > 0){
?>
                            <div id="info_tags" class='entry'>
<?php
                                $tag_string = "<span id='tags'>" . text($con, "BLOG_TAGS", $lang) . ": ";
                                $tag_raw = "";
                                while ($r_tag = mysqli_fetch_array($q_tag)){
                                    $tag_string = $tag_string . "<a href='$lserver/blog/search/tag/$r_tag[tag]'>$r_tag[tag]</a>, ";
                                    $tag_raw = $tag_raw . "$r_tag[tag],";
                                }
                                $tag_string = substr($tag_string, 0, strlen($tag_string) - 2);
                                $tag_string = $tag_string . "</span>";
                                $tag_raw = substr($tag_raw, 0, strlen($tag_raw) - 1);
?>
                                <span class='tags'><?=$tag_string?></span>
                                <meta itemprop='keywords' content='<?=$tag_raw?>'/>
                            </div> <!-- #info_tags -->
                            <hr/>
<?php
                        } // if (mysqli_num_rows($q_tag) > 0)
?>
<?php
                        // Previous / next
                        $q_prev = mysqli_query($con, "SELECT id, permalink, title FROM post WHERE id <> $id AND dtime <= '$r_post[dtime]' ORDER BY dtime DESC LIMIT 1;");
                        $q_next = mysqli_query($con, "SELECT id, permalink, title FROM post WHERE id <> $id AND dtime >= '$r_post[dtime]' ORDER BY dtime LIMIT 1;");
                        if (mysqli_num_rows($q_prev) > 0 || mysqli_num_rows($q_next) > 0){
?>
                            <div id='info_prev_next' class='entry'>
                                <table id='prev_next'>
                                    <tr>
                                        <td id='prev'>
<?php
                                            if (mysqli_num_rows($q_prev) > 0){
                                                $r_prev = mysqli_fetch_array($q_prev);
?>
                                                <a href='<?=$lserver?>/blog/<?=$r_prev["permalink"]?>'>
                                                    <span class='info'>Previous post:</span>
                                                    <br/>
                                                    <span class='title'><?=text($con, $r_prev["title"], $lang)?></span>
                                                </a>
<?php
                                            }
?>
                                        </td>
                                        <td id='next'>
<?php
                                            if (mysqli_num_rows($q_next) > 0){
                                                $r_next = mysqli_fetch_array($q_next);
?>
                                                <a href='<?=$lserver?>/blog/<?=$r_next["permalink"]?>'>
                                                    <span class='info'>Next post:</span>
                                                    <br/>
                                                    <span class='title'><?=text($con, $r_next["title"], $lang)?></span>
                                                </a>
<?php
                                            }
?>
                                        </td>
                                    </tr>
                                </table>
                            </div> <!-- #info_prev_next -->
                            <hr/>
<?php
                        } //  if (mysqli_num_rows($q_prev) > 0 || mysqli_num_rows($q_next) > 0)
?>
                        <div id='info_related' class='entry'>
                            <h4><?=text($con, "BLOG_RELATED", $lang)?></h4>
                            <ul>
<?php
                                // TODO: Truly select related
                                $q_related = mysqli_query($con, "SELECT permalink, title FROM post WHERE id <> $id ORDER BY rand() LIMIT 3;");
                                while($r_related = mysqli_fetch_array($q_related)){
?>
                                    <li>
                                        <a href='<?=$lserver?>/blog/<?=$r_related["permalink"]?>'><?=text($con, $r_related["title"], $lang)?></a>
                                    </li>
<?php
                                }
?>
                            </ul>
                        </div>
                        <hr/>
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
                </div> <!-- .content-cell -->
            </div> <!-- #content-row -->
        </div> <!-- #content -->
<?php
        include $doc_root . "footer.php";
        stats($con, $cur_section, $cur_entry);
?>
    </body>
</html>
