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
            header("Location: /projects/");
        }
        else{
            $q_project = mysqli_query($con, "SELECT * FROM project WHERE id = $id;");
            if (mysqli_num_rows($q_project) == 0){
                http_response_code(404); // Unexistent id: Not found.
                header("Location: /projects/");
            }
            else{
                $r_project = mysqli_fetch_array($q_project);
                $id = $r_project["id"];
                $title = text($con, $r_project["title"], $lang);
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
            include $doc_root . "css/projects.css";
?>
        </style>
        <!-- CSS for mobile version -->
        <style media='(max-width : 990px)'>
<?php
            include $doc_root . "css/m/ui.css";
            include $doc_root . "css/m/projects.css";
?>
        </style>
        <!-- Script files -->
        <script type='text/javascript'>
<?php
            include $doc_root . "script/ui.js";
            include $doc_root . "script/projects.js";
?>
        </script>
         <script src='/script/ckeditor/ckeditor.js'></script>
    </head>
    <body>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div class='section' id='project_edit'>
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
                    <?=$pserver?>/projects/
                    <span class='editable'>
                        <span class='field_result'><?=$r_project["permalink"]?></span>
                        <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                        <input class='field_editable' type='text' value='<?=$r_project["permalink"]?>'/>
                        <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "project", "permalink", <?=$id?>);'/>
                        <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                    </span>
                    <hr class='separator'/>
                    <span class='bold'>Icon:</span>
<?php
                    if (strlen($r_project["icon"]) > 0){
                        $src = "$pserver/img/projects/x3/$r_image[image]";
                    }
                    else{
                        $src = "$server/img/icon/addimage.png";
                    }
?>
                    <img class='pointer' onClick='selectIcon();' id='icon' src='<?=$src?>' />
                    <input id='icon_file' type='file' accept='image/*' onchange='changeIcon(event, "<?=$title?>");'>
                    <hr class='separator'/>
<?php
                    mysqli_data_seek($q_lang, 0);
                    $active = "content_lang_active";
                    while ($r_lang = mysqli_fetch_array($q_lang)){
?>
                        <div class='content_lang_<?=$r_lang["code"]?> content_lang <?=$active?>'>
                            <div class='editable'>
                                <span class='bold'>Title (<?=$r_lang["name"]?>):</span>
                                <span class='field_result'><?=text($con, $r_project["title"], $r_lang["code"])?></span>
                                <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                                <input class='field_editable' type='text' value='<?=text($con, $r_project["title"], $r_lang["code"])?>'/>
                                <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "text", "<?=$r_lang["code"]?>", "<?=$r_project["title"]?>");'/>
                                <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                            </div>
                            <hr class='separator'/>
                            <div class='editable'>
                                <span class='bold'>Summary (<?=$r_lang["name"]?>):</span>
                                <span class='field_result'><?=text($con, $r_project["summary"], $r_lang["code"])?></span>
                                <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                                <input class='field_editable' type='text' value='<?=text($con, $r_project["summary"], $r_lang["code"])?>'/>
                                <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "text", "<?=$r_lang["code"]?>", "<?=$r_project["summary"]?>");'/>
                                <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                            </div>
                            <hr class='separator'/>
                            <div class='editable'>
                                <span class='bold'>Text (<?=$r_lang["name"]?>):</span>
                                <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                                <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "text", "<?=$r_lang["code"]?>", "<?=$r_project["text"]?>");'/>
                                <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                                <br/>
                                <p class='field_result'><?=text($con, $r_project["text"], $r_lang["code"])?></p>
                                <textarea id='text_<?=$r_lang["code"]?>' class='field_editable'><?=text($con, $r_project["text"], $r_lang["code"])?></textarea>
                                <script>CKEDITOR.replace('text_<?=$r_lang["code"]?>');</script>
                            </div>
                        </div> <!-- .project_add_language -->
<?php
                        $active = '';
                    }
?>
                    <hr class='separator'/>
                    <h4>Images</h4>
                    <div id='image_reel' class='horizontal_scroll'>
<?php
                        $q_image = mysqli_query($con, "SELECT id, image FROM project_image WHERE project = $id;");
                        while ($r_image = mysqli_fetch_array($q_image)){
?>
                            <span id='project_image_<?=$r_image["id"]?>'>
                                <img alt='<?=$title?>' title='<?=$title?>' src='<?=$pserver?>/img/projects/x3/<?=$r_image["image"]?>' />
                                <img class='pointer' onClick='deleteImage(<?=$r_image["id"]?>)' alt='Delete image' title='Delete image' src='<?=$server?>/img/icon/cancel.png' />
                            </span>
<?php
                        }
?>
                        <span id='project_image_add'>
                            <img onClick='addImage(<?=$id?>)' alt='Add image' title='Add image' src='<?=$server?>/img/icon/addimage.png' />
                        </span> <!-- #image_reel -->
                    </div>
                    <hr class='separator'/>
                    <h4>Tags</h4>
                    TODO
                    <hr class='separator'/>
                    <h4>Versions</h4>
                    <div id='versions'>
                        <input id='new_version' type='button' value='New version' onClick='newVersion(<?=$id?>);' />
