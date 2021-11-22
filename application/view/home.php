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
<html lang='en'>
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
                    <?=$page->get_title()?>
                </h3>
                <!-- TODO: Profile form model -->
                <article>
                    <img
                      id='profile_image'
                      srcset='<?=HTML::srcset("profile/profile.png")?>'
                      src='<?=URL::IMG["CONTENT"]?>profile/x400/profile.png'
                      alt='<?=TEXT::get("USER_NAME");?>'
                      title='<?=TEXT::get("USER_NAME");?>'
                    />
                    <div id='profile_content'>
                        <h4 id='tagline'><?=TEXT::get("USER_TAGLINE");?></h4>
                        <p id='bio'><?=TEXT::get("USER_BIO");?></p>
                    </div>
                    <div class='buttons'>
                        <a class='a_button' title='eMail' href='mailto:i@inigovalentin.com'>
                            <?=TEXT::get("INDEX_PROFILE_MAIL");?>
                            <img class='footer_social_icon' src='<?=URL::IMG["LAYOUT"]?>social/email.svg' alt='eMail' title='eMail'/>
                        </a>
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
                                <td>
                                    <a href='<?=URL::PROJECTS . $project->get_permalink()?>'>
                                        <img
                                          class='project_image'
                                          alt='<?=TEXT::get($project->get_title())?>'
                                          title='<?=TEXT::get($project->get_title())?>'
                                          srcset='<?=HTML::srcset("project/" . $project->get_logo())?>'
                                          src='<?=URL::IMG["CONTENT"]?>project/x200/<?=$project->get_logo()?>'
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
