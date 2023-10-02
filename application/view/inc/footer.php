<footer>
    <hr id='footer_separator'/>
    <br/>
    <table id='footer_table'>
        <tr>
            <td id='footer_left'>
                <span id='footer_follow' class='desktop'>
                    <?=TEXT::get("FOOTER_FOLLOW");?>
                </span>
<?php
                if (get_context()->get_user()->get_first_email() != null){
?>
                    <a target='_blank' title='eMail' href='mailto:<?=get_context()->get_user()->get_first_email()?>'>
                        <img class='footer_social_icon' src='<?=URL::IMG["LAYOUT"]?>social/email.svg' alt='eMail' title='eMail'/>
                    </a>
<?php
                }
                foreach (get_context()->get_user()->get_social() as $social){
?>
                    <a target='_blank' title='<?=$social->get_text()?>' href='<?=$social->get_url()?>'>
                        <img class='footer_social_icon' src='<?=URL::IMG["LAYOUT"]?>social/<?=$social->get_logo()?>' title='<?=$social->get_text()?>' alt='<?=$social->get_site_name()?>'/>
                    </a>
<?php
                }
?>
            </td>
            <td id='footer_center'>
                <?=str_replace("#YEAR#", date("Y"), TEXT::get("FOOTER_COPY"));?>
            </td>
            <td id='footer_right'>
                <a id='footer_help' href='<?=URL::BASE?>help/'>
                    <?=TEXT::get("FOOTER_HELP");?>
                </a>
                <br/><br/>
<?php
                foreach (get_context()->get_available_langs() as $code){
                    $lang = new Lang($code);
                    $uri = $_SERVER["REQUEST_URI"];
                    if (substr($uri, 3, 1) == '/'){
                        $uri = substr($uri, 3);
                    }
                    $dest = URL::BASE . $lang->get_code() . $uri;
?>
                    <a class='lang' href='<?=$dest?>'>
                        <img src='<?=URL::IMG["LAYOUT"]?>lang/<?=$lang->get_code()?>.svg' alt='<?=$lang->get_name()?>' title='<?=$lang->get_name()?>'/>
                    </a>
<?php
                }
?>
            </td>
        </tr>
    </table>
</footer>
