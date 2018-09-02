<div id='footer'>
    <hr id='footer_separator'/>
    <br/>
    <table id='footer_table'>
        <tr>
            <td id='footer_left'>
                <span id='footer_follow' class='desktop'>
                    <?=text($page, "FOOTER_FOLLOW");?>
                </span>
<?php
                foreach ($page->footer->social as $social){
?>
                    <a title='<?=text($page, $social->title)?>' href='<?=$social->url?>'>
                        <img class='footer_social_icon' src='<?=$path["img"]["content"]?>social/x2/<?=$social->icon?>' alt='<?=text($page, $social->title)?>' title='<?=text($page, $social->title)?>'/>
                    </a>
<?php
                }
?>
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
</div>
