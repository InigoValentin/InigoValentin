<?php

require_once(PATH::PAGE . 'Page.php');

/**
 * robots.txt file page model.
 */
class Robots_Page extends Page{

    /**
     * robots.txt contents
     */
    private $text = "User-agent: *\nDisallow:";

    /**
     * Constructor.
     *
     * Retrieves the data and populates the text.
     */
    public function __construct(){
        parent::__construct();
        $this->set_view('robots.php');
    }

    /**
     * Retrieves the text for the robots.txt file.
     *
     * @return string The text for the txt file.
     */
    public function get_text(){return $this->text;}

}
