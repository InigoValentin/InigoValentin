<?php

require_once(PATH::PAGE . "Page.php");
require_once(PATH::ENTITY . "Project.php");

/**
 * Home page model.
 */
class Home_Page extends Page{

    private $max_projects = 3;

    /**
     * List of recent projects.
     */
    private $projects = [];

    /**
     * Constructor.
     *
     * Retrieves the data and initializes the variables.
     */
    public function __construct(){
        parent::__construct();
        $this->set_view("home.php");
        $this->set_title("");
        $this->set_description(get_context()->get_user()->get_text("TAGLINE"));
        $this->set_canonical("");
        $this->add_css("home.css");
        $this->set_code(200);
        $this->set_message("OK");
        $statement = get_context()->get_db()->prepare(
          "SELECT id FROM project WHERE user = :user AND visible = 1 ORDER BY idx LIMIT :limit"
        );
        $statement->bindValue(':limit', $this->max_projects, PDO::PARAM_INT);
        $statement->bindValue(':user', get_context()->get_user()->get_id(), PDO::PARAM_INT);
        $statement->execute();
        while ($r_project = $statement->fetch(PDO::FETCH_ASSOC)){
            Log::debug("Instantiating new project: " . $r_project["id"]);
            array_push($this->projects, new Project($r_project["id"]));
        }
        
    }

    /**
     * Retrieves the projects to show on the page.
     *
     * @return Project[] Project list.
     */
    public function get_projects(){return $this->projects;}

}
