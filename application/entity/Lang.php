<?php

    require_once($path["entity"] . "Entity.php");


    /**
     * Language.
     *
     * Represents an object from the table 'lang'.
     */
    class Lang extends Entity{

        /**
         * Lowercase, two-letter language code.
         */
        public $code;

        /**
         * Language name, in it's own language.
         */
        public $name;

        /**
         * Indictes wether the language is offered in this language.
         */
        public $active;

        /**
         * Constructor.
         *
         * Searches the database and retrieves the information about the
         * object, populating it.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param int $id Database identifier of the language.
         */
        public function __construct($db, $id){
            parent::__construct($db, null);
            $s =
              "SELECT " .
              "  code, " .
              "  name, " .
              "  active " .
              "FROM lang " .
              "WHERE " .
              "  code = '$id'; ";
            $q = mysqli_query($this->db, $s);
            if (mysqli_num_rows($q) > 0){
                $r = mysqli_fetch_array($q);
                $this->code = $r["code"];
                $this->name = $r["name"];
                $this->active = $r["active"];
            }
        }
    }
?>
