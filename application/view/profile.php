<?php
/**
 * Profile view.
 *
 * Contains the view layout and some code to present the data.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 * @category View
 * @property Profile_Page $page The page model.
 * @var Profile_Page $page The page model.
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
            <section id='info'>
                <h3>
                    <?=get_context()->get_user()->get_display_name()?>
                </h3>
                <img
                  id='profile_image'
                  srcset='<?=HTML::srcset("profile/" . get_context()->get_user()->get_image())?>'
                  src='<?=URL::IMG["CONTENT"]?>profile/<?=get_context()->get_user()->get_image()?>'
                  alt='<?=get_context()->get_user()->get_display_name()?>'
                  title='<?=get_context()->get_user()->get_display_name()?>'
                />
                <h4>
                    <?=get_context()->get_user()->get_text("TAGLINE")?>
                </h4>
                <div id='social'>
<?php
                    if (get_context()->get_user()->get_first_email() != null){
?>
                        <a target='_blank' title='eMail' href='mailto:<?=get_context()->get_user()->get_first_email()?>'>
                            <img src='<?=URL::IMG["LAYOUT"]?>social/email.svg' alt='eMail' title='eMail'/>
                        </a>
<?php
                    }
                    foreach (get_context()->get_user()->get_social() as $social){
?>
                        <a target='_blank' title='<?=$social->get_text()?>' href='<?=$social->get_url()?>'>
                            <img src='<?=URL::IMG["LAYOUT"]?>social/<?=$social->get_logo()?>' title='<?=$social->get_text()?>' alt='<?=$social->get_site_name()?>'/>
                        </a>
<?php
                    }
?>
                </div>
            </section>
            <section id='about'>
                <h3>
                    <?=Text::get("PROFILE_DESCRIPTION");?>
                </h3>
                <p>
                    <?=get_context()->get_user()->get_text("TEXT")?>
                </p>
                <div id='cv_download'>
                    <a class='a_button' target='_blank' href='<?=$static["cv"] . $page->get_main_cv()->get_file()?>'>
                        <?=Text::get("PROFILE_CV");?>
                    </a>
                    <details>
                        <summary class='pointer'><?=Text::get("PROFILE_CV_LANG");?></summary>
                        <ul>
<?php
                            for ($i = 1; $i < count($page->get_other_cvs()); $i ++) {
?>
                                <li>
                                    <a target='_blank' href='<?=$static["cv"] . $page->get_other_cvs()[$i]->get_file()?>'>
                                        <?=$page->get_other_cvs()[$i]->get_lang()->get_name()?>
                                    </a>
                                </li>
<?php
                            }
?>
                        </ul>
                    </details>
                </div>
            </section>
        </main>
<?php
        include __DIR__ . "/inc/footer.php";
?>
    </body>
</html>
