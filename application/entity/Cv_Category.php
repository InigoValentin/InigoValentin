<?php

    require_once($path["entity"] . "Entity.php");
    require_once($path["helper"] . "text.php");


    /**
     * Category of a CV entry.
     *
     * Represents an object from the table 'cv_category'.
     */
    class Cv_Category extends Entity{

        /**
         * Identifier of the category.
         */
        public $id;

        /**
         * Category denomination, in the defined language.
         */
        public $title;

        /**
         * Category description, in the defined language.
         */
        public $summary;

        /**
         * Indicates wether the category must or mustn's be displayed.
         */
        public $visible;

        /**
         * Display order.
         */
        public $priority;

        /**
         * Constructor.
         *
         * Searches the database and retrieves the information about the
         * category, populating it.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         * @param int $id Identifier of the cv category.
         */
        public function __construct($db, $lang, $id){
            parent::__construct($db, $lang);
            $s =
              "SELECT " .
              "  id, " .
              "  title, " .
              "  summary, " .
              "  visible, " .
              "  priority " .
              "FROM cv_category " .
              "WHERE id = $id ;";
            $q = mysqli_query($this->db, $s);
            if (mysqli_num_rows($q) > 0){
                $r = mysqli_fetch_array($q);
                $this->id = $r["id"];
                $this->title = text($this, $r["title"]);
                $this->summary = text($this, $r["summary"]);
                $this->visible = $r["visible"];
                $this->priority = $r["priority"];
            }
        }
    }
?>
