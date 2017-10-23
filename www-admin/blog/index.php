<?php
    session_start();
    $http_host = $_SERVER["HTTP_HOST"];
    $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";
    include $doc_root . "functions.php";
    $proto = get_protocol();
    $con = start_db();
    $server = $proto . $http_host;
    $pserver = substr($server, 0, strpos($http_host, ':')); // public server
    $lang = "en";
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
        <title>Blog - I&ntilde;igo Valentin - Administration Panel</title>
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
    </head>
    <body>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div class='section'>
                <h3 class='section_title'>Post list</h3>
                <div class='entry'>
                    <table id='post_list'>
                        <tr>
                            <th>Post</th>
                            <th>Detalles</th>
                            <th>Acciones</th>
                        </tr>
<?php
                        $q_post = mysqli_query($con, "SELECT post.id AS id, permalink, title, text, dtime, comments, (SELECT count(id) FROM post_comment WHERE post = post.id) AS comment_count, concat(fname, concat(' ', lname)) AS user, visible, comments, (SELECT image FROM post_image WHERE post = post.id ORDER BY idx LIMIT 1) AS image, (SELECT count(image) FROM post_image WHERE post = post.id) AS image_count FROM post, user WHERE user = user.id");
                        while ($r_post = mysqli_fetch_array($q_post)){
                            $title = text($con, $r_post["title"], $lang);
?>
                            <tr>
                                <td class='td_post'>
                                    <h4>
                                        <a title='View <?=$title?> on a new tab' target='_blank' href='<?=$pserver?>/blog/<?=$r_post["permalink"]?>'>
                                            <?=$title?>
                                        </a>
                                    </h4>
                                    <p><?=cut_text(text($con, $r_post["text"], $lang), 200)?></p>
<?php
                                    if ($r_post["image_count"] > 0){
?>
                                        <img class='post_image' alt='<?=$title?>' title='<?=$title?>' src='<?=$pserver?>/img/blog/x2/<?=$r_post["image"]?>' />
<?php
                                        if ($r_post["image_count"] == 2){
?>
                                            + other image.
<?php
                                        }
                                        elseif ($r_post["image_count"] > 2){
                                            $pl = $r_post["image_count"] - 1;
?>
                                            + <?=$pl?> other images.
<?php
                                        }
                                    }
?>
                                </td>
                                <td class='td_details'>
                                    By <?=$r_post["user"]?>.<br/>
                                    Posted <?=format_date($r_post["dtime"], $lang, true)?>.<br/>
                                    Visible:
<?php
                                    if ($r_post["visible"] == 1){
?>
                                        Yes
<?php
                                    }
                                    else{
?>
                                        No
<?php
                                    }
?>
                                    <br/>Comments: <?=$r_post["comment_count"]?><br/>
                                    Comments allowed:
<?php
                                    if ($r_post["comments"] == 1){
?>
                                        Yes
<?php
                                    }
                                    else{
?>
                                        No
<?php
                                    }
?>
                                </td>
                                <td class='td_actions'>
                                    <input type='button' onclick='managePost(<?=$r_post["id"]?>);' value='Manage / Translate'/>
                                    <input type='button' onclick='deletePost(<?=$r_post["id"]?>, "<?=$title?>");' value='Delete'/>
                                    <?php
                                    if ($r_post["visible"] == 1){
?>
                                        <input type='button' onclick='visiblePost(<?=$r_post["id"]?>, "<?=$title?>", 0);' value='Unpublish'/>
<?php
                                    }
                                    else{
?>
                                        <input type='button' onclick='visiblePost(<?=$r_post["id"]?>, "<?=$title?>", 1);' value='Publish'/>
<?php
                                    }
?>
                                </td>
                            </tr>
<?php
                        }
?>
                    </table>
                </div> <!-- .entry -->
            </div> <!-- .section -->
        </div> <!-- #content -->
    </body>
</html>
<?php
    }
?>
