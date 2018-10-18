<?php

    require_once($path["entity"] . "Entity.php");
    require_once($path["entity"] . "License.php");
    require_once($path["entity"] . "Project_Type.php");
    require_once($path["entity"] . "Project_Image.php");
    require_once($path["entity"] . "Project_Comment.php");
    require_once($path["entity"] . "Project_Version.php");
    require_once($path["entity"] . "Project_Tag.php");
    require_once($path["entity"] . "Project_Url.php");
    require_once($path["helper"] . "text.php");


    /**
     * Project.
     *
     * Represents an object from the table 'project'.
     */
    class Project extends Entity{

        /**
         * Project identifier.
         */
        public $id;

        /**
         * Permalink for linking the project (relative).
         */
        public $permalink;

        /**
         * {@see Project_Type} of project.
         */
        public $type;

        /**
         * Project title in the defined language.
         */
        public $title;

        /**
         * Project logo filename.
         */
        public $logo;

        /**
         * Project summary in the defined language.
         */
        public $header;

        /**
         * Project description in the defined language.
         */
        public $text;

        /**
         * Project {@see License}.
         */
        public $license;

        /**
         * Array with the project {@see Project_Image}.
         */
        public $image = [];

        /**
         * Array with the released {@see Project_Version} of the project,
         * sorted from new to old.
         */
        public $version = [];

        /**
         * Array with the {@see Project_Comment} posted in the project, sorted
         * from new to old.
         */
        public $comment = [];

        /**
         * Array with the {@see Project_Tag} of the project.
         */
        public $tag = [];

        /**
         * Array with {@see Project_Url} related to the project.
         */
        public $url = [];

        /**
         * Constructor.
         *
         * Searches the database and retrieves the information about the
         * project, populating it and it's items.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         * @param string $id Identifier or permalink of the project.
         */
        public function __construct($db, $lang, $id){
            parent::__construct($db, $lang);
            $s =
              "SELECT " .
              "  id, " .
              "  permalink, " .
              "  type, " .
              "  title, " .
              "  logo, " .
              "  header, " .
              "  text, " .
              "  license " .
              "FROM project " .
              "WHERE " .
              "  visible = 1 AND " .
              "  ( " .
              "    id = '$id' OR " .
              "    permalink = '$id' " .
              "  );";
            $q = mysqli_query($this->db, $s);
            if (mysqli_num_rows($q) > 0){
                $r = mysqli_fetch_array($q);
                $this->id = $r["id"];
                $this->permalink = $r["permalink"];
                $this->title = text($this, $r["title"]);
                $this->logo = $r["logo"];
                $this->header = text($this, $r["header"]);
                $this->text = text($this, $r["text"]);
                $this->type = new Project_Type($this->db, $this->lang, $r["type"]);
                $this->license = new License($this->db, $this->lang, $r["license"]);
            }
            $s_image =
              "SELECT id " .
              "FROM project_image " .
              "WHERE project = " . $this->id . " " .
              "ORDER BY idx; ";
            $q_image = mysqli_query($this->db, $s_image);
            while($r_image = mysqli_fetch_array($q_image)){
                array_push($this->image, new Project_Image($this->db, $r_image["id"]));
            }
            $s_version =
              "SELECT version_code AS code " .
              "FROM project_version " .
              "WHERE " .
              "  project = " . $this->id . " AND " .
              "  visible = 1 " .
              "ORDER BY dtime DESC; ";
            $q_version = mysqli_query($this->db, $s_version);
            while($r_version = mysqli_fetch_array($q_version)){
                array_push($this->version, new Project_Version($this->db, $this->lang, $this->id, $r_version["code"]));
            }
            $s_tag =
              "SELECT tag " .
              "FROM project_tag " .
              "WHERE project = " . $this->id . ";";
            $q_tag = mysqli_query($this->db, $s_tag);
            while($r_tag = mysqli_fetch_array($q_tag)){
                array_push($this->tag, new Project_Tag($this->db, $this->lang, $this->id, $r_tag["tag"]));
            }
            $s_url =
              "SELECT id " .
              "FROM project_url " .
              "WHERE project = " . $this->id . ";";
            error_log($s_url);
            $q_url = mysqli_query($this->db, $s_url);
            while($r_url = mysqli_fetch_array($q_url)){
                array_push($this->url, new Project_Url($this->db, $this->lang, $r_url["id"]));
            }
            $s_comment =
              "SELECT id " .
              "FROM project_comment " .
              "WHERE project = " . $this->id . ";";
            $q_comment = mysqli_query($this->db, $s_comment);
            while($r_comment = mysqli_fetch_array($q_comment)){
                array_push($this->comment, new Project_Comment($this->db, $r_comment["id"]));
            }
        }
    }
?>
