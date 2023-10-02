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
 * @property Help_Page $page The page model.
 * @var Help_Page $page The page model.
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
<?php
            $sections = ["info", "license", "privacy", "cookies"];
            $first = true;
            foreach($sections as $section) {
?>
                <section id='<?=$section?>' class='help <?=$first ? "selected" : ""?>'>
                    <h3 class='pointer' onClick='toggleHelp("<?=$section?>");'>
                        <img class='slider' src='<?=URL::IMG["CONTROL"]?>slid_r.svg' alt='>'/>
                        <?=$page->get_section_title($section)?>
                    </h3>
                    <div>
                        <?=$page->get_section_text($section)?>
                    </div>
                </section>
<?php
                $first = false;
            }
?>
        </main>
        <div id='policy_cover'></div>
        <section id='policy'>
            <h3>
                <?=TEXT::get("HELP_POLICY")?>
                <div id='policy_close'>
                    <a onClick='closePolicy();'>
                        <img src='<?=URL::IMG["LAYOUT"]?>control/close.svg'/>
                    </a>
                </div>
            </h3>
            <div>
                <?=get_context()->get_user()->get_text("POLICY")?>
            </div>
        </section>
<?php
        include __DIR__ . "/inc/footer.php";
?>
    </body>
</html>
