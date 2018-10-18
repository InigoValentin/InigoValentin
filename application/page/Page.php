<?php

    require_once($path["entity"] . "Footer.php");


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
         * Footer.
         * @see Footer_Page
         */
        public $footer;

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
         * Autjhor URL.
         */
        public $author;

        /**
         * Constructor.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         */
        public function __construct($db, $lang){
            $this->db = $db;
            $this->lang = $lang;
            $this->footer = new Footer($db, $lang);
        }
    }
?>
