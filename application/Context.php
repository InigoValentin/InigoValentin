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
            Log::debug("It is null");
        }
    }
    
    /**
     * Retrieves the language.
     * 
     * @todo Implement
     * @return string Two letter language code.
     */
    public function get_lang(){
        return "es";
    }
    
    /**
     * Retrieves the list of available languages.
     *
     * @todo Implement
     * @return string Two letter language code.
     */
    public function get_available_langs(){
        return [];
    }

}
