<?php

require_once(PATH::ENTITY . "Entity.php");


/**
 * License.
 *
 * Represents an object from the table 'license'.
 */
class License extends Entity{

    /**
     * @var string License identifier. Usually an abbreviation.
     */
    private $id;

    /**
     * @var string Short, easily readable text summarizing the full text of
     * the license.
     */
    private $summary;

    /**
     * @var string Full text of the license.
     */
    private $legal;

    /**
     * @var string License logo.
     */
    private $logo;

    /**
     * @var string License icon, small.
     */
    private $icon;

    /**
     * Constructor.
     *
     * Searches the database and retrieves the information about the
     * object, populating it.
     *
     * @param string $id Identifier of the license.
     */
    public function __construct($id){
        $statement = get_context()->get_db()->prepare("
          SELECT
            id
            summary
            legal
            logo
            icon
          FROM license
          WHERE id = :id
        ");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $r_license = $statement->fetch(PDO::FETCH_ASSOC);
        if ($r_license !== false){
            $this->id = $r_license["id"];
            $this->summary = TEXT::get($r_license["summary"]);
            $this->legal = TEXT::get($r_license["legal"]);
            $this->logo = $r_license["logo"];
            $this->icon = $r_license["icon"];
            $this->mark_as_loaded(true);
            $this->mark_as_complete(true);
        }
        else{
            Log::warn("License with id '$id' doesn't exist");
        }
    }
    
    /**
     * Retrieves the license identifier
     *
     * @return string License ID.
     */
    public function get_id(){
        return $this->id;
    }
    
    /**
     * Retrieves a short, easily readable text summarizing the full text of
     * the license.
     *
     * @return string License summary.
     */
    public function get_summary(){
        return $this->summary;
    }
    
    /**
     * Retrieves the full text of the license
     *
     * @return string License legal text.
     */
    public function get_legal(){
        return $this->legal;
    }
    
    /**
     * Retrieves the license logo.
     *
     * @return string The logo filename.
     */
    public function get_logo(){
        return $this->logo;
    }
    
    /**
     * Retrieves the license icon.
     *
     * @return string The icon filename.
     */
    public function get_icon(){
        return $this->icon;
    }
}
