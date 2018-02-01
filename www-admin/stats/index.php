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
?>
<html>
    <head>
        <meta content='text/html; charset=windows-1252' http-equiv='content-type'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'>
        <link rel='shortcut icon' href='<?=$pserver?>/img/logo/x2/favicon.ico'/>
        <title><?=$title?>Stats - I&ntilde;igo Valentin - Administration Panel</title>
        <style>
<?php
            include $doc_root . "css/ui.css";
            include $doc_root . "css/stats.css";
?>
        </style>
        <!-- CSS for mobile version -->
        <style media='(max-width : 990px)'>
<?php
            include $doc_root . "css/m/ui.css";
            include $doc_root . "css/m/stats.css";
?>
        </style>
        <!-- Script files -->
        <script type='text/javascript'>
<?php
            include $doc_root . "script/ui.js";
            include $doc_root . "script/stats.js";
?>
        </script>
    </head>
    <body>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div class='section' id='post_edit'>
                <h3 class='section_title'>Visits</h3>
                <div class='entry'>
                    <div id='visitCanvas'></div>
                    <script>
                        (function () {
                            function createVisitCanvas() {
                                var parent = document.getElementById("visitCanvas");
                                var canvas = document.createElement("canvas");
                                parent.appendChild(canvas);
                                return canvas.getContext("2d");
                            }
                            var context = createVisitCanvas();
                            var graph = new BarGraph(context);
<?php
                            $q_month = mysqli_query($con, "SELECT month(dtime) AS month, count(id) AS total FROM stat_visit GROUP BY year(dtime), month(dtime) ORDER BY dtime DESC LIMIT 12;");
                            $name_string = "";
                            $valu_string = "";
                            $month = date('m');

                            // Show at least the last twelve months, even if there is no data that old.
                            for ($i = 0; $i < 12 - mysqli_num_rows($q_month); $i ++){
                                $month_number = intval($month) - (12 - $i) + 1;
                                if ($month_number <= 0){
                                    $month_number = $month_number + 12;
                                }
                                $name_string = $name_string . "\"" . ucfirst(substr(text($con, "MONTH_" . str_pad($month_number, 2, "0", STR_PAD_LEFT), $lang), 0, 3)) . "\", ";     //"\"" . text($con, "MONTH_" . $r_month["month"], $lang) . "\", ";
                                $valu_string = $valu_string . "0, ";
                            }

                            // Loop data
                            while ($r_month = mysqli_fetch_array($q_month)){
                                $name_string = $name_string . "\"" . ucfirst(substr(text($con, "MONTH_" . $r_month["month"], $lang), 0, 3)) . "\", ";
                                $valu_string = $valu_string . $r_month["total"] . ", ";
                            }
                            $name_string = substr(trim($name_string), 0, -1);
                            $valu_string = substr(trim($valu_string), 0, -1);
?>
                            graph.width = parseInt(window.getComputedStyle(document.getElementById("visitCanvas")).width);
                            graph.height = 180;
                            graph.setLabels([<?=$name_string?>]);
                            graph.setValues([<?=$valu_string?>]);
                            graph.draw();
                        }());
                    </script>
                </div> <!-- .entry -->
            </div> <!-- .section -->
            <div class='section' id='post_edit'>
                <h3 class='section_title'>Most popular pages</h3>
                <div class='entry'>
                    <div id='pagesCanvas'></div>
                    <script>
                        (function () {
                            function createPagesCanvas() {
                                var parent = document.getElementById("pagesCanvas");
                                var canvas = document.createElement("canvas");
                                parent.appendChild(canvas);
                                return canvas.getContext("2d");
                            }
                            var context = createPagesCanvas();
                            var graph = new HBarGraph(context);
                            
<?php
                            $q_visit = mysqli_query($con, "SELECT count(id) AS total, section, entry FROM stat_view GROUP BY section, entry LIMIT 10;");
                            $name_string = "";
                            $valu_string = "";
                            while ($r_visit = mysqli_fetch_array($q_visit)){
                                $s = $r_visit["section"];
                                $e = $r_visit["entry"];
                                switch ($s){
                                    case "index":
                                        $name_string = $name_string . "\"Homepage\", ";
                                        break;
                                    case "profile":
                                        $name_string = $name_string . "\"Profile page\", ";
                                        break;
                                    case "help":
                                        $name_string = $name_string . "\"Help page\", ";
                                        break;
                                    case "project":
                                        if (strlen(e) == 0){
                                            $name_string = $name_string . "\"Projects page\", ";
                                        }
                                        else{
                                            $t = text($con, mysqli_fetch_array(mysqli_query($con, "SELECT title, permalink FROM project WHERE id = $e;"))["title"], $lang);
                                            $name_string = $name_string . "\"Project: " . $t . "\", ";
                                        }
                                        break;
                                    case "blog":
                                        if (strlen(e) == 0){
                                            $name_string = $name_string . "\"Blog\", ";
                                        }
                                        else{
                                            $t = text($con, mysqli_fetch_array(mysqli_query($con, "SELECT title, permalink FROM project WHERE id = $e;"))["title"], $lang);
                                            $name_string = $name_string . "\"Post: " . $t . "\", ";
                                        }
                                        break;
                                    default:
                                        $name_string = $name_string . "\"" . $s . " - " . $e . "\", ";
                                }
                                $valu_string = $valu_string . $r_visit["total"] . ", ";
                            }
                            $name_string = substr(trim($name_string), 0, -1);
                            $valu_string = substr(trim($valu_string), 0, -1);
?>
                            setTimeout(function(){
                                graph.width = parseInt(window.getComputedStyle(document.getElementById("pagesCanvas")).width);
                                graph.height = <?=(40 + (30 * mysqli_num_rows($q_visit)))?>;
                                graph.setLabels([<?=$name_string?>]);
                                graph.setValues([<?=$valu_string?>]);
                                graph.draw();
                            }, 0);
                        }());
                    </script>
                </div> <!-- .entry -->
            </div> <!-- .section -->
            <div class='section'>
                <h3 class='section_title'>Visitors profile</h3>
                <div class='entry'>
                    <div class='pie_chart' id='osCanvas'><h4>Top OS</h4></div>
                    <div class='pie_chart' id='browserCanvas'><h4>Top browsers</h4></div>
                    <div class='pie_chart' id='osBrowserCanvas'><h4>Top OS/browser</h4></div>
                    <script>
                        (function () {
                            function createOsCanvas() {
                                var parent = document.getElementById("osCanvas");
                                var canvas = document.createElement("canvas");
                                parent.appendChild(canvas);
                                return canvas.getContext("2d");
                            }
                            var context = createOsCanvas();
                            var graph = new PieGraph(context);
<?php
                            $q_os = mysqli_query($con, "SELECT count(id) AS total, os FROM stat_visit GROUP BY os ORDER BY total DESC LIMIT 9;");
                            $name_string = "";
                            $valu_string = "";
                            while ($r_os = mysqli_fetch_array($q_os)){
                                $name_string = $name_string . "\"" . $r_os["os"] . "\", ";
                                $valu_string = $valu_string . $r_os["total"] . ", ";
                            }
                            $name_string = substr(trim($name_string), 0, -1);
                            $valu_string = substr(trim($valu_string), 0, -1);
?>
                            var cHeight = 30 * (<?=mysqli_num_rows($q_os)?> + 3);
                            if (cHeight < 200){
                                cHeight = 200;
                            }
                            graph.width = 400;
                            graph.height = cHeight;
                            graph.setLabels([<?=$name_string?>]);
                            graph.setValues([<?=$valu_string?>]);
                            graph.draw();
                        }());
                        (function () {
                            function createBrowserCanvas() {
                                var parent = document.getElementById("browserCanvas");
                                var canvas = document.createElement("canvas");
                                parent.appendChild(canvas);
                                return canvas.getContext("2d");
                            }
                            var context = createBrowserCanvas();
                            var graph = new PieGraph(context);
<?php
                            $q_browser = mysqli_query($con, "SELECT count(id) AS total, browser FROM stat_visit GROUP BY browser ORDER BY total DESC LIMIT 9;");
                            $name_string = "";
                            $valu_string = "";
                            while ($r_browser = mysqli_fetch_array($q_browser)){
                                $name_string = $name_string . "\"" . $r_browser["browser"] . "\", ";
                                $valu_string = $valu_string . $r_browser["total"] . ", ";
                            }
                            $name_string = substr(trim($name_string), 0, -1);
                            $valu_string = substr(trim($valu_string), 0, -1);
?>
                            var cHeight = 30 * (<?=mysqli_num_rows($q_browser)?> + 3);
                            if (cHeight < 200){
                                cHeight = 200;
                            }
                            graph.width = 400;
                            graph.height = cHeight;
                            graph.setLabels([<?=$name_string?>]);
                            graph.setValues([<?=$valu_string?>]);
                            graph.draw();
                        }());
                        (function () {
                            function createOsBrowserCanvas() {
                                var parent = document.getElementById("osBrowserCanvas");
                                var canvas = document.createElement("canvas");
                                parent.appendChild(canvas);
                                return canvas.getContext("2d");
                            }
                            var context = createOsBrowserCanvas();
                            var graph = new PieGraph(context);
<?php
                            $q_osbrowser = mysqli_query($con, "SELECT count(id) AS total, os, browser FROM stat_visit GROUP BY os, browser ORDER BY total DESC LIMIT 9;");
                            $name_string = "";
                            $valu_string = "";
                            while ($r_osbrowser = mysqli_fetch_array($q_osbrowser)){
                                $name_string = $name_string . "\"" . $r_osbrowser["os"] . "/" . $r_osbrowser["browser"] . "\", ";
                                $valu_string = $valu_string . $r_osbrowser["total"] . ", ";
                            }
                            $name_string = substr(trim($name_string), 0, -1);
                            $valu_string = substr(trim($valu_string), 0, -1);
?>
                            var cHeight = 30 * (<?=mysqli_num_rows($q_osbrowser)?> + 3);
                            if (cHeight < 200){
                                cHeight = 200;
                            }
                            graph.width = 400;
                            graph.height = cHeight;
                            graph.setLabels([<?=$name_string?>]);
                            graph.setValues([<?=$valu_string?>]);
                            graph.draw();
                        }());
                    </script>
                </div> <!-- .entry -->
            </div> <!-- .section -->
        </div>
    </div>
<?php
    }
?>
