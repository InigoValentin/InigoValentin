<?php

    require_once($path["entity"] . "Lang.php");

    class Footer_Page{
        public $lang = [];

        public function __construct($db, $lang){
            $s_lang =
              "SELECT code AS id " .
              "FROM lang " .
              "WHERE active = 1; ";
            $q_lang = mysqli_query($db, $s_lang);
            while($r_lang = mysqli_fetch_array($q_lang)){
                array_push($this->lang, new Lang($db, $r_lang["id"]));
            }
        }
    }
?>
