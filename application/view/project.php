<?php
/**
 * Project view.
 *
 * Contains the view layout and some code to present the data.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 * @category View
 * @property Project_Page $page The page model.
 * @var Project_Page $page The page model.
 */
?>
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
                <h3>
                    <?=$page->get_project()->get_title()?>
                </h3>
                <article>
                    <div id='info_summary'>
                        <h4>
                            <?=$page->get_project()->get_header()?>
                        </h4>
                        <div id='text'>
                            <?=$page->get_project()->get_text()?>
                        </div>
<?php
                        if ($page->get_project()->get_comment() != ""){
?>
                            <div id='comment'>
                                <div id='comment_title'>
                                    <?=Text::compose("PROJECT_COMMENT", explode(" ", get_context()->get_user()->get_display_name()))?>
                                </div>
                                <?=$page->get_project()->get_comment()?>
                            </div>
<?php
                        }
?>
                    </div>
                    <div id='info_details'>
<?php
                        if (strlen($page->get_project()->get_logo()) > 0){
?>
                            <img
                                id='logo'
                                srcset='<?=HTML::srcset("project/" . $page->get_project()->get_logo())?>'
                                src='<?=URL::IMG["CONTENT"]?>project/<?=$page->get_project()->get_logo()?>'
                                title='<?=$page->get_project()->get_title()?>'
                                alt='<?=$page->get_project()->get_title()?>'
                            />
<?php
                        }
?>
                        <div id='tags' class='details'>
<?php
                            $str_tag = "";
                            foreach($page->get_project()->get_tags() as $tag)
                                $str_tag .= $tag . ", ";
                            $str_tag = rtrim($str_tag, ", ");
?>
                            <?=Text::get("PROJECT_TAGS")?>: <?=$str_tag?>
                            <hr class='details_separator'/>
                        </div> <!-- #tags -->
<?php
                        if (sizeof($page->get_project()->get_urls()) > 0){
?>
                            <div id='links' class='details'>
<?php
                                foreach($page->get_project()->get_urls() as $url){
                                    if ($url->get_type()->get_id() != "E"){
?>
                                        <div>
                                            <a target='_blank' class='link' href='<?=$url->get_url()?>'>
                                                <img
                                                  class='link'
                                                  title='<?=$url->get_type()->get_title()?>'
                                                  alt='<?=$url->get_type()->get_title()?>'
                                                  src='<?=URL::IMG["LAYOUT"] . "social/" . $url->get_type()->get_logo()?>'
                                                />
                                                <?=$url->get_type()->get_summary()?>
                                            </a>
                                        </div>
<?php
                                    }
                                }
?>
                                <hr class='details_separator'/>
                            </div> <!-- #links -->
<?php
                        }
?>
                        <div id='license' class='details'>
                            <?=Text::get("PROJECT_LICENSE")?>:
                            <img
                              src='<?=URL::IMG["LAYOUT"] . "license/" . $page->get_project()->get_license()->get_logo()?>'
                              title='<?=$page->get_project()->get_license()->get_id()?>'
                              alt='<?=$page->get_project()->get_license()->get_id()?>'/>
                        </div> <!-- #license -->
                    </div> <!-- #info_details -->
                </article>
<?php
                foreach($page->get_project()->get_urls() as $embed){
                    if ($embed->get_type()->get_id() == "E"){
?>
                        <iframe id='demo' src='<?=$static["demo"]?><?=$embed->get_url()?>' onload='setTimeout(function(){resizeDemo();}, 500);'></iframe>
<?php
                    }
                }
?>
<?php
                if (sizeof($page->get_project()->get_images()) > 0){
?>
                    <div id='image_reel'>
<?php
                        foreach($page->get_project()->get_images() as $image){
?>
                            <div class='img'>
                                <img
                                  title='<?=$page->get_project()->get_title()?>'
                                  alt='<?=$image->get_text()?>'
                                  src='<?=URL::IMG["CONTENT"]?>project/<?=$image->get_image()?>'
                                  srcset='<?=HTML::srcset("project/" . $image->get_image())?>'
                                />
                                <h5>
                                    <?=$image->get_text()?>
                                </h5>
                            </div>
<?php
                        }
?>
                    </div> <!-- #image_reel -->
<?php
                }
?>
            </section>
        </main>
<?php
        include __DIR__ . "/inc/footer.php";
?>
    </body>
</html>
