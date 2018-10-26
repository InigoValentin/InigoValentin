<?php

    require_once($path["page"] . "Page.php");
    require_once($path["helper"] . "text.php");


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
            $this->view = $path["view"] . "error.php";
            $this->code = http_response_code();
            if (in_array($this->code, array(400, 401, 403, 404, 500))){
                $err = $this->code;
            }
            else{
                $err = "XXX";
            }
            $this->error_description = text($this, "ERROR_" . $err . "_DESCRIPTION");
            $this->advice = text($this, "ERROR_" . $err . "_SOLUTION");
            array_push($this->solution, text($this, "ERROR_" . $err . "_SOLUTION_0"));
            array_push($this->solution, text($this, "ERROR_" . $err . "_SOLUTION_1"));
            array_push($this->solution, text($this, "ERROR_" . $err . "_SOLUTION_2"));
            $this->title = text($this, "ERROR_TITLE") . " " . $this->code . " - " . text($this, "USER_NAME");
            $this->description = text($this, "ERROR_TITLE") . " " . $this->code . " - " . text($this, "USER_NAME");
        }
    }
?>
