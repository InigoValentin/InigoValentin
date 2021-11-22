<?php
/**
 * Netowrk helper file.
 *
 * Provides a helper to perform network operations.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 */

require_once(__DIR__ . "/Helper.php");

/**
 * Netowrk helper.
 *
 * Contains netowrk related utilities.
 *
 * @category Helper.
 */
final class NET extends Helper{
    
    /**
     * Finds out the protocol the user is connecting to the site with.
     *
     * @return string "http://" or "https://".
     */
    public static function get_protocol(){
        if (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on" || $_SERVER["HTTPS"] == 1) || isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https") {
            $protocol = "https://";
        }
        else {
            $protocol = "http://";
        }
        return $protocol;
    }
    
    /**
     * Finds out the IP address of the client.
     *
     * @return string Client IP address.
     */
    public static function get_ip(){
        $client  = @$_SERVER["HTTP_CLIENT_IP"];
        $forward = @$_SERVER["HTTP_X_FORWARDED_FOR"];
        $remote  = $_SERVER["REMOTE_ADDR"];
        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }
        else{
            $ip = $remote;
        }
        return $ip;
    }
    
}
