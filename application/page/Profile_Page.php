<?php

    require_once($path["page"] . "Page.php");
    require_once($path["entity"] . "Cv.php");
    require_once($path["helper"] . "text.php");


    /**
     * Profile page model.
     */
    class Profile_Page extends Page{

        /**
         * List of available {@see CV}.
         */
        public $cv = [];

        /**
         * Constructor.
         *
         * Retrieves the data and initializes the variables.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         */
        public function __construct($db, $lang){
            global $path;
            global $base_url;
            parent::__construct($db, $lang);
            $this->view = $path["view"] . "profile.php";
            $s =
              "SELECT id " .
              "FROM cv " .
              "WHERE visible = 1 " .
              "ORDER BY lang = '" . $this->lang . "' DESC;";
            $q = mysqli_query($this->db, $s);
            while($r = mysqli_fetch_array($q)){
                array_push($this->cv, new Cv($this->db, $r["id"]));
            }
            $this->title = text($this, "USER_NAME");
            $this->description = text($this, "SECTION_ME") . " - " . text($this, "USER_NAME");
            $this->canonical = $base_url . "/profile/";
        }
    }
?>
