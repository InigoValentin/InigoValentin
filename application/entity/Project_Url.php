<?php

require_once(PATH::ENTITY . "Entity.php");


/**
 * URL related to a project.
 *
 * Represents an object from the table 'project_url'.
 */
class Project_Url extends Entity{

    /**
     * @var int Identifier of the URL.
     */
    private $id;

    /**
     * @var int Identifier of the project the URL is related to.
     */
    private $project;

    /**
     * @var Project_Url_Type URL type.
     */
    private $type;

    /**
     * @var string Full URL address.
     */
    private $url;

    /**
     * Constructor.
     *
     * Searches the database and retrieves the information about the
     * url, populating it and its items.
     *
     * @param int $id Identifier of the URL.
     */
    public function __construct($id){
        $statement = get_context()->get_db()->prepare("
          SELECT
            id
            project
            type
            url
          FROM project_url
          WHERE id = :id
        ");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $r_url = $statement->fetch(PDO::FETCH_ASSOC);
        if ($r_url !== false){
            $this->id = $r_url["id"];
            $this->project = $r_url["project"];
            $this->type = new Project_Url_Type($r_url["type"]);
            $this->url = $r_url["url"];
            $this->mark_as_loaded(true);
            $this->mark_as_complete(true);
        }
        else{
            Log::warn("Project URL with id '$id' doesn't exist");
        }
    }
    
    /**
     * Retrieves the URL identifier
     *
     * @return int URL ID.
     */
    public function get_id(){
        return $this->id;
    }
    
    /**
     * Retrieves the project identifier
     *
     * @return int Project ID.
     */
    public function get_project(){
        return $this->project;
    }
    
    /**
     * Retrieves the url type.
     *
     * @return Project_Url_Type URL type.
     */
    public function get_type(){
        return $this->type;
    }
    
    /**
     * Retrieves the URL
     *
     * @return string The URL.
     */
    public function get_url(){
        return $this->url;
    }
}
