<div id='footer'>
    <hr id='footer_separator'/><br/>
    <table id='footer_table'>
        <tr>
            <td id='footer_left'>
                <span id='footer_follow' class='desktop'><?=text($con, "FOOTER_FOLLOW", $lang);?></span>
                <a title='Github' href='https://www.github.com/u/Seavenois'><img class='footer_social_icon' src='<?=$lserver?>/img/social/github.gif' alt='Github'/></a>
                <a title='Facebook' href='https://www.facebook.com/ivalentin'><img class='footer_social_icon' src='<?=$lserver?>/img/social/facebook.gif' alt='Facebook'/></a>
                <a title='Google+' href='https://plus.google.com/108048773942421710294/'><img class='footer_social_icon' src='<?=$lserver?>/img/social/googleplus.gif' alt='Google+'/></a>
                <a title='RSS' href='<?=$lserver?>/feed/'><img class='footer_social_icon' src='<?=$lserver?>/img/social/rss.gif' alt='RSS'/></a>
            </td>
            <td id='footer_center'><?=text($con, "FOOTER_COPY", $lang);?></td>
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
