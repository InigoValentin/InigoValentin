<?php
    session_start();
    $http_host = $_SERVER["HTTP_HOST"];
    $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";
    include $doc_root . "functions.php";
    $proto = get_protocol();
    $lang = "en";
    $con = start_db();
    $server = $proto . $http_host;
    $pserver = $proto . substr($http_host, 0, strpos($http_host, ':')); // public server
    if (!check_session($con)){
        http_response_code(401);
        header("Location: /authentication.php");
    }
    else{
        $id = intval(mysqli_real_escape_string($con, $_GET["p"]));
        if (strlen($id) < 1){
            http_response_code(400); // No or bad ID: Bad request.
            header("Location: /blog/");
        }
        else{
            $q_post = mysqli_query($con, "SELECT * FROM post WHERE id = $id;");
            if (mysqli_num_rows($q_post) == 0){
                http_response_code(404); // Unexistent id: Not found.
                header("Location: /blog/");
            }
            else{
                $r_post = mysqli_fetch_array($q_post);
                $id = $r_post["id"];
                $title = text($con, $r_post["title"], $lang);
                $q_lang = mysqli_query($con, "SELECT * FROM lang;");
?>
<html>
    <head>
        <meta content='text/html; charset=windows-1252' http-equiv='content-type'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'>
        <link rel='shortcut icon' href='<?=$pserver?>/img/logo/x2/favicon.ico'/>
        <title><?=$title?>I&ntilde;igo Valentin - Administration Panel</title>
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
         <script src='/script/ckeditor/ckeditor.js'></script>
    </head>
    <body>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div class='section' id='post_edit'>
                <h3 class='section_title'><?=$title?></h3>
                <div class='entry'>
                    <div id='lang_tabs'>
                        <table>
                            <tr>
<?php
                                mysqli_data_seek($q_lang, 0);
                                $active = 'lang_tabs_active';
                                while ($r_lang = mysqli_fetch_array($q_lang)){
?>
                                    <td class='pointer <?=$active?>' id='lang_tab_<?=$r_lang["code"]?>' onclick='showLanguage("<?=$r_lang["code"]?>");'>
                                        <?=$r_lang["name"]?>
                                    </td>
<?php
                                    $active = '';
                                }
?>
                            </tr>
                        </table>
                    </div> <!-- #lang_tabs -->
                    <span class='bold'>URL:</span>
                    <?=$pserver?>/blog/
                    <span class='editable'>
                        <span class='field_result'><?=$r_post["permalink"]?></span>
                        <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                        <input class='field_editable' type='text' value='<?=$r_post["permalink"]?>'/>
                        <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "post", "permalink", <?=$id?>);'/>
                        <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                    </span>
                    <hr class='separator'/>
<?php
                    mysqli_data_seek($q_lang, 0);
                    $active = "content_lang_active";
                    while ($r_lang = mysqli_fetch_array($q_lang)){
?>
                        <div class='content_lang_<?=$r_lang["code"]?> content_lang <?=$active?>'>
                            <div class='editable'>
                                <span class='bold'>Title (<?=$r_lang["name"]?>):</span>
                                <span class='field_result'><?=text($con, $r_post["title"], $r_lang["code"])?></span>
                                <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                                <input class='field_editable' type='text' value='<?=text($con, $r_post["title"], $r_lang["code"])?>'/>
                                <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "text", "<?=$r_lang["code"]?>", "<?=$r_post["title"]?>");'/>
                                <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                            </div>
                            <hr class='separator'/>
                            <div class='editable'>
                                <span class='bold'>Text (<?=$r_lang["name"]?>):</span>
                                <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                                <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "text", "<?=$r_lang["code"]?>", "<?=$r_post["text"]?>");'/>
                                <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                                <br/>
                                <p class='field_result'><?=text($con, $r_post["text"], $r_lang["code"])?></p>
                                <textarea id='text_<?=$r_lang["code"]?>' class='field_editable'><?=text($con, $r_post["text"], $r_lang["code"])?></textarea>
                                <script>CKEDITOR.replace('text_<?=$r_lang["code"]?>');</script>
                            </div>
                        </div> <!-- .content_lang_<?=$r_lang["code"]?> -->
<?php
                        $active = '';
                    }
?>
                    <hr class='separator'/>
                    <h4>Images</h4>
                    <div id='image_reel' class='horizontal_scroll'>
<?php
                        $q_image = mysqli_query($con, "SELECT id, image FROM post_image WHERE post = $id;");
                        while ($r_image = mysqli_fetch_array($q_image)){
?>
                            <div class='post_image' id='post_image_<?=$r_image["id"]?>'>
                                <img alt='<?=$title?>' title='<?=$title?>' src='<?=$pserver?>/img/blog/x4/<?=$r_image["image"]?>' />
                                <br/>
                                <label class="image_control image_upload">
                                    <input id="image" onchange="preview_image();" type="file" name="image" accept="image/x-png, image/gif, image/jpeg"/>
                                    @
                                </label>
                                <input class='image_control' type='button' onClick='deleteImage(<?=$r_image["id"]?>)' value='X' />
                            </div>
<?php
                        }
