<?php

require_once(PATH::ENTITY . "Entity.php");


/**
 * Language.
 *
 * Represents an object from the table 'lang'.
 */
class Lang extends Entity{

    /**
     * Lowercase, two-letter language code.
     */
    private $code;

    /**
     * Language name, in it's own language.
     */
    private $name;

    /**
     * Indictes wether the language is offered in this language.
     */
    private $active;

    /**
     * Constructor.
     *
     * Searches the database and retrieves the information about the
     * object, populating it.
     *
     * @param int $id Database identifier of the language.
     */
    public function __construct($id){
        $statement = get_context()->get_db()->prepare(
          "SELECT code, name, active FROM lang WHERE code = :id"
        );
        $statement->bindValue(':id', $id, PDO::PARAM_STR);
        $statement->execute();
        $r_lang = $statement->fetch(PDO::FETCH_ASSOC);
        if ($r_lang !== false){
            $this->code = $r_lang["code"];
            $this->name = $r_lang["name"];
            $this->active = $r_lang["active"];
        }
    }

    /**
     * Retrieves the language identifier code.
     *
     * @return int Language code.
     */
    public function get_code(){
        return $this->code;
    }

    /**
     * Retrieves the language name.
     *
     * @return int Language name.
     */
    public function get_name(){
        return $this->name;
    }

    /**
     * Checks if the language is active.
     *
     * @return bool True if the language is active, false otherwise.
     */
    public function is_active(){
        return $this->active;
    }
}
?>
