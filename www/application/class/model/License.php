<?php

    require_once($path["model"] . "Entity.php");
    require_once($path["helper"] . "text.php");


    /**
     * License.
     *
     * Represents an object from the table 'license'.
     */
    class License extends Entity{

        /**
         * License identifier. Usually an abbreviation.
         */
        public $id;

        /**
         * Short, easily readable text summarizing the full text of the
         * license.
         */
        public $summary;

        /**
         * Full text of the license.
         */
        public $legal;

        /**
         * License logo.
         */
        public $logo;

        /**
         * License icon, small.
         */
        public $icon;

        /**
         * Constructor.
         *
         * Searches the database and retrieves the information about the
         * object, populating it.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         * @param string $id Database identifier of the license.
         */
        public function __construct($db, $lang, $id){
            parent::__construct($db, $lang);
            $s =
              "SELECT " .
              "  id, " .
              "  summary, " .
              "  legal, " .
              "  logo, " .
              "  icon " .
              "FROM license " .
              "WHERE id = '$id'; ";
            $q = mysqli_query($this->db, $s);
            if (mysqli_num_rows($q) > 0){
                $r = mysqli_fetch_array($q);
                $this->id = $r["id"];
                $this->summary = text($this, $r["summary"]);
                $this->legal = text($this, $r["legal"]);
                $this->logo = $r["logo"];
                $this->icon = $r["icon"];
            }
        }
    }
?>
