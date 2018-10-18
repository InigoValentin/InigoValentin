<footer>
    <hr id='footer_separator'/>
    <br/>
    <table id='footer_table'>
        <tr>
            <td id='footer_left'>
                <span id='footer_follow' class='desktop'>
                    <?=text($page, "FOOTER_FOLLOW");?>
                </span>
                <a target='_blank' title='eMail' href='mailto:i@inigovalentin.com'>
                    <img class='footer_social_icon' src='<?=$path["img"]["layout"]?>social/email.svg' alt='eMail' title='eMail'/>
                </a>
                <a target='_blank' title='Telegram' href='https://telegram.me/@InigoValentin'>
                    <img class='footer_social_icon' src='<?=$path["img"]["layout"]?>social/telegram.svg' alt='Telegram' title='Telegram'/>
                </a>
                <a target='_blank' title='Github' href='https://github.com/InigoValentin'>
                    <img class='footer_social_icon' src='<?=$path["img"]["layout"]?>social/github.svg' alt='Github' title='Github'/>
                </a>
                <a target='_blank' title='LinkedIn' href='https://www.linkedin.com/in/ivalentin'>
                    <img class='footer_social_icon' src='<?=$path["img"]["layout"]?>social/linkedin.svg' alt='LinkedIn' title='LinkedIn'/>
                </a>
            </td>
            <td id='footer_center'>
                <?=str_replace("#YEAR#", date("Y"), text($page, "FOOTER_COPY"));?>
            </td>
            <td id='footer_right'>
                <a id='footer_help' href='<?=$root?>help/'>
                    <?=text($page, "FOOTER_HELP");?>
                </a>
                <br/><br/>
<?php
                foreach ($page->footer->lang as $lang){
                    $uri = $_SERVER["REQUEST_URI"];
                    if (substr($uri, 3, 1) == '/'){
                        $uri = substr($uri, 3);
                    }
                    $dest = $root . $lang->code . $uri;
?>
                    <a class='lang' href='<?=$dest?>'>
                        <img src='<?=$path["img"]["layout"]?>lang/<?=$lang->code?>.svg' alt='<?=$lang->name?>' title='<?=$lang->name?>'/>
                    </a>
<?php
                }
?>
            </td>
        </tr>
    </table>
</footer>
