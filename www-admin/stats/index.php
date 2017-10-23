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
        <div id='content'>
            <div class='section' id='post_edit'>
                <h3 class='section_title'>Visits</h3>
                <div class='entry'>
                    <div id='visitCanvas'></div>
                    <script>
                        (function () {
                            function createCanvas() {
                                var parent = document.getElementById("visitCanvas");
                                var canvas = document.createElement("canvas");
                                parent.appendChild(canvas);
                                return canvas.getContext("2d");
                            }
                            var context = createCanvas();
                            var graph = new BarGraph(context);
                            graph.width = 450;
                            graph.height = 150;;
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
                            graph.setLabels([<?=$name_string?>]);
                            graph.setValues([<?=$valu_string?>]);
                            graph.draw();

                        }());
                    </script>
                </div>
            </div>
        </div>
    </div>
<?php
    }
?>
