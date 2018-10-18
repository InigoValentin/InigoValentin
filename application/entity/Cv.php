<?php

    require_once($path["entity"] . "Entity.php");
    require_once($path["entity"] . "Cv_Category.php");
    require_once($path["helper"] . "text.php");


    /**
     * Entry on the CV.
     *
     * Represents an object from the table 'cv'.
     */
    class Cv extends Entity{

        /**
         * Project identifier.
         */
        public $id;

        /**
         * {@see Cv_Category} of the entry.
         */
        public $category;

        /**
         * Role of the entry in the defined language.
         */
        public $role;

        /**
         * Company or center of the entry in the defined language.
         */
        public $company;

        /**
         * City.
         */
        public $city;

        /**
         * Start date of the activity.
         */
        public $start;

        /**
         * End date of the activity, or null if it's a current one.
         */
        public $end;

        /**
         * Date precission to show ("M" for months, "Y for years").
         */
        public $date_precission;

        /**
         * Description of the role in the defined language.
         */
        public $summary;

        /**
         * Indicates wether the activity must or mustn's be displayed.
         */
        public $visible;

        /**
         * Constructor.
         *
         * Searches the database and retrieves the information about the
         * entry, populating it and it's items.
         *
         * @param MySQL_connection $db Connection to the database.
         * @param string $lang Lowercase, two-letter language code.
         * @param int $id Identifier of the cv entry.
         */
        public function __construct($db, $lang, $id){
            parent::__construct($db, $lang);
            $s =
              "SELECT " .
              "  id, " .
              "  category, " .
              "  role, " .
              "  company, " .
              "  city, " .
              "  start, " .
              "  end, " .
              "  date_precission, " .
              "  summary, " .
              "  visible " .
              "FROM cv " .
              "WHERE " .
              "  visible = 1 AND " .
              "  id = $id ; ";
            $q = mysqli_query($this->db, $s);
            if (mysqli_num_rows($q) > 0){
                $r = mysqli_fetch_array($q);
                $this->id = $r["id"];
                $this->role = text($this, $r["role"]);
                $this->company = $r["company"];
                $this->city = text($this, $r["city"]);
                $this->start = $r["start"];
                $this->end = $r["end"];
                $this->date_precission = $r["date_precission"];
                $this->summary = text($this, $r["summary"]);
                $this->visible = $r["visible"];
                $this->category = new Cv_Category($this->db, $this->lang, $r["category"]);
            }
        }
    }
?>
