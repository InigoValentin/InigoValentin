<?php

    require_once($path["page"] . "Page.php");
    require_once($path["entity"] . "Cv.php");
    require_once($path["helper"] . "text.php");


    /**
     * Profile page model.
     */
    class Profile_Page extends Page{


        public $category = [
          "WORK" => 0,
          "EDUCATION" => 1,
          "PROJECTS" => 2,
          "OTHERS" => 3
        ];


        public $entry = [
          "WORK" => [],
          "EDUCATION" => [],
          "PROJECTS" => [],
          "OTHERS" => []
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
            global $root;
            parent::__construct($db, $lang);
            $this->view = $path["view"] . "profile.php";
            foreach ($this->category as $cat){
                $s =
                  "SELECT id " .
                  "FROM cv " .
                  "WHERE " .
                  "  visible = 1 AND " .
                  "  category = " . ($cat + 1) . " " .
                  "ORDER BY " . 
                  "  IF(end IS NULL, 9, end) DESC, " .
                  "  start DESC; ";
                $q = mysqli_query($this->db, $s);
                while($r = mysqli_fetch_array($q)){
                    $k = array_keys($this->category)[$cat];
                    $e = new Cv($this->db, $this->lang, $r["id"]);
                    array_push($this->entry[$k], $e);
                }
            }
            $this->title = text($this, "USER_NAME");
            $this->name = text($this, "USER_NAME");
            $this->description = text($this, "USER_NAME") . " - " . text($this, "USER_TAGLINE");
            $this->favicon = $path["img"]["layout"] . "logo/logo.svg";
            $this->icon = $path["img"]["layout"] . "logo/logo.svg";
            $this->canonical = $root . $lang . "/profile/";
            $this->author = $root . $lang . "/";
        }
    }
?>
