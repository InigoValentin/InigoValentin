<?php
    session_start();
    $http_host = $_SERVER["HTTP_HOST"];
    $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";
    include $doc_root . "functions.php";
    $proto = get_protocol();
    $con = start_db();
    $server = $proto . $http_host;
    $pserver = substr($server, 0, strpos($http_host, ':')); // public server
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
    </head>
    <body>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div class='section'>
                <div class='entry'>
                    <table>
                        <tr>
                            <th>Post</th>
                            <th>Detalles</th>
                            <th>Acciones</th>
                        </tr>
<?php
                        // TODO: Chaneg for blog
                        $q_post = mysqli_query($con, "SELECT project.id, permalink, project_type.title AS type, project.title AS title, project.logo AS logo, header, text, license.id AS license, concat(fname, concat(' ', lname)) AS user, visible, comments, (SELECT version_name FROM project_version v, project_version_type WHERE type = id AND v.project = project.id ORDER BY version_code DESC LIMIT 1) AS version, (SELECT title FROM project_version v, project_version_type WHERE type = id AND v.project = project.id ORDER BY version_code DESC LIMIT 1) AS version_type, (SELECT color FROM project_version v, project_version_type WHERE type = id AND v.project = project.id ORDER BY version_code DESC LIMIT 1) AS version_color, (SELECT image FROM project_image WHERE project = project.id) AS image, (SELECT count(image) FROM project_image WHERE project = project.id) AS image_count FROM project, project_type, license, user WHERE project.type = project_type.id AND project.license = license.id AND project.user = user.id;")
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
