<?php
/**
 * URL constants file.
 *
 * Provides the app URLs.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 */

/**
 * The site base URL.
 */
define('BASE_URL', NET::get_protocol() . $_SERVER["HTTP_HOST"] . "/");


/**
 * In-app URLs.
 *
 * @category Data
 */
final class URL{

    /**
     * Domain, with protcol (includes final '/').
     */
    const BASE = BASE_URL;
    
    /**
     * Profile page.
     */
    const PROFILE = BASE_URL . "/profile/";
    
    /**
     * Projects page.
     */
    const PROJECTS = BASE_URL . "/projects/";

    /**
     * Fonts full url (includes final '/').
     */
    const FONTS = BASE_URL . "/fonts/";

    /**
     * CSS full url (includes final '/').
     */
    const CSS = BASE_URL . "css/";

    /**
     * URLs to image resources.
     */
    const IMG = array(
        "BASE" => BASE_URL . "img/",
        "UNKNOWN" => BASE_URL . "img/unknown.png",
        "ICON" => BASE_URL . "img/icon/",
        "LOGO" => BASE_URL . "img/logo/",
        "LAYOUT" => BASE_URL . "img/layout/",
        "CONTENT" => BASE_URL . "img/content/",
    );
}