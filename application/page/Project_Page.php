<?php

require_once(PATH::PAGE . "Page.php");
require_once(PATH::ENTITY . "Project.php");


/**
    * Project page model.
    */
class Project_Page extends Page{

    /**
    * The selected {@see Project}.
    */
    private $project;

    /**
    * Constructor.
    *
    * Retrieves the data and initializes the variables.
    *
    * @param string $id Project id or permalink.
    */
    public function __construct($id){
        parent:: __construct();
        $this->view = PATH::VIEW . "project.php";
        $this->set_view("project.php");
        $this->project = new Project($id);
        $this->set_title($this->project->get_title() . " - " . Text::get("USER_NAME"));
        $this->set_description($this->project->get_header());
        $this->add_css("project.css");
        if (strlen($this->project->get_logo()) > 0){
            $this->icon = URL::IMG["CONTENT"] . "project/x100/" . $this->project->get_logo();
        }
        $this->set_canonical(URL::PROJECTS . $this->project->get_permalink() . "/");
    }

    /**
     * Retrieves the loade project.
     *
     * @return Project Loaded project.
     */
    public function get_project(){
        return $this->project;
    }
}
?>
