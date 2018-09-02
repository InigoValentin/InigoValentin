<?php

    require_once($path["model"] . "Lang.php");
    require_once($path["model"] . "Social.php");

    class Footer_Page{
        public $social = [];
        public $lang = [];

        public function __construct($db, $lang){
            $s_social =
              "SELECT id " .
              "FROM social " .
              "WHERE visible = 1; ";
            $q_social = mysqli_query($db, $s_social);
            while($r_social = mysqli_fetch_array($q_social)){
                array_push($this->social, new Social($db, $lang, $r_social["id"]));
            }
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
