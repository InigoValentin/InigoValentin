<?php

    require_once($path["entity"] . "Lang.php");
    require_once($path["entity"] . "Social.php");

    /**
     * Page footer.
     *
     * Used to display the footer in every page.
     */
    class Footer{

        /**
         * Array of {@see Social} to display social network links.
         */
        public $social = [];

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
            $s_social =
              "SELECT id " .
              "FROM social " .
              "WHERE visible = 1; ";
            $q_social = mysqli_query($db, $s_social);
            while($r_social = mysqli_fetch_array($q_social)){
                array_push($this->social, new Social($db, $lang, $r_social["id"]));
            }
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