<?php
                        // TODO replace id -> project_version: id
                        $q_version = mysqli_query($con, "SELECT project_version.id AS version, version_code, version_name, type, (SELECT text FROM text WHERE id = project_version_type.title AND lang = '$lang') AS type_name, color AS type_color, project_version.summary AS summary, changelog FROM project_version, project_version_type WHERE type = project_version_type.id AND project = $id ORDER BY version_code;");
                        while ($r_version = mysqli_fetch_array($q_version)){
?>
                            <div class='entry list_enty'>
                                <table id='versions'>
                                    <tr>
                                        <td class='version_name'>
                                            <span class='editable'>
                                                <span class='field_result'><?=$r_version["version_name"]?></span>
                                                <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                                                <input class='field_editable' type='text' value='<?=$r_version["version_name"]?>'/>
                                                <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "project_version", "version", "<?=$r_version["id"]?>");'/>
                                                <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                                            </span>
                                        </td>
                                        <td class='version_details'>
                                            <span class='bold'>Version code (fixed):</span> <?=$r_version["version_code"]?>
                                            <br/>
                                            <span class='editable'>
                                                <span class='bold'>Version type:</span>
                                                <span class='field_result'><?=$r_version["type_name"]?></span>
                                                <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                                                <select class='field_editable' value='<?=$r_version["type"]?>'>
<?php
                                                    $q_version_type = mysqli_query($con, "SELECT id, title, color, (SELECT text FROM text WHERE id = project_version_type.title AND lang = '$lang') AS title FROM project_version_type;");
                                                    while ($r_version_type = mysqli_fetch_array($q_version_type)){
                                                        if ($r_version_type["id"] == $r_version["type"]){
                                                            $selected = "selected";
                                                        }
                                                        else{
                                                            $selected = "";
                                                        }
                                                        // TODO: Ignoring default 'selected'. It's because display: none?
?>
                                                        <option value='<?=$r_version_type["id"]?>' <?=$selected?>><?=$r_version_type["title"]?></option>
<?php
                                                    }
?>
                                                </select>
                                                <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "project_version", "type", "<?=$r_version["id"]?>");'/>
                                                <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                                            </span>
<?php
                                            mysqli_data_seek($q_lang, 0);
                                            $active = "content_lang_active";
                                            while ($r_lang = mysqli_fetch_array($q_lang)){
?>
                                                <div class='content_lang_<?=$r_lang["code"]?> content_lang <?=$active?>'>
                                                    <div class='editable'>
                                                        <span class='bold'>Summary (<?=$r_lang["name"]?>):</span>
                                                        <span class='field_result'><?=text($con, $r_version["summary"], $r_lang["code"])?></span>
                                                        <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                                                        <input class='field_editable' type='text' value='<?=text($con, $r_project["summary"], $r_lang["code"])?>'/>
                                                        <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "text", "<?=$r_lang["code"]?>", "<?=$r_version["summary"]?>");'/>
                                                        <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                                                    </div>
                                                </div>
                                                <div class='content_lang_<?=$r_lang["code"]?> content_lang <?=$active?>'>
                                                    <div class='editable'>
                                                        <span class='bold'>Changelog (<?=$r_lang["name"]?>):</span>
                                                        <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                                                        <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "text", "<?=$r_lang["code"]?>", "<?=$r_version["changelog"]?>");'/>
                                                        <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                                                        <p class='field_result'><?=text($con, $r_version["changelog"], $r_lang["code"])?></p>
                                                        <textarea class='field_editable'><?=text($con, $r_project["summary"], $r_lang["code"])?></textarea>
                                                    </div>
                                                </div>
<?php
                                                $active = "";
                                            }
                                            if ($r_project["visible"] == 1){
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
                                                <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "project_version", "visible", "<?=$r_version["id"]?>");'/>
                                                <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                                            </div>

                                        </td>
                                        <td class='version_actions'>
                                            <input type='button' onclick='deleteVersion(<?=$r_version["id"]?>, "<?=$title?>");' value='Delete'/>
                                        </td>
                                    </tr>
                                </table>
                            </div> <!-- .entry -->
<?php
                        }
?>
                    </div> <!-- #versions -->
                    <hr class='separator'/>
                    <h4>Settings</h4>
<?php
                    if ($r_project["visible"] == 1){
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
                        <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "project", "visible", "<?=$id?>");'/>
                        <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                    </div>
<?php
                    if ($r_project["comments"] == 1){
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
                        <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "project", "comments", "<?=$id?>");'/>
                        <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                    </div>
                    <input type='button' onclick='deleteProject(<?=$id?>, "<?=$title?>");' value='Delete project'/>
                    <h4>Comments</h4>
<?php
                        $q_comment = mysqli_query($con, "SELECT project_comment.id AS id, (SELECT version_name FROM project_version WHERE id = project_comment.version) AS version, text, dtime, user, username, lang, (SELECT name FROM lang WHERE code = project_comment.lang) AS lang_name, approved, ip, browser, os, uagent FROM project_comment, stat_visit WHERE stat_visit.id = visit AND project = $id;");
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
                                        For version <?=$r_comment["version"]?>
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
                                        if ($r_project["visible"] == 1){
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
                                            <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "project_comment", "approved", "<?=$r_comment["id"]?>");'/>
                                            <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                                        </div>
                                    </td>
                                    <td class='actions'>
                                        <input type='button' onclick='deleteProjectComment(<?=$id?>);' value='Delete'/>
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