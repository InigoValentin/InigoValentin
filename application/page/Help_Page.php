<?php

require_once(PATH::PAGE . "Page.php");

/**
 * Help page model.
 */
class Help_Page extends Page{

    private $help = [
        "info" => [
            "title" => "",
            "text" => "",
        ],
        "license" => [
            "title" => "",
            "text" => "",
        ],
        "privacy" => [
            "title" => "",
            "text" => "",
        ],
        "cookies" => [
            "title" => "",
            "text" => "",
        ]
    ];

    /**
     * Constructor.
     *
     * Retrieves the data and initializes the variables.
     */
    public function __construct(){
        parent::__construct();
        $this->set_view("help.php");
        $this->help["info"]["title"] = Text::get("HELP_INFO_TITLE");
        $this->help["info"]["text"] = get_context()->get_user()->get_text("HELP");
        $this->help["license"]["title"] = Text::get("HELP_LICENSE_TITLE");
        $this->help["license"]["text"] = get_context()->get_user()->get_text("LICENSE");
        $this->help["privacy"]["title"] = Text::get("HELP_PRIVACY_TITLE");
        $this->help["privacy"]["text"] = get_context()->get_user()->get_text("PRIVACY");
        $this->help["cookies"]["title"] = Text::get("HELP_COOKIES_TITLE");
        $this->help["cookies"]["text"] = get_context()->get_user()->get_text("COOKIES");
        $this->set_title(Text::get("HELP_TITLE"));
        $this->set_description(Text::get("HELP_DESCRIPTION") . " - " . Text::get("USER_TAGLINE"));
        $this->set_canonical(URL::HELP);
        $this->add_css("help.css");
        $this->add_js("help.js");
    }
    
    /**
     * Retrives the text body for a section.
     * 
     * Available sections are "info", "license", "privacy" and "cookies".
     * 
     * @param string $section Section for which to retrieve the text, case insensitive.
     * @return The text for the requested section, or an empty string if an invalid section is
     * provided or the text is not defined.
     */
    public function get_section_text($section){
        if (isSet($this->help[$section]))
            if (isSet($this->help[$section]["text"])) return $this->help[$section]["text"];
        return "";
    }
    
    /**
     * Retrives the title of a section.
     * 
     * Available sections are "info", "license", "privacy" and "cookies".
     * 
     * @param string $section Section for which to retrieve the title, case insensitive.
     * @return The title for the requested section, or an empty string if an invalid section
     * is provided or the title is not defined.
     */
    public function get_section_title($section){
        if (isSet($this->help[$section]))
            if (isSet($this->help[$section]["title"])) return $this->help[$section]["title"];
        return "";
    }
}
?>
