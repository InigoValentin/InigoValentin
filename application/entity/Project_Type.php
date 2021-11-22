<?php

require_once(PATH::ENTITY . "Entity.php");


/**
 * Type of a project.
 *
 * Represents an object from the table 'project_type'.
 */
class Project_Type extends Entity{

    /**
     * @var int Identifier of the project type.
     */
    private $id;

    /**
     * @var String Type denomination, in the defined language.
     */
    private $title;

    /**
     * @var String Type description, in the defined language.
     */
    private $summary;

    /**
     * Constructor.
     *
     * Searches the database and retrieves the information about the
     * type, populating it.
     *
     * @param string $id Identifier of the project type.
     */
    public function __construct($id){
        $statement = get_context()->get_db()->prepare("
          SELECT
            id,
            title,
            summary
          FROM project_type
          WHERE id = :id;
        ");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $r_type = $statement->fetch(PDO::FETCH_ASSOC);
        if ($r_type !== false){
            $this->id = $r_type["id"];
            $this->title = TEXT::get($r_type["title"]);
            $this->summary = TEXT::get($$r_type["summary"]);
            $this->mark_as_loaded(true);
            $this->mark_as_complete(true);
        }
        else{
            Log::warn("Project type with id '$id' doesn't exist");
        }
    }
    
    /**
     * Retrieves the project type identifier
     *
     * @return int Project type ID.
     */
    public function get_id(){
        return $this->id;
    }
    
    /**
     * Retrieves the project type title.
     *
     * @return string Type name.
     */
    public function get_title(){
        return $this->title;
    }
    
    /**
     * Retrieves the project type description.
     *
     * @return string Type summary.
     */
    public function get_summary(){
        return $this->summary;
    }
}
