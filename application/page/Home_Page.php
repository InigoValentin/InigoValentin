<?php

    require_once($path["page"] . "Page.php");
    require_once($path["entity"] . "Project.php");
    require_once($path["helper"] . "text.php");


    /**
     * Home page model.
     */
    class Home_Page extends Page{

        private $max_projects = 3;

        /**
         * List of recent projects.
         */
        public $project = [];

        /**
         * Constructor.
         *
         * Retrieves the data and initializes the variables.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         */
        public function __construct($db, $lang){
            global $path;
            global $base_url;
            parent::__construct($db, $lang);
            $this->view = $path["view"] . "home.php";
            $s_project =
              "SELECT id " .
              "FROM project " .
              "WHERE visible = 1 " .
              "ORDER BY idx DESC " .
              "LIMIT " . $this->max_projects . ";";
            $q_project = mysqli_query($this->db, $s_project);
            while($r_project = mysqli_fetch_array($q_project)){
                array_push($this->project, new Project($this->db, $this->lang, $r_project["id"]));
            }
            $this->title = text($this, "USER_NAME");
            $this->description = text($this, "USER_NAME") . " - " . text($this, "USER_TAGLINE");
            $this->canonical = $base_url . "/";
        }
    }
?>
