<!DOCTYPE html>
<html lang='<?=$page->lang?>'>
    <head>
        <meta content='text/html; charset=utf-8' http-equiv='content-type'/>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'/>
        <title><?=$page->title?></title>
        <link rel='shortcut icon' href='<?=$page->favicon?>'/>
        <!-- CSS files -->
        <link rel='stylesheet' type='text/css' href='<?=$static["css"]?>ui.css'/>
        <link rel='stylesheet' type='text/css' href='<?=$static["css"]?>profile.css'/>
        <!-- Script files -->
        <script type="text/javascript" src="<?=$static["js"]?>ui.js"></script>
        <!-- Meta tags -->
        <link rel='canonical' href='<?=$page->canonical?>'/>
        <link rel='author' href='<?=$page->author?>'/>
        <link rel='publisher' href='<?=$page->author?>'/>
        <meta name='description' content='<?=$page->description?>'/>
        <meta property='og:title' content='<?=$page->title?>'/>
        <meta property='og:url' content='<?=$page->canonical?>'/>
        <meta property='og:description' content='<?=$page->description?>'/>
        <meta property='og:image' content='<?=$page->icon?>'/>
        <meta property='og:site_name' content='<?=$page->name?>'/>
        <meta property='og:type' content='website'/>
        <meta property='og:locale' content='<?=$page->lang?>'/>
        <meta name='twitter:card' content='summary'/>
        <meta name='twitter:title' content='<?=$page->title?>'/>
        <meta name='twitter:description' content='<?=$page->description?>'/>
        <meta name='twitter:image' content='<?=$page->icon?>'/>
        <meta name='twitter:url' content='<?=$page->canonical?>'/>
        <meta name='robots' content='index follow'/>
    </head>
    <body>
<?php
        include $path["inc"] . "header.php";
?>
        <main>
            <section id='info'>
                <h3>
                    <?=text($page, "USER_NAME");?>
                </h3>
                <img id='profile_image' srcset='<?=srcset("profile/profile.png")?>' src='<?=$static["content"]?>profile/x400/profile.png' alt='<?=text($page, "USER_NAME");?>' title='<?=text($page, "USER_NAME");?>' />
                <div id='social'>
                    <a target='_blank' title='eMail' href='mailto:i@inigovalentin.com'>
                        <img class='footer_social_icon' src='<?=$static["layout"]?>social/email.svg' alt='eMail' title='eMail'/>
                    </a>
                    <a target='_blank' title='Telegram' href='https://telegram.me/InigoValentin'>
                        <img class='footer_social_icon' src='<?=$static["layout"]?>social/telegram.svg' alt='Telegram' title='Telegram'/>
                    </a>
                    <a target='_blank' title='Github' href='https://github.com/InigoValentin'>
                        <img class='footer_social_icon' src='<?=$static["layout"]?>social/github.svg' alt='Github' title='Github'/>
                    </a>
                    <a target='_blank' title='LinkedIn' href='https://www.linkedin.com/in/ivalentin'>
                        <img class='footer_social_icon' src='<?=$static["layout"]?>social/linkedin.svg' alt='LinkedIn' title='LinkedIn'/>
                    </a>
                </div>
            </section>
            <section id='about'>
                <h3>
                    <?=text($page, "PROFILE_DESCRIPTION");?>
                </h3>
                <p>
                    <?=text($page, "USER_TEXT");?>
                </p>
                <div id='cv_download'>
                    <a class='a_button' target='_blank' href='<?=$static["cv"] . $page->cv[0]->file?>'>
                        <?=text($page, "PROFILE_CV");?>
                    </a>
                    <details>
                        <summary class='pointer'><?=text($page, "PROFILE_CV_LANG");?></summary>
                        <ul>
<?php
                            for ($i = 1; $i < count($page->cv); $i ++) {
?>
                                <li>
                                    <a target='_blank' href='<?=$static["cv"] . $page->cv[$i]->file?>'>
                                        <?=$page->cv[$i]->lang->name?>
                                    </a>
                                </li>
<?php
                            }
?>
                        </ul>
                    </details>
                </div>
            </section>
        </main>
<?php
        include $path["inc"] . "footer.php";
?>
    </body>
</html>
