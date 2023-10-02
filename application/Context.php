<?php
/**
 * Context file.
 *
 * Provides a handy class with usefull data to be accessible from anywhere in the app.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IV
 */

require_once(PATH::ENTITY . "User.php");

/**
 * Application context.
 *
 * Stores usefull data to be retrieved anywhere in the app.
 *
 * @category Context
 */
class Context {

    /**
     * @var SQLITE3 Database connection.
     */
    private $db;

    /**
     * Current site user profile.
     */
    private $user;
    
    /**
     * Two letter language code.
     */
    private $lang;
    
    /**
     * List of two letter language codes available in the application.
     * */
    private $available_languages = [];
    
    public function __construct(){
        // TODO: Validate language codes.
        $langs = parse_ini_file(__DIR__ . "/config/config.ini", true)["language"]["available"];
        $this->available_languages = explode("|", $langs);
        $this->lang = parse_ini_file(__DIR__ . "/config/config.ini", true)["language"]["default"];
    }

    /**
     * Retrieves the database connection.
     *
     * @return SQLITE3 The database connection.
     */
    public function get_db(){
        return $this->db;
    }

    /**
     * Sets the database connection
     *
     * @param SQLITE3 Database connection.
     */
    protected function set_db($db){
        $this->db = $db;
        Log::debug("Context database is set and accesible.");
        if ($this->db == null){
            Log::error("DB is null");
        }
    }

    public function get_user(){
        if ($this->user == null) $this->user = new User();
        return $this->user;
    }
    
    /**
     * Retrieves the language.
     * 
     * @return string Two letter language code.
     */
    public function get_lang(){
        return $this->lang;
    }
    
    /**
     * Sets the anguage.
     * @param string $code Two letter language code.
     */
    public function set_lang($code){
        if (in_array(strtolower($code), $this->available_languages)){
            $this->lang = strtolower($code);
            setcookie("lang", $this->lang, time()+ 60 * 60 * 24 * 30, "/", $_SERVER["HTTP_HOST"]);
        }
        else Log::warn("Tried to set unsupported language '$code'");
    }
    
    /**
     * Retrieves the list of available languages.
     *
     * @return string Two letter language code of avilable languages.
     */
    public function get_available_langs(){
        return $this->available_languages;
    }

}
