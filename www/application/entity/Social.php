<?php

    require_once($path["entity"] . "Entity.php");
    require_once($path["helper"] . "text.php");


    /**
     * Social, contains a button to a social network.
     *
     * Represents an object from the table 'social'.
     */
    class Social extends Entity{

        /**
         * Identifier.
         */
        public $id;

        /**
         * Indicates the order position among other social buttons.
         */
        public $idx;

        /**
         * Indicates wether the object must or mustn's be displayed.
         */
        public $visible;

        /**
         * Name of the social network.
         */
        public $title;

        /**
         * Icon of the social network.
         */
        public $icon;

        /**
         * URL to the profile in the social network.
         */
        public $url;

        /**
         * Constructor.
         *
         * Searches the database and retrieves the information about the
         * object, populating it.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         * @param int $id Database identifier of the social network.
         */
        public function __construct($db, $lang, $id){
            parent::__construct($db, $lang);
            $s =
              "SELECT " .
              "  id, " .
              "  idx, " .
              "  visible, " .
              "  title, " .
              "  icon, " .
              "  url " .
              "FROM social " .
              "WHERE " .
              "  id = $id; ";
            $q = mysqli_query($this->db, $s);
            if (mysqli_num_rows($q) > 0){
                $r = mysqli_fetch_array($q);
                $this->id = $r["id"];
                $this->idx = $r["idx"];
                $this->visible = $r["visible"];
                $this->title = text($this, $r["title"]);
                $this->icon = $r["icon"];
                $this->url = $r["url"];
            }
        }
    }
?>
