<?php

    require_once($path["entity"] . "Entity.php");
    require_once($path["entity"] . "Lang.php");


    /**
     * CV file.
     *
     * Represents an object from the table 'cv'.
     */
    class Cv extends Entity{

        /**
         * CV file identifier.
         */
        public $id;

        /**
         * CV {@see Lang}.
         */
        public $lang;

        /**
         * Filename.
         */
        public $file;


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
              "  lang, " .
              "  file " .
              "FROM cv " .
              "WHERE " .
              "  id = '$id'; ";
            error_log($s);
            $q = mysqli_query($this->db, $s);
            if (mysqli_num_rows($q) > 0){
                $r = mysqli_fetch_array($q);
                $this->id = $id;
                $this->lang = new Lang($this->db, $r["lang"]);
                $this->file = $r["file"];
            }
        }
    }
?>
