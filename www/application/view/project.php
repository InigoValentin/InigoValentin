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
        <link rel='stylesheet' type='text/css' href='<?=$path["css"]?>project.css'/>
        <!-- Script files -->
        <script type="text/javascript" src="<?=$path["js"]?>ui.js"></script>
        <script type="text/javascript" src="<?=$path["js"]?>project.js"></script>
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
            <section id='info'>
                <h3>
                    <?=$page->project->title?>
                </h3>
                <h4 id='summary'>
                    <?=$page->project->header?>
                </h4>
                <p id='text'>
<?php
                    if (strlen($page->project->logo) > 0){
?>
                        <img id='logo' src='<?=$path["img"]["content"]?>project/<?=$page->project->logo?>' title='<?=$page->project->title?>' alt='<?=$page->project->title?>'/>
<?php
                    }
?>
                    <?=$page->project->text?>
                </p>
<?php
                foreach($page->project->url as $embed){
                    if ($embed->type->id == "E"){
?>
                        <iframe id='demo' src='<?=$path["demo"]?><?=$embed->url?>' onload='resizeDemo(this);'></iframe>
<?php
                    }
                }
?>
<?php
                if (sizeof($page->project->image) > 0){
?>
                    <div id='image_reel'>
                        <table>
                            <tr>
<?php
                                foreach($page->project->image as $image){
?>
                                    <td>
                                        <img title='<?=$page->project->title?>' alt='<?=$page->project->title?>' src='<?=$path["img"]["content"]?>project/<?=$image->image?>'/>
                                    </td>
<?php
                                }
?>
                            </tr>
                        </table>
                    </div> <!-- #image_reel -->
<?php
                }
?>
            </div> <!-- #info -->
            <section id='details'>
                <h3 class='section_title'>
                    <?=text($page, "PROJECT_INFO")?>
                </h3>
                <div id='tags' class='details'>
<?php
                    $str_tag = "";
                    foreach($page->project->tag as $tag){
                        $str_tag = $str_tag . "<a class='tag' href='TODO' title='" . $tag->tag . "'>" . $tag->tag . "</a>, ";
                    }
                    $str_tag = rtrim($str_tag, ", ");
?>
                    <?=text($page, "PROJECT_TAGS")?>: <?=$str_tag?>
                    <hr class='details_separator'/>
                </div> <!-- #tags -->
<?php
                if (sizeof($page->project->url) > 0){
?>
                    <div id='links' class='details'>
<?php
                        foreach($page->project->url as $url){
                            if ($url->type->id != "E"){
?>
                                <td>
                                    <a class='link' href='<?=$url->url?>'>
                                        <img class='link' title='<?=$url->type->title?>' alt='<?=$url->type->title?>' src='<?=$path["img"]["content"]?>url/<?=$url->type->logo?>'/>
                                        <?=$url->type->title?>
                                    </a>
                                </td>
<?php
                            }
                        }
?>
                        <hr class='details_separator'/>
                    </div> <!-- #links -->
<?php
                }
?>
                <div id='version' class='details'>
                    <?=text($page, "PROJECT_VERSION")?>:<?=$page->project->version[0]->name?>
                    <br/>
                    <a href='TODO'><?=text($page, "PROJECT_VERSION_TREE")?></a>
                    <hr class='details_separator'/>
                </div> <!-- #license -->
                <div id='license' class='details'>
                    <?=text($page, "PROJECT_LICENSE")?>:
                    <img src='<?=$path["img"]["content"]?>license/<?=$page->project->license->logo?>' title='<?=$page->project->license->id?>' alt='<?=$page->project->license->id?>'/>
                </div> <!-- #license -->
            </section> <!-- #details -->
        </main> <!-- .content -->
<?php
        include __DIR__ . "/inc/footer.php";
?>
    </body>
</html>
