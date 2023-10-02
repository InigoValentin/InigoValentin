<?php

    require_once(PATH::PAGE . "Page.php");

    /**
     * Error page model.
     */
    class Error_Page extends Page{

        public $code = "";
        public $error_description = "";
        public $advice = "";
        public $solution = [];

        /**
         * Constructor.
         *
         * Retrieves the data and initializes the page.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         */
        public function __construct($db, $lang){
            global $path;
            global $base_url;
            parent::__construct($db, $lang);
            $this->view = PATH::VIEW . "error.php";
            $this->set_view("error.php");
            $this->code = http_response_code();
            if (in_array($this->code, array(400, 401, 403, 404, 500))){
                $err = $this->code;
            }
            else{
                $err = "XXX";
            }
            $this->error_description = Text::get("ERROR_" . $err . "_DESCRIPTION");
            $this->advice = Text::get("ERROR_" . $err . "_SOLUTION");
            array_push($this->solution, Text::get("ERROR_" . $err . "_SOLUTION_0"));
            array_push($this->solution, Text::get("ERROR_" . $err . "_SOLUTION_1"));
            array_push($this->solution, Text::get("ERROR_" . $err . "_SOLUTION_2"));
            $this->title = Text::get("ERROR_TITLE") . " " . $this->code . " - " . Text::get("USER_NAME");
            $this->description = Text::get("ERROR_TITLE") . " " . $this->code . " - " . Text::get("USER_NAME");
        }
    }
?>
