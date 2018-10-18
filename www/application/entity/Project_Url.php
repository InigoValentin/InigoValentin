<?php

    require_once($path["entity"] . "Entity.php");
    require_once($path["entity"] . "Project_Url_Type.php");


    /**
     * URL related to a project.
     *
     * Represents an object from the table 'project_url'.
     */
    class Project_Url extends Entity{

        /**
         * Identifier of the url.
         */
        public $id;

        /**
         * Identifier of the project the URL is related to.
         */
        public $project;

        /**
         * URL {@see Project_Url_Type}.
         */
        public $type;

        /**
         * Full URL address.
         */
        public $url;

        /**
         * Constructor.
         *
         * Searches the database and retrieves the information about the
         * url, populating it and its items.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         * @param int $id Identifier of the url.
         */
        public function __construct($db, $lang, $id){
            parent::__construct($db, $lang);
            $s =
              "SELECT " .
              "  id, " .
              "  project, " .
              "  type, " .
              "  url " .
              "FROM project_url " .
              "WHERE id = $id ;";
            $q = mysqli_query($this->db, $s);
            if (mysqli_num_rows($q) > 0){
                $r = mysqli_fetch_array($q);
                $this->id = $r["id"];
                $this->project = $r["project"];
                $this->url = $r["url"];
                $this->type = new Project_Url_Type($this->db, $this->lang, $r["type"]);
            }
        }
    }
?>
