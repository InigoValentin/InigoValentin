<div id='footer'>
    <hr id='footer_separator'/><br/>
    <table id='footer_table'>
        <tr>
            <td id='footer_left'>
                <span id='footer_follow' class='desktop'><?=text($con, "FOOTER_FOLLOW", $lang);?></span>
                <a title='Github' href='https://www.github.com/u/Seavenois'><img class='footer_social_icon' src='<?=$server?>/img/social/github.gif' alt='Github'/></a>
                <a title='Facebook' href='https://www.facebook.com/ivalentin'><img class='footer_social_icon' src='<?=$server?>/img/social/facebook.gif' alt='Facebook'/></a>
                <a title='Google+' href='https://plus.google.com/108048773942421710294/'><img class='footer_social_icon' src='<?=$server?>/img/social/googleplus.gif' alt='Google+'/></a>
                <a title='RSS' href='<?=$server?>/feed/'><img class='footer_social_icon' src='<?=$server?>/img/social/rss.gif' alt='RSS'/></a>
            </td>
            <td id='footer_center'><?=text($con, "FOOTER_COPY", $lang);?></td>
            <td id='footer_right'>
                <a href='<?=$server?>/help/'><?=text($con, "FOOTER_HELP", $lang);?></a>
                <br/><br/>
<?php
                $q_lang = mysqli_query($con, "SELECT * FROM lang WHERE active = 1;");
                while ($r = mysqli_fetch_array($q_lang)){
                    // TODO: href
?>
                    <a class='lang' href='#'><img src='<?=$server?>/img/lang/<?=$r["code"]?>.gif' alt='<?=$r['name']?>' /></a>
<?php
                }
?>
            </td>
        </tr>
    </table>
</div>
