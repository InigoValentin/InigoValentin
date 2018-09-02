<?php

    require_once($path["model"] . "Page.php");
    require_once($path["helper"] . "text.php");


    /**
     * Profile page model.
     */
    class Profile_Page extends Page{

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
            global $root;
            parent::__construct($db, $lang);
            $this->view = $path["view"] . "profile.php";

            // TODO: Get data

            $this->title = text($this, "USER_NAME");
            $this->name = text($this, "USER_NAME");
            $this->description = text($this, "USER_NAME") . " - " . text($this, "USER_TAGLINE");
            $this->favicon = $path["img"]["layout"] . "logo/logo.svg";
            $this->icon = $path["img"]["layout"] . "logo/logo.svg";
            $this->canonical = $root . $lang . "/";
            $this->author = $root . $lang . "/";
        }
    }
?>
