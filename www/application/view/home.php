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
        <link rel='stylesheet' type='text/css' href='<?=$path["css"]?>home.css'/>
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
            <div id='left'>
                <section>
                    <h3>
                        <?=$page->name?>
                    </h3>
                    <!-- TODO: Profile form model -->
                    <article>
                        <div id='profile_container'>
                            <img id='profile' src='<?=$path["img"]["content"]?>profile/x6/0.png' alt='<?=text($page, "USER_NAME");?>' title='<?=text($page, "USER_NAME");?>' />
                        </div>
                        <span id='tagline'><?=text($page, "USER_TAGLINE");?></span>
                        <a class='a_button' href='<?=$root?>profile/'>
                            <span class='header_container'>
                                <span class='header_icon_container'>
                                    <img class='header_icon' alt='<?=text($page, "HEADER_ME");?>' src='<?=$path["img"]["content"]?>icon/profile.gif'/>
                                </span>
                                <?=text($page, "INDEX_PROFILE");?>
                            </span>
                        </a>
                    </article>
                </section>
            </div> <!-- left -->
            <div id='right'>
                <section>
                    <h3>
                        <?=text($page, "INDEX_PROJECTS");?>
                    </h3>
<?php
                    foreach ($page->project as $project){
?>
                        <article>
                            <table>
                                <tr>
<?php
                                    if (strlen($project->logo) > 0){
?>
                                        <td>
                                            <a href='<?=$root?>project/<?=$project->permalink?>'>
                                                <img alt='<?=text($page, $project->title)?>' title='<?=text($page, $project->title)?>' src='<?=$path["img"]["content"]?>project/x2/<?=$project->logo?>'/>
                                            </a>
                                        </td>
<?php
                                    }
?>
                                    <td>
                                        <a href='<?=$root?>project/<?=$project->permalink?>'>
                                            <h4 class='project_name'><?=$project->title?></h4>
                                        </a>
                                        <span>
                                            <?=$project->header?>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </article>
<?php
                    }
?>
                    <a class='a_button' href='<?=$root?>project/'>
                        <span class='header_container'>
                            <span class='header_icon_container'>
                                <img class='header_icon' alt='<?=text($page, "HEADER_PROJECTS");?>' src='<?=$path["img"]["layout"]?>icon/projects.gif'/>
                            </span>
                            <?=text($page, "INDEX_PROJECTS");?>
                        </span>
                    </a>
                </section>
            </div> <!-- #right -->
        </main>
<?php
        include __DIR__ . "/inc/footer.php";
?>
    </body>
</html>
