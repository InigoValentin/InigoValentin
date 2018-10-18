<?php

    require_once($path["entity"] . "Lang.php");

    /**
     * Page footer.
     *
     * Used to display the footer in every page.
     */
    class Footer{

        /**
         * Array of {@see Lang} the page can be served on.
         */
        public $lang = [];

        /**
         * Constructor.
         *
         * Searches the database and populates the social and lang arrays.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         */
        public function __construct($db, $lang){
            $s_lang =
              "SELECT code AS id " .
              "FROM lang " .
              "WHERE active = 1; ";
            $q_lang = mysqli_query($db, $s_lang);
            while($r_lang = mysqli_fetch_array($q_lang)){
                array_push($this->lang, new Lang($db, $r_lang["id"]));
            }
        }
    }
?>
