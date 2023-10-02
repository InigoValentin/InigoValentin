<?php
/**
 * Home view.
 *
 * Contains the view layout and some code to present the data.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 * @category View
 * @property Home_Page $page The page model.
 * @var Home_Page $page The page model.
 */
?>
<!DOCTYPE html>
<html lang='<?=get_context()->get_lang()?>'>
    <head>
        <?=$page->generate_head()?>
    </head>
    <body>
        <header>
<?php
            include __DIR__ . "/inc/header.php";
?>
        </header>
        <main>
            <section id='profile'>
                <h3>
                    <?=get_context()->get_user()->get_display_name()?>
                </h3>
                <!-- TODO: Profile form model -->
                <article>
                    <h4 id='tagline'><?=get_context()->get_user()->get_text("TAGLINE")?></h4>
                    <img
                      id='profile_image'
                      srcset='<?=HTML::srcset(get_context()->get_user()->get_image())?>'
                      src='<?=URL::IMG["CONTENT"] . 'profile/' . get_context()->get_user()->get_image()?>'
                      alt='<?=get_context()->get_user()->get_display_name()?>'
                      title='<?=get_context()->get_user()->get_display_name()?>'
                    />
                    <table id='profile_table'>
                        <tr>
<?php
                            $i = 0;
                            $total = sizeof(get_context()->get_user()->get_social());
                            if (get_context()->get_user()->get_first_email() != null){
                                $i ++;
                                $total ++;
?>
                                <td class='social'>
                                    <a target='_blank' title='eMail' href='mailto:<?=get_context()->get_user()->get_first_email()?>'>
                                        <img src='<?=URL::IMG["LAYOUT"]?>social/email.svg' alt='eMail' title='eMail'/>
                                    </a>
                                </td>
<?php
                            }
                            foreach (get_context()->get_user()->get_social() as $social){
?>
                                <td class='social'>
                                    <a target='_blank' title='<?=$social->get_text()?>' href='<?=$social->get_url()?>'>
                                        <img src='<?=URL::IMG["LAYOUT"]?>social/<?=$social->get_logo()?>' title='<?=$social->get_text()?>' alt='<?=$social->get_site_name()?>'/>
                                    </a>
                                </td>
<?php
                                $i ++;
                                if ($total > 3 && $i >= $total / 2){
                                    $i = 0;
?>
                                    </tr>
                                    <tr>
<?php
                                }
                            }
?>
                        </tr>
                    </table>
<!--                     <div id='profile_content'> -->
                        <p id='bio'><?=get_context()->get_user()->get_text("BIO")?></p>
                    </div>
                    <div class='buttons'>
                        <a class='a_button' href='<?=URL::PROFILE?>'>
                            <?=TEXT::get("INDEX_PROFILE_MORE");?>
                        </a>
                    </div>
                </article>
            </section>
            <section id='projects'>
                <h3>
                    <?=TEXT::get("INDEX_PROJECTS");?>
                </h3>
<?php
            foreach ($page->get_projects() as $project){
?>
                <article class='project'>
                    <table>
                        <tr>
<?php
                            if (strlen($project->get_logo()) > 0){
?>
                                <td class='logo'>
                                    <a href='<?=URL::PROJECTS . $project->get_permalink()?>'>
                                        <img
                                          class='project_image'
                                          alt='<?=TEXT::get($project->get_title())?>'
                                          title='<?=TEXT::get($project->get_title())?>'
                                          srcset='<?=HTML::srcset("project/" . $project->get_logo())?>'
                                          src='<?=URL::IMG["CONTENT"]?>project/<?=$project->get_logo()?>'
                                        />
                                    </a>
                                </td>
<?php
                            }
?>
                            <td class='project_details'>
                                <h4 class='project_name'>
                                    <a href='<?=URL::PROJECTS . $project->get_permalink()?>'>
                                        <?=$project->get_title()?>
                                    </a>
                                </h4>
                                <span>
                                    <?=$project->get_header()?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </article>
<?php
                }
?>
                <div class='buttons'>
                    <a class='a_button' href='<?=URL::PROJECTS?>'>
                        <?=TEXT::get("INDEX_PROJECTS_ALL");?>
                    </a>
                </div>
            </section>
        </main>
<?php
        include __DIR__ . "/inc/footer.php";
?>
    </body>
</html>
