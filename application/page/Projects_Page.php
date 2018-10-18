<?php

    require_once($path["page"] . "Page.php");
    require_once($path["entity"] . "Project.php");
    require_once($path["helper"] . "text.php");


    /**
     * Projects list page model.
     */
    class Projects_Page extends Page{

        /**
         * Array with the {@see Project}.
         */
        public $project = [];

        /**
         * Constructor.
         *
         * Retrieves the data and initializes the variables.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         * @param string $id Project id or permalink.
         */
        public function __construct($db, $lang){
            global $path;
            global $root;
            parent:: __construct($db, $lang);
            $this->view = $path["view"] . "projects.php";
            $s =
              "SELECT id " .
              "FROM project " .
              "WHERE visible = 1;";
            $q = mysqli_query($this->db, $s);
            while($r = mysqli_fetch_array($q)){
                array_push($this->project, new Project($this->db, $this->lang, $r["id"]));
            }
            $this->title = text($this, "PROJECT_TITLE") . " - " . text($this, "USER_NAME");
            $this->name = text($this, "USER_NAME");
            $this->description = text($this, "PROJECT_DESCRIPTION");
            $this->favicon = $path["img"]["layout"] . "logo/logo.svg";
            $this->icon = $path["img"]["layout"] . "logo/logo.svg";
            $this->canonical = $root . $lang . "/project/";
            $this->author = $root . $lang . "/";
        }
    }
?>
