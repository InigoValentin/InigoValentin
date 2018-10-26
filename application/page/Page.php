<?php

    /**
     * Page superclass.
     *
     * Every visitable page type must inherit from this one.
     */
    abstract class Page{

        /**
         * Database connection.
         */
        public $db;

        /**
         * View associated with the page.
         */
        public $view;

        /**
         * Language the page will be served on (lowercase, two-letter
         * language code).
         */
        public $lang;

        /**
         * List of available {@see Lang}uages (lowercase, two-letter language code).
         */
        public $available_langs = [];

        /**
         * Title of the page, in the defined language.
         */
        public $title;

        /**
         * Site name.
         */
        public $name;

        /**
         * Page description, in the defined language.
         */
        public $description;

        /**
         * Path to the site favicon.
         */
        public $favicon;

        /**
         * Path to the page icon or main image.
         */
        public $icon;

        /**
         * Canonical URL.
         */
        public $canonical;

        /**
         * Author URL.
         */
        public $author;


        /**
         * Constructor.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         */
        public function __construct($db, $lang){
            global $static;
            global $base_url;
            $this->db = $db;
            $this->lang = $lang;
            $s_lang =
              "SELECT code AS id " .
              "FROM lang " .
              "WHERE active = 1; ";
            $q_lang = mysqli_query($db, $s_lang);
            while($r_lang = mysqli_fetch_array($q_lang)){
                array_push($this->available_langs, new Lang($db, $r_lang["id"]));
            }
            $this->favicon = $static["layout"] . "logo/logo.svg";
            $this->icon = $static["layout"] . "logo/logo.svg";
            $this->name = text($this, "USER_NAME");
            $this->author = $base_url;
            $this->name = text($this, "USER_NAME");
        }
    }
?>