?>
                        <div class='post_image' id='post_image_add'>
                            <img onClick='addImage(<?=$id?>)' alt='Add image' title='Add image' src='<?=$server?>/img/icon/addimage.png' />
                            <input type='file' id='header_img_selector' onChange='uploadHeaderImage(event, <?=$r["id"]?>);'/>
                            <img id="image_preview" src="<?php echo $img; ?>"/><br/><br/>
                        </div>
                    </div>
                    <hr class='separator'/>
                    <h4>Tags</h4>
                    TODO
                    <hr class='separator'/>
                    <h4>Settings</h4>
<?php
                    if ($r_post["visible"] == 1){
                        $v = "Yes";
                        $selected1 = "selected";
                        $selected0 = "";
                    }
                    else{
                        $v = "No";
                        $selected1 = "";
                        $selected0 = "selected";
                    }
?>
                    <div class='editable'>
                        <span class='bold'>Visible:</span>
                        <span class='field_result'><?=$v?></span>
                        <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                        <select class='field_editable'>
                            <option value='1' <?=$selected1?>>Yes</option>
                            <option value='0' <?=$selected0?>>No</option>
                        </select>
                        <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "post", "visible", "<?=$id?>");'/>
                        <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                    </div>
<?php
                    if ($r_post["comments"] == 1){
                        $v = "Yes";
                        $selected1 = "selected";
                        $selected0 = "";
                    }
                    else{
                        $v = "No";
                        $selected1 = "";
                        $selected0 = "selected";
                    }
?>
                    <div class='editable'>
                        <span class='bold'>Comments enabled:</span>
                        <span class='field_result'><?=$v?></span>
                        <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                        <select class='field_editable'>
                            <option value='1' <?=$selected1?>>Yes</option>
                            <option value='0' <?=$selected0?>>No</option>
                        </select>
                        <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "post", "comments", "<?=$id?>");'/>
                        <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                    </div>
                    <input type='button' onclick='deletePost(<?=$id?>, "<?=$title?>");' value='Delete post'/>
                    <h4>Comments</h4>
<?php
                        $q_comment = mysqli_query($con, "SELECT post_comment.id AS id, text, dtime, user, username, lang, (SELECT name FROM lang WHERE code = post_comment.lang) AS lang_name, approved, ip, browser, os, uagent FROM post_comment, stat_visit WHERE stat_visit.id = visit AND post = $id;");
                        if (mysqli_num_rows($q_comment) == 0){
?>
                            <span>No comments yet</span>
<?php
                        }
                        else{
?>
                            <table id='comments'>
<?php
                            while ($r_comment = mysqli_fetch_array($q_comment)){
?>
                                <tr>
                                    <td class='text'>
                                        <p><?=$r_comment["text"]?></p>
                                    </td>
                                    <td class='details'>
                                        On <?=format_date($r_comment["dtime"], $lang, true)?>
                                        <br/>
<?php
                                        if (strlen($r_comment["user"]) > 0){
                                            $q_user = mysqli_query($con, "SELECT concat(fname, concat(' ', lname)) AS name, username FROM user WHERE id = $r_comment[user];");
                                            $r_user = mysqli_fetch_array($q_user);
?>
                                            By <?=$r_user["name"]?> (<span class='bold'><?=$r_user["username"]?></span>)
<?php
                                        }
                                        else{
?>
                                            By <?=$r_comment["username"]?>
<?php
                                        }
                                        if (strlen($r_comment["lang_name"]) > 0){
                                            $strlang = $r_comment["lang_name"];
                                        }
                                        else{
                                            $strlang = $r_comment["lang"];
                                        }
                                        if (file_exists($doc_root . "img/lang/" . $r_comment["lang"] . ".gif")){
                                            $imgpath = $doc_root . "img/lang/" . $r_comment["lang"] . ".gif";
                                            $strlang = $strlang . " <img class='lang' title='$r_comment[lang]' alt='$r_comment[lang]' src='$server/$imgpath' />";
                                        }
?>
                                        <br/>
                                        Language: <?=$strlang?>
<?php
                                        if ($r_post["visible"] == 1){
                                            $v = "Yes";
                                            $selected1 = "selected";
                                            $selected0 = "";
                                        }
                                        else{
                                            $v = "No";
                                            $selected1 = "";
                                            $selected0 = "selected";
                                        }
?>
                                        <div class='editable'>
                                            Approved:
                                            <span class='field_result'><?=$v?></span>
                                            <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                                            <select class='field_editable'>
                                                <option value='1' <?=$selected1?>>Yes</option>
                                                <option value='0' <?=$selected0?>>No</option>
                                            </select>
                                            <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "post_comment", "approved", "<?=$r_comment["id"]?>");'/>
                                            <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                                        </div>
                                    </td>
                                    <td class='actions'>
                                        <input type='button' onclick='deletePostComment(<?=$id?>);' value='Delete'/>
                                    </td>
                                </tr>
<?php
                            }
?>
                            </table>
<?php
                        }
?>
                </div> <!-- .entry -->
            </div> <!-- .section -->
        </div> <!-- #content -->
    </body>
</html>
<?php
            }
        }
    }
?>
