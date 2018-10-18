<?php

    require_once($path["entity"] . "Entity.php");
    require_once($path["helper"] . "text.php");


    /**
     * Type of version.
     *
     * Represents an object from the table 'project_version_type'.
     */
    class Project_Version_Type extends Entity{

        /**
         * Version type identifier.
         */
        public $id;

        /**
         * Version type denomination, in the defined language.
         */
        public $title;

        /**
         * Short version type description, in the defined language.
         */
        public $summary;

        /**
         * Color code, in HEX format, identifying the version type.
         */
        public $color;

        /**
         * Constructor.
         *
         * Searches the database and retrieves the information about the
         * version type, populating it and its items.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         * @param int $id Identifier of the version type.
         */
        public function __construct($db, $lang, $id){
            parent::__construct($db, $lang);
            $s =
              "SELECT " .
              "  id, " .
              "  title, " .
              "  summary, " .
              "  color " .
              "FROM project_version_type " .
              "WHERE id = '$id' ;";
            $q = mysqli_query($this->db, $s);
            if (mysqli_num_rows($q) > 0){
                $r = mysqli_fetch_array($q);
                $this->id = $r["id"];
                $this->title = text($this, $r["title"]);
                $this->summary = text($this, $r["summary"]);
                $this->id = $r["color"];
            }
        }
    }
?>
