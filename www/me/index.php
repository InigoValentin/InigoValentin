<?php
    session_start();
    $http_host = $_SERVER["HTTP_HOST"];
    $doc_root = $_SERVER["DOCUMENT_ROOT"]; 
    include $doc_root . "functions.php";
    $proto = get_protocol();
    $con = start_db();
    $server = $proto . $http_host;
    $lang = select_language();
    $cur_section = "me";
    $cur_entry = "";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta content='text/html; charset=utf-8' http-equiv='content-type'/>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'/>
        <title><?=text($con, "ME_TITLE", $lang)?> - I&ntilde;igo Valentin</title>
        <link rel='shortcut icon' href='<?=$server?>/img/logo/favicon.ico'/>
        <!-- CSS files -->
        <style>
<?php
            include $doc_root . "css/ui.css";
            include $doc_root . "css/me.css";
?>
        </style>
        <!-- CSS for mobile version -->
        <style media='(max-width : 990px)'>
<?php
            include $doc_root . "css/m/ui.css";
            include $doc_root . "css/m/me.css";
?>
        </style>
        <!-- Script files -->
        <script type='text/javascript'>
<?php
            include $doc_root . "script/ui.js";
            include $doc_root . "script/me.js";
?>
        </script>
        <!-- Meta tags -->
        <link rel='canonical' href='<?=$server?>/me/'/>
        <link rel='author' href='<?=$server?>'/>
        <link rel='publisher' href='<?=$server?>'/>
        <meta name='description' content='<?=text($con, "ME_DESCRIPTION", $lang)?>'/>
        <meta property='og:title' content='<?=text($con, "ME_TITLE", $lang)?> - I&ntilde;igo Valentin'/>
        <meta property='og:url' content='<?=$server?>/me'/>
        <meta property='og:description' content='<?=text($con, "ME_DESCRIPTION", $lang)?>'/>
        <meta property='og:image' content='<?=$server?>/img/logo/favicon.ico''/>
        <meta property='og:site_name' content='I&ntilde;igo Valentin'/>
        <meta property='og:type' content='website'/>
        <meta property='og:locale' content='<?=$lang?>'/>
        <meta name='twitter:card' content='summary'/>
        <meta name='twitter:title' content='<?=text($con, "ME_TITLE", $lang)?> - I&ntilde;igo Valentin'/>
        <meta name='twitter:description' content='<?=text($con, "ME_DESCRIPTION", $lang)?>'/>
        <meta name='twitter:image' content='<?=$server?>/img/logo/favicon.ico''/>
        <meta name='twitter:url' content='<?=$server?>'/>
        <meta name='robots' content='index follow'/>
    </head>
    <body>
<?php
        include $doc_root . "header.php";
?>
        <div id='content'>
            <div class='section section_no_title'>
                <div class='entry' id='profile'>
                    <div class='table_row'>
                        <div class='table_cell'>
                            <img id='profile' src='<?=$server?>/img/profile/preview/0.png' alt='I&ntilde;igo Valentin' title='I&ntilde;igo Valentin' />
                        </div> <!-- .table_cell -->
                        <div class='table_cell'>
                            <h3 id='name'>I&ntilde;igo Valentin</h3>
                            <h4 id='tagline'>TR#Developer</h4>
                            <p id='bio'>TR#Bio</p>
                        </div> <!-- .table_cell -->
                    </div> <!-- .table_row -->
                </div> <!-- #profile -->
            </div> <!-- .section -->
            <div class='section'>
                <h3 class='section_title'>TR#Curriculum Vitae</h3>
                <ul class='cv_download'>
                    <li>
                        <a target='_blank' href='TODO' title='I&ntilde;igo Valentin - TR#Curriculum Vitae'>TR#Download in currlang</a>
                    </li>
                    <li>
                        <a href='TODO' title='TR#Curriculum Vitae - Other languages'>TR#Download in other languages</a>
                    </li>
                </ul>
