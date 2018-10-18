<?php

    require_once($path["entity"] . "Entity.php");


    /**
     * Project posted on a comment.
     *
     * Represents an object from the table 'project_comment'.
     */
    class Project_Comment extends Entity{

        /**
         * Comment unique identifier.
         */
        public $id;

        /**
         * Identifier of the project the comment is on.
         */
        public $project;

        /**
         * Version identifier of the project at the time the post was posted.
         */
        public $version;

        /**
         * Text of the comment.
         */
        public $text;

        /**
         * Time the comment was published.
         */
        public $dtime;

        /**
         * User identifier of the poster, if it was a registered user.
         */
        public $user;

        /**
         * Username of the poster, if it was not a registered user.
         */
        public $username;

        /**
         * Lowercase, two-letter language code of the comment. Guessed at the
         * time of posting.
         */
        public $lang;

        /**
         * Indicates wether the comment has been approved and can be displayed.
         */
        public $approved;

        /**
         * Constructor.
         *
         * Searches the database and retrieves the information about the
         * comment, populating it.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param int $id Identifier of the comment.
         */
        public function __construct($db, $id){
            parent::__construct($db, null);
            $s =
              "SELECT " .
              "  id, " .
              "  project, " .
              "  version, " .
              "  text, " .
              "  dtime, " .
              "  user, " .
              "  username, " .
              "  lang, " .
              "  approved " .
              "FROM project_comment " .
              "WHERE id = $id ;";
            $q = mysqli_query($this->db, $s);
            if (mysqli_num_rows($q) > 0){
                $r = mysqli_fetch_array($q);
                $this->id = $r["id"];
                $this->project = $r["project"];
                $this->version = $r["version"];
                $this->text = $r["text"];
                $this->dtime = $r["dtime"];
                $this->user = $r["user"];
                $this->username = $r["username"];
                $this->lang = $r["lang"];
                $this->approved = $r["approved"];
            }
        }
    }
?>
