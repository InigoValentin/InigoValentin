<!DOCTYPE html>
<html lang='<?=get_context()->get_lang()?>'>
    <head>
        <?=$page->generate_head()?>
    </head>
    <body>
<?php
        include __DIR__ . "/inc/header.php";
?>
        <main>
            <section>
                <h3><?=Text::get("ERROR_ERROR")?></h3>
                <div id='left'>
                    <p id='code'>
                        <?=$page->code?>
                    </p>
                    <p>
                        <span><?=Text::get("ERROR_ERROR")?></span>
                        <span><?=Text::get("ERROR_CODE")?></span>
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
        include __DIR__ . "/inc/footer.php";
?>
    </body>
</html>
