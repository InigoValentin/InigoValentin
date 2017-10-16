<?php
    session_start();
    $http_host = $_SERVER["HTTP_HOST"];
    $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";
    include $doc_root . "functions.php";
    $proto = get_protocol();
    $lang = "es";
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
         <script src='/script/ckeditor/ckeditor.js'></script>
    </head>
    <body>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div class='section'>
                <h3 class='section_title'><?=$title?></h3>
                <div class='entry'>
                    <span class='bold'>URL:</span>
                    <?=$pserver?>/
                    <span class='editable'>
                        <span class='field_result'><?=$r_project["permalink"]?></span>
                        <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                        <input class='field_editable' type='text' value='<?=$r_project["permalink"]?>'/>
                        <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "project", "permalink", <?=$id?>);'/>
                        <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                    </span>
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
                    </div>
<?php
                    mysqli_data_seek($q_lang, 0);
                    $active = 'content_lang_active';
                    while ($r_lang = mysqli_fetch_array($q_lang)){
?>
                        <div id='content_lang_<?=$r_lang["code"]?>' class='content_lang <?=$active?>'>
                            <div class='editable'>
                                Title:
                                <span class='field_result'><?=text($con, $r_project["title"], $r_lang["code"])?></span>
                                <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                                <input class='field_editable' type='text' value='<?=text($con, $r_project["title"], $r_lang["code"])?>'/>
                                <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "text", "<?=$r_lang["code"]?>", "<?=$r_project["title"]?>");'/>
                                <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                            </div>
                            <hr/>
                            <div class='editable'>
                                Summary: 
                                <span class='field_result'><?=text($con, $r_project["summary"], $r_lang["code"])?></span>
                                <img class='button_edit' src='<?=$server?>/img/icon/edit.png' onclick='enableEdit(this);'/>
                                <input class='field_editable' type='text' value='<?=text($con, $r_project["summary"], $r_lang["code"])?>'/>
                                <img class='button_save' src='<?=$server?>/img/icon/save.png' onclick='saveEdit(this, "text", "<?=$r_lang["code"]?>", "<?=$r_project["summary"]?>");'/>
                                <img class='button_cancel' src='<?=$server?>/img/icon/cancel.png' onclick='cancelEdit(this);'/>
                            </div>
                            <hr/>
                            <div class='editable'>
                                Text:
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
                    </div> <!-- #lang_tabs -->

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
