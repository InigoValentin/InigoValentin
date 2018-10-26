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
        <link rel='stylesheet' type='text/css' href='<?=$static["css"]?>help.css'/>
        <!-- Script files -->
        <script type="text/javascript" src="<?=$static["js"]?>ui.js"></script>
        <script type="text/javascript" src="<?=$static["js"]?>help.js"></script>
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
<?php
            foreach($page->help as $key=>$help) {
?>
                <section id='<?=$key?>' class='help'>
                    <h3 class='pointer' onClick='toggleHelp("<?=$key?>");'>
                        <img class='slider' src='<?=$static["layout"]?>control/slid_r.svg' alt='>'/>
                        <?=$help["title"]?>
                    </h3>
                    <p>
                        <?=$help["text"]?>
                    </p>
                </section>
<?php
            }
?>
        </main>
<?php
        include $path["inc"] . "footer.php";
?>
    </body>
</html>
