<?php
/**
 * Path constants file.
 *
 * Provides paths to everything in the code tree.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 */

define('BASE_PATH', $_SERVER["DOCUMENT_ROOT"] . "/");

/**
 * In-app directories (filesystem, not url).
 *
 * @category Data
 */
final class PATH{
    
    /**
     * Path to the application direcory.
     */
    const APPLICATION = BASE_PATH . "../application/";
    
    /**
     * Path to the public direcory.
     */
    const BASE = BASE_PATH;
    
    /**
     * Path to the controller file.
     */
    const CONTROLLER = BASE_PATH . "../application/Controller.php";
    
    /**
     * Path to the entity files.
     */
    const ENTITY = BASE_PATH . "../application/entity/";
    
    /**
     * Path to the page files.
     */
    const PAGE = BASE_PATH . "../application/page/";
    
    /**
     * Path to the action files.
     */
    const ACTION = BASE_PATH . "../application/action/";
    
    /**
     * Path to the view files.
     */
    const VIEW = BASE_PATH . "../application/view/";
    
    /**
     * Paths to image resources.
     */
    const IMG = array(
        "BASE" => BASE_PATH . "img/",
        "UNKNOWN" => BASE_PATH . "img/unknown.png",
        "ICON" => BASE_PATH . "img/icon/",
        "LOGO" => BASE_PATH . "img/logo/",
        "CURRENCY" => BASE_PATH . "img/currency/",
        "UNIT" => BASE_PATH . "img/unit/",
        "AREA" => BASE_PATH . "img/area/",
        "SKILL" => BASE_PATH . "img/skill/",
        "ESSENCE" => BASE_PATH . "img/essence/",
        "RUNE" => BASE_PATH . "img/rune/",
        "GRIND" => BASE_PATH . "img/grind/",
        "ELEMENT" => BASE_PATH . "img/element/",
        "SKILL_GUILD" => BASE_PATH . "img/skill_guild/",
        "DECORATION" => BASE_PATH . "img/decoration/",
        "SOURCE" => BASE_PATH . "img/source/",
        "SKILL_LEADER" => BASE_PATH . "img/skill_leader/",
        "INVENTORY" => BASE_PATH . "img/inventory/",
        "EFFECT" => BASE_PATH . "img/effect/",
        "BUILDING" => BASE_PATH . "img/building/",
    );
    
    /**
     * Path to the helper files.
     */
    const HELPER = BASE_PATH . "../application/helper/";
    
    /**
     * Path to the text resources.
     */
    const TEXT = BASE_PATH . "../application/resources/text/";
}