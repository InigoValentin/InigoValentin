<?php
/**
 * CV (resume) entity file.
 *
 * Provides the entity Cv.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IVV
 */

require_once(PATH::ENTITY . "Entity.php");
require_once(PATH::ENTITY . "Lang.php");

/**
 * CV (resume).
 *
 * Represents an object from the table 'cv'.
 */
class Cv extends Entity{

    /**
     * CV file identifier.
     */
    private $id;

    /**
     * CV {@see Lang}.
     */
    private $lang;

    /**
     * Filename.
     */
    private $file;

    /**
     * Constructor.
     *
     * Searches the database and retrieves the information about the
     * object, populating it.
     *
     * @param string $id CV id.
     */
    public function __construct($id){
        $statement = get_context()->get_db()->prepare("SELECT lang, file FROM cv WHERE id = :id");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $r_cv = $statement->fetch(PDO::FETCH_ASSOC);
        if ($r_cv !== false){
            $this->id = $id;
            $this->lang = new Lang($r_cv["lang"]);
            $this->file = $r_cv["file"];
        }
    }

    /**
     * Retrieves the CV identifier.
     *
     * @return int CV ID.
     */
    public function get_id(){
        return $this->id;
    }

    /**
     * Retrieves the CV language.
     *
     * @return int CV language.
     */
    public function get_lang(){
        return $this->lang;
    }

    /**
     * Retrieves the path to the CV file.
     *
     * @return int CV file path.
     */
    public function get_file(){
        return $this->file;
    }
}
?>
