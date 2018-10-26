<?php

    require_once($path["page"] . "Page.php");
    require_once($path["helper"] . "text.php");


    /**
     * Help page model.
     */
    class Help_Page extends Page{

        public $help = [
            "info" => [
                "title" => "",
                "text" => "",
            ],
            "license" => [
                "title" => "",
                "text" => "",
            ],
            "privacy" => [
                "title" => "",
                "text" => "",
            ],
            "cookies" => [
                "title" => "",
                "text" => "",
            ]
        ];

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
            $this->view = $path["view"] . "help.php";

            $this->help["info"]["title"] = text($this, "HELP_INFO_TITLE");
            $this->help["info"]["text"] = text($this, "HELP_INFO_TEXT");
            $this->help["license"]["title"] = text($this, "HELP_LICENSE_TITLE");
            $this->help["license"]["text"] = text($this, "HELP_LICENSE_TEXT");
            $this->help["privacy"]["title"] = text($this, "HELP_PRIVACY_TITLE");
            $this->help["privacy"]["text"] = text($this, "HELP_PRIVACY_TEXT");
            $this->help["cookies"]["title"] = text($this, "HELP_COOKIES_TITLE");
            $this->help["cookies"]["text"] = text($this, "HELP_COOKIES_TEXT");
            $this->title = text($this, "USER_NAME");
            $this->description = text($this, "USER_NAME") . " - " . text($this, "USER_TAGLINE");
            $this->canonical = $base_url . "/help/";
        }
    }
?>
