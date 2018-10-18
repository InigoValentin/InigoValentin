<?php

    require_once($path["entity"] . "Entity.php");
    require_once($path["helper"] . "text.php");


    /**
     * Tag of a project.
     *
     * Represents an object from the table 'project_tag'.
     */
    class Project_Tag extends Entity{

        /**
         * Identifier of the project the tag belongs to.
         */
        public $project;

        /**
         * Tag text.
         */
        public $tag;

        /**
         * Constructor.
         *
         * Searches the database and retrieves the information about the
         * tag, populating it.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         * @param int $project Identifier of the project the tag belongs to.
         * @param string $tag Tag identifier. Same as it's text.
         */
        public function __construct($db, $lang, $project, $tag){
            parent::__construct($db, $lang);
            $this->project = $project;
            $this->tag = text($this, $tag);
        }
    }
?>
