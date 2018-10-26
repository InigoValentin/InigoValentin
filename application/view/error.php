<!DOCTYPE html>
<html lang='<?=$lang?>'>
    <head>
        <meta content='text/html; charset=utf-8' http-equiv='content-type'/>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'>
        <title><?=$page->title?></title>
        <link rel='shortcut icon' href='<?=$static["layout"]?>/layout/logo/logo.svg'/>
        <!-- CSS files -->
        <link rel='stylesheet' type='text/css' href='<?=$static["css"]?>ui.css'/>
        <link rel='stylesheet' type='text/css' href='<?=$static["css"]?>error.css'/>
        <!-- Script files -->
        <script type="text/javascript" src="<?=$static["js"]?>ui.js"></script>
        <!-- No meta -->
        <meta name="robots" content="noindex follow"/>
    </head>
    <body>
<?php
        include $path["inc"] . "header.php";
?>
        <main>
            <section>
                <h3><?=text($page, "ERROR_ERROR");?></h3>
                <div id='left'>
                    <p id='code'>
                        <?=$page->code?>
                    </p>
                    <p>
                        <span><?=text($page, "ERROR_ERROR");?></span>
                        <span><?=text($page, "ERROR_CODE");?></span>
                    </p>
                </div>
                <div id='right'>
                    <h4>
                        <?=$page->error_description?>
                    </h4>
                    <?=$page->advice?>
                    <ul>
                        <li>
                            <a href='javascript: location.reload();'><?=$page->solution[0]?></a>
                        </li>
                        <li>
                            <a href='javascript: history.go(-1);'><?=$page->solution[1]?></a>
                        </li>
                        <li>
                            <a href='/'><?=$page->solution[2]?></a>
                        </li>
                    </ul>
                </div>
            </section>
        </main>
<?php
        include $path["inc"] . "footer.php";
?>
    </body>
</html>
