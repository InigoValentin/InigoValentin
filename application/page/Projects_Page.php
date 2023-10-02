<?php

require_once(PATH::PAGE . "Page.php");
require_once(PATH::ENTITY . "Project.php");

/**
 * Projects list page model.
 */
class Projects_Page extends Page{

    /**
     * Array with the {@see Project}.
     */
    private $projects = [];

    /**
     * Constructor.
     *
     * Retrieves the data and initializes the variables.
     */
    public function __construct(){
        $this->view = PATH::VIEW . "projects.php";
        parent:: __construct();
        $this->set_view("projects.php");
        $statement = get_context()->get_db()->prepare(
          "SELECT id FROM project WHERE user = :user AND visible = 1 ORDER BY idx"
        );
        $statement->bindValue(':user', get_context()->get_user()->get_id(), PDO::PARAM_INT);
        $statement->execute();
        while ($r_projects = $statement->fetch(PDO::FETCH_ASSOC))
            array_push($this->projects, new Project($r_projects["id"]));
        $this->set_title(Text::get("PROJECT_TITLE"));
        $this->set_description(Text::get("PROJECT_DESCRIPTION"));
        $this->set_canonical(URL::PROJECTS);
        $this->add_css("projects.css");
    }

    /**
     * Retrieves the projects to show on the page.
     *
     * @return Project[] Project list.
     */
    public function get_projects(){return $this->projects;}
}
?>