<?php
                $q_section = mysqli_query($con, "SELECT * FROM cv_category WHERE visible = 1 ORDER BY priority;");
                while ($r_section = mysqli_fetch_array($q_section)){
?>
                    <div id='cv' class='entry cv_entry'>
                        <h4><?=text($con, $r_section["title"], $lang)?></h4>
<?php
                        if (strlen($r_section["summary"]) > 0){
?>
                            <h5><?=text($con, $r_section["summary"], $lang)?></h5>
<?php
                        }
                        $q_item = mysqli_query($con, "SELECT id, role, company, summary, city, start, end, year(start) AS start_y, DATE_FORMAT(start, '%m') AS start_m, year(end) AS end_y, DATE_FORMAT(end, '%m') AS end_m, date_precission FROM cv_entry WHERE category = $r_section[id] AND visible = 1 ORDER BY start DESC");
                        while ($r_item = mysqli_fetch_array($q_item)){
                            switch ($r_item["date_precission"]){
                                case "Y":
                                    if (strlen($r_item["end"]) <= 0){    // Since 2016
                                        $str_date = str_replace("#YEAR_START#", $r_item["start_y"], text($con, "CV_DATE_FROM_YEAR", $lang));
                                    }
                                    else{
                                        if ($r_item["start_y"] == $r_item["end_y"]){    // 2016
                                            $str_date = str_replace("#YEAR_START#", $r_item["start_y"], text($con, "CV_DATE_DURING_YEAR", $lang));
                                        }
                                        else{    // From 2015 until 2017
                                            $str_date = str_replace("#YEAR_START#", $r_item["start_y"], text($con, "CV_DATE_FROM_TO_YEAR", $lang));
                                            $str_date = str_replace("#YEAR_END#", $r_item["end_y"], $str_date);
                                        }
                                    }
                                    break;
                                case "M":
                                    if (strlen($r_item["end"]) <= 0){    // Since March 2016
                                        $str_date = str_replace("#YEAR_START#", $r_item["start_y"], text($con, "CV_DATE_FROM_MONTH", $lang));
                                        $str_date = str_replace("#MONTH_START#", text($con, "MONTH_" . $r_item["start_m"], $lang), $str_date);
                                    }
                                    else{
                                        if ($r_item["start_y"] == $r_item["end_y"]){
                                            if ($r_item["start_m"] == $r_item["end_m"]){    // March 2016
                                                $str_date = str_replace("#YEAR_START#", $r_item["start_y"], text($con, "CV_DATE_DURING_MONTH", $lang));
                                                $str_date = str_replace("#MONTH_START#", text($con, "MONTH_" . $r_item["start_m"], $lang), $str_date);
                                            }
                                            else{    // From February until March 2016
                                                $str_date = str_replace("#YEAR_START#", $r_item["start_y"], text($con, "CV_DATE_FROM_TO_MONTH_YEAR", $lang));
                                                $str_date = str_replace("#MONTH_START#", text($con, "MONTH_" . $r_item["start_m"], $lang), $str_date);
                                                $str_date = str_replace("#MONTH_END#", text($con, "MONTH_" . $r_item["end_m"], $lang), $str_date);
                                            }
                                        }
                                        else{
                                            // From February 2015 until March 2016
                                            $str_date = str_replace("#YEAR_START#", $r_item["start_y"], text($con, "CV_DATE_FROM_TO_MONTH", $lang));
                                            $str_date = str_replace("#YEAR_END#", $r_item["end_y"], $str_date);
                                            $str_date = str_replace("#MONTH_START#", text($con, "MONTH_" . $r_item["start_m"], $lang), $str_date);
                                            $str_date = str_replace("#MONTH_END#", text($con, "MONTH_" . $r_item["end_m"], $lang), $str_date);
                                        }
                                    }
                                    break;
                            } // switch ($r_item["date_precission"])
?>
                            <div class='role'>
                                <h4><?=text($con, $r_item["role"], $lang)?></h4>
                                <h5><?=$str_date?>. <?=$r_item["company"]?> (<?=text($con, $r_item["city"], $lang)?>)</h5>
                                <p><?=text($con, $r_item["summary"], $lang)?></p>
                            </div>
<?php
                        } // while ($r_item = mysqli_fetch_array($q_item))
?>
                    </div>
<?php
                }
?>
            </div> <!-- .section -->
        </div> <!-- #content -->
<?php
        include $doc_root . "footer.php";
        stats($con, $cur_section, $cur_entry);
?>
    </body>
</html>
