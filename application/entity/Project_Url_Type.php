<?php

require_once(PATH::ENTITY . "Entity.php");


/**
 * Type of URL.
 *
 * Represents an object from the table 'project_url_type'.
 */
class Project_Url_Type extends Entity{

    /**
     * URL type identifier.
     */
    private $id;

    /**
     * URL denomination, in the defined language.
     */
    private $title;

    /**
     * URL short explanation, in the defined language.
     */
    private $summary;

    /**
     * Filename of the logo of the URL. Usually, the logo of the site it
     * points to.
     */
    private $logo;

    /**
     * Constructor.
     *
     * Searches the database and retrieves the information about the
     * url type, populating it and its items.
     *
     * @param MySQL_connection $db Connection to the database.
     * @param string $lang Lowercase, two-letter language code.
     * @param int $id Identifier of the url type.
     */
    public function __construct($id){
        $statement = get_context()->get_db()->prepare("
          SELECT id, title, summary, logo
          FROM project_url_type
          WHERE id = :id
        ");
        $statement->bindValue(':id', $id, PDO::PARAM_STR);
        $statement->execute();
        $r_type = $statement->fetch(PDO::FETCH_ASSOC);
        if ($r_type != false){
            $this->id = $r_type["id"];
            $this->title = Text::get($r_type["title"]);
            $this->summary = Text::get($r_type["summary"]);
            $this->logo = $r_type["logo"];
        }
    }

    /**
     * Retrieves the project url typeidentifier
     *
     * @return int Project url type ID.
     */
    public function get_id(){
        return $this->id;
    }

    /**
     * Retrieves the project url type title.
     *
     * @return string Title.
     */
    public function get_title(){
        return $this->title;
    }

    /**
     * Retrieves the project url type summary.
     *
     * @return string The logo filename.
     */
    public function get_summary(){
        return $this->summary;
    }

    /**
     * Retrieves the project url type logo.
     *
     * @return string The logo filename.
     */
    public function get_logo(){
        return $this->logo;
    }
}
