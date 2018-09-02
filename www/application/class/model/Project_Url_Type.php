<?php

    require_once($path["model"] . "Entity.php");
    require_once($path["helper"] . "text.php");


    /**
     * Type of URL.
     *
     * Represents an object from the table 'project_url_type'.
     */
    class Project_Url_Type extends Entity{

        /**
         * URL type identifier.
         */
        public $id;

        /**
         * URL denomination, in the defined language.
         */
        public $title;

        /**
         * URL short explanation, in the defined language.
         */
        public $summary;

        /**
         * Filename of the logo of the URL. Usually, the logo of the site it
         * points to.
         */
        public $logo;

        /**
         * Constructor.
         *
         * Searches the database and retrieves the information about the
         * url type, populating it and its items.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         * @param int $id Identifier of the url type.
         */
        public function __construct($db, $lang, $id){
            parent::__construct($db, $lang);
            $s =
              "SELECT " .
              "  id, " .
              "  title, " .
              "  summary, " .
              "  logo " .
              "FROM project_url_type " .
              "WHERE id = '$id' ;";
            $q = mysqli_query($this->db, $s);
            if (mysqli_num_rows($q) > 0){
                $r = mysqli_fetch_array($q);
                $this->id = $r["id"];
                $this->title = text($this, $r["title"]);
                $this->summary = text($this, $r["summary"]);
                $this->logo = $r["logo"];
            }
        }
    }
?>
