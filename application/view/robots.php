<?php
/**
 * robots.txt file.
 *
 * Prints the robots.txt contents.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 * @category View
 * @property Robots_Page $page The page model.
 * @var Robots_Page $page The page model.
 */
?>
<?php header('Content-type: text/plain; charset=utf-8') ?>
<?=$page->get_text()?>
