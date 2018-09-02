<?php

    require_once($path["model"] . "Entity.php");


    /**
     * Image of a project.
     *
     * Represents an object from the table 'project_image'.
     */
    class Project_Image extends Entity{

        /**
         * Image identifier.
         */
        public $id;

        /**
         * Project identifier.
         */
        public $project;

        /**
         * Indicates the order position among other images.
         */
        public $idx;

        /**
         * Filename of the image.
         */
        public $image;

        /**
         * Constructor.
         *
         * Searches the database and retrieves the information about the
         * image, populating it.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param int $id Identifier of the image.
         */
        public function __construct($db, $id){
            parent::__construct($db, null);
            $s =
              "SELECT " .
              "  id, " .
              "  project, " .
              "  idx, " .
              "  image " .
              "FROM project_image " .
              "WHERE id = $id ;";
            $q = mysqli_query($this->db, $s);
            if (mysqli_num_rows($q) > 0){
                $r = mysqli_fetch_array($q);
                $this->id = $r["id"];
                $this->project = $r["project"];
                $this->idx = $r["idx"];
                $this->image = $r["image"];
            }
        }
    }
?>
