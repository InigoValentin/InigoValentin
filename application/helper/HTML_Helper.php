<?php
/**
 * HTML helper file.
 *
 * Provides utilities to generate HTML content.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 */

require_once(__DIR__ . "/Helper.php");


/**
 * HTML helper.
 *
 * Contains utilities to generate HTML content.
 *
 * @category Helper.
 */
final class HTML extends Helper{

    /**
     * This function closes all the opened HTML tags in a given string.
     * 
     * @param string html The string with HTML tags.
     * @return string HTML with closed tags.
     */
    public static function close_tags($html) {
        $result = [];
        preg_match_all("#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU", $html, $result);
        $openedtags = $result[1];
        preg_match_all("#</([a-z]+)>#iU", $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i=0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= "</".$openedtags[$i].">";
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }


    /**
     * Text shortener. Given a string, it trims in the proximity of the
     * desired string, up to the next white character. If indicated, it will
     * append a link to the full text.
     * 
     * @param string $text The text to shorten.
     * @param int $length The desired length.
     * @param string $link_text Text for the link. Optional.
     * @param string $link URI of the link.
     * @return string Shortened text.
     */
     function cut_text($text, $length, $link_text = "", $link = ""){
        if (strlen($text) < $length){
            return $text;
        }
        $cut = substr($text, 0, strpos($text, " ", $length));
        $cut = close_tags($cut);
        if (strlen($cut) == 0){
            $cut = $text;
        }
        if (strlen($text) != strlen($cut) && strlen($link) > 0 && strlen($link_text) > 0){
            $cut = $cut . "... <a href='$link'>$link_text</a>";
        }
        return $cut;
    }

    /**
     * Creates the srcset attribute for content images.
     * Creates 9 different resolutions, from 100px to 900px.
     * 
     * @param string $file Path to the file, relative to $path["img"]["content"]).
     * @return string srcset atttribute content.
     */
    public static function srcset($file){
        global $static;
        $srcset = "";
        $dir = dirname($file);
        $name = basename($file);
        foreach (range(1, 9) as $d) {
            $srcset = $srcset . URL::IMG["CONTENT"] . $dir . "/x" . $d . "00/" . $name . " " . $d . "00px, ";
        }
        $srcset = rtrim($srcset, ", ");
        return $srcset;
    }

}
