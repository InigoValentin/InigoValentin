<?php
/**
 * Project list view.
 *
 * Contains the view layout and some code to present the data.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 * @category View
 * @property Projects_Page $page The page model.
 * @var Projects_Page $page The page model.
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
                <h3><?=Text::get("PROJECT_TITLE")?></h3>
                    <p>
                        <?=get_context()->get_user()->get_text("PROJECTS")?>
                    </p>
                    <div id='projects'>
<?php
                        foreach ($page->get_projects() as $project){
?>
                            <article class='project'>
                                <table>
                                    <tr>
<?php
                                        if (strlen($project->get_logo() > 0)){
?>
                                            <td class='logo'>
                                                <a href='<?=URL::PROJECTS . $project->get_permalink()?>'>
                                                    <img
                                                      class='project_image'
                                                      alt='<?=$project->get_title()?>'
                                                      title='<?=$project->get_title()?>'
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
                        </article> <!-- .project -->
<?php
                    }
?>
                </div>
            </section>
        </main>
<?php
        include __DIR__ . "/inc/footer.php";
?>
    </body>
</html>
