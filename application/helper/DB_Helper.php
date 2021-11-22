<?php
/**
 * DB helper file.
 *
 * Provides a helper to perform database operations.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 */

require_once(__DIR__ . "/Helper.php");

/**
 * Database helper.
 *
 * Contains database utilities to connect.
 *
 * @category Helper.
 */
final class DB extends Helper{

    private static function generate_dsn($db_configuration){
        
        $type = $db_configuration["type"];
        $host = $db_configuration["host"];
        $port = $db_configuration["port"];
        $name = $db_configuration["name"];
        Log::debug("Database type: $type");
        Log::debug("Database host: $host");
        Log::debug("Database port: $port");
        Log::debug("Database name: $name");
        $dsn = "";
        switch ($type){
            case "mysql":
                $dsn = "mysql:";
                if (filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) == false){
                    Log::fatal(
                      "MySQL driver specified, but hostname is invalid: $host",
                      EXCEPTION_CODE::PDO_MYSQL_HOSTNAME
                      );
                    throw new UnexpectedValueException(
                      "MySQL driver specified, but hostname is invalid: $host",
                      EXCEPTION_CODE::PDO_MYSQL_HOSTNAME
                    );
                }
                else{
                    $dsn .= "host=$host;";
                }
                if (
                  strlen($name) > 64 ||
                  strpos($name, "\\") !== false ||
                  strpos($name, "/") !== false ||
                  strpos($name, ".") !== false
                ){
                    Log::fatal(
                      "MySQL driver specified, but database name is invalid: $name",
                      EXCEPTION_CODE::PDO_MYSQL_DBNAME
                    );
                    throw new UnexpectedValueException(
                      "MySQL driver specified, but database name is invalid: $name",
                      EXCEPTION_CODE::PDO_MYSQL_DBNAME
                    );
                }
                else{
                    $dsn .= "dbname=$name;";
                }
                if (intval($port) != 0){
                    $port = intval($port);
                    if ($port < 1 || $port > 65534){
                        Log::fatal(
                          "MySQL driver specified, but port number name is invalid: $port",
                          EXCEPTION_CODE::PDO_MYSQL_PORT
                        );
                        throw new UnexpectedValueException(
                          "MySQL driver specified, but port number name is invalid: $port",
                          EXCEPTION_CODE::PDO_MYSQL_PORT
                        );
                    }
                    else{
                        $dsn .= "port=$port;";
                    }
                }
                
                if ($host != null && strlen($host) > 0){
                    $dsn .= "host=$host;";
                }
                break;
            default:
                Log::fatal(
                  "Unsupported batabase driver '$type'.",
                  EXCEPTION_CODE::PDO_UNSUPPORTED
                );
                throw new UnexpectedValueException(
                  "Unsupported batabase driver '$type'.",
                  EXCEPTION_CODE::PDO_UNSUPPORTED
                );
        }
        $dsn .= "charset=UTF8;";
        Log::debug("Database dsn: $dsn");
        return $dsn;
    }
    
    /**
     * Creates a database connection using the data in the config files.
     * 
     * @return resource Connection to the database.
     */
    public static function start($db_configuration){
        //ini_set('mssql.charset', 'UTF8');
        $dsn = DB::generate_dsn($db_configuration);
        $user = $db_configuration["user"];
        $pass = $db_configuration["pass"];
        
        try{
            $db = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
            Log::info("Successfully connected with database");
            //$db->exec('SET NAMES utf8');
            //$db->exec('SET CHARACTER SET utf8');
            return $db;
        }
        catch(Exception $e){
            Log::fatal("Connection failed" . $e->getMessage());
        }
    }
}
