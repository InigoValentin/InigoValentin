<?php
/**
 * Logger file.
 *
 * Provides an utility to log messages.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 */

/**
 * Logger class.
 *
 * Logs different types of messages.
 *
 * @category Util
 */
final class Log{
    
    /**
     * Reads the log configuration in ../config/config.ini
     * 
     * @return mixed[] Log configuration.
     */
    private static function read_config(){
        return $configuration = parse_ini_file(__DIR__ . "/../config/config.ini", true)["log"];
    }
    
    /**
     * Formats a message for logging, including the current time.
     * 
     * @param string $tag Log type tag.
     * @param string $message Message to log.
     * @param int $code Log message associated code, optional.
     * @return string Message, ready to be written.
     */
    private static function format($tag, $message, $code = null){
        $msg = "[" . $tag . "][" . date("c") . "]";
        if (is_int($code)){
            $msg .= "[$code]";
        }
        $msg .= " $message\n";
        return $msg;
    }
    
    /**
     * Sends a debug message.
     * 
     * Will do nothing unless the log level is set to DEBUG.
     * 
     * @param string $message Message to log.
     * @param int $code Message associated code, optional.
     */
    public static function debug($message, $code = null){
        $config = Log::read_config();
        if ($config["level"] == "debug"){
            $msg = Log::format("DEBUG", $message, $code);
            file_put_contents($config["file"], $msg, FILE_APPEND);
        }
    }

    /**
     * Sends an informative message.
     *
     * Will do nothing unless the log level is set to DEBUG or INFO.
     *
     * @param string $message Message to log.
     * @param int $code Message associated code, optional.
     */
    public static function info($message, $code = null){
        $config = Log::read_config();
        if (in_array($config["level"], ["debug", "info"])){
            $msg = Log::format("INFO ", $message, $code);
            file_put_contents($config["file"], $msg, FILE_APPEND);
        }
    }

    /**
     * Sends a warning message.
     *
     * Will do nothing unless the log level is set to WARN.
     *
     * @param string $message Message to log.
     * @param int $code Message associated code, optional.
     */
    public static function warn($message, $code = null){
        $config = Log::read_config();
        if (in_array($config["level"], ["debug", "info", "warn"])){
            $msg = Log::format("WARN ", $message, $code);
            file_put_contents($config["file"], $msg, FILE_APPEND);
        }
    }

    /**
     * Sends an error message.
     *
     * Will do nothing if the log level is set to FATAL.
     *
     * @param string $message Message to log.
     * @param int $code Message associated code, optional.
     */
    public static function error($message, $code = null){
        $config = Log::read_config();
        if (in_array($config["level"], ["debug", "info", "warn", "error"])){
            $msg = Log::format("ERROR", $message, $code);
            file_put_contents($config["file"], $msg, FILE_APPEND);
        }
    }

    /**
     * Sends a fatal error message.
     *
     * Fatal messages are always logged.
     *
     * @param string $message Message to log.
     * @param int $code Message associated code, optional.
     */
    public static function fatal($message, $code = null){
        $config = Log::read_config();
        $msg = Log::format("FATAL", $message, $code);
        file_put_contents($config["file"], $msg, FILE_APPEND);
    }
}