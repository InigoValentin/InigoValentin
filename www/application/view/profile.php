<!DOCTYPE html>
<html lang='<?=$page->lang?>'>
    <head>
        <meta content='text/html; charset=utf-8' http-equiv='content-type'/>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'/>
        <title><?=$page->title?></title>
        <link rel='shortcut icon' href='<?=$page->favicon?>'/>
        <!-- CSS files -->
        <link rel='stylesheet' type='text/css' href='<?=$path["css"]?>ui.css'/>
        <link rel='stylesheet' type='text/css' href='<?=$path["css"]?>profile.css'/>
        <!-- Script files -->
        <script type="text/javascript" src="<?=$path["js"]?>ui.js"></script>
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
        include __DIR__ . "/inc/header.php";
?>
        <main>
            <section>
                <div id='left'>
                    <div id='logo'>
                        <img id='profile' src='<?=$path["img"]["content"]?>profile/x6/0.png' alt='<?=text($page, "USER_NAME");?>' title='<?=text($page, "USER_NAME");?>' />
                    </div>
                    <!-- TODO: Skills -->
                </div> <!-- #left -->
                <div id='right'>
<?php
                    foreach($page->entry["WORK"] as $entry){
                        // TODO: Something if its the current one.
?>
                        <div class='entry'>
                            <h4><?=$entry->role?> - <?=$entry->company?></h4>
                        </div>
<?php
                    }
?>
                </div> <!-- #right -->
            </section>
        </main>
<?php
        include __DIR__ . "/inc/footer.php";
?>
    </body>
</html>
