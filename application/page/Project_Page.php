<?php

    require_once($path["page"] . "Page.php");
    require_once($path["entity"] . "Project.php");
    require_once($path["helper"] . "text.php");


    /**
     * Project page model.
     */
    class Project_Page extends Page{

        /**
         * The selected {@see Project}.
         */
        public $project;

        /**
         * Constructor.
         *
         * Retrieves the data and initializes the variables.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         * @param string $id Project id or permalink.
         */
        public function __construct($db, $lang, $id){
            global $path;
            global $base_url;
            global $static;
            parent:: __construct($db, $lang);
            $this->view = $path["view"] . "project.php";
            $this->project = new Project($this->db, $this->lang, $id);
            $this->title = $this->project->title . " - " . text($this, "USER_NAME");
            $this->description = $this->project->header;
            if (strlen($this->project->logo) > 0){
                $this->icon = $static["content"] . "project/" . $this->project->logo;
            }
            else{
                $this->icon = $static["layout"] . "logo/logo.svg";
            }
            $this->canonical = $base_url . "/project/" . $this->project->permalink . "/";
        }
    }
?>
