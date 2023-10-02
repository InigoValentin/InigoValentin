<?php

require_once(PATH::ENTITY . "Entity.php");


/**
 * Image of a project.
 *
 * Represents an object from the table 'project_image'.
 */
class Project_Image extends Entity{

    /**
     * @var int Image identifier.
     */
    private $id;

    /**
     * @var int Project identifier.
     */
    private $project;

    /**
     * @var int Indicates the order position among other images.
     */
    private $idx;

    /**
     * @var string Filename of the image.
     */
    private $image;

    /**
     * @var string Alternative text for the image.
     */
    private $alt;

    /**
     * Constructor.
     *
     * Searches the database and retrieves the information about the
     * image, populating it.
     *
     * @param int $id Identifier of the image.
     */
    public function __construct($id){
        $statement = get_context()->get_db()->prepare("
          SELECT id, project, idx, image, alt FROM project_image WHERE id = :id
        ");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $r_image = $statement->fetch(PDO::FETCH_ASSOC);
        if ($r_image !== false){
            $this->id = $r_image["id"];
            $this->project = $r_image["project"];
            $this->idx = $r_image["idx"];
            $this->image = $r_image["image"];
            $this->alt = Text::get($r_image["alt"]);
        }
        else{
            Log::warn("Project image with id '$id' doesn't exist");
        }
    }
    
    /**
     * Retrieves the image identifier
     *
     * @return int Image ID.
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
     * Retrieves the image index for sorting.
     *
     * @return int Image index.
     */
    public function get_idx(){
        return $this->idx;
    }
    
    /**
     * Retrieves the image filename.
     *
     * @return string Image filename.
     */
    public function get_image(){
        return $this->image;
    }

    /**
     * Retrieves the image alternative text or title.
     *
     * @return string Image text.
     */
    public function get_text(){
        return $this->alt;
    }
}
