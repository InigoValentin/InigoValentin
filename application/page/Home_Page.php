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
        $this->view = PATH::VIEW . "home.php";
        parent::__construct();
        $this->set_view("home.php");
        $this->set_title(Text::get("USER_NAME"));
        $this->set_description(Text::get("USER_NAME"));
        $this->set_canonical("");
        $this->add_css("home.css");
        $this->set_code(200);
        $this->set_message("OK");

        $statement = get_context()->get_db()->prepare("
          SELECT id
          FROM project
          WHERE visible = 1
          ORDER BY idx DESC
          LIMIT :limit
        ");
        $statement->bindValue(':limit', $this->max_projects, PDO::PARAM_INT);
        
        
        $statement->execute();
        while ($r_project = $statement->fetch(PDO::FETCH_ASSOC)) {
            Log::debug("Instantiating new project: " . $r_project["id"]);
            array_push($this->project, new Project($r_project["id"]));
        }
        
    }
    /**
     * Retrieves the projects to show on the page.
     *
     * @return Project[] Project list.
     */
    public function get_projects(){
        return $this->projects;
    }

}
