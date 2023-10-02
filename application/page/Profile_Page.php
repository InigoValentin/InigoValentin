<?php

require_once(PATH::PAGE . "Page.php");
require_once(PATH::ENTITY . "Cv.php");

/**
 * Profile page model.
 */
class Profile_Page extends Page{

    /**
    * List of available {@see CV}.
    */
    private $cv = [];

    /**
    * {@see CV} in the current languages.
    */
    private $main_cv;

    /**
    * List {@see CV}s in other languages.
    */
    private $other_cv = [];

    /**
    * Constructor.
    *
    * Retrieves the data and initializes the variables.
    */
    public function __construct(){
        $this->view = PATH::VIEW . "profile.php";
        parent::__construct();
        $this->set_view("profile.php");
        $statement = get_context()->get_db()->prepare(
          "SELECT id FROM cv WHERE user = :user AND visible = 1 ORDER BY lang = :lang DESC"
        );
        $statement->bindValue(':user', get_context()->get_user()->get_id(), PDO::PARAM_INT);
        $statement->bindValue(':lang', get_context()->get_lang(), PDO::PARAM_STR);
        $statement->execute();
        while ($r_cv = $statement->fetch(PDO::FETCH_ASSOC)){
            $c = new Cv($r_cv["id"]);
            array_push($this->cv, $c);
            if ($c->get_lang()->get_code() == get_context()->get_lang()) $this->main_cv = $c;
            array_push($this->other_cv, $c);
        }

        $this->set_title(Text::get("USER_NAME"));
        $this->set_description(Text::get("SECTION_ME") . " - " . Text::get("USER_NAME"));
        $this->set_canonical(URL::PROFILE);
        $this->add_css("profile.css");
    }

    /**
     * Retrieves the list of CVs.
     *
     * @return CV[] CV list.
     */
    public function get_cvs(){return $this->cv;}

    /**
     * Retrieves the main CV.
     *
     * @return Main CV.
     */
    public function get_main_cv(){return $this->main_cv;}

    /**
     * Retrieves the list of CVs excluding the main one.
     *
     * @return CV[] CV list, excluding the main one.
     */
    public function get_other_cvs(){return $this->other_cv;}
}
?>
