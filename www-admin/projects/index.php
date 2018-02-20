<?php
    session_start();
    $http_host = $_SERVER["HTTP_HOST"];
    $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";
    include $doc_root . "functions.php";
    $proto = get_protocol();
    $con = start_db();
    $server = $proto . $http_host;
    $pserver = $proto . substr($http_host, 0, strpos($http_host, ':')); // public server
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
        <title>Projects - I&ntilde;igo Valentin - Administration Panel</title>
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
    </head>
    <body>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div class='section'>
                <h3 class='section_title'>Project list</h3>
                <div class='entry'>
                    <table id='project_list'>
                        <tr>
                            <th>Projects</th>
                            <th>Details</th>
                            <th>Actions</th>
                        </tr>
<?php
                        $q_project = mysqli_query($con, "SELECT project.id, permalink, project_type.title AS type, project.title AS title, project.logo AS logo, header, text, license.id AS license, concat(fname, concat(' ', lname)) AS user, visible, comments, (SELECT count(id) FROM project_comment WHERE project = project.id) AS comment_count, (SELECT version_name FROM project_version v, project_version_type WHERE type = v.id AND v.project = project.id ORDER BY version_code DESC LIMIT 1) AS version, (SELECT dtime FROM project_version v WHERE  v.project = project.id ORDER BY version_code DESC LIMIT 1) AS dtime, (SELECT title FROM project_version v, project_version_type WHERE type = v.id AND v.project = project.id ORDER BY version_code DESC LIMIT 1) AS version_type, (SELECT color FROM project_version v, project_version_type WHERE type = v.id AND v.project = project.id ORDER BY version_code DESC LIMIT 1) AS version_color, (SELECT image FROM project_image WHERE project = project.id) AS image, (SELECT count(image) FROM project_image WHERE project = project.id ORDER BY idx LIMIT 1) AS image_count FROM project, project_type, license, user WHERE project.type = project_type.id AND project.license = license.id AND project.user = user.id;");
                        while ($r_project = mysqli_fetch_array($q_project)){
                            $title = text($con, $r_project["title"], $lang);
?>
                            <tr>
                                <td class='td_project'>
                                    <h4>
                                        <a title='View <?=$title?> on a new tab' target='_blank' href='<?=$pserver?>/project/<?=$r_project["permalink"]?>'>
<?php
                                            if (strlen($r_project["logo"]) > 0){
?>
                                                <img alt='<?=$title?>' title='<?=$title?>' src='<?=$pserver?>/img/project/x2/<?=$r_project["logo"]?>' />
<?php
                                            }
?>
                                            <?=$title?>
                                        </a>
                                    </h4>
                                    <p><?=cut_text(text($con, $r_project["header"],$lang), 300)?></p>
<?php
                                    if ($r_project["image_count"] > 0){
?>
                                        <img class='project_image' alt='<?=$title?>' title='<?=$title?>' src='<?=$pserver?>/img/project/x2/<?=$r_project["image"]?>' />
<?php
                                        if ($r_project["image_count"] == 2){
?>
                                            + other image.
<?php
                                        }
                                        elseif ($r_project["image_count"] > 2){
                                            $pl = $r_project["image_count"] - 1;
?>
                                            + <?=$pl?> other images.
<?php
                                        }
                                    }
?>
                                </td>
                                <td class='td_details'>
                                    By <?=$r_project["user"]?>.<br/>
                                    Last version 
                                    <span style='color:<?=$r_project["version_color"]?>;'>
                                        <?=$r_project["version"]?> (<?=strtolower(text($con, $r_project["version_type"], $lang))?>)
                                    </span>
                                    modified on <?=format_date($r_project["dtime"], $lang, false)?>.<br/>
                                    Licensed under <?=$r_project["license"]?>.<br/>
                                    Visible:
<?php
                                    if ($r_project["visible"] == 1){
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
                                    <br/>Comments: <?=$r_project["comment_count"]?><br/>
                                    Comments allowed:
<?php
                                    if ($r_project["comments"] == 1){
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
                                    <input type='button' onclick='manageProject(<?=$r_project["id"]?>);' value='Manage / Translate'/>
                                    <input type='button' onclick='deleteProject(<?=$r_project["id"]?>, "<?=$title?>");' value='Delete'/>
                                    <?php
                                    if ($r_project["visible"] == 1){
?>
                                        <input type='button' onclick='visibleProject(<?=$r_project["id"]?>, "<?=$title?>", 0);' value='Unpublish'/>
<?php
                                    }
                                    else{
?>
                                        <input type='button' onclick='visibleProject(<?=$r_project["id"]?>, "<?=$title?>", 1);' value='Publish'/>
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
