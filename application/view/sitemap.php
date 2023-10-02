<?php
/**
 * Sitemap file.
 *
 * Prints the sitemap XML contents.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 * @category View
 * @property Sitemap_Page $page The page model.
 * @var Sitemap_Page $page The page model.
 */
?>
<?php header('Content-type: application/xml; charset=utf-8') ?>
<?=$page->get_text()?>
