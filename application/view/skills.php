<section>
    <h3><?=text($con, "PROFILE_CV", $lang);?></h3>
    <ul class='cv_download'>
        <li>
            <a target='_blank' href='TODO' title='<?=text($con, "USER_NAME", $lang);?> - <?=text($con, "PROFILE_CV", $lang);?>'><?=text($con, "PROFILE_DOWNLOAD_CURRENT", $lang);?></a>
        </li>
        <li>
            <a href='TODO' title='<?=text($con, "PROFILE_CV_DOWNLOAD_LANG", $lang);?>'><?=text($con, "PROFILE_DOWNLOAD_OTHER", $lang);?></a>
        </li>
    </ul>
<?php
    $q_section = mysqli_query($con, "SELECT * FROM cv_category WHERE visible = 1 ORDER BY priority;");
    while ($r_section = mysqli_fetch_array($q_section)){
?>
        <article id='cv' class='cv_entry'>
            <h4 class='cv_entry_title'><?=text($con, $r_section["title"], $lang)?></h4>
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
        </article>
<?php
    }
?>
</section> <!-- .section -->
