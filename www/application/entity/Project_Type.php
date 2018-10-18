<?php

    require_once($path["entity"] . "Entity.php");
    require_once($path["helper"] . "text.php");


    /**
     * Type of a project.
     *
     * Represents an object from the table 'project_type'.
     */
    class Project_Type extends Entity{

        /**
         * Identifier of the project type.
         */
        public $id;

        /**
         * Type denomination, in the defined language.
         */
        public $title;

        /**
         * Type description, in the defined language.
         */
        public $summary;

        /**
         * Constructor.
         *
         * Searches the database and retrieves the information about the
         * type, populating it.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         * @param string $id Identifier of the project type.
         */
        public function __construct($db, $lang, $id){
            parent::__construct($db, $lang);
            $s =
              "SELECT " .
              "  id, " .
              "  title, " .
              "  summary " .
              "FROM project_type " .
              "WHERE id = '$id' ;";
            $q = mysqli_query($this->db, $s);
            if (mysqli_num_rows($q) > 0){
                $r = mysqli_fetch_array($q);
                $this->id = $r["id"];
                $this->title = text($this, $r["title"]);
                $this->summary = text($this, $r["summary"]);
            }
        }
    }
?>
