<?php

    require_once($path["page"] . "Page.php");
    require_once($path["entity"] . "Project.php");
    require_once($path["helper"] . "text.php");


    /**
     * Home page model.
     */
    class Home_Page extends Page{

        private $max_projects = 3;

        /**
         * Array with profile data.
         */
        public $profile = [
            "role" => "",
            "company" => "",
            "city" => "",
            "days" => "",
            "summary" => ""
        ];

        /**
         * List of recent projects.
         */
        public $project = [];

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
            $this->view = $path["view"] . "home.php";
            $s_profile =
              "SELECT " .
              "  role, " .
              "  company, " .
              "  city, " .
              "  datediff(now(), start) AS days, " .
              "  summary " .
              "FROM cv_entry " .
              "WHERE " .
              "  category = 1 AND " .
              "  visible = 1 AND " .
              "  end IS NULL " .
              "ORDER BY start " .
              "DESC LIMIT 1;";
            $q_profile = mysqli_query($this->db, $s_profile);
            if (mysqli_num_rows($q_profile) > 0){
                $r_profile = mysqli_fetch_array($q_profile);
                $this->profile["role"] = text($this, $r_profile["role"]);
                $this->profile["company"] = $r_profile["company"];
                $this->profile["city"] = $r_profile["city"];
                $this->profile["days"] = $r_profile["days"];
                $this->profile["summary"] = text($this, $r_profile["summary"]);
            }
            $s_project =
              "SELECT id " .
              "FROM project " .
              "WHERE visible = 1;";
            $q_project = mysqli_query($this->db, $s_project);
            while($r_project = mysqli_fetch_array($q_project)){
                array_push($this->project, new Project($this->db, $this->lang, $r_project["id"]));
            }
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
