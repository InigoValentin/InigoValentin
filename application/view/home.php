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
        <link rel='stylesheet' type='text/css' href='<?=$static["css"]?>home.css'/>
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
            <section id='profile'>
                <h3>
                    <?=$page->name?>
                </h3>
                <!-- TODO: Profile form model -->
                <article>
                    <img id='profile_image' srcset='<?=srcset("profile/profile.png")?>' src='<?=$static["content"]?>profile/x400/profile.png' alt='<?=text($page, "USER_NAME");?>' title='<?=text($page, "USER_NAME");?>' />
                    <div id='profile_content'>
                        <h4 id='tagline'><?=text($page, "USER_TAGLINE");?></h4>
                        <p id='bio'><?=text($page, "USER_BIO");?></p>
                    </div>
                    <div class='buttons'>
                        <a class='a_button' href='<?=$base_url?>/profile/'>
                            <?=text($page, "INDEX_PROFILE_MORE");?>
                        </a>
                    </div>
                </article>
            </section>
            <section id='projects'>
                <h3>
                    <?=text($page, "INDEX_PROJECTS");?>
                </h3>
<?php
            foreach ($page->project as $project){
?>
                <article class='project'>
                    <table>
                        <tr>
<?php
                            if (strlen($project->logo) > 0){
?>
                                <td>
                                    <a href='<?=$base_url?>/project/<?=$project->permalink?>'>
                                        <img class='project_image' alt='<?=text($page, $project->title)?>' title='<?=text($page, $project->title)?>' srcset='<?=srcset("project/" . $project->logo)?>' src='<?=$static["content"]?>project/x200/<?=$project->logo?>'/>
                                    </a>
                                </td>
<?php
                            }
?>
                            <td class='project_details'>
                                <a href='<?=$base_url?>/project/<?=$project->permalink?>'>
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
                <div class='buttons'>
                    <a class='a_button' href='<?=$base_url?>/project/'>
                        <?=text($page, "INDEX_PROJECTS_ALL");?>
                    </a>
                </div>
            </section>
        </main>
<?php
        include $path["inc"] . "footer.php";
?>
    </body>
</html>
