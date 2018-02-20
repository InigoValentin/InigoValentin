<div id='footer'>
    <hr id='footer_separator'/><br/>
    <table id='footer_table'>
        <tr>
            <td id='footer_left'>
                <span id='footer_follow' class='desktop'><?=text($con, "FOOTER_FOLLOW", $lang);?><br/></span>
<?php
                $q_social = mysqli_query($con, "SELECT title, icon, url FROM social WHERE visible = 1 ORDER BY idx;");
                while ($r_social = mysqli_fetch_array($q_social)){
?>
                    <a title='<?=text($con, $r_social["title"], $lang)?>' href='<?=$r_social["url"]?>'>
                        <img class='footer_social_icon' src='<?=$lserver?>/img/social/x2/<?=$r_social["icon"]?>' alt='<?=text($con, $r_social["title"], $lang)?>' title='<?=text($con, $r_social["title"], $lang)?>'/>
                    </a>
<?php
                }
?>
            </td>
            <td id='footer_center'><?=str_replace("#YEAR#", date("Y"), text($con, "FOOTER_COPY", $lang));?></td>
            <td id='footer_right'>
                <a href='<?=$lserver?>/help/'><?=text($con, "FOOTER_HELP", $lang);?></a>
                <br/><br/>
<?php
                $q_lang = mysqli_query($con, "SELECT * FROM lang WHERE active = 1;");
                while ($r = mysqli_fetch_array($q_lang)){
                    $uri = $_SERVER["REQUEST_URI"];
                    if (substr($uri, 3, 1) == '/'){
                        $uri = substr($uri, 3);
                    }
                    $dest = $server . "/" . $r["code"] . $uri;
?>
                    <a class='lang' href='<?=$dest?>'><img src='<?=$lserver?>/img/lang/<?=$r["code"]?>.gif' alt='<?=$r['name']?>' /></a>
<?php
                }
?>
            </td>
        </tr>
    </table>
</div>
