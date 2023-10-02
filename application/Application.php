<?php
/**
 * Constants file.
 *
 * Provides some predefined values.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 */

    class URL{
        //static $BASE = Net.get_protocol() . $_SERVER["HTTP_HOST"];
        //static $STATIC = Net.get_protocol() . $_SERVER["HTTP_HOST"];
        //static $BASE = ((1 == 1) ? 1 : 0);
        //static $BASE = $_SERVER["HTTP_HOST"];
    }
    
    final class EXCEPTION_CODE{
        const PDO_UNSUPPORTED = 800001;
        const PDO_MYSQL_HOSTNAME = 807701;
        const PDO_MYSQL_DBNAME = 807702;
        const PDO_MYSQL_PORT = 807703;
    }

?>
